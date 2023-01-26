<html>
<head>
	<title>Cara Membuat Form Login Sederhana Tapi Berkelas</title>
    <link rel="stylesheet" href="../css/login.css">
</head><
<body>
<div class="login" action>
    <h2 class="login-header"><img src="../img/logo.png"></h2>
        <form class="login-container" method="POST" action="">
            <p>
                <input type="email" placeholder="email" name="email">
            </p>
            <p>
                <input type="password" placeholder="password" name="pass">
            </p>
            <p>
                <input type="submit" value="Log in" name="submit">
            </p>
            <p>
                <center><a href="../index.php">back</a></center>
            </p>
        </form>
</div>
</body>
</html>

<?php
session_start();
error_reporting(0);
        $user = array(
                        "email" => "admin@admin.com",
                        "pass" => "admin"            
                );
if (isset($_POST['submit'])) {
    if ($_POST['email'] == $user['email'] && $_POST['pass'] == $user['pass']){
        $_SESSION["email"] = $_POST['email']; 
        echo '<script>window.location="dashboard.php"</script>';
    } else {
        display_login_form();
        echo '<p>email Atau Password Tidak Benar</p>';
    }
}    
else { 
    display_login_form();
}