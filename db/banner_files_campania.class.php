<?php
    include_once 'db.class.php';  
    include_once 'config.php';

    class BannerFilesCampania extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'banner_files_campania',
            $pk = 'id';            
       

        public function GetSRCBannerList() {
            $arraySRCBanner = array();
            $filesBannerWeb = $this::all(); 
            
            foreach ($filesBannerWeb as $key => $value) {
                $bannerFile = array();
                $srcImgWeb = 'data:'.$value->mime_img_web.';base64,'.base64_encode($value->datos_img_web).'';
                $srcImgMovil = 'data:'.$value->mime_img_movil.';base64,'.base64_encode($value->datos_img_movil).'';
                $bannerFile['srcImgWeb'] = $srcImgWeb;
                $bannerFile['srcImgMovil'] = $srcImgMovil;
                array_push($arraySRCBanner, (object)$bannerFile);
            }
            return $arraySRCBanner;
        }
    }