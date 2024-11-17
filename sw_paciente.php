<?php
include 'models/Paciente.php';

$id = isset($_POST["id"])? $_POST["id"]:null;
$sip = isset($_POST["sip"])? $_POST["sip"]:null;
$dni = isset($_POST["dni"])? $_POST["dni"]:null;
$nombre = isset($_POST["nombre"])? $_POST["nombre"]:null;
$apellido1 = isset($_POST["apellido1"])? $_POST["apellido1"]:null;
$apellido2 = isset($_POST["apellido2"])? $_POST["apellido2"]:null;
$telefono = isset($_POST["telefono"])? $_POST["telefono"]:null;
$sexo= isset($_POST["sexo"])? $_POST["sexo"]:null;
$fecha = isset($_POST["fecha"])? $_POST["fecha"]:null;
$localidad= isset($_POST["localidad"])? $_POST["localidad"]:null;
$calle= isset($_POST["calle"])? $_POST["calle"]:null;
$numero= isset($_POST["numero"])? $_POST["numero"]:null;
$puerta= isset($_POST["puerta"])? $_POST["puerta"]:null;
$piso= isset($_POST["piso"])? $_POST["piso"]:null;

$register = isset($_POST['numeros_personas']) ? $_POST['numeros_personas']:10;

$page= isset($_POST["pagina"])? $_POST["pagina"]:1;

$action = isset($_POST["action"])? $_POST["action"]:"get";

$filtros = array(
    "id" => $id,
    "sip" => $sip,
    "dni" => $dni,
    "nombre" => $nombre,
    "apellido1" => $apellido1,
    "apellido2" => $apellido2,
    "telefono" => $telefono,
    "sexo" => $sexo,
    "fecha_nacimiento" => $fecha,
    "localidad" => $localidad,
    "calle" => $calle,
    "numero" => $numero,
    "puerta" => $puerta,
    "piso" => $piso,
);

$success = true;
$data =[];
try {
    switch ($action) {
        case "get":
            $data = Paciente::find($page, $register, $filtros);
            $registros = Paciente::numeroRegistros($filtros);
            $msg = "Listado de pacientes";
            break;
        case "insert":
            $paciente = new Paciente(null, $sip, $dni,  $nombre, $apellido1, $apellido2, $telefono, $sexo, $fecha, $localidad, $calle, $numero, $puerta, $piso);
            $registros =0;
            if ($paciente->insert()) {
                $msg = "Paciente insertado correctamente";
            } else{
                $success = false;
                $msg = "Error al insertar el paciente";
            }
            break;
        case "delete":
            $paciente = Paciente::recuperarPaciente($id);
            $registros=0;
            if ($paciente->delete()) {
                $msg = "Paciente borrado correctamente";
            }else{
                $success = false;
                $msg = "Error al borrar paciente";
            }
            break;
        case "update":
            $paciente = Paciente::recuperarPaciente($id);
            $paciente->setDni($dni);
            $paciente->setSip($sip);
            $paciente->setNombre($nombre);
            $paciente->setApellido1($apellido1);
            $paciente->setApellido2($apellido2);
            $paciente->setTelefono($telefono);
            $paciente->setSexo($sexo);
            $paciente->setFecha($fecha);
            $paciente->setLocalidad($localidad);
            $paciente->setCalle($calle);
            $paciente->setNumero($numero);
            $paciente->setPuerta($puerta);
            $paciente->setPiso($piso);
            $registros=0;
            if ($paciente->update()){
                $msg = "Paciente modificado correctamente";
            }else{
                $success = false;
                $msg = "Error al modificar";
            }
            break;
    }
}catch (Exception $e){
    $success = false;
    $msg = $e->getMessage();
}

$salida = array(
    "data" => $data,
    "registros" => $registros,
    "msg" => $msg,
    "success" => $success
);

echo json_encode($salida);

?>