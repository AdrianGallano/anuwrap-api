<?php

namespace Src\Routes\Api\V1;

use FastRoute;
use Src\Controllers\AnnualReportController;
use Src\Controllers\ReportController;
use Src\Controllers\TokenController;
use Src\Controllers\UserController;
use Src\Controllers\WorkspaceController;
use Src\Controllers\UserWorkspaceController;
use Src\Controllers\DocumentationController;
use Src\Controllers\RoleController;
use Src\Controllers\ReportTypeController;
use Src\Controllers\ReportSelectionController;
use Src\Controllers\ContentController;

class Router
{
    private $dispatcher;
    public function __construct()
    {
        $this->dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/docs', [DocumentationController::class, 'getDocs']);

            /* users */
            $r->addRoute('POST', '/users', [UserController::class, 'postUser']);
            $r->addRoute('GET', '/users', [UserController::class, 'getAllUser']);
            $r->addRoute('GET', '/users/{userId:\d+}', [UserController::class, 'getUser']);
            $r->addRoute('PATCH', '/users/{userId:\d+}', [UserController::class, 'updateUser']);
            $r->addRoute('DELETE', '/users/{userId:\d+}', [UserController::class, 'deleteUser']);
            $r->addRoute('POST', '/users/{userId:\d+}/avatar', [UserController::class, 'uploadAvatar']);

            /* tokens */
            $r->addRoute('POST', '/token', [TokenController::class, 'postToken']);

            /* workspaces */
            $r->addRoute('POST', '/workspaces', [WorkspaceController::class, 'createWorkspace']);
            $r->addRoute('GET', '/workspaces', [WorkspaceController::class, 'getAllWorkspace']);
            $r->addRoute('GET', '/workspaces/{workspaceId:\d+}', [WorkspaceController::class, 'getWorkspace']);
            $r->addRoute('PUT', '/workspaces/{workspaceId:\d+}', [WorkspaceController::class, 'updateWorkspace']);
            $r->addRoute('DELETE', '/workspaces/{workspaceId:\d+}', [WorkspaceController::class, 'deleteWorkspace']);
            $r->addRoute('GET', '/users/{userId:\d+}/workspaces', [WorkspaceController::class, 'getAllWorkspaceWithUser']);
            $r->addRoute('GET', '/users/{userId:\d+}/workspaces/{workspaceId:\d+}', [WorkspaceController::class, 'getWorkspaceWithUser']);

            /* userworkspaces */
            $r->addRoute('POST', '/userworkspaces', [UserWorkspaceController::class, 'createUserWorkspace']);
            $r->addRoute('GET', '/userworkspaces', [UserWorkspaceController::class, 'getAllUserWorkspace']);
            $r->addRoute('GET', '/users/{userId:\d+}/workspaces/{workspaceId:\d+}/userworkspaces', [UserWorkspaceController::class, 'getUserWorkspace']);
            $r->addRoute('GET', '/users/{userId:\d+}/userworkspaces', [UserWorkspaceController::class, 'getAllUserWorkspaceWithUser']);
            $r->addRoute('GET', '/workspaces/{workspaceId:\d+}/userworkspaces', [UserWorkspaceController::class, 'getAllUserWorkspaceWithWorkspace']);
            $r->addRoute('PATCH', '/users/{userId:\d+}/workspaces/{workspaceId:\d+}/userworkspaces', [UserWorkspaceController::class, 'updateUserWorkspace']);
            $r->addRoute('DELETE', '/users/{userId:\d+}/workspaces/{workspaceId:\d+}/userworkspaces', [UserWorkspaceController::class, 'deleteUserWorkspace']);

            /* report types */
            $r->addRoute('GET', '/report-types', [ReportTypeController::class, 'getAllReportTypes']);
            $r->addRoute('GET', '/report-types/{reportTypeId:\d+}', [ReportTypeController::class, 'getReportType']);

            /* reports*/
            $r->addRoute('POST', '/reports', [ReportController::class, 'createReport']);
            $r->addRoute('GET', '/reports', [ReportController::class, 'getAllReport']);
            $r->addRoute('GET', '/reports/{reportId:\d+}', [ReportController::class, 'getReport']);
            $r->addRoute('PUT', '/reports/{reportId:\d+}', [ReportController::class, 'updateReport']);
            $r->addRoute('DELETE', '/reports/{reportId:\d+}', [ReportController::class, 'deleteReport']);

            /* roles */
            $r->addRoute('GET', '/roles', [RoleController::class, 'getAllRole']);
            $r->addRoute('GET', '/roles/{roleId:\d+}', [RoleController::class, 'getRole']);

            /* report selections */
            $r->addRoute('POST', '/report-selections', [ReportSelectionController::class, 'createReportSelection']);
            $r->addRoute('GET', '/report-selections', [ReportSelectionController::class, 'getAllReportSelection']);
            $r->addRoute('GET', '/annual-reports/{annualReportId:\d+}/reports/{reportId:\d+}/report-selections', [ReportSelectionController::class, 'getReportSelection']);
            $r->addRoute('PUT', '/annual-reports/{annualReportId:\d+}/reports/{reportId:\d+}/report-selections', [ReportSelectionController::class, 'updateReportSelection']);
            $r->addRoute('DELETE', '/annual-reports/{annualReportId:\d+}/reports/{reportId:\d+}/report-selections', [ReportSelectionController::class, 'deleteReportSelection']);

            /* annual report */
            $r->addRoute('POST', '/annual-reports', [AnnualReportController::class, 'createAnnualReport']);
            $r->addRoute('GET', '/annual-reports', [AnnualReportController::class, 'getAllAnnualReport']);
            $r->addRoute('GET', '/annual-reports/{annualReportId:\d+}', [AnnualReportController::class, 'getAnnualReport']);
            $r->addRoute('PUT', '/annual-reports/{annualReportId:\d+}', [AnnualReportController::class, 'updateAnnualReport']);
            $r->addRoute('DELETE', '/annual-reports/{annualReportId:\d+}', [AnnualReportController::class, 'deleteAnnualReport']);
            
            /* content */
            $r->addRoute('POST', '/contents', [ContentController::class, 'createContent']);
            $r->addRoute('GET', '/contents', [ContentController::class, 'getAllContent']);
            $r->addRoute('GET', '/contents/{contentId:\d+}', [ContentController::class, 'getContent']);
            $r->addRoute('DELETE', '/contents/{contentId:\d+}', [ContentController::class, 'deleteContent']);
            $r->addRoute('PUT', '/contents/{contentId:\d+}', [ContentController::class, 'updateContent']);
        });
    }

    public function handle($method, $uri)
    {
        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo json_encode(array("error" => "Not found"));
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                echo json_encode(array("error" => "Method not allowed"));
                break;
            case FastRoute\Dispatcher::FOUND:
                $controllerName = $routeInfo[1][0];
                $method = $routeInfo[1][1];
                $vars = $routeInfo[2];

                $controller = new $controllerName();

                if (count($vars) == 0) {
                    $controller->$method();
                } else {
                    $controller->$method($vars);
                }
                break;
        }
    }
}
