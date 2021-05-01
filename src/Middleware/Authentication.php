<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Middleware;

use Closure;
use Psr\Http\Message\RequestInterface;

class Authentication
{
    /** @var string */
    private $key;

    /**
     * Authentication constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @param callable $next
     * @return Closure
     */
    public function __invoke(callable $next): Closure
    {
        return function (RequestInterface $request, array $options = []) use ($next) {
            $newHeaders = [
                'X-CMC_PRO_API_KEY' => $this->key,
            ];
            foreach ($newHeaders as $key => $value)
                $request = $request->withAddedHeader($key, $value);
            return $next($request, $options);
        };
    }

}