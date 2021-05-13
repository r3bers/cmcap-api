<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Api;

/**
 * Class Market
 * @package R3bers\CMCapApi\Api
 */
class GlobalMetrics extends Api
{

    private $category = "/global-metrics";

    /**
     * @param string|null $convert
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \R3bers\CMCapApi\Exception\TransformResponseException
     * @throws \R3bers\CMCapApi\Exception\QueryParametersException
     */
    public function quotesLatest(?string $convert = null): array
    {
        $options = [];
        if (isset($convert)) {
            $buf = $this->processList($convert);
            if (array_key_exists('id' , $buf))
                $options = ['query' => [
                    'convert_id' => $convert
                ]];
            elseif (array_key_exists('symbol', $buf))
                $options = ['query' => [
                    'convert' => $convert
                ]];
        }
        $uri = $this->category . '/quotes/latest';
        return $this->rest('GET', $uri, $options);
    }

}