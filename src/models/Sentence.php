<?php

namespace Src\Models;

use PDOException;

class Sentence
{
    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function create($request)
    {
        $text = $request["text"];
        $queryStr = "INSERT INTO Sentences(text) VALUES (:text)";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(["text" => $text]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function get($sentenceId)
    {
        $queryStr = "SELECT * FROM Sentences WHERE sentence_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(["id" => $sentenceId]);
            $sentence = $stmt->fetch();
            return $sentence;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function getAll($filter = "")
    {
        if ($filter == "") {
            $queryStr = "SELECT * FROM Sentences";
        } else {
            $queryStr = "SELECT * FROM Sentences WHERE $filter";
        }

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute();
            $sentences = $stmt->fetchAll();
            return $sentences;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function update($sentenceId, $request)
    {
        $text = $request["text"];
        $queryStr = "UPDATE Sentences SET text = :text WHERE sentence_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(["text" => $text, "id" => $sentenceId]);
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function delete($sentenceId)
    {
        $queryStr = "DELETE FROM Sentences WHERE sentence_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(["id" => $sentenceId]);
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
