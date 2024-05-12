<?php


namespace Src\Controllers;

use Src\Services\WorkspaceService;

class WorkspaceController
{
    private $workspaceService;
    function __construct()
    {
        $this->workspaceService = new WorkspaceService();
    }

    function createWorkspace()
    {

        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->workspaceService->create($postData);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getWorkspace($request)
    {
        $workspaceId = $request["workspaceId"];
        $payload = $this->workspaceService->get($workspaceId);

        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    
    function deleteWorkspace($request)
    {
        $workspaceId = $request["workspaceId"];
        $payload = $this->workspaceService->delete($workspaceId);
        
        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
    
    function updateWorkspace($request)
    {
        $workspaceId = $request["workspaceId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->workspaceService->update($postData, $workspaceId);
        
        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
    
    function getAllWorkspaceWithUser($request)
    {
        $userId = $request["userId"];
        $payload = $this->workspaceService->getAllWithUser($userId);
    
        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getWorkspaceWithUser($request)
    {
        $userId = $request["userId"];
        $workspaceId = $request["workspaceId"];
        $payload = $this->workspaceService->getWithUser($userId, $workspaceId);
    
        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllWorkspace()
    {
        $payload = $this->workspaceService->getAll();
    
        if(array_key_exists("code", $payload))
        {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
}
