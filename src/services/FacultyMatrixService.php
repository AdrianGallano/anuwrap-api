<?php

namespace Src\Services;

use Src\Models\FacultyMatrix;
use Src\Utils\Response;
use Src\Config\DatabaseConnector;
use Src\Services\TokenService;
use Src\Utils\Checker;
use Src\Utils\Filter;
class FacultyMatrixService
{
    private $pdo;
    private $facultyMatrixModel;
    private $tokenService;
    private $filter;

    public function __construct()
    {
        $this->pdo = (new DatabaseConnector())->getConnection();
        $this->facultyMatrixModel = new FacultyMatrix($this->pdo);
        $this->tokenService = new TokenService();
        $this->filter = new Filter("name", "position", "tenure", "status", "related_certificate", "doctorate_degree", "masters_degree", "baccalaureate_degree", "specification", "enrollment_status", "designation", "teaching_experience", "organization_membership", "report_id");
    }

    function create($request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["name", "position", "tenure", "status", "related_certificate", "doctorate_degree", "masters_degree", "baccalaureate_degree", "specification", "enrollment_status", "designation", "teaching_experience", "organization_membership", "report_id"])) {
            return Response::payload(
                400,
                false,
                "name, position, tenure, status, related_certificate, doctorate_degree, masters_degree, baccalaureate_degree, specification, enrollment_status, designation, teaching_experience, organization_membership, and report_id are required"
            );
        }

        $facultyMatrixId = $this->facultyMatrixModel->create($request);

        if (!$facultyMatrixId) {
            return Response::payload(500, false, array("message" => "Contact administrator (adriangallanomain@gmail.com)"));
        }

        return $facultyMatrixId ? Response::payload(
            201,
            true,
            "faculty matrix created successfully",
            array("facultyMatrix" => $this->facultyMatrixModel->get($facultyMatrixId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
    function get($facultyMatrixId)
    {
        $token = $this->tokenService->readEncodedToken();
        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $facultyMatrix = $this->facultyMatrixModel->get($facultyMatrixId);

        if (!$facultyMatrix) {
            return Response::payload(404, false, "faculty matrix not found");
        }

        return $facultyMatrix ? Response::payload(
            200,
            true,
            "faculty matrix found",
            array("facultyMatrix" => $facultyMatrix)
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

        $facultyMatrix = $this->facultyMatrixModel->getAll($filterStr);

        if (!$facultyMatrix) {
            return Response::payload(404, false, "faculty matrix not found");
        }

        return $facultyMatrix ? Response::payload(
            200,
            true,
            "faculty matrix found",
            array("facultyMatrix" => $facultyMatrix)
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function delete($facultyMatrixId)
    {
        $token = $this->tokenService->readEncodedToken();
        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        $facultyMatrix = $this->facultyMatrixModel->delete($facultyMatrixId);

        if (!$facultyMatrix) {
            return Response::payload(404, false, "deletion unsuccessful");
        }

        return $facultyMatrix ? Response::payload(
            200,
            true,
            "faculty matrix deleted",
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }

    function update($facultyMatrixId, $request)
    {
        $token = $this->tokenService->readEncodedToken();

        if (!$token) {
            return Response::payload(404, false, "unauthorized access");
        }

        if (!Checker::isFieldExist($request, ["name", "position", "tenure", "status", "related_certificate", "doctorate_degree", "masters_degree", "baccalaureate_degree", "specification", "enrollment_status", "designation", "teaching_experience", "organization_membership", "report_id"])) {
            return Response::payload(
                400,
                false,
                "name, position, tenure, status, related_certificate, doctorate_degree, masters_degree, baccalaureate_degree, specification, enrollment_status, designation, teaching_experience, organization_membership, and report_id are required"
            );
        }

        $facultyMatrix = $this->facultyMatrixModel->update($facultyMatrixId, $request);

        if (!$facultyMatrix) {
            return Response::payload(404, false, "update unsuccessful");
        }

        return $facultyMatrix ? Response::payload(
            200,
            true,
            "faculty matrix updated",
            array("facultyMatrix" => $this->facultyMatrixModel->get($facultyMatrixId))
        ) : Response::payload(400, False, message: "Contact administrator (adriangallanomain@gmail.com)",);
    }
}
