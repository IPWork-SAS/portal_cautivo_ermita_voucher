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
<<<<<<< HEAD
                $voucher = new Voucher();
                if($voucher->validateVoucher($user->num_voucher) === 1) {
                    return 'Location: vistas/banner.php';
                } else {                
                    return 'Location: vistas/error.php?e=error_voucher';
                }
=======
                return 'Location: vistas/banner.php';
                // $voucher = new Voucher();
                // if($voucher->validateVoucher($user->num_voucher) == 1) {
                //     return 'Location: vistas/banner.php';
                // } else {                
                //     return 'Location: vistas/error.php?e=error_voucher';
                // }
>>>>>>> 49c2762c87e6fe5dbb4c6d28e1a70f8fac39d9ce
            } else {
                return 'Location: vistas/formulario.php';
            }
        }       
    }
?>