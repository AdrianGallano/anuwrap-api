<?php

namespace Src\Services;

use Src\Config\DatabaseConnector;
use Src\Models\AnnualReport;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Services\TokenService;
use Src\Utils\Filter;

class AnnualReportService
{
    private $pdo;
    private $annualReportModel;
    private $tokenService;
    private $filter;

    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->annualReportModel = new AnnualReport($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("annualreport_title", "description", "workspace_id");

    }

    function create($request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["annualreport_title", "description", "workspace_id"])) {
            return Response::payload(
                400,
                false,
                "annualreport_title, description, and workspace_id is required"
            );
        }

        
        $annualReportId = $this->annualReportModel->create($request);

        if (!$annualReportId) {
            return Response::payload(404, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
        }

        return $annualReportId ? Response::payload(
            201,
            true,
            "annual report created successfully",
            array("annualReport" => $this->annualReportModel->get($annualReportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function get($annualReportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $report = $this->annualReportModel->get($annualReportId);

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
        
        if(str_contains($filterStr, "unavailable") || str_contains($filterStr, "empty")){
            return Response::payload(400, false, $filterStr);
        }

        $reports = $this->annualReportModel->getAll($filterStr);

        if (!$reports) {
            return Response::payload(404, false, "reports not found");
        }

        return $reports ? Response::payload(
            200,
            true,
            "reports found",
            array("reports" => $reports)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($annualReportId, $request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["annualreport_title", "description", "workspace_id"])) {
            return Response::payload(
                400,
                false,
                "annualreport_title, description, and workspace_id is required"
            );
        }

        $isUpdated = $this->annualReportModel->update($annualReportId, $request);

        if (!$isUpdated) {
            return Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
        }

        return $isUpdated ? Response::payload(
            200,
            true,
            "report updated successfully",
            array("report" => $this->annualReportModel->get($annualReportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function delete($annualReportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $isDeleted = $this->annualReportModel->delete($annualReportId);

        if (!$isDeleted) {
            return Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
        }

        return $isDeleted ? Response::payload(
            200,
            true,
            "report deleted successfully",
            array("report" => $this->annualReportModel->get($annualReportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
