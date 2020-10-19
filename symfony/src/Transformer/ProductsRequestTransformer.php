<?php


namespace App\Transformer;

use App\Model\API\ProductRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

class ProductsRequestTransformer
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);

        $normalizers = [new JsonSerializableNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer(null, null, null, $extractor)];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param string $data
     * @return ProductRequest[]
     */
    public function transform(string $data): array
    {
        try {
            $result = $this->serializer->deserialize(
                $data,
                'App\Model\API\ProductRequest[]'
                ,
                'json', [
                    ObjectNormalizer::ALLOW_EXTRA_ATTRIBUTES => true,
                ]
            );
        } catch (NotEncodableValueException $exception) {
            throw new BadRequestHttpException('Invalid parameter');
        }

        return $result;

    }
}