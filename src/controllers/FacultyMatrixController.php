<?php

namespace Src\Controllers;

use Src\Services\FacultyMatrixService;

class FacultyMatrixController
{
    private $facultyMatrixService;

    function __construct()
    {
        $this->facultyMatrixService = new FacultyMatrixService();
    }

    function createFacultyMatrix()
    {
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->facultyMatrixService->create($postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getFacultyMatrix($request)
    {
        $facultyMatrixId = $request["facultyMatrixId"];
        $payload = $this->facultyMatrixService->get($facultyMatrixId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function getAllFacultyMatrix()
    {
        $payload = $this->facultyMatrixService->getAll();

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function deleteFacultyMatrix($request)
    {
        $facultyMatrixId = $request["facultyMatrixId"];
        $payload = $this->facultyMatrixService->delete($facultyMatrixId);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }

    function updateFacultyMatrix($request)
    {
        $facultyMatrixId = $request["facultyMatrixId"];
        $postData = json_decode(file_get_contents("php://input"));
        $postData = json_decode(json_encode($postData), true);
        $payload = $this->facultyMatrixService->update($facultyMatrixId, $postData);

        if (array_key_exists("code", $payload)) {
            http_response_code($payload["code"]);
            unset($payload["code"]);
        }
        echo json_encode($payload);
    }
}
