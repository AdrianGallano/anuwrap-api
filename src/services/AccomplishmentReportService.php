<?php

namespace Src\Services;

use Src\Models\AccomplishmentReport;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Utils\Filter;
use Src\Services\TokenService;
use Src\Config\DatabaseConnector;

class AccomplishmentReportService
{
    private $pdo;
    private $accomplishmentReportModel;
    private $tokenService;
    private $filter;

    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->accomplishmentReportModel = new AccomplishmentReport($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("name_of_activity", "date_of_activity", "venue_of_activity", "nature_of_activity", "benefits_of_the_participants", "narrative_report", "report_id");
    }

    function create($request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["name_of_activity", "date_of_activity", "venue_of_activity", "nature_of_activity", "benefits_of_the_participants", "narrative_report", "report_id"])) {
            return Response::payload(
                400,
                false,
                "name_of_activity, date_of_activity, venue_of_activity, nature_of_activity, benefits_of_the_participants, narrative_report,  and report_id is required"
            );
        }

        $accomplishmentReportId = $this->accomplishmentReportModel->create($request);

        if (!$accomplishmentReportId) {
            return Response::payload(404, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
        }

        return $accomplishmentReportId ? Response::payload(
            201,
            true,
            "accomplishment report created successfully",
            array("accomplishmentReport" => $this->accomplishmentReportModel->get($accomplishmentReportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function get($accomplishmentReportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $accomplishmentReport = $this->accomplishmentReportModel->get($accomplishmentReportId);

        if (!$accomplishmentReport) {
            return Response::payload(404, false, "accomplishment report not found");
        }

        return $accomplishmentReport ? Response::payload(
            200,
            true,
            "accomplishment report found",
            array("accomplishmentReport" => $accomplishmentReport)
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

        $accomplishmentReports = $this->accomplishmentReportModel->getAll($filterStr);

        if (!$accomplishmentReports) {
            return Response::payload(404, false, "accomplishment reports not found");
        }

        return $accomplishmentReports ? Response::payload(
            200,
            true,
            "accomplishment reports found",
            array("accomplishmentReports" => $accomplishmentReports)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($accomplishmentReportId, $request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["name_of_activity", "date_of_activity", "venue_of_activity", "nature_of_activity", "benefits_of_the_participants", "narrative_report", "report_id"])) {
            return Response::payload(
                400,
                false,
                "name_of_activity, date_of_activity, venue_of_activity, nature_of_activity, benefits_of_the_participants, narrative_report, and report_id is required"
            );
        }

        $isUpdated = $this->accomplishmentReportModel->update($accomplishmentReportId, $request);

        if (!$isUpdated) {
            return Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
        }

        return $isUpdated ? Response::payload(
            200,
            true,
            "accomplishment report updated successfully",
            array("accomplishmentReport" => $this->accomplishmentReportModel->get($accomplishmentReportId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function delete($accomplishmentReportId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $isDeleted = $this->accomplishmentReportModel->delete($accomplishmentReportId);

        if (!$isDeleted) {
            return Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
        }

        return $isDeleted ? Response::payload(
            200,
            true,
            "accomplishment report deleted successfully"
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
