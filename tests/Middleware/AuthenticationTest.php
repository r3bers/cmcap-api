<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Tests\Middleware;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use R3bers\CMCapApi\Middleware\Authentication;

class AuthenticationTest extends TestCase
{
    private const API_KEY = 'API_KEY';
    private const URI = '/v1/';
    private const METHOD = 'GET';

    public function testUri()
    {
        $request = $this->getHandledRequest(new Request(self::METHOD, self::URI, []));
        $this->assertEquals(
            self::URI,
            $request->getUri()->__toString()
        );
    }

    private function getHandledRequest(RequestInterface $request): RequestInterface
    {
        $middleware = new Authentication(self::API_KEY);
        return $middleware(function (RequestInterface $request) {
            return $request;
        })($request);
    }

    public function testHeader()
    {
        $request = $this->getHandledRequest(new Request(self::METHOD, self::URI, []));
        $this->assertEquals(
            self::API_KEY,
            $request->getHeaderLine('X-CMC_PRO_API_KEY')
        );
    }
}
