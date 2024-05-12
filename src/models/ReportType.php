<?php

namespace Src\Models;

use PDOException;

class ReportType
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT * FROM ReportType";
        } else {
            $queryStr = "SELECT * FROM ReportType WHERE " . $filterStr;
        }
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute();
            $reportType = $stmt->fetchAll();
            return $reportType;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    function get($report_type_id)
    {
        $queryStr = "SELECT * FROM ReportType WHERE report_type_id = :report_type_id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "report_type_id" => $report_type_id
                )
            );
            $reportType = $stmt->fetch();
            return $reportType;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

/*     function get($id)
    {
        $queryStr = "SELECT Report.*, ReportType.* FROM Report 
        JOIN ReportType ON Report.report_type_id = ReportType.report_type_id 
        WHERE Report.report_id = :id";
        
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "id" => $id
            ));

            $report = $stmt->fetch();
            return $report;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    } */

/*     function getAll($workspace_id)
    {
        $queryStr = "SELECT Report.*, ReportType.* FROM Report 
        JOIN ReportType ON Report.report_type_id = ReportType.report_type_id 
        WHERE Report.workspace_id = :workspace_id";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "workspace_id" => $workspace_id
            ));

            $report = $stmt->fetchAll();
            return $report;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    } */

}
