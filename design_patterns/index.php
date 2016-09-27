<?php
require('Database.php');
session_start();

if(isset($_POST['email']) && isset($_POST['password']))
{
    $database = Database::connect();
    $statusUser = $database->authenticateUser($_POST['email'],$_POST['password']);
    if(!$statusUser)
    {
        echo "make sure your email or password is correct";
    }
    elseif(isset($_SESSION['user_id']))
    {
        if(!strcmp(strtolower($_SESSION['role']),strtolower('admin')))
        {
            header("Location:dashboard.php");
        }
        else
        {
            header("Location:userDashboard.php");
        }
    }
    else{
        echo "problem in starting session";
    }
}
?>
<html>
<head>
    <title>Login Page</title>
    <script>
        function validateEmail(){
            var emailField = document.getElementById('email');
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (reg.test(emailField.value) == false)
            {
                alert('Invalid Email Address');
                return false;
            }
            return true;

        }
    </script>
</head>
<body>
<form action="index.php" method="post" onsubmit="return validateEmail();">
    Enter EmailId:   <input type="text" name="email" value="email" id = "email"><br/>
    Enter Password:  <input type="password" name="password" value="password"><br/>
    <input type="submit" name="login" value="login">
</form>
</body>
</html>
