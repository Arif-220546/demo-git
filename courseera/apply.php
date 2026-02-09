<?php
session_start();

if(isset($_POST['submit_application'])) {

    $name  = $_POST['FullName'];
    $email = $_POST['EmailAddress'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    // FILE UPLOAD
    if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){

        $folder = "uploads/";
        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $originalName = basename($_FILES['resume']['name']);
        $tmpName = $_FILES['resume']['tmp_name'];

        // Make filename safe + unique
        $safeName = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $originalName);

        if(move_uploaded_file($tmpName, $folder . $safeName)){

            echo "<h2>Application submitted ✅</h2>";
            echo "<p><b>Name:</b> $name</p>";
            echo "<p><b>Email:</b> $email</p>";
            echo "<p><b>Course:</b> $course</p>";

            echo "<p><b>Resume Uploaded:</b> $originalName</p>";

            echo "<a href='download.php?file=$safeName'>
                    <button style='padding:10px 20px; background:#1a73e8; color:white; border:none; border-radius:6px; cursor:pointer;'>
                        Download Resume
                    </button>
                  </a>";

            echo "<br><br><a href='index.php'>⬅ Back to Home</a>";

        } else {
            echo "Resume upload failed ❌";
        }

    } else {
        echo "Please upload a resume file ❌";
    }
}
?>
