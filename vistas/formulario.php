<?php 
    include_once '../db/campania.class.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_REQUEST['i'])) {
        $_SESSION['i'] = $_REQUEST['i'];
        $lang = $_REQUEST['i'];
    } else {
        $lang = $_SESSION["i"]; 
    } 

    include_once("../lang/{$lang}.php");
    
    $campania = new Campania();
    $datosCampania = $campania->GetDatosCampaña();   
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
                        
                        <?php 
                            // Se valida que exista el campo nombre y apellidos en los datos de la campania, si existe se muestra el contenido html. 
                            if(isset($datosCampania['nombre']) && isset($datosCampania['apellidos'])) {
                                echo '
                                <div class="form-row">
                                    <div class="form-group col-md-6" name="form_group_nombre" id="form_group_nombre">
                                        <input type="text" required autocomplete="off" onkeyup="dropInvalidCharacteresNombre();" class="form-control form-control-sm" id="nombre" name="nombre" onfocus="restaurarInputNombre()" placeholder="'.$lang['nombre_form'].'">
                                        <span id="errorMSGNombre"></span>
                                    </div>
                                    <div class="form-group col-md-6" name="form_group_apellidos" id="form_group_apellidos">
                                        <input type="text" autocomplete="off" required onkeyup="dropInvalidCharacteresApellidos();" class="form-control form-control-sm" id="apellidos" name="apellidos" onfocus="restaurarInputApellidos()" placeholder="'.$lang['apellidos_form'].'">
                                        <span id="errorMSGApellidos"></span>
                                    </div>
                                </div>
                                ';
                            } 
                            // Se valida que exista el campo email en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['email'])) {
                                echo '
                                <div class="form-group" id="form_group_email"  name="form_group_email">
                                    <input type="email" required class="form-control form-control-sm" id="email" name="email" placeholder="'.$lang['email_form'].'">
                                    <span id="errorMSGEmail"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo telefono en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['telefono'])) {
                                echo '
                                <div class="form-group" id="form_group_telefono"  name="form_group_telefono">
                                <input type="tel" class="form-control form-control-sm" id="telefono" name="telefono" placeholder="'.$lang['celular_form'].'" required>
                                    <span id="errorMSGTelefono"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo genero en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['genero'])) {
                                echo '
                                <div class="form-group" id="form_group_genero"  name="form_group_genero">
                                    <select id="genero"  name="genero" class="form-control form-control-sm" required>
                                        <option selected value="">'.$lang['seleccion_genero_form'].'</option>
                                        <option value="Hombre">'.$lang['masculino_genero_form'].'</option>
                                        <option value="Mujer">'.$lang['femenino_genero_form'].'</option>
                                        <option value="Otro">'.$lang['otro_genero_form'].'</option>
                                    </select>
                                    <span id="errorMSGGenero"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo numero de habitacion en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['num_habitacion'])) {
                                echo '
                                <div class="form-group" id="form_group_habitacion"  name="form_group_habitacion">
                                    <input type="text" required autocomplete="off" onkeyup="dropInvalidCharacteresHabitacion()" class="form-control form-control-sm" id="num_habitacion" name="num_habitacion" onfocus="restaurarInputHabitacion()" placeholder="'.$lang['num_habitacion_form'].'">
                                    <span id="errorMSGHabitacion"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo voucher en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['num_voucher'])) {
                                echo '
                                <div class="form-group" id="form_group_voucher" name="form_group_voucher">
                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="num_voucher" name="num_voucher" onfocus="restaurarInputVoucher()" placeholder="'.$lang['voucher_form'].'">
                                    <span id="errorMSGVoucher"></span>
                                </div>
                                ';
                            }
                        ?>  
                        <div class="form-group check-terminos input_error" id="form_group_check" name="form_group_check">
                            <div class="form-check">
                                <input class="form-check-input custom-control-input" type="checkbox" id="gridCheck" name="gridCheck"  required onclick="restaurarInputCheck()">
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
                                Powered by <a href="https://ipwork.com.co/"> IPwork</a> (C) Copyright 2019
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