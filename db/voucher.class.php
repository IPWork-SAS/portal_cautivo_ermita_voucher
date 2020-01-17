<?php
    include_once 'db.class.php';    

    class Voucher extends Orm {

        protected static    
            $database = 'portal_oxohotel',
            $table = 'vouchers',
            $pk = 'id_voucher';
        
        public function validateVoucher($num_voucher = '') {
        
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 

            $fecha_inicio = date('Y-m-d', strtotime($voucher->fecha_inicio));
            $fecha_fin = date('Y-m-d', strtotime($voucher->fecha_fin));
            $fecha_hoy = $this->getDatetimeNow(); 

            if (($fecha_hoy >= $fecha_inicio) && ($fecha_hoy <= $fecha_fin)){
                return true;
            }
            else{
                return false; 
            }          
        }

        public function validateExistVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE);
        
            if(isset($voucher) && $voucher->id_campania == 1) {
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