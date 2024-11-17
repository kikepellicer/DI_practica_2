<?php
include "models/DBSingleton.php";
class Paciente
{
    private $id;
    private $sip;
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $telefono;
    private $fecha;
    private $sexo;
    private $localidad;
    private $calle;
    private $numero;
    private $puerta;
    private $piso;

    /**
     * @param $id
     * @param $sip
     * @param $dni
     * @param $nombre
     * @param $apellido1
     * @param $apellido2
     * @param $telefono
     * @param $sexo
     * @param $localidad
     */
    public function __construct($id=null, $sip=null, $dni=null, $nombre=null, $apellido1=null, $apellido2=null, $telefono=null, $sexo=null,$fecha=null, $localidad=null, $calle=null,$numero=null,$puerta=null,$piso=null){
        $this->id = $id;
        $this->sip = $sip;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->telefono = $telefono;
        $this->sexo = $sexo;
        $this->fecha = $fecha;
        $this->localidad = $localidad;
        $this->calle = $calle;
        $this->numero = $numero;
        $this->puerta = $puerta;
        $this->piso = $piso;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setSip($sip){
        $this->sip = $sip;
    }

    public function getSip(){
        return $this->sip;
    }

    public function setDni($dni){
        $this->dni = $dni;
    }

    public function getDni(){
        return $this->dni;
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

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setLocalidad($localidad){
        $this->localidad = $localidad;
    }

    public function getLocalidad(){
        return $this->localidad;
    }

    public function setCalle($calle){
        $this->calle = $calle;
    }

    public function getCalle(){
        return $this->calle;
    }

    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function setPuerta($puerta){
        $this->puerta = $puerta;
    }

    public function getPuerta(){
        return $this->puerta;
    }

    public function setPiso($piso){
        $this->piso = $piso;
    }

    public function getPiso(){
        return $this->piso;
    }

    public static function find($page,$numeros_personas, $filtros){
        $final_page = $page * $numeros_personas;
        $init_page = $final_page - $numeros_personas;
        $connection = BDSingleton::getInstance();
        $params = array();
        $sql = "SELECT * FROM PACIENTES WHERE TRUE";

        if(!empty($filtros["id"])){
            $sql .= " and id=:id";
            $params[':id'] = $filtros["id"];
        }

        if(!empty($filtros["sip"])){
            $sql .= " and sip=:sip";
            $params[':sip'] = $filtros["sip"];
        }

        if(!empty($filtros["dni"])){
            $sql .= " and dni=:dni";
            $params[':dni'] = $filtros["dni"];
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

        if(!empty($filtros["fecha_nacimiento"])){
            $sql .= " and fecha_nacimiento like :fecha_nacimiento";
            $params[':fecha_nacimiento'] = "%".$filtros["fecha_nacimiento"]."%";
        }

        if(!empty($filtros["localidad"])){
            $sql .= " and localidad=:localidad";
            $params[':localidad'] = $filtros["localidad"];
        }

        if(!empty($filtros["calle"])){
            $sql .= " and calle like :calle";
            $params[':calle'] = "%".$filtros["calle"]."%";
        }

        if(!empty($filtros["numero"])){
            $sql .= " and numero=:numero";
            $params[':numero'] = $filtros["numero"];
        }

        if(!empty($filtros["puerta"])){
            $sql .= " and puerta=:puerta";
            $params[':puerta'] = $filtros["puerta"];
        }

        if(!empty($filtros["piso"])){
            $sql .= " and piso=:piso";
            $params[':piso'] = $filtros["piso"];
        }

        $sql .=" LIMIT $init_page, $numeros_personas";

        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function numeroRegistros($filtros){
        $connection = BDSingleton::getInstance();
        $params = array();
        $sql = "SELECT COUNT(*) as registrosTotales FROM PACIENTES WHERE TRUE ";

        if(!empty($filtros["id"])){
            $sql .= " and id=:id";
            $params[':id'] = $filtros["id"];
        }

        if(!empty($filtros["sip"])){
            $sql .= " and sip=:sip";
            $params[':sip'] = $filtros["sip"];
        }

        if(!empty($filtros["dni"])){
            $sql .= " and dni=:dni";
            $params[':dni'] = $filtros["dni"];
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

        if(!empty($filtros["fecha_nacimiento"])){
            $sql .= " and fecha_nacimiento like :fecha_nacimiento";
            $params[':fecha_nacimiento'] = "%".$filtros["fecha_nacimiento"]."%";
        }

        if(!empty($filtros["localidad"])){
            $sql .= " and localidad=:localidad";
            $params[':localidad'] = $filtros["localidad"];
        }

        if(!empty($filtros["calle"])){
            $sql .= " and calle like :calle";
            $params[':calle'] = "%".$filtros["calle"]."%";
        }

        if(!empty($filtros["numero"])){
            $sql .= " and numero=:numero";
            $params[':numero'] = $filtros["numero"];
        }

        if(!empty($filtros["puerta"])){
            $sql .= " and puerta=:puerta";
            $params[':puerta'] = $filtros["puerta"];
        }

        if(!empty($filtros["piso"])){
            $sql .= " and piso=:piso";
            $params[':piso'] = $filtros["piso"];
        }

        $stmt = $connection->prepare($sql);
        $stmt ->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(){
        try {
            if (empty($this->sip)) {
                throw new Exception("El SIP es obligatorio");
            }

            if (empty($this->dni)) {
                throw new Exception("El DNI es obligatorio");
            }

            if (empty($this->nombre)) {
                throw new Exception("El Nombre es obligatorio");
            }

            $connection = BDSingleton::getInstance();

            $params = array();

            $sql = "insert into pacientes (sip, dni, nombre, apellido1, apellido2, telefono, sexo, fecha_nacimiento,localidad,calle,numero,puerta,piso) values(:sip, :dni, :nombre, :apellido1, :apellido2, :telefono, :sexo, :fecha_nacimiento, :localidad, :calle, :numero, :puerta, :piso)";

            $params[':sip'] = $this->sip;

            $params[':dni'] = $this->dni;

            $params[':nombre'] = $this->nombre;

            $params[':apellido1'] = $this->apellido1;

            $params[':apellido2'] = $this->apellido2;

            $params[':telefono'] = $this->telefono;

            $params[':sexo'] = $this->sexo;

            $params[':fecha_nacimiento'] = $this->fecha;

            $params[':localidad'] = $this->localidad;

            $params[':calle'] = $this->calle;

            $params[':numero'] = $this->numero;

            $params[':puerta'] = $this->puerta;

            $params[':piso'] = $this->piso;

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

            $sql = "update pacientes set sip=:sip, dni=:dni, nombre=:nombre, apellido1=:apellido1, apellido2=:apellido2, telefono=:telefono, sexo=:sexo, fecha_nacimiento=:fecha_nacimiento,localidad=:localidad, calle=:calle,numero=:numero,puerta=:puerta,piso=:piso where id=:id";

            $params[':id'] = $this->id;

            $params[':sip'] = $this->sip;

            $params[':dni'] = $this->dni;

            $params[':nombre'] = $this->nombre;

            $params[':apellido1'] = $this->apellido1;

            $params[':apellido2'] = $this->apellido2;

            $params[':telefono'] = $this->telefono;

            $params[':sexo'] = $this->sexo;

            $params[':fecha_nacimiento'] = $this->fecha;

            $params[':localidad'] = $this->localidad;

            $params[':calle'] = $this->calle;

            $params[':numero'] = $this->numero;

            $params[':puerta'] = $this->puerta;

            $params[':piso'] = $this->piso;

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

            $sql = "delete from pacientes where id=:id";

            if (!empty($this->id)) {
                $params[':id'] = $this->id;
            }

            $stmt = $connection->prepare($sql);
            return $stmt->execute($params);
        }catch(Exception $e){
            throw $e;
        }
    }

    public static function recuperarPaciente($id){
        $connection = BDSingleton::getInstance();
        $params = array();

        $sql = "SELECT * FROM PACIENTES where id=:id";

        if (!empty($id)) {
            $params[':id'] = ''.$id.'';
        }

        $stmt = $connection->prepare($sql);
        $stmt->execute($params);
        $pacienteArray = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Paciente(
            $pacienteArray["id"],
            $pacienteArray["sip"],
            $pacienteArray["dni"],
            $pacienteArray["nombre"],
            $pacienteArray["apellido1"],
            $pacienteArray["apellido2"],
            $pacienteArray["telefono"],
            $pacienteArray["sexo"],
            $pacienteArray["fecha_nacimiento"],
            $pacienteArray["localidad"],
            $pacienteArray["calle"],
            $pacienteArray["numero"],
            $pacienteArray["puerta"],
            $pacienteArray["piso"]);
    }
}