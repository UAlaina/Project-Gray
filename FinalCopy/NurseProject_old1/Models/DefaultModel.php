<?php
include_once "Models/Model.php";

class DefaultModel extends Model {
    private $db;
    
    public function __construct() {
        $this->db = parent::connect();
    }
    
    public function getFeaturedContent() {
        // This would typically fetch from database
        // For now, returning static content
        return [
            'tagline' => 'Healing Hands, Familiar Spaces',
            'mainContent' => 'Professional home healthcare services tailored to your needs.'
        ];
    }
    
    //get available services
    public function getServices() {
        // For now returning static services
        // Later this would fetch from a services table
        return [
            [
                'name' => 'Home Medical Care',
                'description' => 'Professional medical care in the comfort of your home.'
            ],
            [
                'name' => 'Elderly Assistance',
                'description' => 'Compassionate care for seniors needing daily assistance.'
            ],
            [
                'name' => 'Post-Surgery Recovery',
                'description' => 'Specialized care to help you recover after surgery.'
            ],
            [
                'name' => 'Chronic Illness Management',
                'description' => 'Ongoing support for managing chronic health conditions.'
            ]
        ];
    }
    
    //Get available nurses
    public function getNurses() {
        $nurses = [];
        
        $query = "SELECT u.Id, u.firstName, u.lastName, n.specialitiesGoodAt, n.rating 
                 FROM users u 
                 JOIN nurse n ON u.Id = n.NurseID 
                 WHERE u.isActive = 1";
                 
        $result = $this->db->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nurses[] = $row;
            }
        }
        
        return $nurses;
    }
    
    //Get user by ID
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE Id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    //Get nurse by ID
    public function getNurseById($id) {
        $query = "SELECT u.*, n.* 
                 FROM users u 
                 JOIN nurse n ON u.Id = n.NurseID 
                 WHERE u.Id = ?";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Get patient by ID
    public function getPatientById($id) {
        $query = "SELECT u.*, p.* 
                 FROM users u 
                 JOIN patients p ON u.Id = p.patientID 
                 WHERE u.Id = ?";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
}