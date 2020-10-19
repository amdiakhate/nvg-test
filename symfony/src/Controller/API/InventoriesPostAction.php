<?php

namespace App\Controller\API;

use App\Factory\API\ProductRequestToProductFactory;
use App\Message\API\ProductsRequestReceivedMessage;
use App\Message\API\StockRequestReceivedMessage;
use App\Model\API\ProductRequest;
use App\Model\API\StockRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class InventoriesPostAction
{
    private SerializerInterface $serializer;
    private MessageBusInterface $messageBus;

    private const CHUNK_SIZE = 100;


    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        $encoders = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);

        $normalizers = [new JsonSerializableNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer(null, null, null, $extractor)];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function __invoke(Request $request)
    {
        $data = $request->getContent();
//        we get the products from the request

        try {
            $stocksRequest = $this->serializer->deserialize(
                $data,
                'App\Model\API\StockRequest[]'
                ,
                'json', [
                    ObjectNormalizer::ALLOW_EXTRA_ATTRIBUTES => true,
                ]
            );
        } catch (NotEncodableValueException $exception) {
            throw new BadRequestHttpException('Invalid parameter');
        }

        if (!empty($stocksRequest)) {
            $stocksRequestChunk = [];
            foreach ($stocksRequest as $stockRequest) {
                $stocksRequestChunk[] = $stockRequest;
                if (count($stocksRequestChunk) >= self::CHUNK_SIZE) {
                    $this->messageBus->dispatch(new StockRequestReceivedMessage($stocksRequestChunk));
                    $stocksRequestChunk = [];
                }

            }
            $this->messageBus->dispatch(new StockRequestReceivedMessage($stocksRequestChunk));
        }

        return new JsonResponse('ok');
    }
}