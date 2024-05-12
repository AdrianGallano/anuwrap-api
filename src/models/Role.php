<?php

namespace Src\Models;

use PDOException;

class Role
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT * FROM role";
        } else {
            $queryStr = "SELECT * FROM role WHERE $filterStr";
        }
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute();
            $roles = $stmt->fetchAll();
            return $roles;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function get($id)
    {
        $queryStr = "SELECT * FROM role WHERE role_id = :id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "id" => $id
            ));

            $role = $stmt->fetch();

            return $role;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}
