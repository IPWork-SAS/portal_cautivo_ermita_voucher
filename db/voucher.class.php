<?php
    include_once 'db.class.php';    

    class Voucher extends Orm {

        protected static    
            $database = 'portal_oxohotel',
            $table = 'vouchers',
            $pk = 'id';
        
        public function validateVoucher($num_voucher = '') {
        
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 

            $fecha_inicial = date('Y-m-d', strtotime($voucher->fecha_inicial));
            $fecha_final = date('Y-m-d', strtotime($voucher->fecha_final));
            $fecha_hoy = $this->getDatetimeNow();           

            if (($fecha_hoy >= $fecha_inicial) && ($fecha_hoy <= $fecha_final)){

                return true;
            }else{

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