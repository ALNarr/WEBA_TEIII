<?php

class Model {

    private $db;

    public function __construct(bool $withErrors = false) {
        $this->db = new PDO("mysql:host=127.0.0.1;dbname=weba-te03-2025;charset=UTF8", 'root', '');
        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    } 

<<<<<<< HEAD
    // Obtenir tous les projets sans tâches
public function getProjects(): array {
    $stmt = $this->db->prepare("SELECT id, name, deadline FROM project ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtenir tous les projets avec leurs tâches
public function getProjectsWithTasks(): array {
    $projects = $this->getProjects();
    
    foreach ($projects as &$project) {
        $project['tasks'] = $this->getTasksByProjectId($project['id']);
    }
    
    return $projects;
}

// Obtenir les détails d'un projet avec ses tâches et le pourcentage
public function getProjectDetails(int $projectId): ?array {
    $stmt = $this->db->prepare("SELECT id, name, deadline FROM project WHERE id = ?");
    $stmt->execute([$projectId]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$project) {
        return null;
    }
    
    $project['tasks'] = $this->getTasksByProjectId($projectId);
    
    // Calculer le pourcentage de tâches terminées
    $totalTasks = count($project['tasks']);
    $finishedTasks = count(array_filter($project['tasks'], fn($task) => $task['finished'] == 1));
    $project['completionPercentage'] = $totalTasks > 0 ? round(($finishedTasks / $totalTasks) * 100, 2) : 0;
    
    return $project;
}

// Obtenir les tâches d'un projet
public function getTasksByProjectId(int $projectId): array {
    $stmt = $this->db->prepare("SELECT id, name, description, finished FROM task WHERE projectId = ? ORDER BY id");
    $stmt->execute([$projectId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter un projet
public function addProject(string $name, ?string $deadline = null): int {
    $stmt = $this->db->prepare("INSERT INTO project (name, deadline) VALUES (?, ?)");
    $stmt->execute([$name, $deadline]);
    return (int)$this->db->lastInsertId();
}

// Supprimer un projet
public function deleteProject(int $projectId): bool {
    $stmt = $this->db->prepare("DELETE FROM project WHERE id = ?");
    $stmt->execute([$projectId]);
    return $stmt->rowCount() > 0;
}

// Ajouter une tâche
public function addTask(int $projectId, string $name, string $description): int {
    $stmt = $this->db->prepare("INSERT INTO task (projectId, name, description, finished) VALUES (?, ?, ?, 0)");
    $stmt->execute([$projectId, $name, $description]);
    return (int)$this->db->lastInsertId();
}

// Supprimer une tâche
public function deleteTask(int $taskId): bool {
    $stmt = $this->db->prepare("DELETE FROM task WHERE id = ?");
    $stmt->execute([$taskId]);
    return $stmt->rowCount() > 0;
}

// Obtenir les projets en retard
public function getLateProjects(): array {
    $stmt = $this->db->prepare("
        SELECT p.id, p.name, p.deadline, 
               COUNT(CASE WHEN t.finished = 0 THEN 1 END) as remainingTasks
        FROM project p
        LEFT JOIN task t ON p.id = t.projectId
        WHERE p.deadline IS NOT NULL AND p.deadline < NOW()
        GROUP BY p.id, p.name, p.deadline
        ORDER BY p.id
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Vérifier si un projet existe
public function projectExists(int $projectId): bool {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM project WHERE id = ?");
    $stmt->execute([$projectId]);
    return $stmt->fetchColumn() > 0;
}
=======
    // TODO
>>>>>>> d31d56c (Connexion reussie)
}
?>