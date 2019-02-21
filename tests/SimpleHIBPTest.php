<?php

use HIBP\SimpleHIBP;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SimpleHIBPTest extends TestCase
{
    public function passwordProviders()
    {
        return [
            [
                '12345',
                200,
                implode(PHP_EOL, [
                    '3717CE60500CA92261A020EBC2525332EF3:3',
                    '372D23655B46A21125B455F41BF56C8A2D7:1',
                    '37D0679CA88DB6464EAC60DA96345513964:2333232',
                    '382E858D0D8D00CA04210A15D5D32F2C4FC:1',
                    '38D1CABB8D92132ACBB3C73C484FE086A34:1',
                    '38F18526E2CC951F673DA2F88143C802744:17'
                ]),
                false
            ],
            [
                'supercalifragilisticexpialidocious',
                200,
                implode(PHP_EOL, [
                    '0086C8CD1D2D4328EBBB2BBB8A2BC4C1B2F:8',
                    '014531D907F2DC8D40AAC52E3F24FFDBAD6:5',
                    '01C8895CC60517CB1E7C38498BCBC9289D1:5',
                    '023DB10FEBE1B3675365712B919F2930561:1',
                    '03BAE5EE2C2E55527DFFE241D2B7DCF8D4C:2'
                ]),
                true
            ]
        ];
    }

    /**
     * @dataProvider passwordProviders
     */
    public function testIsPasswordSafe($password, $status, $body, $isSafe)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $hibp = new \ReflectionClass(SimpleHIBP::class);
        $property = $hibp->getProperty('client');
        $property->setAccessible(true);
        $property->setValue('client', $client);

        $method = $hibp->getMethod('isPasswordSafe');
        $this->assertEquals($method->invokeArgs(null, [$password]), $isSafe);
    }
}
