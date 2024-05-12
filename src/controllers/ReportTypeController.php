<?php

namespace Src\Controllers;

use Src\Services\ReportTypeService;

class ReportTypeController
{
    private $reportTypeService;

    function __construct()
    {
        $this->reportTypeService = new ReportTypeService();
    }

    function getAllReportTypes()
    {
        $payload = $this->reportTypeService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function getReportType($request)
    {
        $reportTypeId = $request["reportTypeId"];
        $payload = $this->reportTypeService->get($reportTypeId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }
}
