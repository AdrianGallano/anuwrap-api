<?php

namespace Src\Models;

use PDOException;

class ReportSelection
{

    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function create($request)
    {
        $annual_report_id = $request["annual_report_id"];
        $report_id = $request["report_id"];

        $queryStr = "INSERT INTO reportselection(annual_report_id, report_id) VALUES (:annual_report_id, :report_id)";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "annual_report_id" => $annual_report_id,
                    "report_id" => $report_id
                )
            );
            return array(
                "annual_report_id" => $annual_report_id,
                "report_id" => $report_id
            );
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT reportselection.*, annualreport.*, report.* FROM reportselection
            JOIN annualreport ON reportselection.annual_report_id = annualreport.annual_report_id
            JOIN report ON reportselection.report_id = report.report_id";


        } else {
            $queryStr = "SELECT reportselection.*, annualreport.*, report.* FROM reportselection
            JOIN annualreport ON reportselection.annual_report_id = annualreport.annual_report_id
            JOIN report ON reportselection.report_id = report.report_id WHERE reportselection.$filterStr";
        }
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute();

            $reportSelection = $stmt->fetchAll();
            return $reportSelection;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    function get($annual_report_id, $report_id)
    {
        $queryStr = "SELECT * FROM reportselection WHERE annual_report_id = :annual_report_id AND report_id = :report_id";
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(array(
                "annual_report_id" => $annual_report_id,
                "report_id" => $report_id
            ));
            $reportSelection = $stmt->fetch();
            return $reportSelection;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function delete($annual_report_id, $report_id)
    {
        $queryStr = "DELETE FROM reportselection WHERE annual_report_id = :annual_report_id AND report_id = :report_id";
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(array(
                "annual_report_id" => $annual_report_id,
                "report_id" => $report_id
            ));
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function update($annual_report_id, $report_id, $request)
    {
        $new_annual_report_id = $request["annual_report_id"];
        $new_report_id = $request["report_id"];
        
        $queryStr = "UPDATE reportselection SET annual_report_id = :new_annual_report_id, report_id = :new_report_id WHERE annual_report_id = :annual_report_id AND report_id = :report_id";
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "new_annual_report_id" => $new_annual_report_id,
                    "new_report_id" => $new_report_id,
                    "annual_report_id" => $annual_report_id,
                    "report_id" => $report_id
                )
            );
            return array(
                "annual_report_id" => $new_annual_report_id,
                "report_id" => $new_report_id
            );
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
