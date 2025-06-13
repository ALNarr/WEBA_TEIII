<?php

include_once("Model/Model.php");
include_once("Views/Response.php");

class Controller {

    private $model;

    public function __construct() {
        $this->model = new Model(withErrors: true);
    }

    // Obtenir la liste des projets
public function getProjects(bool $withTasks = false): Response {
    try {
        if ($withTasks) {
            $projects = $this->model->getProjectsWithTasks();
        } else {
            $projects = $this->model->getProjects();
        }
        
        return new Response(httpCode: 200, responseString: json_encode($projects));
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}

// Obtenir les détails d'un projet
public function getProjectDetails(int $projectId): Response {
    try {
        $project = $this->model->getProjectDetails($projectId);
        
        if ($project === null) {
            return new Response(httpCode: 404);
        }
        
        return new Response(httpCode: 200, responseString: json_encode($project));
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}

// Ajouter un projet
public function addProject(): Response {
    try {
        if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
            return new Response(httpCode: 400);
        }
        
        $name = trim($_POST['name']);
        $deadline = null;
        
        if (isset($_POST['deadline']) && !empty(trim($_POST['deadline']))) {
            $deadline = trim($_POST['deadline']);
            
            // Valider le format de la date
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $deadline);
            if (!$date || $date->format('Y-m-d H:i:s') !== $deadline) {
                return new Response(httpCode: 400);
            }
        }
        
        $projectId = $this->model->addProject($name, $deadline);
        
        return new Response(httpCode: 201, responseString: json_encode(['id' => $projectId]));
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}

// Supprimer un projet
public function deleteProject(int $projectId): Response {
    try {
        $deleted = $this->model->deleteProject($projectId);
        
        if (!$deleted) {
            return new Response(httpCode: 404);
        }
        
        return new Response(httpCode: 204);
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}

// Ajouter une tâche
public function addTask(): Response {
    try {
        if (!isset($_POST['projectId']) || !isset($_POST['name']) || !isset($_POST['description']) ||
            empty(trim($_POST['name'])) || empty(trim($_POST['description']))) {
            return new Response(httpCode: 400);
        }
        
        $projectId = (int)$_POST['projectId'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        
        // Vérifier que le projet existe
        if (!$this->model->projectExists($projectId)) {
            return new Response(httpCode: 404);
        }
        
        $taskId = $this->model->addTask($projectId, $name, $description);
        
        return new Response(httpCode: 201, responseString: json_encode(['id' => $taskId]));
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}

// Supprimer une tâche
public function deleteTask(int $taskId): Response {
    try {
        $deleted = $this->model->deleteTask($taskId);
        
        if (!$deleted) {
            return new Response(httpCode: 404);
        }
        
        return new Response(httpCode: 204);
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}

// Obtenir les projets en retard
public function getLateProjects(): Response {
    try {
        $lateProjects = $this->model->getLateProjects();
        
        return new Response(httpCode: 200, responseString: json_encode($lateProjects));
    } catch (Exception $e) {
        return new Response(httpCode: 500);
    }
}
}

?>