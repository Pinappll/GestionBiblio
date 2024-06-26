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
}