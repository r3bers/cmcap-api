<?php

namespace R3bers\CMCapApi\Tests\Api;

use GuzzleHttp\Exception\GuzzleException;
use R3bers\CMCapApi\Api\Cryptocurrency;
use R3bers\CMCapApi\Exception\QueryParametersException;
use R3bers\CMCapApi\Exception\TransformResponseException;

class CryptocurrencyTest extends ApiTestCase
{
    /**
     * @throws GuzzleException | TransformResponseException | QueryParametersException
     */
    public function testMAP()
    {
        $this->createApi()->map('1', 'status');
        $request = $this->getLastRequest();

        $this->assertEquals(
            '/v1/cryptocurrency/map?id=1&aux=status',
            $request->getUri()->__toString()
        );
        $this->assertEquals(
            'API_KEY',
            $request->getHeaderLine('X-CMC_PRO_API_KEY')
        );
    }

    private function createApi(): Cryptocurrency
    {
        return new Cryptocurrency($this->getMockClient(true));
    }

    /**
     * @throws GuzzleException | TransformResponseException | QueryParametersException
     */
    public function testQuotesLatest()
    {
        $this->createApi()->quotesLatest('1,2,3', 'USD', 'status');
        $request = $this->getLastRequest();

        $this->assertEquals(
            '/v1/cryptocurrency/quotes/latest?id=1%2C2%2C3&aux=status&convert=USD',
            $request->getUri()->__toString()
        );
        $this->assertEquals(
            'API_KEY',
            $request->getHeaderLine('X-CMC_PRO_API_KEY')
        );
    }

}
