<?php

class StudentProfile extends Controller
{
    
public function index()
{
    // 1️⃣ Ensure session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2️⃣ Check login
    if (!isset($_SESSION['USER'])) {
        redirect('login');
        exit();
    }

    // 3️⃣ Fetch account events
    $accountId = $_SESSION['USER']['account_id'];
    $eventModel = new Event();
    $events = $eventModel->where(['account_id' => $accountId]);

    // Ensure it's always an array
    if (!$events) $events = [];

    // 4️⃣ Pass events to the view
    $data['events'] = $events;
    $this->view('student_profile', $data);
}


    
public function save_event()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $accountId = $_SESSION['user_id'] ?? null; 

        if (!$accountId) {
            $_SESSION['error'] = "User not identified.";
            redirect('StudentProfileController/index');
        }

        $eventModel = new Event();

        $data = [
            'account_id'        => $accountId,
            'event_date'        => $_POST['event_date'] ?? date('Y-m-d'),
            'event_title'       => $_POST['event_title'] ?? '',
            'event_time'        => $_POST['event_time'] ?? '',
            'event_description' => $_POST['event_description'] ?? '',
        ];

        if ($eventModel->validate($data)) {
            $eventModel->insert($data);
            $_SESSION['success'] = "Event saved successfully.";
        } else {
            $_SESSION['error'] = $eventModel->validation_errors;
        }

        redirect('StudentProfile/index');
    } else {
        redirect('StudentProfile/index');
    }
}

}
