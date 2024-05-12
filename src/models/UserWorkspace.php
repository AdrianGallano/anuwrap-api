<?php

namespace Src\Models;

use PDOException;

class UserWorkspace
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function create($request)
    {
        $user_id = $request["user_id"];
        $workspace_id = $request["workspace_id"];
        $role_id = $request["role_id"];

        $queryStr = "INSERT INTO 
        userworkspace(user_id, workspace_id, role_id) VALUES
        (:user_id, :workspace_id, :role_id)";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "user_id" => $user_id,
                "workspace_id" => $workspace_id,
                "role_id" => $role_id
            ));
            return array(
                "user_id" => $user_id,
                "workspace_id" => $workspace_id,
                "role_id" => $role_id
            );
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function get($user_id, $workspace_id)
    {
        $queryStr = "SELECT userworkspace.*, workspace.*, user.*, role.role_id, role.name as role_name FROM userworkspace
        JOIN workspace ON userworkspace.workspace_id = workspace.workspace_id
        JOIN user ON userworkspace.user_id = user.user_id
        JOIN role ON userworkspace.role_id = role.role_id WHERE userworkspace.user_id = :user_id AND userworkspace.workspace_id = :workspace_id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "user_id" => $user_id,
                "workspace_id" => $workspace_id
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
            $queryStr = "SELECT userworkspace.*, workspace.*, user.*, role.role_id, role.name as role_name FROM userworkspace
            JOIN workspace ON userworkspace.workspace_id = workspace.workspace_id
            JOIN user ON userworkspace.user_id = user.user_id
            JOIN role ON userworkspace.role_id = role.role_id";
        } else {
            $queryStr = "SELECT userworkspace.*, workspace.*, user.*, role.role_id, role.name as role_name FROM userworkspace
            JOIN workspace ON userworkspace.workspace_id = workspace.workspace_id
            JOIN user ON userworkspace.user_id = user.user_id
            JOIN role ON userworkspace.role_id = role.role_id WHERE userworkspace.$filterStr";
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

    function getAllWorkspaceWithUser($id)
    {
        $queryStr = "SELECT * FROM userworkspace WHERE user_id = :id";
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
    function getAllWorkspaceWithWorkspace($id)
    {
        $queryStr = "SELECT * FROM userworkspace WHERE workspace_id = :id";
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
    function delete($workspace_id, $user_id)
    {
        $queryStr = "DELETE FROM userworkspace WHERE workspace_id = :workspace_id AND user_id = :user_id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "workspace_id" => $workspace_id,
                    "user_id" => $user_id
                )
            );
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    function update($user_id, $workspace_id, $payload)
    {
        $role_id = $payload["role_id"];

        $queryStr = "UPDATE userworkspace 
            SET role_id=:role_id WHERE user_id = :user_id AND workspace_id = :workspace_id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "user_id" => $user_id,
                    "workspace_id" => $workspace_id,
                    "role_id" => $role_id,
                )
            );
            return array(
                "user_id" => $user_id,
                "workspace_id" => $workspace_id,
                "role_id" => $role_id
            );
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
