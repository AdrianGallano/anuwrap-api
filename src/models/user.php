<?php

namespace Src\Models;

use PDOException;
use Exception;
class User
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function get($id)
    {
        $queryStr = "SELECT user_id, username, first_name, last_name, email, status, image_name FROM User WHERE user_id=:id";
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
            $queryStr = "SELECT user_id, username, first_name, last_name, email, status, image_name FROM User";
        } else {
            $queryStr = "SELECT user_id, username, first_name, last_name, email, status, image_name FROM User WHERE $filterStr";
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
        $image_name = "";

        $queryStr = "INSERT INTO User (username, first_name, last_name, email, password,status, image_name) 
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

    function uploadAvatar($id, $files)
    {
        $base_directory = "../uploads/user_avatar/"; 
        # addsite url here eg. https://saddlebrown-hyena-720529.hostingersite.com/anuwrap-api/public/../uploads/user_avatar/3_exit.png
        $target_file = $base_directory . basename($id . "_" . $files['image']['name']);

        try{
            move_uploaded_file($files['image']['tmp_name'], $target_file);
        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
        
        $queryStr = "UPDATE User 
        SET image_name=:image_name
        WHERE user_id = :id";

        try {
            $stmt = $this->pdo->prepare($queryStr);
            $stmt->execute(
                array(
                    "image_name" => $target_file,
                    "id" => $id
                )
            );
            return $id;
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

        $queryStr = "UPDATE User 
        SET first_name=:first_name,
        last_name=:last_name, status=:status
        WHERE user_id = :id";

        try {
            $stmt = $this->pdo->prepare($queryStr);
            $stmt->execute(
                array(
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "status" => $status,
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
        $queryStr = "DELETE FROM User WHERE user_id = :id";

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
