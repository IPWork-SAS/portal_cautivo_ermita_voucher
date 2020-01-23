<?php
    include_once 'db.class.php';    

    class Campanias extends Orm {

        protected static    
            $database = 'portal_oxohotel',
            $table = 'campania',
            $pk = 'id';

            public function getCampaing($id = '') {
                return $this::retrieveByid($id, Orm::FETCH_ONE);
            }
    }