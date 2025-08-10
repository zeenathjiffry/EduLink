<?php

class Database
{
    private function connect()
    {
        $string = "mysql:host=".DBHOST.";dbname=".DBNAME;
        try {
            $con = new PDO($string, DBUSER, DBPASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function query($query,$data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if($check)
        {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
            {
        
                return  $result;
            }
        }

        return false;

    }
}





