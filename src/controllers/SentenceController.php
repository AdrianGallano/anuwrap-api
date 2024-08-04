<?php 

namespace Src\Controllers;

use Src\Services\SentenceService;

class SentenceController
{
    private $sentenceService;

    function __construct()
    {
        $this->sentenceService = new SentenceService();
    }

    function postSentence()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->sentenceService->create($postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getSentence($request)
    {
        $sentenceId = $request["sentenceId"];
        $payload = $this->sentenceService->get($sentenceId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getSentences()
    {
        $payload = $this->sentenceService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function putSentence($request)
    {
        $sentenceId = $request["sentenceId"];
        $putData = json_decode(file_get_contents("php://input"));
        $putData = json_decode(json_encode($putData), true);
        $payload = $this->sentenceService->update($sentenceId, $putData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteSentence($request)
{
    $sentenceId = $request["sentenceId"];
    $payload = $this->sentenceService->delete($sentenceId);

    if (array_key_exists("code", $payload)) {
        http_response_code($payload["code"]);
        unset($payload["code"]);
    }
    echo json_encode($payload);
}

}
