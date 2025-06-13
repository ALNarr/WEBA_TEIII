<?php
require_once("Views/Response.php");
require_once("Controllers/Controller.php");

class Router {

    public static function route(string $method, ?string $action): Response|null {

        if ($action == null) {
            return new Response(httpCode: 400);
        }

        $controller = new Controller();

        switch ($action) {
        case 'projects':
            switch ($method) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        // Détails d'un projet spécifique
                        return $controller->getProjectDetails((int)$_GET['id']);
                    } else {
                        // Liste des projets (avec ou sans tâches)
                        $withTasks = isset($_GET['withTasks']) ? (bool)$_GET['withTasks'] : false;
                        return $controller->getProjects($withTasks);
                    }
                case 'POST':
                    // Ajouter un projet
                    return $controller->addProject();
                case 'DELETE':
                    // Supprimer un projet
                    if (isset($_GET['id'])) {
                        return $controller->deleteProject((int)$_GET['id']);
                    }
                    return new Response(httpCode: 400);
            }
            break;
            
        case 'tasks':
            switch ($method) {
                case 'POST':
                    // Ajouter une tâche
                    return $controller->addTask();
                case 'DELETE':
                    // Supprimer une tâche
                    if (isset($_GET['id'])) {
                        return $controller->deleteTask((int)$_GET['id']);
                    }
                    return new Response(httpCode: 400);
            }
            break;
            
        case 'lateprojects':
            if ($method === 'GET') {
                return $controller->getLateProjects();
            }
            break;
    }

    return null;
    }
}
?>