<?php

class CallConsultation {
    private $consultationId;
    private $patientId;
    private $doctorId;
    private $startTime;
    private $endTime;
    private $status;

    public function __construct($patientId, $doctorId) {
        $this->consultationId = uniqid('consultation_');
        $this->patientId = $patientId;
        $this->doctorId = $doctorId;
        $this->status = 'scheduled';
    }

    public function startCall() {
        $this->startTime = time();
        $this->status = 'active';
        return true;
    }

    public function endCall() {
        $this->endTime = time();
        $this->status = 'completed';
        return $this->getDuration();
    }

    public function getDuration() {
        if ($this->startTime && $this->endTime) {
            return $this->endTime - $this->startTime;
        }
        return null;
    }

    public function getStatus() {
        return $this->status;
    }
}

?>