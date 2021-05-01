<?php

declare(strict_types=1);

namespace R3bers\CMCapApi;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use R3bers\CMCapApi\Api\Cryptocurrency;
use R3bers\CMCapApi\Exception\InvalidCredentialException;
use R3bers\CMCapApi\Middleware\Authentication;

class CMCapClient
{
    /**
     * Main URL to CoinMarketCap API Endpoint
     */
    private const BASE_URI = 'https://pro-api.coinmarketcap.com';

    private const CLIENT_HEADER = [
        'User-Agent' => 'r3bers/cmcap-api/1.0.0',
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    /** @var Client */
    private $privateClient;

    /** @var string */
    private $key = '';

    /**
     * @param string $key
     * @throws InvalidCredentialException
     */
    public function setCredential(string $key): void
    {

        if (!$this->isValidUuid($key))
            throw new InvalidCredentialException('API Key and Secret have bad format');
        $this->key = $key;
    }

    /**
     * @param $uuid
     * @return bool
     */
    public function isValidUuid($uuid): bool
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }

    /**
     * @return Cryptocurrency
     * @throws InvalidCredentialException
     */
    public function cryptocurrency(): Cryptocurrency
    {
        return new Cryptocurrency($this->getPrivateClient());
    }

    /**
     * @return Client
     * @throws InvalidCredentialException
     */
    private function getPrivateClient(): Client
    {
        return $this->privateClient ?: $this->createPrivateClient();
    }

    /**
     * @return Client
     * @throws InvalidCredentialException
     */
    private function createPrivateClient(): Client
    {
        if (!$this->isValidUuid($this->key))
            throw new InvalidCredentialException('Key and secret must be set before call Private API');

        $stack = HandlerStack::create();
        $stack->push(new Authentication($this->key));

        return new Client([
            'headers' => self::CLIENT_HEADER,
            'handler' => $stack,
            'base_uri' => self::BASE_URI
        ]);
    }
}