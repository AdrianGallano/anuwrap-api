<?php

namespace Src\Models;

use PDOException;

class Report
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    function get($id)
    {
        $queryStr = "SELECT * FROM report WHERE report_id = :id";

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
    }

    function getAll($filter = "")
    {
        if($filter == ""){
            $queryStr = "SELECT * FROM report";
        }else{
            $queryStr = "SELECT * FROM report WHERE $filter";
        }

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute();

            $report = $stmt->fetchAll();
            return $report;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    function create($request)
    {
        $title = $request["title"];
        $report_type_id = $request["report_type_id"];
        $workspace_id = $request["workspace_id"];

        $queryStr = "INSERT INTO 
        report(title, report_type_id, workspace_id) VALUES
        (:title, :report_type_id, :workspace_id)";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "title" => $title,
                "report_type_id" => $report_type_id,
                "workspace_id" => $workspace_id,
            ));
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    function delete($id)
    {
        $queryStr = "DELETE FROM report WHERE report_id = :id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "id" => $id,
                )
            );
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    function update($request, $id)
    {
        $title = $request["title"];
        $report_type_id = $request["report_type_id"];
        $workspace_id = $request["workspace_id"];

        $queryStr = "UPDATE report 
            SET title=:title, report_type_id=:report_type_id, workspace_id=:workspace_id WHERE report_id = :id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "title" => $title,
                    "report_type_id" => $report_type_id,
                    "workspace_id" => $workspace_id,
                    "id" => $id
                )
            );
            return $id;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
