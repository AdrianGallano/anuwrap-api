<?php

namespace Src\Models;


use PDOException;

class AccomplishmentReport
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getAll($filterStr = "")
    {
        $queryStr = "SELECT AccomplishmentReport.*, report.* FROM accomplishmentreport 
        JOIN report ON accomplishmentreport.report_id = report.report_id";

        if ($filterStr !== "") {
            $queryStr .= " WHERE accomplishmentreport.$filterStr";
        }

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute();
            $accomplishmentReports = $stmt->fetchAll();
            return $accomplishmentReports;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function create($request)
    {
        $name_of_activity = $request['name_of_activity'];
        $date_of_activity = $request['date_of_activity'];
        $venue_of_activity = $request['venue_of_activity'];
        $nature_of_activity = $request['nature_of_activity'];
        $benefits_of_the_participants = $request['benefits_of_the_participants'];
        $narrative_report = $request['narrative_report'];
        $image_name = $request['image_name'];
        $report_id = $request['report_id'];

        $queryStr = "INSERT INTO accomplishmentreport (name_of_activity, date_of_activity, venue_of_activity, nature_of_activity, benefits_of_the_participants, narrative_report, image_name, report_id) VALUES (:name_of_activity, :date_of_activity, :venue_of_activity, :nature_of_activity, :benefits_of_the_participants, :narrative_report, :image_name, :report_id)";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "name_of_activity" => $name_of_activity,
                    "date_of_activity" => $date_of_activity,
                    "venue_of_activity" => $venue_of_activity,
                    "nature_of_activity" => $nature_of_activity,
                    "benefits_of_the_participants" => $benefits_of_the_participants,
                    "narrative_report" => $narrative_report,
                    "image_name" => $image_name,
                    "report_id" => $report_id
                )
            );
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function get($id)
    {
        $queryStr = "SELECT * FROM accomplishmentreport WHERE accomplishment_report_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "id" => $id
            ));
            $accomplishmentReport = $stmt->fetch();
            return $accomplishmentReport;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function update($id, $request)
    {
        $name_of_activity = $request['name_of_activity'];
        $date_of_activity = $request['date_of_activity'];
        $venue_of_activity = $request['venue_of_activity'];
        $nature_of_activity = $request['nature_of_activity'];
        $benefits_of_the_participants = $request['benefits_of_the_participants'];
        $narrative_report = $request['narrative_report'];
        $image_name = $request['image_name'];
        $report_id = $request['report_id'];

        $queryStr = "UPDATE accomplishmentreport SET name_of_activity = :name_of_activity, date_of_activity = :date_of_activity, venue_of_activity = :venue_of_activity, nature_of_activity = :nature_of_activity, benefits_of_the_participants = :benefits_of_the_participants, narrative_report = :narrative_report, image_name = :image_name, report_id = :report_id WHERE accomplishment_report_id = :id";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "name_of_activity" => $name_of_activity,
                    "date_of_activity" => $date_of_activity,
                    "venue_of_activity" => $venue_of_activity,
                    "nature_of_activity" => $nature_of_activity,
                    "benefits_of_the_participants" => $benefits_of_the_participants,
                    "narrative_report" => $narrative_report,
                    "image_name" => $image_name,
                    "report_id" => $report_id,
                    "id" => $id
                )
            );
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function delete($id)
    {
        $queryStr = "DELETE FROM accomplishmentreport WHERE accomplishment_report_id = :id";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "id" => $id
                )
            );
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

    }
}
/* 

accomplishment_report_id	
name_of_activity
date_of_activity	
venue_of_activity	
nature_of_activity	
benefits_of_the_participants	
narrative_report	
image_name	
report_id */