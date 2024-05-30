<?php


namespace Src\Controllers;

use Src\Services\ReportService;

class ReportController
{
    private $reportService;
    function __construct()
    {
        $this->reportService = new ReportService();
    }

    function createReport()
    {

        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->reportService->create($postData);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getReport($request)
    {
        $reportId = $request["reportId"];
        $payload = $this->reportService->get($reportId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllReport()
    {
        $payload = $this->reportService->getAll();

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteReport($request)
    {
        $reportId = $request["reportId"];
        $payload = $this->reportService->delete($reportId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function updateReport($request)
    {
        $reportId = $request["reportId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->reportService->update($postData, $reportId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllReportsWithContentByWorkspace($request)
    {
        $workspace_id = $request["workspaceId"];
        $payload = $this->reportService->getAllReportsWithContentByWorkspace($workspace_id);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
}
