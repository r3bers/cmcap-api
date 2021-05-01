<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Tests;

use PHPUnit\Framework\TestCase;
use R3bers\CMCapApi\Api\Cryptocurrency;
use R3bers\CMCapApi\CMCapClient;
use R3bers\CMCapApi\Exception\InvalidCredentialException;

class CMCapClientTest extends TestCase
{
    private const API_KEY = '123e4567-e89b-42d3-a456-426614174000';

    /**
     * @throws \R3bers\CMCapApi\Exception\InvalidCredentialException
     */
    public function testSetCredential()
    {
        $client = new CMCapClient();
        $this->expectException(InvalidCredentialException::class);
        $client->setCredential('Not UUID');
    }

    /**
     * @throws \R3bers\CMCapApi\Exception\InvalidCredentialException
     */
    public function testSetCredentialThrowInvalidCredentialException()
    {
        $client = new CMCapClient();
        $client->setCredential(self::API_KEY);
        $this->assertEquals(true, $client->isValidUuid(self::API_KEY));
    }

    /**
     * @throws \R3bers\CMCapApi\Exception\InvalidCredentialException
     */
    public function testCryptocurrency()
    {
        $client = new CMCapClient();
        $client->setCredential(self::API_KEY);
        $this->assertInstanceOf(Cryptocurrency::class, $client->cryptocurrency());
    }

    /**
     * @throws \R3bers\CMCapApi\Exception\InvalidCredentialException
     */
    public function testCryptocurrencyThrowInvalidCredentialException()
    {
        $client = new CMCapClient();
        $this->expectException(InvalidCredentialException::class);
        $client->cryptocurrency();
    }
}