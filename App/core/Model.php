<?php

class Model extends Database
{
    protected $table = 'users';
    protected $limit = 10;
    protected $offset = 0;

    
    public function where($data, $data_not = [])
    {
        $conditions = [];
        $params = [];
        
        // Handle equal conditions (=)
        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        // Handle not equal conditions (!=)
        foreach ($data_not as $key => $value) {
            $conditions[] = "$key != :not_$key";
            $params["not_$key"] = $value;
        }
        
        // Build the query
        $query = "SELECT * FROM $this->table";
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        
        // Add limit/offset if set
        if ($this->limit !== null) {
            $query .= " LIMIT $this->limit";
            if ($this->offset !== null) {
                $query .= " OFFSET $this->offset";
            }
        }

        return $this->query($query, $params);
    }
    public function first($data, $data_not = [])
    {
        $conditions = [];
        $params = [];
        
        // Handle equal conditions (=)
        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        // Handle not equal conditions (!=)
        foreach ($data_not as $key => $value) {
            $conditions[] = "$key != :not_$key";
            $params["not_$key"] = $value;
        }
        
        // Build the query
        $query = "SELECT * FROM $this->table";
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        
        // Add limit/offset if set
        if ($this->limit !== null) {
            $query .= " LIMIT $this->limit";
            if ($this->offset !== null) {
                $query .= " OFFSET $this->offset";
            }
        }

        $result = $this->query($query, $params);
        if($result)
        {
            return $result[0];
        }
        return false;

    }
    public function insert($data)
    {
        try
        {
            $keys = array_keys($data);
            $columns = implode(",", $keys);
            $placeholders = implode(",:", $keys);

            // Build the query
            $query = "INSERT INTO $this->table ($columns) VALUES (:$placeholders)"; 
            $this->query($query,$data);   
        }
        catch (PDOException $e) 
        {
            // Log error in production instead of echoing
            error_log("Database Error: " . $e->getMessage());
            return false;
        }

        
    }
    public function update($id, $data, $id_column = 'id')
    {

    }
    public function delete($id, $data = null, $id_column = 'id') 
    {
        // Validate input
        if (empty($id)) {
            throw new InvalidArgumentException("ID cannot be empty!");
        }

        $conditions = ["$id_column = :$id_column"];
        $params = [":$id_column" => $id];

        // Add additional conditions if provided
        if ($data !== null && is_array($data)) {
            foreach ($data as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        $query = "DELETE FROM $this->table WHERE " . implode(' AND ', $conditions);

        return $this->query($query, $params);
    }
}