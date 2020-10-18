<?php


namespace App\Test\Service\API;


use App\Transformer\ProductsRequestTransformer;
use PHPUnit\Framework\TestCase;

class ProductsRequestTransformerTest extends TestCase
{

//    Test vraiment très simpliste
    public function testTransform()
    {
        $transformer = new ProductsRequestTransformer();
        $data = '[
        {
        "reference": "ELSLADLBRCA003",
        "name": "Ixbaxrii",
        "dropshipping": "false",
        "category": null,
        "description": null,
        "pricing": [
            {
                "channel": "fr",
                "vat_rate": 20,
                "price": 3818
            },
            {
                "channel": "it",
                "vat_rate": 22,
                "price": 3818
            },
            {
                "channel": "nl",
                "vat_rate": 21,
                "price": 3818
            },
            {
                "channel": "at",
                "vat_rate": 20,
                "price": 3818
            },
            {
                "channel": "be",
                "vat_rate": 21,
                "price": 3818
            },
            {
                "channel": "de",
                "vat_rate": 16,
                "price": 3818
            }
        ]
    },
    
    {
        "reference": "ELSLADLBRCR003",
        "name": "Gmqssfzj",
        "dropshipping": "false",
        "category": null,
        "description": null,
        "pricing": [
            {
                "channel": "fr",
                "vat_rate": 20,
                "price": 5920
            },
            {
                "channel": "it",
                "vat_rate": 22,
                "price": 5920
            },
            {
                "channel": "nl",
                "vat_rate": 21,
                "price": 5920
            },
            {
                "channel": "at",
                "vat_rate": 20,
                "price": 5920
            },
            {
                "channel": "be",
                "vat_rate": 21,
                "price": 5920
            },
            {
                "channel": "de",
                "vat_rate": 16,
                "price": 5920
            }
        ]
    }
    ]';

        $result = $transformer->transform($data);
        $this->assertCount(2, $result);
        $this->assertSame('ELSLADLBRCA003', $result[0]->getReference());
        $this->assertSame('ELSLADLBRCR003', $result[1]->getReference());
    }

}