<?php

namespace Dimaveresklia\Akurateco\HttpAdapter;

use Dimaveresklia\Akurateco\Exceptions\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

/**
 * Class GuzzleHttpAdapter
 *
 * @package Dimaveresklia\Akurateco\HttpAdapter
 */
class GuzzleHttpAdapter
{
    /**
     * @param string      $method
     * @param string      $uri
     * @param array       $headers
     * @param string      $data
     * @param Client|null $client
     *
     * @return object
     * @throws ApiException
     */
    public function request(
        string  $method,
        string  $uri,
        array   $headers,
        string  $data,
        ?Client $client
    ): object {
        $request = new Request($method, $uri, $headers, $data);

        $client = $client ?? new Client();

        try {
            $response = $client->send($request);
        } catch (GuzzleException $exception) {
            throw new ApiException($exception->getMessage(), $exception->getCode());
        }

        return json_decode($response->getBody());
    }
}