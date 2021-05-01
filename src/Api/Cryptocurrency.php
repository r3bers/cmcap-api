<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Api;

use GuzzleHttp\Exception\GuzzleException;
use R3bers\CMCapApi\Exception\QueryParametersException;
use R3bers\CMCapApi\Exception\TransformResponseException;

/**
 * Class Market
 * @package R3bers\CMCapApi\Api
 */
class Cryptocurrency extends Api
{
    private $AUX_MAP = 'platform,first_historical_data,last_historical_data,is_active,status';
    private $AUX_INFO = 'urls,logo,description,tags,platform,date_added,notice,status';
//    private $AUX_LISTING_HISTORY = 'platform,tags,date_added,circulating_supply,total_supply,max_supply,cmc_rank,num_market_pairs';
//    private $AUX_LISTING_LATEST = 'num_market_pairs,cmc_rank,date_added,tags,platform,max_supply,circulating_supply,total_supply,market_cap_by_total_supply,volume_24h_reported,volume_7d,volume_7d_reported,volume_30d,volume_30d_reported,is_market_cap_included_in_calc';
//    private $AUX_MARKET_PAIRS_LATEST = 'num_market_pairs,category,fee_type,market_url,currency_name,currency_slug,price_quote,notice,cmc_rank,effective_liquidity,market_score,market_reputation';
//    private $AUX_QUOTES_HISTORY = 'price,volume,market_cap,quote_timestamp,is_active,is_fiat,search_interval';
    private $AUX_QUOTES_LATEST = 'num_market_pairs,cmc_rank,date_added,tags,platform,max_supply,circulating_supply,total_supply,market_cap_by_total_supply,volume_24h_reported,volume_7d,volume_7d_reported,volume_30d,volume_30d_reported,is_active,is_fiat';

    private $category = "/cryptocurrency";

    /**
     * @param string $list
     * @param string|null $aux
     * @return array
     * @throws QueryParametersException | GuzzleException | TransformResponseException
     */
    public function info(string $list, ?string $aux): array
    {
        $options = ['query' => $this->processList($list)];
        if (isset($aux))
            $options['query']['aux'] = $this->checkAUX($aux, $this->AUX_INFO);
        $uri = $this->category . '/info';
        return $this->rest('GET', $uri, $options);
    }

    /**
     * @param string $list
     * @param string|null $aux
     * @return array
     * @throws QueryParametersException | GuzzleException | TransformResponseException
     */
    public function map(string $list, ?string $aux): array
    {
        $options = ['query' => $this->processList($list)];
        if (isset($aux))
            $options['query']['aux'] = $this->checkAUX($aux, $this->AUX_MAP);
        $uri = $this->category . '/map';
        return $this->rest('GET', $uri, $options);
    }

    /**
     * @param $list
     * @param string $convert
     * @param string|null $aux
     * @param bool $skip_invalid
     * @return array
     * @throws QueryParametersException | GuzzleException | TransformResponseException
     */
    public function quotesLatest($list, string $convert, ?string $aux, bool $skip_invalid = false): array
    {
        $options = ['query' => $this->processList($list)];
        if (isset($aux)) $options['query']['aux'] = $this->checkAUX($aux, $this->AUX_QUOTES_LATEST);
        if (isset($convert) and is_string($convert) and $convert != '')
            $options['query']['convert'] = $convert;
        if ($skip_invalid)
            $options['query']['skip_invalid'] = 'true';
        $uri = $this->category . '/quotes/latest';
        return $this->rest('GET', $uri, $options);
    }

}