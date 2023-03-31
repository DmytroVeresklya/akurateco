<?php

namespace Dimaveresklia\Akurateco;
use Dimaveresklia\Akurateco\Endpoints\SaleEndpoint;
use Dimaveresklia\Akurateco\Exceptions\ApiException;
use Dimaveresklia\Akurateco\Responses\SaleResponse;

/**
 * Class AkuratecoApiClient
 *
 * @package Dimaveresklia\Akurateco;
 */
class AkuratecoApiClient
{
    /**
     * @var string
     */
    protected string $publicKey;

    /**
     * @var string
     */
    protected string $clientPass;

    /**
     * @var SaleEndpoint
     */
    public SaleEndpoint $sale;

    public function __construct()
    {
        $this->sale = new SaleEndpoint($this);
    }

    /**
     * @param string $publicKey
     * @param string $clientPass
     *
     * @return AkuratecoApiClient
     * @throws ApiException
     */
    public function setKeys(
        string $publicKey,
        string $clientPass
    ): AkuratecoApiClient {
        $publicKey = trim($publicKey);

        $isValidPublicKey = preg_match(
            '/^[a-f\d]{8}(-[a-f\d]{4}){3}-[a-f\d]{12}$/i',
            $publicKey
        );
        if (!$isValidPublicKey) {
            throw new ApiException("Invalid Public Key : '{$publicKey}'");
        }

        if (strlen($clientPass) !== 32) {
            throw new ApiException("Invalid Client Pass :'{$clientPass}'");
        }

        $this->publicKey  = $publicKey;
        $this->clientPass = $clientPass;

        return $this;
    }

    /**
     * @param array $data
     * @param object $object
     *
     * @return string
     * @throws ApiException
     */
    public function parse(array $data, object $object): string
    {
        if ($object instanceof SaleResponse) {
            $data = $this->_parseSaleData($data);
        }

        return json_encode($data);
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws ApiException
     */
    private function _parseSaleData(array $data): array
    {
        $message = null;

        if (strlen($data['order_id']) > 255 || null === $data['order_id']) {
            $message .= 'Invalid order_id ';
        }
        if (!preg_match('/^[1-9]\d*\.\d{2}$/', $data['order_amount'])) {
            $message .= 'Invalid order_amount ';
        }
        if (!preg_match('/^[a-zA-Z]{3}$/', $data['order_currency'])) {
            $message .= 'Invalid order_currency ';
        }
        /**
         * @TODO ...
         */

        if (!filter_var($data['payer_email'], FILTER_VALIDATE_EMAIL)) {
            $message .= 'Invalid email ';
        } else {
            $email = $data['payer_email'];
        }
        if (null === $data['card_number']) {
            $message .= 'Invalid card number ';
        } else {
            $cardNumber = $data['card_number'];
        }

        if (null !== $message) {
            throw new ApiException($message);
        }

        $data['hash'] = $this->_createHash($email, $cardNumber);

        return $data;
    }

    /**
     * @param string $email
     * @param string $cardNumber
     *
     * @return string
     */
    private function _createHash(string $email, string $cardNumber): string
    {
        return md5(
            strtoupper(
                strrev($email) . $this->clientPass .
                strrev(substr($cardNumber, 0, 6) . substr($cardNumber, -4))
            )
        );
    }
}