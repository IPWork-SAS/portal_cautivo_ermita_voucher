<?php 
    include_once('utilidades.class.php');
    include_once('../db/voucher.class.php');
    include_once('../db/habitacion.class.php');
    include_once('../db/campania.class.php');

    class Formulario {
        
        private $dataFormulario;
        private $dataWIFI;
        private $arrayElementsForm;

        private $utilidades;

        function __construct($formRequest)
        { 
            $this->InitializeVariables();   
            $this->SetFormElements($formRequest);
            $this->SetDataWifi();
        }

        public function GetDataForm() {
            return (object)$this->dataFormulario;
        }

        public function GetDataWIFI() {
            return (object)$this->dataWIFI;
        }

        public function SaveDataForm() {
            $dataClient = $this->GetDataCLient();           
            $campania = new Campania();
    
            if($campania->SaveDataClient($dataClient)){
                return true;
            } else {
                return false;
            }        
        }
        
        function GetDataCLient() {
            $dataCLient = array();
            foreach ($this->arrayElementsForm as $formElement) {
                $dataClient[$formElement] = $this->dataFormulario[$formElement];
            }

            foreach ($this->dataWIFI as $key => $value) {
                $dataClient[$key] = $value;
            }

            return $dataClient;
        }
        function SetDataWifi() {
             //Datos de que suministra el AP
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $this->dataWIFI['ip_ap'] = isset($_SESSION['ip_ap']) ? trim($_SESSION['ip_ap']) : '';   
            $this->dataWIFI['mac_ap'] = isset($_SESSION['mac_ap']) ? trim($_SESSION['mac_ap']) : '';  
            $this->dataWIFI['mac_cliente'] = isset($_SESSION['mac_cliente']) ? trim($_SESSION['mac_cliente']) : '';  
            $this->dataWIFI['ip_cliente'] = isset($_SESSION['ip_cliente']) ? trim($_SESSION['ip_cliente']) : '';  
            $this->dataWIFI['ssid'] = isset($_SESSION['ssid']) ? trim($_SESSION['ssid']) : '';
        }

        function InitializeVariables() {
            $this->utilidades = new Utilidades();
            $this->dataFormulario = array();
            $this->dataWIFI = array();
            $this->arrayElementsForm = array();
            $this->dataFormulario['errorFormulario'] = false;  
        }

        function SetFormElements($formRequest) {   
            foreach ($formRequest as $key => $value) {
                if ($key == 'nombre') {
                    array_push($this->arrayElementsForm, $key);
                    $nombre = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->ValidateNombre($nombre);
                }
                if ($key == 'apellidos') {
                    array_push($this->arrayElementsForm, $key);
                    $apellidos = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->ValidateApellidos($apellidos);
                }
                if ($key == 'num_habitacion') {
                    array_push($this->arrayElementsForm, $key);
                    $num_habitacion = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->dataFormulario['apellidos'] = $apellidos;
                    $this->ValidateHabitacion($num_habitacion);
                }
                if ($key == 'num_voucher') {
                    array_push($this->arrayElementsForm, $key);
                    $num_voucher = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->dataFormulario['num_voucher'] = $num_voucher;
                    $this->ValidateVoucher($num_voucher);
                }
                if ($key == 'os') {  
                    array_push($this->arrayElementsForm, $key);                  
                    $os = $value;
                    $this->dataFormulario['os'] = $os;
                    $this->ValidateSistemaOperativo($os);
                }
                //Datos que se omiten al guardar la informacion
                if ($key == 'check') {
                    $check = $value;
                    $this->ValidateTerminosCondiciones($check);
                }
            }  
        }

        function ValidateNombre($nombre) { 
            if (empty($nombre)) {
                $this->dataFormulario['errorMSGNombre']  = 'error_nombre_vacio';
                $this->dataFormulario['errorNombre'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if(!preg_match("/^[a-zA-Z'-]/", $nombre)) {
                    $this->dataFormulario['errorMSGNombre'] = 'error_nombre_estructura';
                    $this->dataFormulario['errorNombre'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (strlen($nombre) < 3) {
                    $this->dataFormulario['errorMSGNombre'] = 'error_nombre_longitud';
                    $this->dataFormulario['errorNombre'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGNombre'] = '';
                    $this->dataFormulario['errorNombre'] = false;;   
                }
            }            

            $this->dataFormulario['nombre'] = $nombre;            
        }
    
        function ValidateApellidos($apellido) {        
            if (empty($apellido)) {
                $this->dataFormulario['errorMSGApellidos'] = 'error_apellido_vacio';
                $this->dataFormulario['errorApellidos'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if(!preg_match("/^[a-zA-Z'-]/", $apellido)) {
                    $this->dataFormulario['errorMSGApellidos']= 'error_apellido_estructura';
                    $this->dataFormulario['errorApellidos'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (strlen($apellido) < 3) {
                    $this->dataFormulario['errorMSGApellidos'] = 'error_apellido_longitud';
                    $this->dataFormulario['errorApellidos'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGApellidos'] = '';
                    $this->dataFormulario['errorApellidos'] = false;
                }   
            }          

            $this->dataFormulario['apellidos'] = $apellido;
        }
    
        function ValidateHabitacion($num_habitacion) {
            $habitacion = new Habitacion();

            if(empty($num_habitacion)) {
                $this->dataFormulario['errorMSGHabitacion'] =  'error_num_habitacion_vacio';
                $this->dataFormulario['errorHabitacion'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if (!$habitacion->validateHabitacion($num_habitacion)) {
                    $this->dataFormulario['errorMSGHabitacion'] = 'error_num_habitacion';
                    $this->dataFormulario['errorHabitacion'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGHabitacion'] = '';
                    $this->dataFormulario['errorHabitacion'] = false;
                }
            }            

            $this->dataFormulario['num_habitacion'] = $num_habitacion;
        } 
    
        function ValidateVoucher($num_voucher) {            
            $voucher = new Voucher();        
            if(empty($num_voucher)) {
                $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_vacio';
                $this->dataFormulario['errorVoucher'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if ( !$voucher->validateExistVoucher($num_voucher)) {
                    $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_existencia';
                    $this->dataFormulario['errorVoucher'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if ($voucher->validateUsesVoucher($num_voucher)) {
                    $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_usos';
                    $this->dataFormulario['errorVoucher'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (!$voucher->ValidateVoucherExpiration($num_voucher)) {
                    $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_expiration';
                    $this->dataFormulario['errorVoucher'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                }
                else {
                    $this->dataFormulario['errorMSGVoucher'] = '';
                    $this->dataFormulario['errorVoucher'] = false;
                }  
            }           

            $this->dataFormulario['num_voucher'] = $num_voucher;             
        }
    
        function ValidateTerminosCondiciones($check) {       

            if ($check == 'false') {
                $this->dataFormulario['errorMSGCheck'] =  'error_terminos_condiciones';
                $this->dataFormulario['errorCheck']  = true; 
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                $this->dataFormulario['errorMSGCheck'] =  '';
                $this->dataFormulario['errorCheck']  = false; 
            }

            $this->dataFormulario['check'] = $check;            
        }
    
        function ValidateSistemaOperativo($os) {
            if ($os == '') {
                $this->dataFormulario['os'] = 'Otro';   
            }
        }
    }

   
?>