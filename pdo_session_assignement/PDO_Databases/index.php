<?php
abstract class Databases{
    abstract protected function connect();

    function selectQuery($query,$databaseDriver)
    {
        $statementPrepared=$databaseDriver->prepare($query);
        $statementPrepared->execute();
        $result = $statementPrepared->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
    function insertQuery($query,$databaseDriver)
    {
        $statementPrepared=$databaseDriver->prepare($query);
        if($statementPrepared->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}

class MysqlDatabase extends Databases{
    private $user;
    private $password;
    function __construct($user,$password){
        $this->user = $user;
        $this->password = $password;
    }
    function connect()
    {
        try {
            $databaseDriver = new PDO("mysql:host=localhost;dbname=e_commerce", $this->user, $this->password);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        return $databaseDriver;
    }
}

class PostgresqlDatabase extends Databases{
    private $user;
    private $password;
    function __construct($user,$password){
        $this->user = $user;
        $this->password = $password;
    }
    function connect()
    {
        try {
            $databaseDriver = new PDO("pgsql:dbname=first;host=localhost", $this->user, $this->password);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        return $databaseDriver;

    }
}

class SqliteDatabase extends Databases{
    private $user;
    private $password;
    function __construct($user,$password){
        $this->user = $user;
        $this->password = $password;
    }
    function connect()
    {
        try {
            $databaseDriver = new PDO("sqlite:".__DIR__."/sqliteDatabase.db", $this->user, $this->password);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        return $databaseDriver;

    }
}

if(isset($_POST['mysql']))
{
    $mysqlDatabase = new MysqlDatabase('root','mayuri123#');
    $databaseDriver = $mysqlDatabase->connect();
    if($databaseDriver){
        echo "connection Successful<br>";
    }else{
        echo "connection failed<br>";
    }
    $status = $mysqlDatabase->insertQuery("INSERT INTO users (idusers, user_name, email,password) VALUES (10,'Prajakta','prajkta@gmail.com','mayuri')",$databaseDriver);
    if($status){
        echo "insertion success<br>";
    }else{
        echo "insertion failed<br>";
    }
    $result = $mysqlDatabase->selectQuery("select * from users",$databaseDriver);
    echo '<pre>',print_r($result);
}
if(isset($_POST['postgresql']))
{
    $postgresqlDatabase = new PostgresqlDatabase('postgres','mayuri123#');
    $databaseDriver = $postgresqlDatabase->connect();
    if($databaseDriver){
        echo "connection Successful<br>";
    }else{
        echo "connection failed<br>";
    }
    $status = $postgresqlDatabase->insertQuery("INSERT INTO company (id, name,age,address,salary) VALUES (5,'Prajakta',22,'Pune',50000)",$databaseDriver);
    if($status){
        echo "insertion success<br>";
    }else{
        echo "insertion failed<br>";
    }
    $result = $postgresqlDatabase->selectQuery('select * from company',$databaseDriver);
    echo '<pre>',print_r($result);
}

if(isset($_POST['sqlite']))
{
    $sqliteDatabase = new SqliteDatabase('','');
    $databaseDriver = $sqliteDatabase->connect();
    if($databaseDriver){
        echo "connection Successful<br>";
    }else{
        echo "connection failed<br>";
    }
    $status = $sqliteDatabase->insertQuery("INSERT INTO users (id,user_name,age,address,salary)
    VALUES (1,'Prajakta',22,'Pune',50000);",$databaseDriver);
    if($status){
        echo "insertion success<br>";
    }else{
        echo "insertion failed<br>";
    }
    $result = $sqliteDatabase->selectQuery('select * from users;',$databaseDriver);
    echo '<pre>',print_r($result);
}
?>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
<form action="index.php" method="post">
    <input type="submit" name="mysql" value="mysql"><br/>
    <input type="submit" name="postgresql" value="postgresql"><br/>
    <input type="submit" name="sqlite" value="sqlite">
</form>
</body>
</html>