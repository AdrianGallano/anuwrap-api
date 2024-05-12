<?php

namespace Src\Services;

use Src\Models\ReportSelection;
use Src\Services\TokenService;
use Src\Config\DatabaseConnector;
use Src\Utils\Response;
use Src\Utils\Checker;
use Src\Utils\Filter;

class ReportSelectionService
{
    private $reportSelectionModel;
    private $pdo;
    private $tokenService;
    private $filter;

    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->reportSelectionModel = new ReportSelection($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("annual_report_id", "report_id");
    }

    function create($request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["annual_report_id", "report_id"])) {
            return Response::payload(
                400,
                false,
                "annual_report_id and report_id are required"
            );
        }

        $reportSelection = $this->reportSelectionModel->create($request);


        if (!$reportSelection) {
            return Response::payload(400, false, "Report Selection bad request");
        }


        return $reportSelection ? Response::payload(
            201,
            true,
            "Report Selection created successfully",
            array("reportSelection" => $this->reportSelectionModel->get($reportSelection["annual_report_id"], $reportSelection["report_id"]))
        ) : Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
    }

    function delete($annual_report_id, $report_id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $reportSelection = $this->reportSelectionModel->delete($annual_report_id, $report_id);

        if (!$reportSelection) {
            return Response::payload(404, false, "Report Selection not found");
        }

        return $reportSelection ? Response::payload(
            200,
            true,
            "Report Selection deleted",
        ) : Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
    }

    function get($annual_report_id, $report_id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $reportSelection = $this->reportSelectionModel->get($annual_report_id, $report_id);

        if (!$reportSelection) {
            return Response::payload(404, false, "Report Selection not found");
        }

        return $reportSelection ? Response::payload(
            200,
            true,
            "Report Selection found",
            array("reportSelection" => $reportSelection)
        ) : Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
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
        $reportSelections = $this->reportSelectionModel->getAll($filterStr);

        if (!$reportSelections) {
            return Response::payload(404, false, "Report Selection not found");
        }

        return $reportSelections ? Response::payload(
            200,
            true,
            "Report Selection found",
            array("reportSelections" => $reportSelections)
        ) : Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
    }

    function update($annual_report_id, $report_id, $request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $reportSelection = $this->reportSelectionModel->update($annual_report_id, $report_id, $request);

        if (!$reportSelection) {
            return Response::payload(404, false, "update unsuccessful");
        }

        return $reportSelection ? Response::payload(
            200,
            true,
            "Report Selection updated",
            array("reportSelection" => $this->reportSelectionModel->get($reportSelection["annual_report_id"], $reportSelection["report_id"]))
        ) : Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
    }
}
