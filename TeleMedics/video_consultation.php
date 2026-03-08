<?php

class VideoConsultation {
    private $db;
    private $consultationId;
    private $patientId;
    private $doctorId;
    private $startTime;
    private $status;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createConsultation($patientId, $doctorId) {
        $this->patientId = $patientId;
        $this->doctorId = $doctorId;
        $this->startTime = date('Y-m-d H:i:s');
        $this->status = 'scheduled';
        
        return $this->saveToDatabase();
    }

    public function startSession() {
        $this->status = 'active';
        return $this->updateStatus();
    }

    public function endSession() {
        $this->status = 'completed';
        return $this->updateStatus();
    }

    private function saveToDatabase() {
        try {
            $query = "INSERT INTO consultations (patient_id, doctor_id, start_time, status) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$this->patientId, $this->doctorId, $this->startTime, $this->status]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    private function updateStatus() {
        try {
            $query = "UPDATE consultations SET status = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$this->status, $this->consultationId]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>