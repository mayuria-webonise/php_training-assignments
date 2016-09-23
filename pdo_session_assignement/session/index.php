<?php
session_start();
echo session_id();
function authenticateUser($email,$password){
    $hostname='localhost';
    $databaseUsername='root';
    $databasePassword='mayuri123#';
    $dbh = new PDO("mysql:host=$hostname;dbname=e_commerce",$databaseUsername,$databasePassword);
    $statementPrepared=$dbh->prepare("select * from users where email = :email and password = :password");
    $statementPrepared->bindParam(':email',$email);
    $statementPrepared->bindParam(':password',$password);
    $statementPrepared->execute();
    $result = $statementPrepared->fetchAll(PDO::FETCH_ASSOC);
    if(empty($result))
    {
        return false;
    }
    else {
        foreach ($result as $row) {
            $_SESSION['user_id'] = $row['idusers'];
            $_SESSION['user_name'] = $row['user_name'];
        }
    }
    return true;
}
if(isset($_POST['email']) && isset($_POST['password']))
{
    $statusUser=authenticateUser($_POST['email'],$_POST['password']);
    if(!$statusUser)
    {
        echo "make sure your email or password is correct";
    }
    elseif(isset($_SESSION['user_id'])){
        header("Location:user_dashboard.php");
    }
    else{
        echo "problem in starting session";
    }
}
?>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
<form action="index.php" method="post">
    Enter EmailId:   <input type="text" name="email" value="email"><br/>
    Enter Password:  <input type="password" name="password" value="password"><br/>
    <input type="submit" name="login" value="login">
</form>
</body>
</html>
