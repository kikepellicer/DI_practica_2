<?php
include 'models/Cita.php';

$id = isset($_POST["id"])? $_POST["id"]:null;
$fecha = isset($_POST["fecha"])? $_POST["fecha"]:null;
$medico_id = isset($_POST["medico_id"])? $_POST["medico_id"]:null;
$enfermero_id = isset($_POST["enfermero_id"])? $_POST["enfermero_id"]:null;
$paciente_id = isset($_POST["paciente_id"])? $_POST["paciente_id"]:null;

$register = isset($_POST['numeros_personas']) ? $_POST['numeros_personas']:10;
$page= isset($_POST["pagina"])? $_POST["pagina"]:1;

$action = isset($_POST["action"])? $_POST["action"]:"get";

$filtros = array(
    "id" => $id,
    "fecha" => $fecha,
    "medico_id" => $medico_id,
    "enfermero_id" => $enfermero_id,
    "paciente_id" => $paciente_id,
);

$success = true;
$data =[];
try {
    switch ($action) {
        case "get":
            $data = Cita::find($page, $register, $filtros);
            $registros = Cita::numeroRegistros($filtros);
            $msg = "Listado de médicos";
            break;
        case "insert":
            $cita = new Cita(null, $fecha, $medico_id, $enfermero_id, $paciente_id);
            if ($cita->insert()) {
                $msg = "Cita insertada correctamente";
            } else{
                $success = false;
                $msg = "Error al insertar la cita";
            }
            break;
        case "delete":
            $cita = Cita::recuperarCita($id);
            $registros=0;
            if ($cita->delete()) {
                $msg = "Cita borrado correctamente";
            }else{
                $success = false;
                $msg = "Error al borrar cita";
            }
            break;
        case "update":
            $cita = Cita::recuperarCita($id);
            $cita->setFecha($fecha);
            echo $fecha;
            exit();
            $cita->setMedico_id($medico_id);
            $cita->setEnfermero_id($enfermero_id);
            $cita->setPaciente_id($paciente_id);
            $registros=0;
            if ($cita->update()){
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