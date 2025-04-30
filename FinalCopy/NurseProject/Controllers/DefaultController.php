<?php

include_once "Controllers/Controller.php";
include_once "Models/DefaultModel.php";

class DefaultController extends Controller {
    private $model;
    function __construct()
    {
        $this->model = new DefaultModel();
    }
    
    function route() {
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        
        if($action == 'list') {
            $this->index();
        } elseif($action == 'nurses') {
            $this->showNurses();
        } elseif($action == 'services') {
            $this->showServices();
        } elseif($action == 'view') {
            if($id > 0) {
                $this->viewDetails($id);
            } else {
                $this->index();
            }
        } elseif($action == 'add') {
            $this->addRecord();
        } elseif($action == 'update') {
            if($id > 0) {
                $this->updateRecord($id);
            } else {
                $this->index();
            }
        } elseif($action == 'delete') {
            if($id > 0) {
                $this->deleteRecord($id);
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }
    function index() {    
        $featuredContent = $this->model->getFeaturedContent();
        $services = $this->model->getServices();
        
        $this->render('default', 'default', [
            'featuredContent' => $featuredContent,
            'services' => $services
        ]);
    }
    
    private function showNurses() {
        $nurses = $this->model->getNurses();
        
        $this->render('default', 'nurses', [
            'nurses' => $nurses
        ]);
    }
    
    private function showServices() {
        $services = $this->model->getServices();
        
        $this->render('default', 'services', [
            'services' => $services
        ]);
    }
    
    private function viewDetails($id) {
        $user = $this->model->getUserById($id);
        
        if(!$user) {
            header("Location: index.php");
            exit;
        }
        
        $nurseData = $this->model->getNurseById($id);
        $patientData = $this->model->getPatientById($id);
        
        if($nurseData) {
            $this->render('default', 'nurseDetails', [
                'user' => $user,
                'nurseData' => $nurseData
            ]);
        } elseif($patientData) {
            $this->render('default', 'patientDetails', [
                'user' => $user,
                'patientData' => $patientData
            ]);
        } else {
            $this->render('default', 'userDetails', [
                'user' => $user
            ]);
        }
    }
    
    private function addRecord() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Location: index.php?controller=default&action=list");
            exit;
        } else {
            $this->render('default', 'addForm', []);
        }
    }
    
    private function updateRecord($id) {
        $user = $this->model->getUserById($id);
        
        if(!$user) {
            header("Location: index.php");
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Location: index.php?controller=default&action=view&id=$id");
            exit;
        } else {
            $this->render('default', 'editForm', [
                'user' => $user
            ]);
        }
    }
    
    private function deleteRecord($id) {        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Location: index.php?controller=default&action=list");
            exit;
        } else {
            $user = $this->model->getUserById($id);
            
            if(!$user) {
                header("Location: index.php");
                exit;
            }
            
            $this->render('default', 'deleteConfirm', [
                'user' => $user
            ]);
        }
    }
}
