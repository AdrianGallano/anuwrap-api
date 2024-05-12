<?php

namespace Src\Controllers;

use Src\Services\RoleService;


class RoleController
{
    private $roleService;

    function __construct()
    {
        $this->roleService = new RoleService();
    }
    function getAllRole()
    {
        $payload = $this->roleService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }

        echo json_encode($payload);
    }

    function getRole($request)
    {
        $roleId = $request["roleId"];
        $payload = $this->roleService->get($roleId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }


        echo json_encode($payload);
    }
}
