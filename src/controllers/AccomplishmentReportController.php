<?php

namespace Src\Controllers;

use Src\Services\AccomplishmentReportService;

class AccomplishmentReportController
{
    private $accomplishmentReportService;

    function __construct()
    {
        $this->accomplishmentReportService = new AccomplishmentReportService();
    }

    function createAccomplishmentReport()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->accomplishmentReportService->create($postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function getAccomplishmentReport($request)
    {
        $accomplishmentReportId = $request["accomplishmentReportId"];
        $payload = $this->accomplishmentReportService->get($accomplishmentReportId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function getAllAccomplishmentReport()
    {
        $payload = $this->accomplishmentReportService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function deleteAccomplishmentReport($request)
    {
        $accomplishmentReportId = $request["accomplishmentReportId"];
        $payload = $this->accomplishmentReportService->delete($accomplishmentReportId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function updateAccomplishmentReport($request)
    {
        $accomplishmentReportId = $request["accomplishmentReportId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->accomplishmentReportService->update($accomplishmentReportId, $postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

}
