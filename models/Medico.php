<?php

include "models/DBSingleton.php";

class Medico{

    private $id;
    private $dni;
    private $numero_colegiado;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $telefono;
    private $sexo;
    private $especialidad_id;

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
    public function __construct($id=null, $dni=null, $numero_colegiado=null, $nombre=null, $apellido1=null, $apellido2=null, $telefono=null, $sexo=null, $especialidad_id=null){
        $this->id = $id;
        $this->dni = $dni;
        $this->numero_colegiado = $numero_colegiado;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->telefono = $telefono;
        $this->sexo = $sexo;
        $this->especialidad_id = $especialidad_id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setDni($dni){
        $this->dni = $dni;
    }

    public function getDni(){
        return $this->dni;
    }

    public function setNumeroColegiado($numero_colegiado){
        $this->numero_colegiado = $numero_colegiado;
    }

    public function getNumeroColegiado(){
        return $this->numero_colegiado;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setApellido1($apellido1){
        $this->apellido1 = $apellido1;
    }

    public function getApellido1(){
        return $this->apellido1;
    }

    public function setApellido2($apellido2){
        $this->apellido2 = $apellido2;
    }

    public function getApellido2(){
        return $this->apellido2;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }

    public function getSexo(){
        return $this->sexo;
    }

    public function setEspecialidadID($especialidad_id){
        $this->especialidad_id = $especialidad_id;
    }

    public function getEspecialidadID(){
        return $this->especialidad_id;
    }


    public static function find($page,$numeros_personas, $filtros){
        $final_page = $page * $numeros_personas;
        $init_page = $final_page - $numeros_personas;
        $connection = BDSingleton::getInstance();
        $params = array();
        $sql = "SELECT * FROM MEDICOS WHERE TRUE";

        if(!empty($filtros["id"])){
            $sql .= " and id=:id";
            $params[':id'] = $filtros["id"];
        }
        if(!empty($filtros["dni"])){
            $sql .= " and dni=:dni";
            $params[':dni'] = $filtros["dni"];
        }
        if(!empty($filtros["numero_colegiado"])){
            $sql .= " and numero_colegiado=:numero_colegiado";
            $params[':numero_colegiado'] = $filtros["numero_colegiado"];
        }
        if(!empty($filtros["nombre"])){
            $sql .= " and nombre like :nombre";
            $params[':nombre'] = "%".$filtros["nombre"]."%";
        }
        if(!empty($filtros["apellido1"])){
            $sql .= " and apellido1 like :apellido1";
            $params[':apellido1'] = "%".$filtros["apellido1"]."%";
        }
        if(!empty($filtros["apellido2"])){
            $sql .= " and apellido2 like :apellido2";
            $params[':apellido2'] = "%".$filtros["apellido2"]."%";
        }
        if(!empty($filtros["telefono"])){
            $sql .= " and telefono=:telefono";
            $params[':telefono'] = $filtros["telefono"];
        }
        if(!empty($filtros["sexo"])){
            $sql .= " and sexo=:sexo";
            $params[':sexo'] = $filtros["sexo"];
        }

        if(!empty($filtros["especialidad_id"])){
            $sql .= " and especialidad_id=:especialidad_id";
            $params[':especialidad_id'] = $filtros["especialidad_id"];
        }
        $sql .=" LIMIT $init_page, $numeros_personas";

        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function numeroRegistros($filtros){
        $connection = BDSingleton::getInstance();
        $params = array();
        $sql = "SELECT COUNT(*) as registrosTotales FROM MEDICOS WHERE TRUE ";

        if(!empty($filtros["id"])){
            $sql .= " and id=:id";
            $params[':id'] = $filtros["id"];
        }

        if(!empty($filtros["dni"])){
            $sql .= " and dni=:dni";
            $params[':dni'] = $filtros["dni"];
        }

        if(!empty($filtros["numero_colegiado"])){
            $sql .= " and numero_colegiado=:numero_colegiado";
            $params[':numero_colegiado'] = $filtros["numero_colegiado"];
        }

        if(!empty($filtros["nombre"])){
            $sql .= " and nombre like :nombre";
            $params[':nombre'] = "%".$filtros["nombre"]."%";
        }

        if(!empty($filtros["apellido1"])){
            $sql .= " and apellido1 like :apellido1";
            $params[':apellido1'] = "%".$filtros["apellido1"]."%";
        }

        if(!empty($filtros["apellido2"])){
            $sql .= " and apellido2 like :apellido2";
            $params[':apellido2'] = "%".$filtros["apellido2"]."%";
        }

        if(!empty($filtros["telefono"])){
            $sql .= " and telefono=:telefono";
            $params[':telefono'] = $filtros["telefono"];
        }

        if(!empty($filtros["sexo"])){
            $sql .= " and sexo=:sexo";
            $params[':sexo'] = $filtros["sexo"];
        }

        if(!empty($filtros["especialidad_id"])){
            $sql .= " and especialidad_id=:especialidad_id";
            $params[':especialidad_id'] = $filtros["especialidad_id"];
        }
        $stmt = $connection->prepare($sql);
        $stmt ->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(){
        try {
            if (empty($this->numero_colegiado)) {
                throw new Exception("El Numero de colegiado es obligatorio");
            }

            if (empty($this->dni)) {
                throw new Exception("El DNI es obligatorio");
            }

            if (empty($this->nombre)) {
                throw new Exception("El Nombre es obligatorio");
            }

            if (empty($this->especialidad_id)) {
                throw new Exception("El ID de la especialidad es obligatorio");
            }

            $connection = BDSingleton::getInstance();

            $params = array();

            $sql = "insert into medicos (numero_colegiado, dni, nombre, apellido1, apellido2, telefono, sexo, especialidad_id) values(:numero_colegiado, :dni,:nombre,:apellido1,:apellido2,:telefono,:sexo,:especialidad_id)";

                $params[':numero_colegiado'] = $this->numero_colegiado;

                $params[':dni'] = $this->dni;

                $params[':nombre'] = $this->nombre;

                $params[':apellido1'] = $this->apellido1;

                $params[':apellido2'] = $this->apellido2;

                $params[':telefono'] = $this->telefono;

                $params[':sexo'] = $this->sexo;

                $params[':especialidad_id'] = $this->especialidad_id;

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

            $sql = "update medicos set numero_colegiado=:numero_colegiado, dni=:dni, nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, telefono=:telefono, sexo=:sexo, especialidad_id=:especialidad_id where id=:id";

            $params[':id'] = $this->id;

            $params[':numero_colegiado'] = $this->numero_colegiado;

            $params[':dni'] = $this->dni;

            $params[':nombre'] = $this->nombre;

            $params[':apellido1'] = $this->apellido1;

            $params[':apellido2'] = $this->apellido2;

            $params[':telefono'] = $this->telefono;

            $params[':sexo'] = $this->sexo;

            $params[':especialidad_id'] = $this->especialidad_id;

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

          $sql = "delete from medicos where id=:id";

          if (!empty($this->id)) {
              $params[':id'] = $this->id;
          }

          $stmt = $connection->prepare($sql);
          return $stmt->execute($params);
      }catch(Exception $e){
          throw $e;
      }
    }

    public static function recuperarMedico($id){
        $connection = BDSingleton::getInstance();
        $params = array();

        $sql = "SELECT * FROM Medicos where id=:id";

        if (!empty($id)) {
            $params[':id'] = ''.$id.'';
        }

        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        $medicoArray = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Medico(
            $medicoArray["id"],
            $medicoArray["dni"],
            $medicoArray["numero_colegiado"],
            $medicoArray["nombre"],
            $medicoArray["apellido1"],
            $medicoArray["apellido2"],
            $medicoArray["telefono"],
            $medicoArray["sexo"],
            $medicoArray["especialidad_id"]);
    }
}
?>