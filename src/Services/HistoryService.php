<?php
namespace GestionBiblio\Services;

/**
 * Classe HistoryService
 * 
 * Ce service permet de gérer l'historique des actions effectuées dans l'application.
 */
class HistoryService {
    private $logFilePath;

    /**
     * Constructeur de la classe HistoryService.
     * 
     * Initialise le chemin du fichier de journalisation.
     */
    public function __construct() {
        $this->logFilePath = __DIR__ . '/../../data/history.log';
    }

    /**
     * Enregistre une action dans le fichier de journalisation.
     * 
     * @param string $action L'action effectuée.
     * @param string $details Les détails de l'action.
     * @return void
     */
    public function logAction($action, $details) {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = sprintf("[%s] %s: %s\n", $timestamp, strtoupper($action), $details);
        file_put_contents($this->logFilePath, $logEntry, FILE_APPEND);
    }

    /**
     * Lit le contenu du fichier de journalisation.
     * 
     * @return string Le contenu du fichier de journalisation.
     */
    public function readLog() {
        if (!file_exists($this->logFilePath)) {
            return "Le fichier de journalisation n'existe pas.";
        }
        return file_get_contents($this->logFilePath);
    }
}