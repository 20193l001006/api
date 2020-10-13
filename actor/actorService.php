<?php
    require "actorBL.php";

    class actorService 
    {
        private $actorDTO;
        private $actorBL;

        public function __construct(){
            $this->actorDTO = new ActorDTO();
            $this->actorBL = new actorBL();

        }

        public function read($Id){
            $this->actorDTO = $this->actorBL->read($Id);
            echo json_encode($this->actorDTO, JSON_PRETTY_PRINT);
        }
    }

    $actorService = new actorService();

    $peticion = $_SERVER['REQUEST_METHOD'];

    switch($peticion){
        case 'POST':
            {
                parse_str(file_get_contents("php://input"), $_POST);
                print_r($_POST);
            break;
            }
        case 'GET':
            {
            if(empty($_GET['param'])) {
                $actorService -> read(0);

            } else if(is_numeric($_GET['param'])){
                    $actorService -> read($_GET['param']);
            }
            break;
            }
        case 'PUT':
            {
                parse_str(file_get_contents("php://input"), $_PUT);
                print_r($_PUT);
            break;
            }
        case 'DELETE':
            {
                echo($_GET['param']); 
                break;
            }
        default:
            echo 'ERROR';
            break;
    }
?>