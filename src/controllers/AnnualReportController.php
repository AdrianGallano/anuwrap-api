<?php

namespace Src\Controllers;

use Src\Services\AnnualReportService;

class AnnualReportController
{
    private $annaulReportService;

    function __construct()
    {
        $this->annaulReportService = new AnnualReportService();
    }

    function createAnnualReport()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->annaulReportService->create($postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function getAnnualReport($request)
    {
        $annualReportId = $request["annualReportId"];
        $payload = $this->annaulReportService->get($annualReportId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function getAllAnnualReport()
    {
        $payload = $this->annaulReportService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function deleteAnnualReport($request)
    {
        $annualReportId = $request["annualReportId"];
        $payload = $this->annaulReportService->delete($annualReportId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function updateAnnualReport($request)
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $annualReportId = $request["annualReportId"];
        $payload = $this->annaulReportService->update($annualReportId, $postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }
}
