<?php

include "models/DBSingleton.php";

class Cita
{
    private $id;
    private $fecha;
    private $medico_id;
    private $enfermero_id;
    private $paciente_id;

    /**
     * @param $id
     * @param $dni
     * @param $numero_colegiado
     * @param $nombre
     * @param $apellido1
     * @param $apellido2
     * @param $telefono
     * @param $sexo
     * @param $especialidad_id
     */
    public function __construct($id=null, $fecha=null, $medico_id=null, $enfermero_id=null, $paciente_id=null){
        $this->id = $id;
        $this->fecha = $fecha;
        $this->medico_id = $medico_id;
        $this->enfermero_id = $enfermero_id;
        $this->paciente_id = $paciente_id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setMedico_id($medico_id){
        $this->medico_id = $medico_id;
    }

    public function getMedico_id(){
        return $this->medico_id;
    }

    public function setEnfermero_id($enfermero_id){
        $this->enfermero_id = $enfermero_id;
    }

    public function getEnfermero_id(){
        return $this->enfermero_id;
    }

    public function setPaciente_id($paciente_id){
        $this->paciente_id = $paciente_id;
    }

    public function getPaciente_id(){
        return $this->paciente_id;
    }

    public static function find($page,$numeros_personas, $filtros){
        $final_page = $page * $numeros_personas;
        $init_page = $final_page - $numeros_personas;
        $connection = BDSingleton::getInstance();
        $params = array();
        $sql = "SELECT * FROM CITAS WHERE TRUE";

        if(!empty($filtros["id"])){
            $sql .= " and id=:id";
            $params[':id'] = $filtros["id"];
        }
        if(!empty($filtros["fecha"])){
            $sql .= " and fecha like :fecha";
            $params[':fecha'] = "%".$filtros["fecha"]."%";
        }
        if(!empty($filtros["medico_id"])){
            $sql .= " and medico_id=:medico_id";
            $params[':medico_id'] = $filtros["medico_id"];
        }
        if(!empty($filtros["enfermero_id"])){
            $sql .= " and enfermero_id = :enfermero_id";
            $params[':enfermero_id'] =$filtros["enfermero_id"];
        }
        if(!empty($filtros["paciente_id"])){
            $sql .= " and paciente_id = :paciente_id";
            $params[':paciente_id'] = $filtros["paciente_id"];
        }

        $sql .=" LIMIT $init_page, $numeros_personas";

        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function numeroRegistros($filtros){
        $connection = BDSingleton::getInstance();
        $params = array();
        $sql = "SELECT COUNT(*) as registrosTotales FROM CITAS WHERE TRUE ";

        if(!empty($filtros["id"])){
            $sql .= " and id=:id";
            $params[':id'] = $filtros["id"];
        }

        if(!empty($filtros["fecha"])){
            $sql .= " and fecha like :fecha";
            $params[':fecha'] = "%".$filtros["fecha"]."%";
        }

        if(!empty($filtros["medico_id"])){
            $sql .= " and medico_id=:medico_id";
            $params[':medico_id'] = $filtros["medico_id"];
        }

        if(!empty($filtros["enfermero_id"])){
            $sql .= " and enfermero_id =:enfermero_id";
            $params[':enfermero_id'] = $filtros["enfermero_id"];
        }

        if(!empty($filtros["paciente_id"])){
            $sql .= " and paciente_id =:paciente_id";
            $params[':paciente_id'] =$filtros["paciente_id"];
        }

        $stmt = $connection->prepare($sql);
        $stmt ->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(){
        try {
            if (empty($this->fecha)) {
                throw new Exception("La fecha es obligatorio");
            }

            $connection = BDSingleton::getInstance();

            $params = array();

            $sql = "insert into CITAS (fecha, medico_id, enfermero_id, paciente_id) values (:fecha, :medico_id, :enfermero_id, :paciente_id)";

            $params[':fecha'] = $this->fecha;

            $params[':medico_id'] = $this->medico_id;

            $params[':enfermero_id'] = $this->enfermero_id;

            $params[':paciente_id'] = $this->paciente_id;

            $stmt = $connection->prepare($sql);
            return $stmt->execute($params);
        }catch (Exception $e){
            throw $e;
        }
    }

    public function update(){
        try{
            $connection = BDSingleton::getInstance();
            $params = array();

            $sql = "update CITAS set fecha=:fecha, medico_id=:medico_id,enfermero_id=:enfermero_id, paciente_id=:paciente_id where id=:id";

            $params[':id'] = $this->id;

            $params[':fecha'] = $this->fecha;

            $params[':medico_id'] = $this->medico_id;

            $params[':enfermero_id'] = $this->enfermero_id;

            $params[':paciente_id'] = $this->paciente_id;


            $stmt = $connection->prepare($sql);
            return $stmt->execute($params);
        }catch (Exception $e){
            throw $e;
        }
    }

    public function delete(){
        try {
            $connection = BDSingleton::getInstance();
            $params = array();

            $sql = "delete from CITAS where id=:id";

            if (!empty($this->id)) {
                $params[':id'] = $this->id;
            }

            $stmt = $connection->prepare($sql);
            return $stmt->execute($params);
        }catch(Exception $e){
            throw $e;
        }
    }

    public static function recuperarCita($id){
        $connection = BDSingleton::getInstance();
        $params = array();

        $sql = "SELECT * FROM CITAS where id=:id";

        if (!empty($id)) {
            $params[':id'] = ''.$id.'';
        }

        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        $citaArray = $stmt->fetch(PDO::FETCH_ASSOC);
        return new CITA(
            $citaArray["id"],
            $citaArray["fecha"],
            $citaArray["medico_id"],
            $citaArray["enfermero_id"],
            $citaArray["paciente_id"]);
    }

}