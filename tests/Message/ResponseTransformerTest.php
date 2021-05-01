<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Tests\Message;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use R3bers\CMCapApi\Exception\TransformResponseException;
use R3bers\CMCapApi\Message\ResponseTransformer;

class ResponseTransformerTest extends TestCase
{
    /**
     * @throws \R3bers\CMCapApi\Exception\TransformResponseException
     */
    public function testTransform()
    {
        $transformer = new ResponseTransformer();
        $data = ['foo' => 'bar'];
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($data));
        $this->assertEquals(array_merge($data), $transformer->transform($response));
    }

    /**
     * @throws \R3bers\CMCapApi\Exception\TransformResponseException
     */
    public function testTransformWithEmptyBody()
    {
        $transformer = new ResponseTransformer();
        $data = [];
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($data));
        $this->assertEquals($data, $transformer->transform($response));
    }

    public function testTransformThrowTransformResponseException()
    {
        $transformer = new ResponseTransformer();
        $response = new Response(200, ['Content-Type' => 'application/json'], '');
        $this->expectException(TransformResponseException::class);
        $transformer->transform($response);
    }

    public function testTransformWithIncorrectContentType()
    {
        $transformer = new ResponseTransformer();
        $data = [];
        $response = new Response(200, ['Content-Type' => 'application/javascript'], json_encode($data));
        $this->expectException(TransformResponseException::class);
        $this->assertEquals($data, $transformer->transform($response));
    }
}