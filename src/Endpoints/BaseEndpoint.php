<?php

namespace Dimaveresklia\Akurateco\Endpoints;


use Dimaveresklia\Akurateco\AkuratecoApiClient;
use Dimaveresklia\Akurateco\Helper\Parser;
use Dimaveresklia\Akurateco\Helper\ResponseFactory;
use Dimaveresklia\Akurateco\HttpAdapter\GuzzleHttpAdapter;
use Dimaveresklia\Akurateco\Responses\BaseResponse;

/**
 * Class Base Endpoint
 *
 * @package Dimaveresklia\Akurateco\Endpoints
 */
abstract class BaseEndpoint
{
    /**
     * Method Post
     */
    public const HTTP_POST = 'POST';

    /**
     *
     */
    public const API_ENDPOINT = 'https://dev-api.rafinita.com/post';

    /**
     * @var AkuratecoApiClient
     */
    protected AkuratecoApiClient $akuratecoApiClient;

    /**
     * @var GuzzleHttpAdapter
     */
    protected GuzzleHttpAdapter $guzzleHttpAdapter;

    /**
     * @var ResponseFactory
     */
    protected ResponseFactory $responseFactory;

    public function __construct(AkuratecoApiClient $akuratecoApiClient)
    {
        $this->akuratecoApiClient = $akuratecoApiClient;
        $this->guzzleHttpAdapter  = new GuzzleHttpAdapter();
        $this->responseFactory    = new ResponseFactory();
    }

    /**
     * @return BaseResponse
     */
    abstract protected function getResponseObject(): BaseResponse;
}