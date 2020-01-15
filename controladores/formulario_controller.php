<?php 
    //Se llaman las librerias y clases necesarias
    include_once "../db/campania.class.php";
    include_once "../db/voucher.class.php";
    include_once "../db/habitacion.class.php";
    include_once "../clases/formulario.class.php";
    include_once "../clases/utilidades.class.php";   

     //Datos de que suministra el AP
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $lang = $_SESSION['i']; 
    include_once("../lang/{$lang}.php"); 

    $formulario = new Formulario($_REQUEST);
    $datosFormulario = $formulario->GetDataForm();

    if (!$datosFormulario->errorFormulario) {        
        if ($formulario->SaveDataForm()) {
            echo json_encode(['code'=>200]);
            exit;
        } else {
            //Pendiente Mensaje cuando no guarde los datos
            echo json_encode(['code'=>404]);   
            exit;
        }
    } else {    
        echo json_encode([
            'code'=>404, 
            'errorHabitacion'=>isset($datosFormulario->errorHabitacion) ? $datosFormulario->errorHabitacion : '', 
            'errorNombre'=>$datosFormulario->errorNombre,
            'errorVoucher'=>$datosFormulario->errorVoucher, 
            'errorApellidos'=>$datosFormulario->errorApellidos,
            'errorCheck' => $datosFormulario->errorCheck,
            'errorMSGHabitacion'=>!empty($datosFormulario->errorMSGHabitacion) ? $lang[$datosFormulario->errorMSGHabitacion] : '',
            'errorMSGVoucher'=>!empty($datosFormulario->errorMSGVoucher) ? $lang[$datosFormulario->errorMSGVoucher]: '',
            'errorMSGNombre'=>!empty($datosFormulario->errorMSGNombre) ? $lang[$datosFormulario->errorMSGNombre] : '',       
            'errorMSGApellidos'=>!empty($datosFormulario->errorMSGApellidos) ? $lang[$datosFormulario->errorMSGApellidos] : '',     
            'errorMSGCheck' => !empty($datosFormulario->errorMSGCheck) ?$lang[$datosFormulario->errorMSGCheck] : ''           
        ]);
    }
?>
