<?php 

namespace Src\Controllers;
use Src\Services\AnnualContentService;

class AnnualContentController
{
    private $AnnualContentService;

    function __construct()
    {
        $this->AnnualContentService = new AnnualContentService();
    }

    function postAnnualContent()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->AnnualContentService->create($postData);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAnnualContent($request)
    {
        $AnnualContentId = $request["annualContentId"];
        $payload = $this->AnnualContentService->get($AnnualContentId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllAnnualContent()
    {
        $payload = $this->AnnualContentService->getAll();

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteAnnualContent($request)
    {
        $annualContentId = $request["annualContentId"];
        $payload = $this->AnnualContentService->delete($annualContentId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function updateAnnualContent($request)
    {
        $annualContentId = $request["annualContentId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->AnnualContentService->update($annualContentId, $postData);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

}