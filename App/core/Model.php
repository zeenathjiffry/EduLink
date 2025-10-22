<?php

class Model extends Database
{
    protected $table = 'users';
    protected $limit = 10;
    protected $offset = 0;
    protected $rules = []; 
    public $validation_errors = [];

    
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
            
            // --- THIS IS THE FIX ---
            // You must *return* the result of the query.
            // This will now be the lastInsertId (e.g., 1, 2, 3...) or false.
            return $this->query($query, $data); 
            // -----------------------
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

 public function validate($data)
    {
        $this->validation_errors = []; 

        if (empty($this->rules)) {
            return true; 
        }

        foreach ($this->rules as $column => $rule_string) {
            
            $is_present = array_key_exists($column, $data);
            $value = $is_present ? $data[$column] : '';
            $rules = explode('|', $rule_string);
            
            foreach ($rules as $rule) {
                
                // 1. REQUIRED Rule
                if ($rule === 'required' && (!$is_present || $value === '' || $value === null)) {
                    $this->validation_errors[$column] = ucfirst(str_replace('_', ' ', $column)) . " is required.";
                    break; 
                }

                if ((!$is_present || $value === '' || $value === null)) {
                    continue; 
                }

                // 2. EMAIL Rule
                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->validation_errors[$column] = ucfirst(str_replace('_', ' ', $column)) . " is not a valid email format.";
                } 
                
                // 3. MAX Length Rule (e.g., max:255)
                elseif (strpos($rule, 'max:') === 0) {
                    $max = (int) explode(':', $rule)[1];
                    if (strlen($value) > $max) {
                        $this->validation_errors[$column] = ucfirst(str_replace('_', ' ', $column)) . " must be less than $max characters.";
                    }
                } 
                
                // 4. MIN Length Rule (e.g., min:6)
                elseif (strpos($rule, 'min:') === 0) {
                    $min = (int) explode(':', $rule)[1];
                    if (strlen($value) < $min) {
                        $this->validation_errors[$column] = ucfirst(str_replace('_', ' ', $column)) . " must be at least $min characters.";
                    }
                }
                
                // 5. NUMERIC Rule
                elseif ($rule === 'numeric' && !is_numeric($value)) {
                    $this->validation_errors[$column] = ucfirst(str_replace('_', ' ', $column)) . " must be a number.";
                }
                
                // 6. ALPHA_DASH Rule (Letters, numbers, dashes, and underscores)
                elseif ($rule === 'alpha_dash' && !preg_match('/^[a-zA-Z0-9_-]+$/', $value)) {
                    $this->validation_errors[$column] = ucfirst(str_replace('_', ' ', $column)) . " can only contain letters, numbers, dashes, and underscores.";
                }

                if (isset($this->validation_errors[$column])) {
                    break;
                }
            }
        }
        
        return empty($this->validation_errors);
    }
    }
