<?php

namespace RIPS\Connector\Exceptions;

use RIPS\Connector\Entities\Response;

class HttpException extends \RuntimeException
{
    /** @var Response */
    private $response;

    /** @var array|null */
    private $errors;

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

        if (property_exists($data, 'errors')) {
            $this->errors = $data->errors;
        }
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array|null
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
