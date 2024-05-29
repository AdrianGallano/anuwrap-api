<?php

namespace Src\Services;

use Src\Models\Content;
use Src\Config\DatabaseConnector;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Services\TokenService;
use Src\Utils\Filter;

class ContentService
{
    private $pdo;
    private $contentModel;
    private $tokenService;
    private $filter;


    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->contentModel = new Content($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("body", "report_id", "report_type_id");
    }


    function create($request)
    {

        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["body", "report_id", "report_type_id"])) {
            return Response::payload(
                400,
                false,
                "body, report_id, and report_type_id is required"
            );
        }

        $contentId = $this->contentModel->create($request);

        if (!$contentId) {
            return Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
        }

        return $contentId ? Response::payload(
            201,
            true,
            "content created successfully",
            array("content" => $this->contentModel->get($contentId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)");
    }

    function get($contentId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $content = $this->contentModel->get($contentId);

        if (!$content) {
            return Response::payload(404, false, "content not found");
        }

        return $content ? Response::payload(
            200,
            true,
            "content found",
            array("content" => $content)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function getAll()
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $filterStr = $this->filter->getFilterStr();

        if (str_contains($filterStr, "unavailable") || str_contains($filterStr, "empty")) {
            return Response::payload(400, false, $filterStr);
        }


        $content = $this->contentModel->getAll($filterStr);

        if (!$content) {
            return Response::payload(404, false, "content not found");
        }

        return $content ? Response::payload(
            200,
            true,
            "content found",
            array("content" => $content)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($contentId, $request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["body", "report_id", "report_type_id"])) {
            return Response::payload(
                400,
                false,
                "body, report_id, and report_type_id is required"
            );
        }

        $content = $this->contentModel->update($contentId, $request);

        if (!$content) {
            return Response::payload(404, false, "content not found");
        }

        return $content ? Response::payload(
            200,
            true,
            "content updated successfully",
            array("content" => $this->contentModel->get($contentId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)");
    }

    function delete($contentId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $content = $this->contentModel->get($contentId);

        if (!$content) {
            return Response::payload(404, false, "content not found");
        }

        return $content ? Response::payload(
            200,
            true,
            "content deleted successfully",
            array("content" => $content)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)");
    }
}
