<?php 
    include './db/campania.class.php';
    include './db/voucher.class.php';

    class Validacion {
        public function getUrlRedirection($mac = '') {
            $campania = new Campania();
            $entries = $campania->validarMac($mac);
            if(empty($entries)) {   
                return 'Location: vistas/formulario.php';
            } else {
                return 'Location: vistas/banner.php';
            }
        }

        public function getUrlRedirectionVoucher($mac = '') {
            $campania = new Campania();
            $user = $campania->getUserByMac($mac);
            if(isset($user)) {
                $voucher = new Voucher();
                if($voucher->validateVoucher($user->num_voucher) == "true") {
                    return 'Location: vistas/banner.php';
                } else {                
                    return 'Location: vistas/error.php?e=error_voucher';
                }
            } else {
                return 'Location: vistas/formulario.php';
            }
        }       
    }
?>