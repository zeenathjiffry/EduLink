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

    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);

        // --- THIS IS THE FIX ---

        // Get the first word of the query (e.g., "SELECT", "INSERT")
        $queryType = strtoupper(trim(substr($query, 0, 6)));

        if ($queryType == "INSERT")
        {
            // If the query was an INSERT, return the new ID on success
            return $check ? $con->lastInsertId() : false;
        }
        elseif ($queryType == "UPDATE" || $queryType == "DELETE")
        {
            // If it was an UPDATE or DELETE, just return true/false
            return $check;
        }
        elseif ($queryType == "SELECT")
        {
            // If it was a SELECT, fetch the results as before
            if ($check)
            {
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                if (is_array($result) && count($result))
                {
                    return $result;
                }
            }
        }

        // If it was a failed SELECT or unknown query, return false
        return false;
    }
}