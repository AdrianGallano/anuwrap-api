<?php

namespace Src\Controllers;

use Src\Services\UserWorkspaceService;


class UserWorkspaceController
{
    private $userWorkpaceService;
    function __construct()
    {
        $this->userWorkpaceService = new UserWorkspaceService();
    }

    function createUserWorkspace()
    {

        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->userWorkpaceService->create($postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllUserWorkspace()
    {
        $payload = $this->userWorkpaceService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getUserWorkspace($request)
    {
        $userId = $request["userId"];
        $workspaceId = $request["workspaceId"];
        $payload = $this->userWorkpaceService->get($userId, $workspaceId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllUserWorkspaceWithUser($request)
    {
        $userId = $request["userId"];
        $payload = $this->userWorkpaceService->getAllWithUser($userId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
    function getAllUserWorkspaceWithWorkspace($request)
    {
        $workspaceId = $request["workspaceId"];
        $payload = $this->userWorkpaceService->getAllWithWorkspace($workspaceId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteUserWorkspace($request)
    {
        $userId = $request["userId"];
        $workspaceId = $request["workspaceId"];
        $payload = $this->userWorkpaceService->delete($workspaceId, $userId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function updateUserWorkspace($request)
    {
        $userId = $request["userId"];
        $workspaceId = $request["workspaceId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->userWorkpaceService->update($userId, $workspaceId, $postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
}
