<?php
    require "../conexion.php";
    require "../DTO/ActorDTO.php";
    class actorBL
    {
        private $conn;

        public function __construct()//metodo constructor
        {
            $this -> conn = new Conexion();//llama a la clase conexión
        }

        public function create($actorDTO) 
        {
            $this -> conn -> OpenConnection();
            $Connsql = $this -> conn -> GetConnection();
            $lastInsertId = 0;
            try{
                if($Connsql){
                    $Connsql -> beginTransaction();
                    $sqlStatment = $Connsql -> prepare(
                        "INSERT INTO actor VALUES(
                            default,
                            :first_name,
                            :last_name,
                            current_date
                        )"
                    );

                    $sqlStatment -> bindParam(':first_name', $actorDTO->nombre);
                    $sqlStatment -> bindParam(':last_name', $actorDTO->apellidos);
                    $sqlStatment -> execute();

                    $lastInsertId = $Connsql -> lastInsertId();
                    $Connsql -> commit();
                }
            }catch(PDOException $e){
                $Connsql -> rollback();
            }
            return $lastInsertId;
        }

        public function read($Id){
            $this -> conn -> OpenConnection();
            $Connsql = $this -> conn -> GetConnection();
            $ArrayActor = new ArrayObject();
            $SQLQuery = "SELECT * FROM actor";
            $actorDTO = new ActorDTO();

            if($Id > 0)
                $SQLQuery = "SELECT * FROM actor WHERE actor_id = {$Id}";
            
                try{
                    if($Connsql)
                        foreach($Connsql->query($SQLQuery) as $row){
                            $actorDTO = new ActorDTO();
                            $actorDTO -> id = $row['actor_id'];
                            $actorDTO -> nombre = $row['first_name'];
                            $actorDTO -> apellidos = $row['last_name'];
                            $ArrayActor->append($actorDTO);
                        }

                } catch(PDOException $e){

                }

                return $ArrayActor;
        }

        public function update($actorDTO){
            $this -> conn -> OpenConnection();
            $Connsql = $this -> conn -> GetConnection();

            try{
                if($Connsql){
                    $Connsql -> beginTransaction();
                    $sqlStatment = $Connsql -> prepare(
                        "UPDATE actor SET
                            first_name = :first_name,
                            last_name = :last_name,
                            last_update = current_timestamp
                            WHERE actor_id = :id
                        "
                    );

                    $sqlStatment -> bindParam(':first_name', $actorDTO->nombre);
                    $sqlStatment -> bindParam(':last_name', $actorDTO->apellidos);
                    $sqlStatment -> bindParam(':id', $actorDTO->id);
                    $sqlStatment -> execute();

                    $lastInsertId = $Connsql -> lastInsertId();
                    $Connsql -> commit();
                    //echo "Actualización correcta";
                    
                }
            }catch(PDOException $e){
                $Connsql -> rollback();
                echo $e;
            }
        }

        public function delete($Id){ 
            $this -> conn -> OpenConnection();
            $Connsql = $this -> conn -> GetConnection();

            try{
                if($Connsql){
                    $Connsql -> beginTransaction();
                    $sqlStatment = $Connsql -> prepare(
                        "DELETE FROM actor
                            WHERE actor_id = :id
                        "
                    );
                   
                    $sqlStatment -> bindParam(':id', $Id); 
                    $sqlStatment -> execute();

                    $Connsql -> commit();
                    
                }
            }catch(PDOException $e){
                $Connsql -> rollback();
            }
        }
    }

    /*$Obj = new actorBL();
    $DTO = new ActorDTO();
    $DTO ->nombre = 'Juan';
    $DTO ->apellidos = 'Perez';
    $Obj ->create($DTO);*/
    
    /*$BL = new actorBL();
    print_r($BL->read(0));*/
    
    /* $Obj = new actorBL();
    $DTO = new ActorDTO();
    $DTO ->nombre = 'Jorge';
    $DTO ->apellidos = 'Salinas Martinez';
    $DTO ->id = 206;
    $Obj ->update($DTO);*/

    /*$Obj = new actorBL();
    $Obj ->delete(208);*/

?>