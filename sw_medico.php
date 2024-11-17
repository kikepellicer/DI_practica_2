<?php
include 'models/Medico.php';

$id = isset($_POST["id"])? $_POST["id"]:null;
$numero_colegiado = isset($_POST["numero_colegiado"])? $_POST["numero_colegiado"]:null;
$dni = isset($_POST["dni"])? $_POST["dni"]:null;
$nombre = isset($_POST["nombre"])? $_POST["nombre"]:null;
$apellido1 = isset($_POST["apellido1"])? $_POST["apellido1"]:null;
$apellido2 = isset($_POST["apellido2"])? $_POST["apellido2"]:null;
$telefono = isset($_POST["telefono"])? $_POST["telefono"]:null;
$sexo= isset($_POST["sexo"])? $_POST["sexo"]:null;
$especialidad_id= isset($_POST["especialidad_id"])? $_POST["especialidad_id"]:null;

$register = isset($_POST['numeros_personas']) ? $_POST['numeros_personas']:10;
$page= isset($_POST["pagina"])? $_POST["pagina"]:1;

$action = isset($_POST["action"])? $_POST["action"]:"get";

$filtros = array(
    "id" => $id,
    "numero_colegiado" => $numero_colegiado,
    "dni" => $dni,
    "nombre" => $nombre,
    "apellido1" => $apellido1,
    "apellido2" => $apellido2,
    "telefono" => $telefono,
    "sexo" => $sexo,
    "especialidad_id" => $especialidad_id,
);

$success = true;
$data =[];

try {
    switch ($action) {
        case "get":
            $data = Medico::find($page, $register, $filtros);
            $registros = Medico::numeroRegistros($filtros);
            $msg = "Listado de médicos";
            break;
        case "insert":
            $medico = new Medico(null, $dni, $numero_colegiado, $nombre, $apellido1, $apellido2, $telefono, $sexo, $especialidad_id);
            $registros = 0;
            if ($medico->insert()) {
                $msg = "Medico insertado correctamente";
            } else{
                $success = false;
                $msg = "Error al insertar el medico";
            }
            break;
        case "delete":
            $medico = Medico::recuperarMedico($id);
            $registros=0;
            if ($medico->delete()) {
                $msg = "Medico borrado correctamente";
            }else{
                $success = false;
                $msg = "Error al borrar medico";
            }
            break;
        case "update":
            $medico = Medico::recuperarMedico($id);
            $medico->setDni($dni);
            $medico->setNumeroColegiado($numero_colegiado);
            $medico->setNombre($nombre);
            $medico->setApellido1($apellido1);
            $medico->setApellido2($apellido2);
            $medico->setTelefono($telefono);
            $medico->setSexo($sexo);
            $medico->setEspecialidadID($especialidad_id);
            $registros=0;
            if ($medico->update()){
                $msg = "Medico modificado correctamente";
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