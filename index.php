<?php
    include_once('./controladores/validacion_controller.php');
    session_start();

    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $acceptLang = ['es', 'en']; 
    $lang = in_array($lang, $acceptLang) ? $lang : 'en';
    $_SESSION['i'] = $lang;
   
    //IP donde se encuentra la interface nortbound de ruckus
    $_SESSION['ip_nbi'] = isset($_REQUEST['nbiIP']) ? $_REQUEST['nbiIP'] : "";
    //Dominio en donde esta asociada la interfaz de logueo del Zone Director
    $_SESSION['zd_ip'] = isset($_REQUEST['sip']) ? $_REQUEST['sip'] : "";
    //IP del ap asociado
    $_SESSION['ip_ap'] = isset($_REQUEST['apip']) ? $_REQUEST['apip'] : "";
    //Mac del ap asociado
    $_SESSION['mac_ap'] = isset($_REQUEST['mac']) ? $_REQUEST['mac'] : "";
    //Mac del cliente asociado
    $_SESSION['mac_cliente'] = isset($_REQUEST['client_mac']) ? $_REQUEST['client_mac'] : "";
    //IP del cliente asociado
    $_SESSION['ip_cliente'] = isset($_REQUEST['uip']) ? $_REQUEST['uip'] : "";
    //SSID de la red
    $_SESSION['ssid'] = isset($_REQUEST['ssid']) ? $_REQUEST['ssid'] : "";
    //SSH Tunel Status Determina si se loguea con el ap directamente o con la controladora
    $_SESSION['sshTunnelStatus'] = isset($_REQUEST['sshTunnelStatus']) ? $_REQUEST['sshTunnelStatus'] : "";
    //URL de redireccion de la controladora
    $_SESSION['url'] = isset($_REQUEST['url']) ? $_REQUEST['url'] : "";
    //Determina si el buscador del equipo del usuario esta configurado con web proxy
    $_SESSION['proxy'] = isset($_REQUEST['proxy']) ? $_REQUEST['proxy'] : "";
    
    $validacion = new Validacion();
    $url = $validacion->getUrlRedirectionVoucher($_SESSION['mac_cliente']); 
  
    header($url);
?>  