<?php

class StudentRegister extends Controller
{
    public function index()
    {
        $data = []; // Initialize $data

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email'])) {
            
            $accountModel = new Account();
            
            // 1. Validate the POST data
            if ($accountModel->validate($_POST)) {
                
                // 2. If validation passes, prepare data
                $data = [
                    'email' => $_POST['email'],

                    // --- THIS IS THE FIX ---
                    // Use the correct database column names
                    'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'account_type'  => $_POST['role']
                    // -----------------------
                ];

                // 3. Insert into 'account' table
                $account_id = $accountModel->insert($data); 

                if($account_id) {
                    // SUCCESS: Start session and save the ID
                    $_SESSION['new_account_id'] = $account_id;
                    $_SESSION['new_account_role'] = $_POST['role']; // Save the selected role

                    // Load the student details view
                    $this->view('student_signup');
                    return; // Stop the script here
                } else {
                    // This should not happen if validation passed, but good to have
                    $data['errors'] = ['account' => 'Database error. Could not create account.'];
                }

            } else {
                // 4. If validation fails, get the errors
                $data['errors'] = $accountModel->validation_errors;
            }
            
            // 5. If we are here, it's because validation or insert failed.
            
            print_r($data['errors']);
            $this->view('signup', $data);

        } else {
            // This is a GET request, just show the details page
            $this->view('student_signup');
        }
    }
}