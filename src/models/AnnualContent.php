<?php

namespace Src\Models;

use PDOException;
class AnnualContent
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    function create($request)
    {
        $annual_body = $request["annual_body"];
        $annual_report_id = $request["annual_report_id"];

        $queryStr = "INSERT INTO AnnualContent(annual_body, annual_report_id) VALUES (:annual_body, :annual_report_id)";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "annual_body" => $annual_body,
                "annual_report_id" => $annual_report_id,
            ));
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function get($annualContentId)
    {
        $queryStr = "SELECT * FROM AnnualContent WHERE annual_content_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute(array("id" => $annualContentId));
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
            $queryStr = "SELECT * FROM AnnualContent";
        }else{
            $queryStr = "SELECT * FROM AnnualContent WHERE $filter";
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

    function update($annualContentId, $request)
    {
        $annual_body = $request["annual_body"];
        $annual_report_id = $request["annual_report_id"];

        $queryStr = "UPDATE AnnualContent SET annual_body = :annual_body, annual_report_id = :annual_report_id WHERE annual_content_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute(array(
                "annual_body" => $annual_body,
                "annual_report_id" => $annual_report_id,
                "id" => $annualContentId
            ));
            return true;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    function delete($annualContentId)
    {
        $queryStr = "DELETE FROM AnnualContent WHERE annual_content_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try{
            $stmt->execute(array("id" => $annualContentId));
            return true;
        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}
