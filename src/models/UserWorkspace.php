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
        UserWorkspace(user_id, workspace_id, role_id) VALUES
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
        $queryStr = "SELECT UserWorkspace.*, Workspace.*, User.*, Role.role_id, Role.name as role_name FROM UserWorkspace
        JOIN Workspace ON UserWorkspace.workspace_id = Workspace.workspace_id
        JOIN User ON UserWorkspace.user_id = User.user_id
        JOIN Role ON UserWorkspace.role_id = Role.role_id WHERE UserWorkspace.user_id = :user_id AND UserWorkspace.workspace_id = :workspace_id";
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
            $queryStr = "SELECT UserWorkspace.*, Workspace.*, User.*, Role.role_id, Role.name as role_name FROM UserWorkspace
            JOIN Workspace ON UserWorkspace.workspace_id = Workspace.workspace_id
            JOIN User ON UserWorkspace.user_id = User.user_id
            JOIN Role ON UserWorkspace.role_id = Role.role_id";
        } else {
            
            $queryStr = "SELECT UserWorkspace.*, Workspace.*, User.*, Role.role_id, Role.name as role_name FROM UserWorkspace
            JOIN Workspace ON UserWorkspace.workspace_id = Workspace.workspace_id
            JOIN User ON UserWorkspace.user_id = User.user_id
            JOIN Role ON UserWorkspace.role_id = Role.role_id WHERE UserWorkspace.$filterStr";
        }


        try {
            $stmt = $this->pdo->prepare($queryStr);
            $stmt->execute();
            $workspace = $stmt->fetchAll();
            return $workspace;
        } catch (PDOException $e) {
            var_dump($e);
            error_log($e->getMessage());
            return null;
        }
    }

    function getAllWorkspaceWithUser($id)
    {
        $queryStr = "SELECT * FROM UserWorkspace WHERE user_id = :id";
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
        $queryStr = "SELECT * FROM UserWorkspace WHERE workspace_id = :id";
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
        $queryStr = "DELETE FROM UserWorkspace WHERE workspace_id = :workspace_id AND user_id = :user_id";

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

        $queryStr = "UPDATE UserWorkspace 
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
