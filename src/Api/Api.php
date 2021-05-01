<?php

declare(strict_types=1);

namespace R3bers\CMCapApi\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use R3bers\CMCapApi\Exception\QueryParametersException;
use R3bers\CMCapApi\Exception\TransformResponseException;
use R3bers\CMCapApi\Message\ResponseTransformer;
use TypeError;

/**
 * Class Api
 * @package R3bers\CMCapApi\Api
 */
class Api
{
    /** @var Client */
    protected $client;
    /** @var ResponseTransformer */
    protected $transformer;
    /** @var string */
    private $version = 'v1';
    private $endpoint = '/';
    private $queryType = ['id', 'slug', 'symbol'];

    /**
     * Api constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->transformer = new ResponseTransformer();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array
     * @throws GuzzleException
     * @throws TransformResponseException
     */
    public function rest(string $method, string $uri, array $options = []): array
    {
        $response = $this->client->request($method, $this->endpoint . $this->version . $uri, $options);
        return $this->transformer->transform($response);
    }


    /**
     * @throws QueryParametersException
     */
    public function processList(string $list): array
    {
        $modificator = $this->queryType[0];
        try {
            $input_list = explode(',', $list);
        } catch (TypeError $e) {
            throw new QueryParametersException('Parameters List Have bad elements');
        }
        if (!is_string($input_list[0]) or $input_list[0] == '')
            throw new QueryParametersException('First Parameter is blank, it cannot be');
        if (preg_match('/^[0-9a-zA-Z]+/', $input_list[0])) {
            if (preg_match('/^[a-z]+/', $input_list[0]))
                $modificator = $this->queryType[1];
            if (preg_match('/^[A-Z]+/', $input_list[0]))
                $modificator = $this->queryType[2];
        } else {
            throw new QueryParametersException('Cannot find any number or letter in first element');
        }
        return [$modificator => $list];
    }

    /**
     * @param string $aux
     * @param string $auxConst
     * @return string
     * @throws QueryParametersException
     */
    protected function checkAUX(string $aux, string $auxConst): string
    {
        if ($aux != '') {
            $auxArray = explode(',', $aux);
            $constArray = explode(',', $auxConst);
            foreach ($auxArray as $givenAux)
                if (!in_array($givenAux,$constArray))
                    throw new QueryParametersException('aux parameter not in available list for this command');
        }
        return $aux;
    }
}