<?php


class TeacherVle extends Controller
{
    public function index()
    {

        $this->view('vle_teacher');
    } public function uploadDocument()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $classContentModel = new ClassContent();

        // Handle file upload
        $uploadFiles = handleFileUploads('docUpload', 'class_content');


        // Combine multiple file paths into one string
        $filePaths = !empty($uploadFiles) ? implode(',', $uploadFiles) : '';

        // Prepare data for database
        $data = [
            'title' => $_POST['docName'] ?? '',
            'description' => $_POST['docDescription'] ?? '',
            'class_id' => 1, // dynamic class id if needed
            'content_type' => $_POST['linkType'] ?? 'note',
            'content_path' => $filePaths
        ];

        $classContentModel->insert($data);
        redirect('TeacherVle');
    }
        
    
    }

}