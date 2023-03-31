<?php

namespace Dimaveresklia\Akurateco\Endpoints;

use Dimaveresklia\Akurateco\Exceptions\ApiException;
use Dimaveresklia\Akurateco\Responses\SaleResponse;
use GuzzleHttp\Client;

/**
 * Class SaleEndpoint
 *
 * @package Dimaveresklia\Akurateco\Endpoints
 */
class SaleEndpoint extends BaseEndpoint
{
    /**
     * @return SaleResponse
     */
    protected function getResponseObject(): SaleResponse
    {
        return new SaleResponse();
    }

    /**
     * @param array $data
     * @param Client|null $httpAdapter
     *
     * @return SaleResponse
     * @throws ApiException
     */
    public function create(array $data, ?Client $httpAdapter = null ): SaleResponse
    {
        $responseObject = $this->getResponseObject();

        $data = $this->akuratecoApiClient->parse($data, $responseObject);

        if (null === $httpAdapter || $httpAdapter instanceof Client) {
            $response = $this->guzzleHttpAdapter->request(
                self::HTTP_POST,
                self::API_ENDPOINT,
                $this->_getHeaders(),
                $data,
                $httpAdapter
            );
        } else {
            // curl ...
        }

        return $this->responseFactory->createResponse($response, $responseObject);
    }

    /**
     * @return array
     */
    private function _getHeaders(): array
    {
        return [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
}