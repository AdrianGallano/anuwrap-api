<?php

namespace Src\Models;

use PDOException;

class Workspace
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getAllWithUser($id)
    {
        $queryStr = "SELECT workspace.*, userworkspace.*
        FROM workspace
        JOIN userworkspace ON workspace.workspace_id = userworkspace.workspace_id
        WHERE userworkspace.user_id = :id";
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(array(
                "id" => $id
            ));
            $workspace = $stmt->fetchAll();
            return $workspace;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function getWithUser($user_id, $workspace_id)
    {
        $queryStr = "SELECT workspace.*, userworkspace.*
        FROM workspace
        JOIN userworkspace ON workspace.workspace_id = userworkspace.workspace_id
        WHERE userworkspace.user_id = :user_id AND workspace.workspace_id = :workspace_id";
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(array(
                "user_id" => $user_id,
                "workspace_id" => $workspace_id
            ));
            $workspace = $stmt->fetchAll();
            return $workspace;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    function get($id)
    {
        $queryStr = "SELECT * FROM workspace WHERE workspace_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "id" => $id
            ));
            $workspace = $stmt->fetch();
            return $workspace;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT * FROM workspace";
        } else {
            $queryStr = "SELECT * FROM workspace WHERE $filterStr";
        }
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute();
            $workspace = $stmt->fetchAll();
            return $workspace;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function create($workspace)
    {
        $name = $workspace['name'];

        $queryStr = "INSERT INTO workspace (name) VALUES (:name)";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "name" => $name
                )
            );
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    function delete($id)
    {
        $queryStr = "DELETE FROM workspace WHERE workspace_id = :id";

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
    function update($workspace, $id)
    {
        $name = $workspace["name"];
        $queryStr = "UPDATE workspace 
            SET name=:name WHERE workspace_id = :id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "name" => $name,
                    "id" => $id,
                )
            );
            return $id;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
