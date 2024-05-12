<?php

namespace Src\Models;

use PDOException;

class FacultyMatrix
{
    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function create($request)
    {
        $name = $request["name"];
        $position = $request["position"];
        $tenure = $request["tenure"];
        $status = $request["status"];
        $relatedCertificate = $request["related_certificate"];
        $doctorateDegree = $request["doctorate_degree"];
        $mastersDegree = $request["masters_degree"];
        $baccalaureateDegree = $request["baccalaureate_degree"];
        $specification = $request["specification"];
        $enrollmentStatus = $request["enrollment_status"];
        $designation = $request["designation"];
        $teachingExperience = $request["teaching_experience"];
        $organizationMembership = $request["organization_membership"];
        $reportId = $request["report_id"];

        $queryStr = "INSERT INTO FacultyMatrix (name, position, tenure, status, related_certificate, doctorate_degree, masters_degree, baccalaureate_degree, specification, enrollment_status, designation, teaching_experience, organization_membership, report_id) VALUES (:name, :position, :tenure, :status, :related_certificate, :doctorate_degree, :masters_degree, :baccalaureate_degree, :specification, :enrollment_status, :designation, :teaching_experience, :organization_membership, :report_id)";
        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "name" => $name,
                    "position" => $position,
                    "tenure" => $tenure,
                    "status" => $status,
                    "related_certificate" => $relatedCertificate,
                    "doctorate_degree" => $doctorateDegree,
                    "masters_degree" => $mastersDegree,
                    "baccalaureate_degree" => $baccalaureateDegree,
                    "specification" => $specification,
                    "enrollment_status" => $enrollmentStatus,
                    "designation" => $designation,
                    "teaching_experience" => $teachingExperience,
                    "organization_membership" => $organizationMembership,
                    "report_id" => $reportId
                )
            );
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function get($id)
    {
        $queryStr = "SELECT * FROM FacultyMatrix WHERE faculty_matrix_id = :id";
        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(array(
                "id" => $id
            ));
            $facultyMatrix = $stmt->fetch();
            return $facultyMatrix;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    function getAll($filterStr = "")
    {
        if ($filterStr == "") {
            $queryStr = "SELECT FacultyMatrix.*, Report.* FROM FacultyMatrix 
            JOIN Report ON FacultyMatrix.report_id = Report.report_id";
        } else {
            $queryStr = "SELECT FacultyMatrix.*, Report.* FROM FacultyMatrix 
            JOIN Report ON FacultyMatrix.report_id = Report.report_id WHERE FacultyMatrix.$filterStr";
        }

        try {
            $stmt = $this->pdo->prepare($queryStr);
            $stmt->execute();
            $facultyMatrix = $stmt->fetchAll();
            return $facultyMatrix;
        } catch (PDOException $e) {
            var_dump($e);
            error_log($e->getMessage());
            return null;
        }
    }


    function update($id, $request)
    {
        $name = $request["name"];
        $position = $request["position"];
        $tenure = $request["tenure"];
        $status = $request["status"];
        $relatedCertificate = $request["related_certificate"];
        $doctorateDegree = $request["doctorate_degree"];
        $mastersDegree = $request["masters_degree"];
        $baccalaureateDegree = $request["baccalaureate_degree"];
        $specification = $request["specification"];
        $enrollmentStatus = $request["enrollment_status"];
        $designation = $request["designation"];
        $teachingExperience = $request["teaching_experience"];
        $organizationMembership = $request["organization_membership"];
        $reportId = $request["report_id"];

        $queryStr = "UPDATE FacultyMatrix SET name = :name, position = :position, tenure = :tenure, status = :status, related_certificate = :related_certificate, doctorate_degree = :doctorate_degree, masters_degree = :masters_degree, baccalaureate_degree = :baccalaureate_degree, specification = :specification, enrollment_status = :enrollment_status, designation = :designation, teaching_experience = :teaching_experience, organization_membership = :organization_membership, report_id = :report_id WHERE faculty_matrix_id = :id";

        $stmt = $this->pdo->prepare($queryStr);

        try {
            $stmt->execute(
                array(
                    "name" => $name,
                    "position" => $position,
                    "tenure" => $tenure,
                    "status" => $status,
                    "related_certificate" => $relatedCertificate,
                    "doctorate_degree" => $doctorateDegree,
                    "masters_degree" => $mastersDegree,
                    "baccalaureate_degree" => $baccalaureateDegree,
                    "specification" => $specification,
                    "enrollment_status" => $enrollmentStatus,
                    "designation" => $designation,
                    "teaching_experience" => $teachingExperience,
                    "organization_membership" => $organizationMembership,
                    "report_id" => $reportId,
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
        $queryStr = "DELETE FROM FacultyMatrix WHERE faculty_matrix_id = :id";

        $stmt = $this->pdo->prepare($queryStr);
        try {
            $stmt->execute(
                array(
                    "id" => $id,
                )
            );
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
