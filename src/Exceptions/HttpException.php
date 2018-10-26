<?php

namespace RIPS\Connector\Exceptions;

use RIPS\Connector\Entities\Response;

class HttpException extends \RuntimeException
{
    /** @var Response */
    private $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $data = $response->getDecodedData();
        parent::__construct($data->message, $data->code);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
