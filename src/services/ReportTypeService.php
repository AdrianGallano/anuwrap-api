<?php

namespace Src\Services;

use Src\Models\ReportType;
use Src\Services\TokenService;
use Src\Config\DatabaseConnector;
use Src\Utils\Response;
use Src\Utils\Filter;
class ReportTypeService
{
    private $reportTypeModel;
    private $pdo;
    private $tokenService;
    private $filter;
    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->reportTypeModel = new ReportType($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("name");
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

        $reportType = $this->reportTypeModel->getAll($filterStr);

        if (!$reportType) {
            return Response::payload(404, false, "report type not found");
        }

        return $reportType ? Response::payload(
            200,
            true,
            "report type found",
            array("reportType" => $reportType)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function get($reportTypeId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $reportType = $this->reportTypeModel->get($reportTypeId);

        if (!$reportType) {
            return Response::payload(404, false, "report type not found");
        }

        return $reportType ? Response::payload(
            200,
            true,
            "report type found",
            array("reportType" => $reportType)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
