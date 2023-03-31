<?php

namespace Dimaveresklia\Akurateco\Helper;
use Dimaveresklia\Akurateco\Responses\BaseResponse;

/**
 * class ResponseFactory
 *
 * @package Dimaveresklia\Akurateco\Helper
 */
class ResponseFactory
{
    /**
     * @param object $data
     * @param BaseResponse $object
     *
     * @return BaseResponse
     */
    public function createResponse(object $data, BaseResponse $object): BaseResponse
    {
        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }
}