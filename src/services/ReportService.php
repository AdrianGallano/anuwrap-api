<?php

namespace Src\Services;

use Src\Models\Report;
use Src\Config\DatabaseConnector;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Utils\Filter;

class ReportService
{
    private $pdo;
    private $tokenService;
    private $reportModel;
    private $filter;
    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->reportModel = new Report($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("title", "workspace_id");
    }

    function create($report)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($report, ["title", "workspace_id"])) {
            return Response::payload(
                400,
                false,
                "title, and workspace_id is required"
            );
        }

        $reportId = $this->reportModel->create($report);

        if ($reportId === false) {
            return Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
        }

        return $reportId ? Response::payload(
            201,
            true,
            "report created successfully",
            array("report" => $this->reportModel->get($reportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function get($reportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $report = $this->reportModel->get($reportId);

        if (!$report) {
            return Response::payload(404, false, "report not found");
        }
        return $report ? Response::payload(
            200,
            true,
            "report found",
            array("report" => $report)
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

        $reports = $this->reportModel->getAll($filterStr);

        if (!$reports) {
            return Response::payload(404, false, "reports not found");
        }
        return $reports ? Response::payload(
            200,
            true,
            "reports found",
            array("report" => $reports)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($report, $reportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $report = $this->reportModel->update($report, $reportId);

        if (!$report) {
            return Response::payload(404, false, "update unsuccessful");
        }

        return $report ? Response::payload(
            200,
            true,
            "report updated successfully",
            array("report" => $this->reportModel->get($reportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function delete($reportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $report = $this->reportModel->delete($reportId);

        if (!$report) {
            return Response::payload(404, false, "deletion unsuccessful");
        }

        return $report ? Response::payload(
            200,
            true,
            "report deleted successfully",
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function getAllReportsWithContentByWorkspace($workspace_id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $reports = $this->reportModel->getAllReportsWithContentByWorkspace($workspace_id);

        if (!$reports) {
            return Response::payload(404, false, "reports not found");
        }
        return $reports ? Response::payload(
            200,
            true,
            "reports found",
            array("report" => $reports)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
