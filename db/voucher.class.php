<?php
    include_once 'db.class.php';    

    class Voucher extends Orm {

        protected static    
            $database = 'portal_oxohotel_vouchers',
            $table = 'vouchers',
            $pk = 'id_voucher';
        
        public function validateVoucher($num_voucher = '') {
        
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 

            $fecha_inicial = date('Y-m-d', strtotime($voucher->fecha_inicial));
            $fecha_final = date('Y-m-d', strtotime($voucher->fecha_final));
            $fecha_hoy = $this->getDatetimeNow(); 

            if (($fecha_hoy >= $fecha_inicial) && ($fecha_hoy <= $fecha_final)){
                return true;
            }
            else{
                return false; 
            }          
        }

        public function validateExistVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            if(isset($voucher)) {
                return true;
            }
            else {
                return false;
            }
        }

        public function validateUsesVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            if((isset($voucher))&&($voucher->num_usos == 0)){
                $voucher->estado = 'En Uso';
                $voucher->save();
                return true;
            }
            else {
                return false;
            }
        }


        function getDatetimeNow() {
            $tz_object = new DateTimeZone('America/Bogota');
            //date_default_timezone_set('Brazil/East');
        
            $datetime = new DateTime();
            $datetime->setTimezone($tz_object);
            return $datetime->format('Y\-m\-d\ h:i:s');
        }
    }