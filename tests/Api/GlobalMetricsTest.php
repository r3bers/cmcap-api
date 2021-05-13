<?php

namespace R3bers\CMCapApi\Tests\Api;

use GuzzleHttp\Exception\GuzzleException;
use R3bers\CMCapApi\Api\GlobalMetrics;
use R3bers\CMCapApi\Exception\QueryParametersException;
use R3bers\CMCapApi\Exception\TransformResponseException;

class GlobalMetricsTest extends ApiTestCase
{

    private function createApi(): GlobalMetrics
    {
        return new GlobalMetrics($this->getMockClient(true));
    }

    /**
     * @throws GuzzleException | TransformResponseException | QueryParametersException
     */
    public function testQuotesLatest()
    {
        $this->createApi()->quotesLatest('1,2781');
        $request = $this->getLastRequest();

        $this->assertEquals(
            '/v1/global-metrics/quotes/latest?convert_id=1%2C2781',
            $request->getUri()->__toString()
        );
        $this->assertEquals(
            'API_KEY',
            $request->getHeaderLine('X-CMC_PRO_API_KEY')
        );
    }

}
