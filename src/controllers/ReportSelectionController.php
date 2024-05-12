<?php

namespace Src\Controllers;
use Src\Services\ReportSelectionService;

class ReportSelectionController{
    private $reportSelectionService;

    function __construct()
    {
        $this->reportSelectionService = new ReportSelectionService();
    }

    function createReportSelection()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->reportSelectionService->create($postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getReportSelection($request)
    {
        $reportId = $request["reportId"];
        $annualReportId = $request["annualReportId"];
        $payload = $this->reportSelectionService->get($annualReportId, $reportId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllReportSelection()
    {
        $payload = $this->reportSelectionService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteReportSelection($request)
    {
        $reportId = $request["reportId"];
        $annualReportId = $request["annualReportId"];
        $payload = $this->reportSelectionService->delete($annualReportId, $reportId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function updateReportSelection($request)
    {
        $reportId = $request["reportId"];
        $annualReportId = $request["annualReportId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->reportSelectionService->update($annualReportId, $reportId, $postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
}