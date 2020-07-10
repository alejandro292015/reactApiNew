<?php
   
   class Database {

    // bzw2kynj0tcamkw0j9wn-mysql.services.clever-cloud.com
    // bzw2kynj0tcamkw0j9wn
    // ultyt5gonpvdkiju
    // yjQYmZvOZpF6Z7NIKhfY
    private $db_host = '  https://www.db4free.net/';
    private $db_name = 'sampledb';
    private $db_username = 'alejol29';
    private $db_password = 'reactapirest';

    public function dbConnection (){
        try{
            $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
            $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn ;
        }
        catch (PDOException $e){
            echo "Connection error " .$e->getMessage();
            exit();
        }
    }

   }
   ?>