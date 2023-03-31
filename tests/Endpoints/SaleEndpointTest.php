<?php

namespace Dimaveresklia\Akurateco\Tests\Endpoints;

use Dimaveresklia\Akurateco\Exceptions\ApiException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class SaleEndpointTest
 *
 * @package Dimaveresklia\Akurateco\Tests\Endpoints
 */
class SaleEndpointTest extends AbstractEndpointTestCase
{
    /**
     * @return void
     * @throws ApiException
     */
    public function testCreateSuccess(): void
    {
        $responseBody = json_encode(
            [
            'action'     => 'SALE',
            'result'     => 'SUCCESS',
            'status'     => 'SETTLED',
            'order_id'   => 'test_order_id',
            'trans_id'   => 'test_trans_id',
            'descriptor' => 'test_descriptor',
            'amount'     =>  10.35,
            'currency'   => 'USD',
            ]
        );

        $response = new Response(200, [], $responseBody);

        $this->guzzleClient->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $requestData = $this->getValidRequestData();

        $saleEndpoint = $this->createAkuratecoApiClient()->sale;
        $saleResponse = $saleEndpoint->create($requestData, $this->guzzleClient);

        $this->assertEquals($requestData['order_id'], $saleResponse->order_id);
        $this->assertEquals($requestData['order_amount'], $saleResponse->amount);
        $this->assertEquals($requestData['order_currency'], $saleResponse->currency);
    }

    /**
     * @return void
     */
    public function testCreateCatchException(): void
    {
        $this->expectException(ApiException::class);

        $request = new Request(self::HTTP_POST, 'http://test/');

        $this->guzzleClient->expects($this->once())
            ->method('send')
            ->will(
                $this->throwException(
                    new RequestException('test', $request)
                )
            );

        $saleEndpoint = $this->createAkuratecoApiClient()->sale;
        $saleEndpoint->create($this->getValidRequestData(), $this->guzzleClient);
    }

    /**
     * @return array
     */
    private function getValidRequestData(): array
    {
        return [
            'order_id'       => 'test_order_id',
            'order_amount'   =>  10.35,
            'order_currency' => 'USD',
            'payer_email'    => 'test@test.com',
            'card_number'    => '4302 4342 4321 4321'
        ];
    }
}
