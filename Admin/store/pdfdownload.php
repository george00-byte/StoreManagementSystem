<?php

include("../../path.php");

if (isset($_GET['document'])) {
    // Get the filename from the query parameter and sanitize it to prevent directory traversal attacks
    $filename = basename($_GET['document']);
    // Define the file path where the files are stored (assets/files/ in this case)
    $file_path = ROOT_PATH.'/assets/files/' . $filename;

    if (file_exists($file_path)) {
        // Get the file extension by using pathinfo (you can also use finfo or other methods)
        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Define an array of allowed file types and their corresponding MIME types
        $allowed_file_types = array(
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'txt' => 'text/plain',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Word (docx)
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Excel (xlsx)
            // Add more file types here as needed
        );


        // Check if the file extension is allowed
        if (isset($allowed_file_types[$file_extension])) {
            // Set appropriate headers for displaying the file in the browser
            header("Content-type: " . $allowed_file_types[$file_extension]);

            // Output the file data to the user
            readfile($file_path);
            exit(); // Terminate the script to prevent any other output
        } else {
            die("File type not supported.");
        }
    } else {
        die("File not found.");
    }
} else {
    die("Invalid file name.");
}
?>
