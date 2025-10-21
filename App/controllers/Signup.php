<?php

class Signup extends Controller
{
    public function index()
    {
        $data = [];
        
        // Check if the form was submitted (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Instantiate the models
            $account_model = new Account();
            
            // 2. Validate the data
            // You would normally have a proper validation method here
            if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['user_type'])) {
                $data['errors'] = "Please fill in all required fields.";
            } 
            // Add more validation here (e.g., password length, unique email check)
            
            // 3. Process if no errors
            if (!isset($data['errors'])) {
                
                $post_data = $_POST;
                $user_type = $post_data['user_type'] ?? 'student'; // Default to 'student' if not set
                
                // --- Insert into 'account' table ---
                $account_data = [
                    'email' => $post_data['email'],
                    'password' => $post_data['password'], 
                    'user_type' => $user_type,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                
                // Hash the password *before* inserting
                $account_data = $account_model->hashPassword($account_data);

                // This must return the new account ID (lastInsertId)
                $account_id = $account_model->insert($account_data); 
                
                if ($account_id) {
                    
                    // --- Insert into specific user table (Student, Teacher, or Institute) ---
                    $specific_data = ['account_id' => $account_id];
                    $specific_model = null;

                    switch ($user_type) {
                        case 'student':
                            $specific_model = new Student();
                            $specific_data['student_name'] = $post_data['name'] ?? '';
                            $specific_data['grade'] = $post_data['grade'] ?? '';
                            break;
                            
                        case 'teacher':
                            $specific_model = new Teacher();
                            $specific_data['teacher_name'] = $post_data['name'] ?? '';
                            $specific_data['subject'] = $post_data['subject'] ?? '';
                            break;

                        case 'institute':
                            $specific_model = new Institute();
                            $specific_data['institute_name'] = $post_data['name'] ?? '';
                            $specific_data['address'] = $post_data['address'] ?? '';
                            break;
                    }

                    $success = $specific_model ? $specific_model->insert($specific_data) : false;

                    if ($success) {
                        
                        // 4. Success: Log the user in and redirect (Post-Redirect-Get pattern)
                        // Note: You need a User class or similar method to handle session creation
                        // For simplicity, let's assume a basic session login:
                        $_SESSION['user_id'] = $account_id;
                        $_SESSION['user_type'] = $user_type;

                        header('Location: ' . BASEURL . '/home');
                        exit;
                        
                    } else {
                        // 5. Cleanup/Rollback if the second insert failed
                        $account_model->delete($account_id); 
                        $data['errors'] = "Registration failed. Please try again.";
                    }
                } else {
                    $data['errors'] = "Account creation failed. Email might be in use.";
                }
            }
            
            $data['post_data'] = $post_data ?? [];
        }

        $this->view('signup', $data);
    }
}