<?php

namespace Src\Services;

use Src\Models\Authentication;
use Src\Models\Workspace;
use Src\Config\DatabaseConnector;
use Src\Models\UserWorkspace;
use Src\Utils\Checker;
use Src\Utils\Response;
use Src\Utils\Filter;

class WorkspaceService
{
    private $workspaceModel;
    private $pdo;
    private $tokenService;
    private $filter;

    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->workspaceModel = new Workspace($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("name");
    }

    function create($workspace)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($workspace, ["name"])) {
            return Response::payload(
                400,
                false,
                "name is required"
            );
        }

        $creation = $this->workspaceModel->create($workspace);

        if ($creation === false) {
            return Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
        }

        return $creation ? Response::payload(
            201,
            true,
            "workspace creation successful",
            array("workspace_id" => $this->workspaceModel->get($creation))
        ) : Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
    }

    function getWithUser($user_id, $workspace_id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }


        $workspace = $this->workspaceModel->getWithUser($user_id, $workspace_id);

        if (!$workspace) {
            return Response::payload(404, false, "workspace not found");
        }
        return $workspace ? Response::payload(
            200,
            true,
            "workspace found",
            array("workspace" => $workspace)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function getAllWithUser($user_id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }


        $workspaces = $this->workspaceModel->getAllWithUser($user_id);

        if (!$workspaces) {
            return Response::payload(404, false, "workspaces not found");
        }
        return $workspaces ? Response::payload(
            200,
            true,
            "workspace found",
            array("workspace" => $workspaces)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function getAll()
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $filterStr = $this->filter->getFilterStr();

        if (str_contains($filterStr, "unavailable") || str_contains($filterStr, "empty")) {
            return Response::payload(400, false, $filterStr);
        }

        $workspaces = $this->workspaceModel->getAll($filterStr);

        if (!$workspaces) {
            return Response::payload(404, false, "workspaces not found");
        }
        return $workspaces ? Response::payload(
            200,
            true,
            "workspace found",
            array("workspace" => $workspaces)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function get($workspaceId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $workspace = $this->workspaceModel->get($workspaceId);

        if (!$workspace) {
            return Response::payload(404, false, "workspace not found");
        }
        return $workspace ? Response::payload(
            200,
            true,
            "workspace found",
            array("workspace" => $workspace)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($workspace, $id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $updated_workspace = $this->workspaceModel->update($workspace, $id);

        if (!$updated_workspace) {
            return Response::payload(404, false, "update unsuccessful");
        }

        return $updated_workspace ? Response::payload(
            200,
            true,
            "update successful",
            array("workspace" => $this->workspaceModel->get($updated_workspace))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function delete($workspaceId)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $workspace = $this->workspaceModel->delete($workspaceId);

        if (!$workspace) {
            return Response::payload(404, false, "deletion unsuccessful");
        }

        return $workspace ? Response::payload(
            200,
            true,
            "deletion successful",
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
