<?php
namespace Src\Services;

use Src\Models\Role;
use Src\Config\DatabaseConnector;
use Src\Services\TokenService;
use Src\Utils\Response;
use Src\Utils\Filter;

class RoleService
{
    private $roleModel;
    private $pdo;
    private $tokenService;
    private $filter;

    function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->roleModel = new Role($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("name");
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

        $roles = $this->roleModel->getAll($filterStr);
        if (!$roles) {
            return Response::payload(404, false, "roles not found");
        } 

        return $roles ? Response::payload(
            200,
            true,
            "roles found",
            array("roles" => $roles)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function get($id)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $role = $this->roleModel->get($id);
        if (!$role) {
            return Response::payload(404, false, "role not found");
        }

        return $role ? Response::payload(
            200,
            true,
            "role found",
            array("role" => $role)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}