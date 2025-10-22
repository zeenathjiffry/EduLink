<?php

class ClassManager extends Controller
{
public function index()
{
    // 1️⃣ Ensure session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2️⃣ Check if user is logged in
    if (!isset($_SESSION['USER'])) {
        redirect('login');
        exit();
    }

    $role = $_SESSION['USER']['role'] ?? null; // safe fallback
    $classModel = new ClassModel();
    $adModel = new AdvertisementRequest(); 
    
    $classes = [];
    $ads = [];

    if ($role === 'teacher' && isset($_SESSION['USER']['teacher_id'])) {
        $teacherId = $_SESSION['USER']['teacher_id'];
        $classes = $classModel->where(['teacher_id' => $teacherId]);
        $ads = $adModel->where(['account_id' => $_SESSION['USER']['account_id']]);
        $data['classes'] = $classes;
        $data['ads'] = $ads;
        $this->view('teacher_class_dashboard', $data);

        

    } elseif ($role === 'institute' && isset($_SESSION['USER']['institute_id'])) {
        $instituteId = $_SESSION['USER']['institute_id'];
        $classes = $classModel->where(['institute_id' => $instituteId]);
        $ads = $adModel->where(['account_id' => $_SESSION['USER']['account_id']]);
        $data['classes'] = $classes;
        $data['ads'] = $ads;
        $this->view('institute_class_dashboard', $data);

    } elseif ($role === 'student' && isset($_SESSION['USER']['student_id'])) {
        $studentId = $_SESSION['USER']['student_id'];
        $enrollmentModel = new EnrollmentModel();
        $classes = $enrollModel->getStudentEnrollments($studentId);
        $data['classes'] = $classes;
        $this->view('student_class_dashboard', $data);
    }

    // 4️⃣ Pass data to view

}


    public function save_advertisement_request()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $adModel = new AdvertisementRequest();

            // Handle poster upload using the helper
            $uploadedFiles = handleFileUploads('ad_poster', 'ads');
            $posterPath = !empty($uploadedFiles) ? $uploadedFiles[0] : null;

            // Prepare data from POST inputs
            $data = [
                'account_id'        => $_SESSION['USER']['account_id'],
                'advertiser_contact' => $_POST['advertiser_contact'] ?? '',
                'placement_option'   => $_POST['placement'] ?? '',
                'start_time'         => $_POST['start_time'] ?? '',
                'end_time'           => $_POST['end_time'] ?? '',
                'poster_path'        => $posterPath,
                'status'             => 'Pending'
            ];

        if (empty($data['advertiser_contact']) || empty($data['placement_option'])) {
            $_SESSION['error'] = "Please fill in all required fields.";
            redirect('ClassManager/index');
            exit;
        }

         
            $adModel->insert($data);

            $_SESSION['success'] = "Advertisement request submitted successfully.";

            redirect('ClassManager/index');
        } else {
            redirect('ClassManager/index');
        }
    }
}
