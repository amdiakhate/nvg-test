<?php

namespace App\Controller\API;

use App\Message\API\ProductsRequestReceivedMessage;
use App\Transformer\ProductsRequestTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsPostAction
{
    private ProductsRequestTransformer $transformer;
    private MessageBusInterface $messageBus;

    private const CHUNK_SIZE = 100;


    public function __construct(MessageBusInterface $messageBus, ProductsRequestTransformer $transformer)
    {
        $this->messageBus = $messageBus;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $data = $request->getContent();

//        i'm using a transformer here just to get some logic out of the controller
//         so we can unit test the transforming part, not necessary
//        we get the products from the request
        $productsRequest = $this->transformer->transform($data);
        if (!empty($productsRequest)) {
            $productsRequestChunk = [];
//            we split the product requests into small chunks and dispatch them to the workers
            foreach ($productsRequest as $productRequest) {
                $productsRequestChunk[] = $productRequest;
                if (count($productsRequestChunk) >= self::CHUNK_SIZE) {
                    $this->messageBus->dispatch(new ProductsRequestReceivedMessage($productsRequestChunk));
                    $productsRequestChunk = [];
                }

            }
            $this->messageBus->dispatch(new ProductsRequestReceivedMessage($productsRequestChunk));
        }

        return new JsonResponse('ok');
    }
}