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

        $queryStr = "INSERT INTO annualreport (annualreport_title, description, workspace_id) VALUES (:annualreport_title, :description, :workspace_id)";
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
        $queryStr = "SELECT * FROM annualreport WHERE annual_report_id = :annual_report_id";

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
            $queryStr = "SELECT * FROM annualreport";
        } else {
            $queryStr = "SELECT * FROM annualreport WHERE $filterStr";
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
        $queryStr = "DELETE FROM annualreport WHERE annual_report_id = :annual_report_id";

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

        $queryStr = "UPDATE annualreport SET annualreport_title = :annualreport_title, description = :description, workspace_id = :workspace_id WHERE annual_report_id = :annual_report_id";
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
