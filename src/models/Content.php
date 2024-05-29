<?php

namespace Src\Models;

use PDOException;
class Content
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    function create($request)
    {
        $body = $request["body"];
        $report_id = $request["report_id"];
        $report_type_id = $request["report_type_id"];

        $queryStr = "INSERT INTO Content(body, report_id, report_type_id) VALUES (:body, :report_id, :report_type_id)";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "body" => $body,
                "report_id" => $report_id,
                "report_type_id" => $report_type_id
            ));
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function get($contentId)
    {
        $queryStr = "SELECT * FROM Content WHERE id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute(array("id" => $contentId));
            $content = $stmt->fetch();
            return $content;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return null;
        }

    }

    function getAll($filter = "")
    {
        if($filter == ""){
            $queryStr = "SELECT * FROM Content";
        }else{
            $queryStr = "SELECT * FROM Content WHERE $filter";
        }

        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute();
            $content = $stmt->fetchAll();
            return $content;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return null;
        }
    }

    function update($contentId, $request)
    {
        $body = $request["body"];
        $report_id = $request["report_id"];
        $report_type_id = $request["report_type_id"];

        $queryStr = "UPDATE Content SET body = :body, report_id = :report_id, report_type_id = :report_type_id WHERE id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute(array(
                "body" => $body,
                "report_id" => $report_id,
                "report_type_id" => $report_type_id,
                "id" => $contentId
            ));
            return true;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    function delete($contentId)
    {
        $queryStr = "DELETE FROM Content WHERE id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute(array("id" => $contentId));
            return true;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}
