<?php 
    //Se llaman las librerias y clases necesarias
    include_once "../db/campania.class.php";
    include_once "../db/voucher.class.php";
    include_once "../db/habitacion.class.php";

   

    //Datos de que suministra el AP
    session_start();

    //Capturamos los datos que trae el formulario y los validamos
    $nombre = isset($_REQUEST['nombre']) ? strtolower(removeAccents(trim($_REQUEST['nombre']))) : "";
    $apellidos = isset($_REQUEST['apellidos']) ? strtolower(removeAccents(trim($_REQUEST['apellidos']))) : "";
    $num_habitacion = isset($_REQUEST['num_habitacion']) ? strtolower(removeAccents(trim($_REQUEST['num_habitacion']))) : "";
    $num_voucher = isset($_REQUEST['voucher']) ?  strtolower(removeAccents(trim($_REQUEST['voucher']))) : "";
    $check = isset($_POST['check']) ? $_POST['check'] : false;  
    $os = isset($_POST['os']) ? $_POST['os'] : "Otro";  
    $lang = isset($_POST['lang']) ? $_POST['lang'] : "es"; 


    include_once("../lang/{$lang}.php"); 

    $voucher = new Voucher();
    $habitacion = new Habitacion();  

    //Validacion elementos del formulario
    $errorMSGHabitacion = "";
    $errorMSGVoucher = ""; 
    $errorMSGNombre = "";
    $errorMSGApellidos = "";
    $errorMSGCheck = "";
    $errorHabitacion = false;
    $errorVoucher = false;
    $errorNombre = false;
    $errorApellidos = false;
    $errorCheck = false;

    //Valida si el campo nombre no es vacio
    if(empty($nombre)) {
        $errorMSGNombre =  $lang['error_nombre'];
        $errorNombre = true; 
    } else {
        if(strlen($nombre) < 3){
            $errorMSGNombre =  $lang['error_nombre_longitud'];
            $errorNombre = true; 
        }
    }

    //Valida si el campo apellidos no es vacio
    if(empty($apellidos)) {
        $errorMSGApellidos =  $lang['error_apellidos'];
        $errorApellidos = true; 
    } else {
        if(strlen($apellidos) < 3){
            $errorMSGApellidos =  $lang['error_apellidos_longitud'];
            $errorApellidos = true; 
        }
    }   
    
    /* Valida si la habitacion es correcta */
    if (!$habitacion->validateHabitacion($num_habitacion)) {
        $errorMSGHabitacion =  $lang['error_num_habitacion'];
        $errorHabitacion = true;
    }     

    /* Valida si el voucher es correcto */
    if (!$voucher->validateExistVoucher($num_voucher)) {
        $errorMSGVoucher =  $lang['error_voucher'];
        $errorVoucher = true;
    }

    if ($voucher->validateUsesVoucher($num_voucher)) {
        $errorMSGVoucher =  $lang['error_voucher_usos'];
        $errorVoucher = true;
    } 
    // Valida si el check de terminos y condiciones
    if($check == 'false') {
        $errorMSGCheck =  $lang['error_aceptar_terminos'];
        $errorCheck = true; 
    }
    

    if(empty($errorMSGVoucher) && empty($errorMSGHabitacion) && empty($errorMSGNombre) && empty($errorMSGApellidos) && empty($errorMSGCheck)) {
        $ip_ap = isset($_SESSION['ip_ap']) ? trim($_SESSION['ip_ap']) : "";  
        $mac_ap = isset($_SESSION['mac_ap']) ? trim($_SESSION['mac_ap']) : "";  
        $mac_cliente = isset($_SESSION['mac_cliente']) ? trim($_SESSION['mac_cliente']) : "";  
        $ip_cliente = isset($_SESSION['ip_cliente']) ? trim($_SESSION['ip_cliente']) : "";  
        $ssid = isset($_SESSION['ssid']) ? trim($_SESSION['ssid']) : "";
        
        $voucher = Voucher::retrieveByvoucher($num_voucher, Orm::FETCH_ONE);

        // if($voucher->num_usos <= 0){
        //     $voucher->num_usos = 0;
           
        // }
        if($voucher->num_usos > 0){
            $voucher->num_usos= $voucher->num_usos-1;
            $voucher->estado = 'En Uso';
            $voucher->save();
        }
        
        $campania = new Campania;
        $campania->nombre = $nombre;
        $campania->apellidos = $apellidos;
        $campania->id_evento = 2;
        $campania->fecha_creacion = getDatetimeNow();
        $campania->num_habitacion = $num_habitacion;
        $campania->num_voucher = $num_voucher;
        $campania->ssid = $ssid;
        $campania->os = $os;
        $campania->mac_cliente = $mac_cliente;
        $campania->ip_cliente = $ip_cliente;
        $campania->mac_ap = $mac_ap;
        $campania->ip_ap = $ip_ap;
        
        $campania->save();
        echo json_encode(['code'=>200]);
        exit;
    }
    
  

    echo json_encode([
        'code'=>404, 
        'errorHabitacion'=>$errorHabitacion, 
        'errorVoucher'=>$errorVoucher, 
        'errorMSGHabitacion'=>$errorMSGHabitacion, 
        'errorMSGVoucher'=>$errorMSGVoucher,
        'errorMSGNombre'=>$errorMSGNombre,
        'errorNombre'=>$errorNombre,
        'errorMSGApellidos'=>$errorMSGApellidos,
        'errorApellidos'=>$errorApellidos,
        'errorMSGCheck' => $errorMSGCheck,
        'errorCheck' => $errorCheck    
    ]);

    
    function getDatetimeNow() {
        $tz_object = new DateTimeZone('America/Bogota');
        //date_default_timezone_set('Brazil/East');
    
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
    }

    function removeAccents($str) {
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $string = strtr( $str, $unwanted_array );
        return $string;
    }

?>
