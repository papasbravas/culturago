<?php
    class bd{
        private $con;

        public function __construct(){
            require_once('../../../../../cred.php');
            // require_once('../../../cred.php');
            $this->con = new mysqli("localhost", USU_CONN, PSW_CONN, "eventos");
        }

        public function getConn(){
            return $this->con;
        }
    }
?>