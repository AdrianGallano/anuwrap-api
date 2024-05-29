<?php 

namespace Src\Controllers;
use Src\Services\ContentService;

class ContentController
{
    private $contentService;

    function __construct()
    {
        $this->contentService = new ContentService();
    }

    function postContent()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->contentService->create($postData);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getContent($request)
    {
        $contentId = $request["contentId"];
        $payload = $this->contentService->get($contentId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllContent()
    {
        $payload = $this->contentService->getAll();

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteContent($request)
    {
        $contentId = $request["contentId"];
        $payload = $this->contentService->delete($contentId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function updateContent($request)
    {
        $contentId = $request["contentId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->contentService->update($contentId, $postData);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

}