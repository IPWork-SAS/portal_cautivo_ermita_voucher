<?php
    include_once 'db.class.php';
    include_once 'campanias.class.php';

    class Voucher extends Orm {

        protected static    
            $database = 'portal_oxohotel',
            $table = 'vouchers',
            $pk = 'id_voucher';
        
            public function validateVoucher($num_voucher = '') {

            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            
            $campanias = new Campanias();
            $campania = $campanias->getCampaing(2);
            

            if(isset($voucher) && (($voucher->id_campania == $campania->id && $voucher->id_locacion == 1) && ($voucher->id_caducidad == 1))) {
                
                $fecha_inicioVoucher = date('Y-m-d H:i:s', strtotime($voucher->fecha_inicio));
                $fecha_finVoucher = date('Y-m-d H:i:s', strtotime($voucher->fecha_fin));
                date_default_timezone_set('America/Bogota');
                $fecha_hoy = date("Y-m-d H:i:s");

                $fecha_inicioCampania = date('Y-m-d 00:00:00', strtotime($campania->fecha_inicio));
                $fecha_finCampania = date('Y-m-d 00:00:00', strtotime($campania->fecha_fin));
    
                if ((($fecha_hoy >= $fecha_inicioVoucher && $fecha_hoy <= $fecha_finVoucher) && ($fecha_inicioVoucher >= $fecha_inicioCampania)) && ($voucher->id_campania == 2 && $voucher->id_locacion == 1)){
                    return false;
                }
                else{
                    return true; 
                }          
            }
            else if (isset($voucher) && (($voucher->id_campania == $campania->id && $voucher->id_locacion == 1) && ($voucher->id_caducidad == 2 || $voucher->id_caducidad == 3))) {
              
                $fecha_inicioVoucher = date('Y-m-d H:i:s', strtotime($voucher->fecha_inicio));
                $fecha_finVoucher = date('Y-m-d H:i:s', strtotime($voucher->fecha_fin));

                date_default_timezone_set('America/Bogota');
                $fecha_hoy = date("Y-m-d H:i:s");
                

                $fecha_inicioCampania = date('Y-m-d 00:00:00', strtotime($campania->fecha_inicio));
                $fecha_finCampania = date('Y-m-d 00:00:00', strtotime($campania->fecha_fin));

                if (
                    (
                        ($fecha_hoy >= $fecha_inicioVoucher && $fecha_hoy <= $fecha_finVoucher) && ($fecha_finVoucher <= $fecha_finCampania && $fecha_inicioVoucher >= $fecha_inicioCampania)
                    ) 
                    && 
                    (
                        $voucher->id_campania == $campania->id  && $voucher->id_locacion == 1
                    )
                        ){
                    return false;
                }
                else{
                    return true; 
                }          
            }
        }

        public function validateExistVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE);
        
            if(isset($voucher) && ($voucher->id_campania == 2 && $voucher->id_locacion == 1)) {
                return true;
            }
            else {
                return false;
            }
        }

        public function validateUsesVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            if((isset($voucher))&& (($voucher->num_usos == $voucher->total_num_usos) && ($voucher->id_campania == 2 && $voucher->id_locacion == 1))){
                $voucher->estado = 'Sin Usos Disponibles';
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