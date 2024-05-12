<?php

namespace Src\Models;

use PDOException;

class User
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function get($id)
    {
        $queryStr = "SELECT user_id, username, first_name, last_name, email, status, image_name FROM user WHERE user_id=:id";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(array(
                "id" => $id
            ));
            $user = $stmt->fetch();
            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT user_id, username, first_name, last_name, email, status, image_name FROM user";
        } else {
            $queryStr = "SELECT user_id, username, first_name, last_name, email, status, image_name FROM user WHERE $filterStr";
        }

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute();
            $user = $stmt->fetchAll();
            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    function create($user)
    {
        $username = $user['username'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $password = $user['password'];
        $status = $user['status'];
        $image_name = $user['image_name'];

        $queryStr = "INSERT INTO user (username, first_name, last_name, email, password,status, image_name) 
        VALUES (:username, :first_name, :last_name, :email, :password, :status, :image_name)";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "username" => $username,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "password" => password_hash($password, PASSWORD_DEFAULT),
                    "status" => $status,
                    "image_name" => $image_name
                )
            );
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function update($id, $request)
    {
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $status = $request['status'];
        $image_name = $request['image_name'];
        
        $queryStr = "UPDATE user 
        SET first_name=:first_name,
        last_name=:last_name
        WHERE user_id = :id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "status" => $status,
                    "image_name" => $image_name,
                    "id" => $id
                )
            );
            return $id;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    function delete($id)
    {
        $queryStr = "DELETE FROM user WHERE user_id = :id";

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
            return false;
        }
    }
}
