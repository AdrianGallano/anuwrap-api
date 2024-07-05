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
        $queryStr = "SELECT * FROM Report WHERE report_id = :id";

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
        if ($filter == "") {
            $queryStr = "SELECT * FROM Report";
        } else {
            $queryStr = "SELECT * FROM Report WHERE $filter";
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
        $workspace_id = $request["workspace_id"];

        $queryStr = "INSERT INTO 
        Report(title, workspace_id) VALUES
        (:title, :workspace_id)";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "title" => $title,
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
        $queryStr = "DELETE FROM Report WHERE report_id = :id";

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
        $workspace_id = $request["workspace_id"];

        $queryStr = "UPDATE Report 
            SET title=:title, workspace_id=:workspace_id WHERE report_id = :id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "title" => $title,
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

    function getAllReportsWithContentByWorkspace($workspace_id)
    {
        $queryStr = "SELECT Report.*, Content.* FROM Report 
        JOIN Content ON Report.report_id = Content.report_id
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
    }
}
