<?php

namespace RIPS\Connector\Exceptions;

use RIPS\Connector\Entities\Response;

class HttpException extends \RuntimeException
{
    /** @var Response */
    private $response;

    /**
     * @param Response $response
     * @throws \Exception if no proper error is found
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $data = $response->getDecodedData();

        if (!is_object($data)) {
            throw new \Exception('Unexpected response in exception: ' . $response->getRawData());
        }

        parent::__construct(
            property_exists($data, 'message') ? $data->message : '',
            property_exists($data, 'code') ? $data->code : 0
        );
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
