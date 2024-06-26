<?php
namespace GestionBiblio\Services;

class HistoryService {
    private $logFilePath;

    public function __construct() {
        $this->logFilePath = __DIR__ . '/../../data/history.log';
    }

    public function logAction($action, $details) {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = sprintf("[%s] %s: %s\n", $timestamp, strtoupper($action), $details);
        file_put_contents($this->logFilePath, $logEntry, FILE_APPEND);
    }

    // New method to read the log file
    public function readLog() {
        if (!file_exists($this->logFilePath)) {
            return "Log file does not exist.";
        }
        return file_get_contents($this->logFilePath);
    }
}