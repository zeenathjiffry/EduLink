<?php

class Signup extends Controller
{

    public function index()
    {
        $data = []; 
        $this->view('signup', $data);
    }

    public function save_student_details()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['new_account_id'])) {


            $studentModel = new Student(); // This line will now work
            $data = [
                'account_id' => $_SESSION['new_account_id'],
                'first_name' => $_POST['first_name'],
                'last_name'  => $_POST['last_name'],
                'school_name' => $_POST['school'], // ✅ match model
                'address'    => $_POST['address'],
                'stream'     => $_POST['stream']
            ];

            $studentModel->insert($data);
           
            $_SESSION['user_id'] = $_SESSION['new_account_id'];
            $_SESSION['user_role'] = $_SESSION['new_account_role'];
            $_SESSION['user_name'] = $_POST['first_name']; 
            unset($_SESSION['new_account_id']);
            unset($_SESSION['new_account_role']);
            redirect('home'); 
        } else {

            redirect('signup');
        }
    }

public function save_teacher_details()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['new_account_id'])) {

        $teacherModel = new Teacher();

     
        $uploadedFiles = handleFileUploads('files', 'teachers');
        $filePaths = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : '';

      
        $data = [
            'account_id'             => $_SESSION['new_account_id'],
            'first_name'             => $_POST['first_name'],
            'last_name'              => $_POST['last_name'],
            'email'                  => $_POST['contact_email'], 
            'phone'                  => $_POST['phone'],
            'subjects_taught'        => $_POST['subject'],
            'approval_status'        => 'pending',
            'approval_document_path' => $filePaths,
            'approved_by_admin_id'   => null
        ];
        $teacherModel->insert($data);

        $_SESSION['user_id']   = $_SESSION['new_account_id'];
        $_SESSION['user_role'] = $_SESSION['new_account_role'];
        
        $_SESSION['user_name'] = $_POST['first_name'];

        unset($_SESSION['new_account_id']);
        unset($_SESSION['new_account_role']);


        redirect('home');
    } else {
        redirect('signup');
    }
}

   public function save_institute_details()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['new_account_id'])) {

        $instituteModel = new Institute();

        // 1️⃣ Handle file uploads using global function
        $uploadedFiles = handleFileUploads('files', 'institutes');
        $filePaths = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : null;

        // 2️⃣ Collect form data
        $data = [
            'account_id'             => $_SESSION['new_account_id'],
            'institute_name'         => $_POST['institute_name'],
            'location'               => $_POST['address'], // matches table column
            'contact_email'          => $_POST['contact_email'],
            'contact_phone'          => $_POST['phone'],
            'approval_status'        => 'pending',
            'approval_document_path' => $filePaths,
            'approved_by_admin_id'   => null
        ];

        // 3️⃣ Filter data using allowedColumns for safety
        $data = array_intersect_key($data, array_flip($instituteModel->getAllowedColumns()));


        // 4️⃣ Insert into DB
        $instituteModel->insert($data);

        // 5️⃣ Set session and redirect
        $_SESSION['user_id']   = $_SESSION['new_account_id'];
        $_SESSION['user_role'] = $_SESSION['new_account_role'];
        $_SESSION['user_name'] = $_POST['institute_name'];

        unset($_SESSION['new_account_id']);
        unset($_SESSION['new_account_role']);

        redirect('home');

    } else {
        redirect('signup');
    }
}

}