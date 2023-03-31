<?php

namespace Dimaveresklia\Akurateco\Tests;

use Dimaveresklia\Akurateco\AkuratecoApiClient;
use Dimaveresklia\Akurateco\Exceptions\ApiException;
use Dimaveresklia\Akurateco\Responses\SaleResponse;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class AkuratecoApiClientTest
 *
 * @package Dimaveresklia\Akurateco\Tests
 */
class AkuratecoApiClientTest extends TestCase
{
    /**
     * @var AkuratecoApiClient
     */
    private AkuratecoApiClient $akuratecoApiClient;

    private SaleResponse $saleResponse;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->akuratecoApiClient = new AkuratecoApiClient();

        $this->saleResponse = $this->createStub(SaleResponse::class);
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testSetPublicKeyInvalidPublicKey(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage("Invalid Public Key : 'test'");

        $this->akuratecoApiClient->setKeys('test', 'test');
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testSetPublicKeyInvalidClientPass(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage("Invalid Client Pass :'test'");

        $this->akuratecoApiClient->setKeys(
            '5b6492f0-f8f5-11ea-976a-0242c0a85007',
            'test'
        );
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testSetPublicKeySuccess(): void
    {
        $publicKey  = '5b6492f0-f8f5-11ea-976a-0242c0a85007';
        $clientPass = 'c152f71c66fae068c5f23272f7a8bdf3';

        $apiClient = $this->akuratecoApiClient->setKeys(
            $publicKey,
            $clientPass
        );

        $this->assertIsObject($apiClient);
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testParseNotInstanceofClass(): void
    {
        $data = $this->getData();

        $parsed = $this->akuratecoApiClient->parse(
            $data,
            new \stdClass()
        );

        $this->assertEquals(json_encode($data), $parsed);
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testParseInvalidData(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage(
            'Invalid order_id Invalid order_amount Invalid email '
        );

        $data = $this->getData();
        $data['order_id'] = null;
        $data['order_amount'] = '100.2';
        $data['payer_email'] = 'test';

        $this->akuratecoApiClient->parse($data, $this->saleResponse);
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testParseGetHash(): void
    {
        $publicKey  = '5b6492f0-f8f5-11ea-976a-0242c0a85007';
        $clientPass = 'c152f71c66fae068c5f23272f7a8bdf3';

        $this->akuratecoApiClient->setKeys(
            $publicKey,
            $clientPass
        );

        $data = $this->getData();

        $parsed  = $this->akuratecoApiClient->parse($data, $this->saleResponse);
        $decoded = json_decode($parsed, true);
        $hash    = $decoded['hash'];

        $cardNumber = $data['card_number'];
        $getHash = md5(
            strtoupper(
                strrev($data['payer_email']) . $clientPass .
                strrev(substr($cardNumber, 0, 6) . substr($cardNumber, -4))
            )
        );

        $this->assertEquals($hash, $getHash);
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return [
            'order_id' => 'test',
            'order_amount' => '32.30',
            'order_currency' => 'USD',
            'payer_email' => 'test@test.com',
            'card_number' => '4302 4342 4321 4321'
        ];
    }
}
