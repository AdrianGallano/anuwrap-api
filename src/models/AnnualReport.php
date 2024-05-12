<?php

namespace Src\Models;

use PDOException;

class AnnualReport
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function create($request)
    {
        $annualreport_title = $request["annualreport_title"];
        $description = $request["description"];
        $workspace_id = $request["workspace_id"];

        $queryStr = "INSERT INTO AnnualReport (annualreport_title, description, workspace_id) VALUES (:annualreport_title, :description, :workspace_id)";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "annualreport_title" => $annualreport_title,
                    "description" => $description,
                    "workspace_id" => $workspace_id
                )
            );
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    function get($annual_report_id)
    {
        $queryStr = "SELECT * FROM AnnualReport WHERE annual_report_id = :annual_report_id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(['annual_report_id' => $annual_report_id]);
            $report = $stmt->fetch();
            return $report;
        } catch (PDOException $e) {
            return false;
        }
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT * FROM AnnualReport";
        } else {
            $queryStr = "SELECT * FROM AnnualReport WHERE $filterStr";
        }

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute();
            $reports = $stmt->fetchAll();
            return $reports;
        } catch (PDOException $e) {
            return false;
        }
    }

    function delete($annual_report_id)
    {
        $queryStr = "DELETE FROM AnnualReport WHERE annual_report_id = :annual_report_id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(['annual_report_id' => $annual_report_id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    function update($annual_report_id, $request)
    {
        $annualreport_title = $request["annualreport_title"];
        $description = $request["description"];
        $workspace_id = $request["workspace_id"];

        $queryStr = "UPDATE AnnualReport SET annualreport_title = :annualreport_title, description = :description, workspace_id = :workspace_id WHERE annual_report_id = :annual_report_id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "annualreport_title" => $annualreport_title,
                    "description" => $description,
                    "workspace_id" => $workspace_id,
                    "annual_report_id" => $annual_report_id
                )
            );
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
