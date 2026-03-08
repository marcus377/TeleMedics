<?php
// Appointment booking system for medical consultations

class AppointmentBooking {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    public function bookAppointment($patientId, $doctorId, $appointmentDate, $reason) {
        try {
            $query = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason, status, created_at) 
                      VALUES (?, ?, ?, ?, 'pending', NOW())";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iiss", $patientId, $doctorId, $appointmentDate, $reason);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Appointment booked successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to book appointment'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function getAvailableSlots($doctorId, $date) {
        $query = "SELECT time_slot FROM available_slots 
                  WHERE doctor_id = ? AND slot_date = ? AND is_available = 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $doctorId, $date);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>