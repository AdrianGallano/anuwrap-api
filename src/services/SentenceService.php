<?php

namespace Src\Services;

use Src\Models\Sentence;
use Src\Config\DatabaseConnector;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Services\TokenService;
use Src\Utils\Filter;

class SentenceService
{
    private $pdo;
    private $sentenceModel;
    private $tokenService;
    private $filter;

    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->sentenceModel = new Sentence($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("text");
    }

    function create($request)
    {

        if (!Checker::isFieldExist($request, ["text"])) {
            return Response::payload(400, false, "text is required");
        }

        $sentenceId = $this->sentenceModel->create($request);

        if (!$sentenceId) {
            return Response::payload(500, false, ["message" => "Contact administrator (adriangallanomain@gmail.com)"]);
        }

        return $sentenceId ? Response::payload(
            201,
            true,
            "sentence created successfully",
            ["sentence" => $this->sentenceModel->get($sentenceId)]
        ) : Response::payload(400, false, "Contact administrator (adriangallanomain@gmail.com)");
    }

    function get($sentenceId)
    {

        $sentence = $this->sentenceModel->get($sentenceId);

        if (!$sentence) {
            return Response::payload(404, false, "sentence not found");
        }

        return $sentence ? Response::payload(
            200,
            true,
            "sentence found",
            ["sentence" => $sentence]
        ) : Response::payload(400, false, "Contact administrator (adriangallanomain@gmail.com)");
    }

    function getAll()
    {

        $filterStr = $this->filter->getFilterStr();

        if (str_contains($filterStr, "unavailable") || str_contains($filterStr, "empty")) {
            return Response::payload(400, false, $filterStr);
        }

        $sentences = $this->sentenceModel->getAll($filterStr);

        if (!$sentences) {
            return Response::payload(404, false, "sentences not found");
        }

        return $sentences ? Response::payload(
            200,
            true,
            "sentences found",
            ["sentences" => $sentences]
        ) : Response::payload(400, false, "Contact administrator (adriangallanomain@gmail.com)");
    }

    function update($sentenceId, $request)
    {

        if (!Checker::isFieldExist($request, ["text"])) {
            return Response::payload(400, false, "text is required");
        }

        $sentence = $this->sentenceModel->update($sentenceId, $request);

        if (!$sentence) {
            return Response::payload(404, false, "sentence not found");
        }

        return $sentence ? Response::payload(
            200,
            true,
            "sentence updated successfully",
            ["sentence" => $this->sentenceModel->get($sentenceId)]
        ) : Response::payload(400, false, "Contact administrator (adriangallanomain@gmail.com)");
    }

    function delete($sentenceId)
{

    $sentence = $this->sentenceModel->delete($sentenceId);

    if (!$sentence) {
        return Response::payload(404, false, "sentence not found");
    }

    return $sentence ? Response::payload(
        200,
        true,
        "sentence deleted successfully"
    ) : Response::payload(400, false, "Contact administrator (adriangallanomain@gmail.com)");
}

}
