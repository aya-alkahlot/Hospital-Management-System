<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $usernumber = $_POST['usernumber'] ?? null;
    $age = $_POST['age'] ?? null;
    $hospitalData = $_POST['hospitalData'] ?? null;

    $files_dir = "uploads/files/";
    $videos_dir = "uploads/videos/";

    if (!is_dir($files_dir)) mkdir($files_dir, 0777, true);
    if (!is_dir($videos_dir)) mkdir($videos_dir, 0777, true);

    echo "<h3>Data Received:</h3>";
    echo "User Name: $username<br>";
    echo "User Number: $usernumber<br>";
    echo "Age: $age<br>";
    echo "Hospital Data: $hospitalData<br><hr>";

    if (isset($_FILES['files'])) {
        echo "<h3>Uploaded files:</h3>";
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['files']['name'][$key]);
            $file_path = $files_dir . time() . "_" . $file_name;

            if (move_uploaded_file($tmp_name, $file_path)) {
                echo "<a href='$file_path' target='_blank'>📄 $file_name</a><br>";
            } else {
                echo "Failed to upload file: $file_name<br>";
            }
        }
    }

    if (isset($_FILES['videos'])) {
        echo "<h3>Uploaded Videos:</h3>";
        foreach ($_FILES['videos']['tmp_name'] as $key => $tmp_name) {
            $video_name = basename($_FILES['videos']['name'][$key]);
            $video_path = $videos_dir . time() . "_" . $video_name;

            if (move_uploaded_file($tmp_name, $video_path)) {
                echo "<video controls width='400' style='display:block; margin-bottom: 10px;'>
                        <source src='$video_path' type='video/mp4'>
                        Your browser does not support video playback.
                      </video>";
            } else {
                echo "Failed to upload video: $video_name<br>";
            }
        }
    }
    echo "<hr><a href='indexbac.html'>Return to home page</a>";
} else
    echo "Data must be submitted via a form.";
