<?php

namespace RIPS\Connector\Entities;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /** @var ResponseInterface */
    private $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get original Guzzle response.
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getRawData()
    {
        return $this->response->getBody();
    }

    /**
     * @return mixed
     */
    public function getDecodedData()
    {
        return json_decode($this->response->getBody());
    }
}
