<?php

namespace Src\Services;

use Src\Config\DatabaseConnector;
use Src\Models\UserWorkspace;
use Src\Utils\Response;
use Src\Utils\Checker;
use Src\Services\TokenService;
use Src\Utils\Filter;

class UserWorkspaceService
{
    private $pdo;
    private $userWorkspaceModel;
    private $tokenService;
    private $filter;
    function __construct()
    {
        $this->pdo = (new DatabaseConnector)->getConnection();
        $this->userWorkspaceModel = new UserWorkspace($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("user_id", "workspace_id", "role_id");
    }
    function create($userWorkspace)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($userWorkspace, ["user_id", "workspace_id", "role_id"])) {
            return Response::payload(
                400,
                false,
                "user_id, workspace_id, and role_id is required"
            );
        }

        $creation = $this->userWorkspaceModel->create($userWorkspace);

        return $creation ? Response::payload(
            201,
            true,
            "User Workspace creation successful",
            array("userWorkspace" => $creation)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function get($userId, $workspaceId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $userWorkspace = $this->userWorkspaceModel->get($userId, $workspaceId);

        if (!$userWorkspace) {
            return Response::payload(404, false, "User Workspace not found");
        }
        return $userWorkspace ? Response::payload(
            200,
            true,
            "User Workspace found",
            array("userWorkspace" => $userWorkspace)
        ) :  Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function getAll()
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $filterStr = $this->filter->getFilterStr();

        if(str_contains($filterStr, "unavailable") || str_contains($filterStr, "empty")){
            return Response::payload(400, false, $filterStr);
        }

        $userWorkspaces = $this->userWorkspaceModel->getAll($filterStr);

        if (!$userWorkspaces) {
            return Response::payload(404, false, "User Workspace not found");
        }
        return $userWorkspaces ? Response::payload(
            200,
            true,
            "User Workspace found",
            array("userWorkspace" => $userWorkspaces)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function getAllWithWorkspace($workspaceId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $userWorkspace = $this->userWorkspaceModel->getAllWorkspaceWithWorkspace($workspaceId);

        if (!$userWorkspace) {
            return Response::payload(404, false, "User Workspace not found");
        }
        return $userWorkspace ? Response::payload(
            200,
            true,
            "User Workspace found",
            array("userWorkspace" => $userWorkspace)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function getAllWithUser($userId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $userWorkspaces = $this->userWorkspaceModel->getAllWorkspaceWithUser($userId);

        if (!$userWorkspaces) {
            return Response::payload(404, false, "User Workspace not found");
        }
        return $userWorkspaces ? Response::payload(
            200,
            true,
            "User Workspace found",
            array("userWorkspace" => $userWorkspaces)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($userId, $workspaceId, $payload)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $userWorkspace = $this->userWorkspaceModel->update($userId, $workspaceId, $payload);

        if (!$userWorkspace) {
            return Response::payload(404, false, "update unsuccessful");
        }

        return $userWorkspace ? Response::payload(
            200,
            true,
            "update successful",
            array("userWorkspace" => $userWorkspace)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function delete($workspaceId, $userId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $userWorkspace = $this->userWorkspaceModel->delete($workspaceId, $userId);

        if (!$userWorkspace) {
            return Response::payload(404, false, "deletion unsuccessful");
        }

        return $userWorkspace ? Response::payload(
            200,
            true,
            "deletion successful",
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
