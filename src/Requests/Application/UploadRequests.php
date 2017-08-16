<?php

namespace RIPS\Connector\Requests\Application;

use RIPS\Connector\Requests\BaseRequest;

class UploadRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/applications';

    /**
     * Upload a new file
     *
     * @param int $applicationId
     * @param string $filename
     * @param $contents
     * @return array
     */
    public function upload(int $applicationId, string $filename, $contents)
    {
        $response = $this->client->post("{$this->uri}/{$applicationId}/uploads", [
            'multipart' => [
                [
                    'name' => 'upload[file]',
                    'contents' => $contents,
                    'filename' => $filename,
                ],
            ],
        ]);

        return $this->handleResponse($response);
    }
}
