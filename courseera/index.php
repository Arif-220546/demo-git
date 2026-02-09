<?php
session_start();
$conn = new mysqli("localhost", "root", "", "courseera");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$register_msg = "";
if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, email, phone, password, course)
            VALUES ('$fullname', '$email', '$phone', '$password', '$course')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_name'] = $fullname;
        header("Location: index.php");
        exit();
    } else {
        $register_msg = "Error: " . $conn->error;
    }
}
$login_msg = "";
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['fullname'];
            header("Location: index.php");
            exit();
        } else { $login_msg = "Incorrect password!"; }
    } else { $login_msg = "User not found!"; }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Era</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: 'Inter', sans-serif; margin:0; padding:0; }
        .navbar { display:flex; justify-content:space-between; align-items:center; padding:15px 50px; background:black; color:#1a7ee833; }
        .navbar a { color:#fff; text-decoration:none; margin-left:20px; font-weight:600; }
        .btn { background:#1a73e8; color:#fff; padding:10px 25px; border:none; cursor:pointer; border-radius:5px; font-weight:600; transition:0.3s; }
        .btn:hover { background:#1558b0; }
        .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.6); justify-content:center; align-items:center; z-index:100; }
        .modal-content { background:#fff; padding:30px; border-radius:8px; width:400px; max-width:90%; position:relative; }
        .close { position:absolute; top:10px; right:15px; font-size:24px; cursor:pointer; }
        input[type=text], input[type=email], input[type=tel], input[type=password], select {
            width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; font-size:16px;
        }
        .message { color:red; text-align:center; margin-bottom:10px; }
    </style>
</head>
<body>
<div class="navbar">
    <img id="logo" alt="Jovian Logo" src="img.jpg" height="30" />
    <div>
        <?php if(isset($_SESSION['user_name'])): ?>
            Welcome, <?php echo $_SESSION['user_name']; ?> | <a href="logout.php" style="color:#fff;">Logout</a>
        <?php else: ?>
            <a href="#" onclick="openModal('loginModal')">Login</a>
            <a href="#" onclick="openModal('registerModal')">Register</a>
        <?php endif; ?>
    </div>
</div>
<img id="banner" src="img.jpg" alt="Banner" height="240">
<h1>About Our Courses</h1>
<div id="about">
    <div id="description">
        <p style="margin-top: 0;">
            Course Era offers comprehensive online courses in web development and data science. Our courses are designed to equip you with the skills needed to excel in today's tech-driven world.
        </p>
        <p>We also offer industry-focused bootcamps:
        <ol>
            <li><a>Full Stack Developer Bootcamp</a></li>
            <li><a>Data Science Bootcamp</a></li>
            <li><a>Frontend Developer Bootcamp</a></li>
            <li><a>ML Bootcamp</a></li>
        </ol>
        </p>
    </div>
    <div id="team">
        <img id="img2image" alt="Team" src="img2.jpg" height="300">
    </div>
</div>
<h2>Courses Offered</h2>
<div id="jobs">
    <table id="jobs-table">
        <tr class="jobs-header-row">
            <th>Course Title</th>
            <th>Mode of Teaching</th>
            <th>Course Fee</th>
            <th>Course Duration</th>
            <th>Certification</th>
        </tr>
        <tr class="jobs-data-row">
            <td>Frontend Developer</td>
            <td>Online</td>
            <td>₹12,000</td>
            <td>60 days</td>
            <td>Yes</td>
        </tr>
        <tr class="jobs-data-row">
            <td>Full Stack Developer</td>
            <td>Online</td>
            <td>₹15,000</td>
            <td>3 months</td>
            <td>Yes</td>
        </tr>
        <tr class="jobs-data-row">
            <td>Data Scientist</td>
            <td>Online</td>
            <td>₹17,000</td>
            <td>6 months</td>
            <td>Yes</td>
        </tr>
        <tr class="jobs-data-row">
            <td>ML Engineer</td>
            <td>Online</td>
            <td>₹28,000</td>
            <td>6 months</td>
            <td>Yes</td>
        </tr>
    </table>
</div>
<div id="application">
    <h2>Submit Your Application</h2>
   <form id="application-form" action="apply.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="FullName" placeholder="Full Name" required><br><br>
        <label>E-Mail:</label>
        <input type="email" name="EmailAddress" placeholder="abc123@gmail.com" required><br><br>
        <label>Phone:</label>
        <input type="tel" name="phone" placeholder="+91 1234567891" required><br><br>
        <label>Course:</label>
        <select name="course" required>
        <option value="">Select Course</option>
        <option value="Frontend Developer">Frontend Developer</option>
        <option value="Full Stack Developer">Full Stack Developer</option>
        <option value="Data Scientist">Data Scientist</option>
        <option value="ML Engineer">ML Engineer</option>
        </select><br><br>
        
        <label>Upload proof of payment:</label><br><br>
        <input type="file" id="resume" name="resume" required><br><br>

        <input type="submit" name="submit_application" class="btn" value="Submit Application">

    </form>
</div>
<div id="footer">
    <ul id="footer-links">
        <li><a>Courses</a></li>
        <li><a>Programs</a></li>
        <li><a href="https://www.youtube.com/">YouTube</a></li>
    </ul>
    <span class="copyright">© 2025, Course Era </span>
</div>
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('loginModal')">&times;</span>
        <h2>Login</h2>
        <?php if($login_msg != "") echo "<p class='message'>$login_msg</p>"; ?>
        <form method="POST">
            <input type="email" name="login_email" placeholder="Email" required>
            <input type="password" name="login_password" placeholder="Password" required>
            <input type="submit" name="login" class="btn" value="Login">
        </form>
    </div>
</div>
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('registerModal')">&times;</span>
        <h2>Register</h2>
        <?php if($register_msg != "") echo "<p class='message'>$register_msg</p>"; ?>
        <form method="POST">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone" required>
            <select name="course" required>
                <option value="">Select Course</option>
                <option value="Frontend Developer">Frontend Developer</option>
                <option value="Full Stack Developer">Full Stack Developer</option>
                <option value="Data Scientist">Data Scientist</option>
                <option value="ML Engineer">ML Engineer</option>
            </select>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="register" class="btn" value="Register">
        </form>
    </div>
</div>
<script>
function openModal(id){ document.getElementById(id).style.display='flex'; }
function closeModal(id){ document.getElementById(id).style.display='none'; }
window.onclick = function(event){ if(event.target.classList.contains('modal')) { event.target.style.display='none'; } }
</script>
</body>
</html>
