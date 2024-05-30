<?php

namespace Src\Services;

use Src\Models\AnnualContent;
use Src\Config\DatabaseConnector;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Services\TokenService;
use Src\Utils\Filter;

class AnnualContentService
{
    private $pdo;
    private $annualContentModel;
    private $tokenService;
    private $filter;


    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->annualContentModel = new AnnualContent($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("annual_body", "annual_report_id");
    }


    function create($request)
    {

        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["annual_body", "annual_report_id"])) {
            return Response::payload(
                400,
                false,
                "annual_body, and annual_report_id is required"
            );
        }

        $annualContentId = $this->annualContentModel->create($request);

        if (!$annualContentId) {
            return Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
        }

        return $annualContentId ? Response::payload(
            201,
            true,
            "annual content created successfully",
            array("annual_content" => $this->annualContentModel->get($annualContentId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)");
    }

    function get($annualContentId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $annualcontent = $this->annualContentModel->get($annualContentId);

        if (!$annualcontent) {
            return Response::payload(404, false, "annual content not found");
        }

        return $annualcontent ? Response::payload(
            200,
            true,
            "annual content found",
            array("annual_content" => $annualcontent)
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


        $annualcontent = $this->annualContentModel->getAll($filterStr);

        if (!$annualcontent) {
            return Response::payload(404, false, "annual content not found");
        }

        return $annualcontent ? Response::payload(
            200,
            true,
            "annual content found",
            array("annual_content" => $annualcontent)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($annualContentId, $request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["annual_body", "annual_report_id"])) {
            return Response::payload(
                400,
                false,
                "annual_body, and annual_report_id is required"
            );
        }

        $annualcontent = $this->annualContentModel->update($annualContentId, $request);

        if (!$annualcontent) {
            return Response::payload(404, false, "annual content not found");
        }

        return $annualcontent ? Response::payload(
            200,
            true,
            "annual content updated successfully",
            array("annual_content" => $this->annualContentModel->get($annualContentId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)");
    }

    function delete($annualContentId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $annualcontent = $this->annualContentModel->delete($annualContentId);

        if (!$annualcontent) {
            return Response::payload(404, false, "annualcontent not found");
        }

        return $annualcontent ? Response::payload(
            200,
            true,
            "annual content deleted successfully",
            array("annual_content" => $annualcontent)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)");
    }
}
