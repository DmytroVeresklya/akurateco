<?php

namespace Dimaveresklia\Akurateco\Responses;

use DateTime;

/**
 * Class SaleResponse
 *
 * @package Dimaveresklia\Akurateco\Resources
 */
class SaleResponse extends BaseResponse
{
    /**
     * @var string
     */
    public string $action;

    /**
     * @var string|null
     */
    public ?string $result;

    /**
     * @var string|null
     */
    public ?string $status;

    /**
     * @var string|null
     */
    public ?string $order_id;

    /**
     * @var string|null
     */
    public ?string $trans_id;

    /**
     * @var DateTime|null
     */
    public ?DateTime $trans_data;

    /**
     * @var string|null
     */
    public ?string $descriptor;

    /**
     * @var string|null
     */
    public ?string $recurring_token;

    /**
     * @var float|null
     */
    public ?float $amount;

    /**
     * @var string|null
     */
    public ?string $currency;
}