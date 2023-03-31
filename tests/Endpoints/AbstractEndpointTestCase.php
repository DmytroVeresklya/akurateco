<?php

namespace Dimaveresklia\Akurateco\Tests\Endpoints;

use Dimaveresklia\Akurateco\AkuratecoApiClient;
use Dimaveresklia\Akurateco\Exceptions\ApiException;
use Dimaveresklia\Akurateco\Helper\ResponseFactory;
use Dimaveresklia\Akurateco\HttpAdapter\GuzzleHttpAdapter;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractEndpointTestCase
 *
 * @package Dimaveresklia\Akurateco\Tests\Endpoints
 */
class AbstractEndpointTestCase extends TestCase
{
    protected const HTTP_POST = 'POST';

    protected const PUBLIC_KEY = '1b6492f0-f8f5-11ea-976a-0242c0a85007';

    protected const CLIENT_PASS = 'a0ec0beca8a3c30652746925d5380cf3';
    /**
     * @var AkuratecoApiClient
     */
    protected AkuratecoApiClient $akuratecoApiClient;

    /**
     * @var Client
     */
    protected Client $guzzleClient;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->akuratecoApiClient = new AkuratecoApiClient();
        $this->guzzleClient       = $this->createMock(Client::class);

        parent::setUp();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @return AkuratecoApiClient
     * @throws ApiException
     */
    protected function createAkuratecoApiClient(): AkuratecoApiClient
    {
        return $this->akuratecoApiClient->setKeys(
            self::PUBLIC_KEY,
            self::CLIENT_PASS
        );
    }
}