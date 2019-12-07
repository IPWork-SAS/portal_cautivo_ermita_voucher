<?php 
    session_start();


    if (isset($_REQUEST['i'])) {
        $_SESSION['i'] = $_REQUEST['i'];
        $lang = $_REQUEST['i'];
    } else {
        $lang = $_SESSION["i"]; 
    } 

    include_once("../lang/{$lang}.php"); 
    

   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />      
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $lang['titulo_website'];?></title>   
    <link rel="stylesheet" href="../vendor/flag-icon/flag-icon.css"> 
    <link rel="stylesheet" href="../vendor/flag-icon/flag-icon.min.css"> 
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/formulario.css">
    <link rel="stylesheet" href="../css/terminos_condiciones.css">

    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    
</head>
<body>
    <div class="selector-idioma">
        <?php if ($lang['lang'] == 'es'){ ?>
            <div class="icono-idioma">
                <a href="../vistas/formulario.php?i=en"><img src="../vendor/flag-icon/flags/4x3/us.svg" alt=""></a>
                <span>EN</span>
            </div>
        <?php } else { ?>
            <div class="icono-idioma">
                <a href="../vistas/formulario.php?i=es"><img src="../vendor/flag-icon/flags/4x3/es.svg" alt=""></a>
                <span>ES</span>
            </div>
        <?php } ?>
       
    </div>

    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12 my-auto">
                <div class="card"> 
                    <div class="logo">
                        <img src="../img/logo_1.png" alt="">
                        <p><?= $lang['titulo_form'];?></p>
                    </div>
                    <form class="formulario"  action="">
                        <input type="hidden" name="os" id="os"> 
                        <input type="hidden" name="lang" id="lang" value="<?=$lang['lang']?>">    
                        <div class="form-row">
                            <div class="form-group col-md-6" name="form_group_nombre" id="form_group_nombre">
                                <input type="text" required autocomplete="off" onkeyup="validate();" class="form-control form-control-sm" id="nombre" name="nombre" onfocus="restaurarInputNombre()" placeholder="<?= $lang['nombre_form'];?>">
                                <span id="errorMSGNombre"></span>
                            </div>
                            <div class="form-group col-md-6" name="form_group_apellidos" id="form_group_apellidos">
                                <input type="text" autocomplete="off" required onkeyup="validate();" class="form-control form-control-sm" id="apellidos" name="apellidos" onfocus="restaurarInputApellidos()" placeholder="<?= $lang['apellidos_form'];?>">
                                <span id="errorMSGApellidos"></span>
                            </div>
                        </div>
                        <div class="form-group" id="form_group_habitacion"  name="form_group_habitacion">
                            <input type="text" required autocomplete="off" class="form-control form-control-sm" id="num_habitacion" name="num_habitacion" onfocus="restaurarInputHabitacion()" placeholder="<?= $lang['num_habitacion_form'];?>">
                            <span id="errorMSGHabitacion"></span>
                        </div>
                        <div class="form-group" id="form_group_voucher" name="form_group_voucher">
                            <input type="text" required autocomplete="off" class="form-control form-control-sm" id="voucher" name="voucher" onfocus="restaurarInputVoucher()" placeholder="<?= $lang['voucher_form'];?>">
                            <span id="errorMSGVoucher"></span>
                        </div>
                        <div class="form-group check-terminos input_error" id="form_group_check" name="form_group_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck"  required onclick="restaurarInputCheck()">
                                <label class="form-check-label" for="gridCheck">
                                    <a href="#popup"><?= $lang['terminos_link'];?></a>
                                </label>
                            </div>
                            <span id="errorMSGCheck"></span>
                        </div>
                        <div class="form-btn">
                            <button type="submit" id="submit" class="btn btn-conect"><?= $lang['btn_continuar'];?></button>
                        </div>                           
                    </form>
                    <div class="footer">
                        <div class="page-footer font-small">
                            <!-- Copyright -->
                            <div class="footer-copyright text-center py-3">
                                Powered by <a href="https://mdbootstrap.com/education/bootstrap/"> IPwork</a> (C) Copyright 2019
                            </div>
                            <!-- Copyright -->
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div> 
    
    <div class="popup" id="popup">
        <div class="popup-inner">
            <div class="popup__text">
                <?php if ($lang['lang'] == 'es'){ ?>
                    <div id="incluirTerminosCondiciones_es" class="container_terminos"></div>
                <?php } else { ?>
                    <div id="incluirTerminosCondiciones_en" class="container_terminos"></div>
                <?php } ?>                
            </div>
            <a class="popup__close" href="#">X</a>
        </div>
    </div>
 
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/formulario.js"></script>
    <script src="../js/terminos_condiciones.js"></script> 

</body>
</html>