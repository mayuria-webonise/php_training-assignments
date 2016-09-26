<?php
function connect()
{
    try {
        $databaseDriver = new PDO("mysql:host=localhost;dbname=upload_portal", "root", "mayuri123#");
    }catch (Exception $e){
        echo $e->getMessage();
        die();
    }
    return $databaseDriver;
}
function selectFromUsers($databaseDriver)
{
    $selectStatement = $databaseDriver->prepare("select idusers from users  where email = :email;");
    $selectStatement->bindParam(":email",$_POST['email']);
    $selectStatement->execute();
    $results = $selectStatement->fetch(PDO::FETCH_ASSOC);
    return $results;
}
function selectFromImages($databaseDriver,$targetFile)
{
    $selectStatement = $databaseDriver->prepare("select idimages from images  where image_path = :image_path;");
    $selectStatement->bindParam(":image_path",$targetFile);
    $selectStatement->execute();
    $results = $selectStatement->fetch(PDO::FETCH_ASSOC);
    echo $targetFile;
    return $results;
}
function updateUser($databaseDriver)
{
    $results=selectFromUsers($databaseDriver);
    //echo '<pre>', print_r($results);
    echo '<pre>', print_r($results[0]['idusers']);
    if(!empty($results))
    {
        echo "user exists";

    }
    else {
        $statementPrepared = $databaseDriver->prepare("INSERT INTO users (username, email) VALUES (:username,:email)");
        $statementPrepared->bindParam(":username", $_POST['name']);
        $statementPrepared->bindParam(":email", $_POST['email']);

        if ($statementPrepared->execute()) {
            echo "insert success";
            return true;
        } else {
            echo "fail";
            return false;
        }
    }

}
function updateFileTable($databaseDriver,$targetFile){

    $statementFile = $databaseDriver->prepare("INSERT INTO images (image_path) VALUES (:filepath)");
    $statementFile->bindParam(":filepath",$targetFile);
    if($statementFile->execute()){
        echo "insert file success";
        return true;
    }
    else{
        echo "fail";
        return false;
    }
}
function updateUploadInfoTable($databaseDriver,$targetFile)
{
    $uploadInfoStatement = $databaseDriver->prepare("INSERT INTO upload_info (usersid, imageid) VALUES (:usersid, :imageid)");
    $resultUsers = selectFromUsers($databaseDriver);
    $resultImages = selectFromImages($databaseDriver,$targetFile);
    $uploadInfoStatement->bindParam(":usersid",$resultUsers['idusers']);
    $uploadInfoStatement->bindParam(":imageid",$resultImages['idimages']);
    if($uploadInfoStatement->execute()){
        echo "insert uploadInfo success";
        return true;
    }
    else{
        echo "<br>fail<br>";
        echo $uploadInfoStatement->errorCode();
        return false;
    }

}
function imageUpload($image)
{
    $targetDir = __DIR__ . "/uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    echo basename($image["name"])."<br>";
    $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
    $check = getimagesize($image["tmp_name"]);
    if ($check == false)
    {
        echo "File is not an image.";
        die();
    }
    if((int)$check[0] > 400 && (int)$check[1] > 400)
    {
        echo "file height width must be less than 400x400 ";
        die();
    }
    if (file_exists($targetFile))
    {
        echo "Sorry, file already exists.";
        die();

    }
    if ($image["size"] > 5000000)
    {
        echo "Sorry, your file is too large.";
        die();

    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        die();

    }

    if (move_uploaded_file($image["tmp_name"], $targetFile))
    {
        echo "The file " . basename($image["name"]) . " has been uploaded.";
        return $targetFile;
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }

}
function excelUpload($excel)
{
    $targetDir = __DIR__ . "/uploads/";
    $targetFile = $targetDir . basename($excel["name"]);
    echo basename($excel["name"])."<br>";
    $FileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);

    if (file_exists($targetFile))
    {
        echo "Sorry, file already exists.";
        die();

    }
    if ($excel["size"] > 5000000)
    {
        echo "Sorry, your file is too large.";
        die();

    }
    if ($FileExtension != "xlsx" && $FileExtension != "xls" )
    {
        echo "Sorry, only xlsx, xls files are allowed.";
        die();

    }

    if (move_uploaded_file($excel["tmp_name"], $targetFile))
    {
        echo "The file " . basename($excel["name"]) . " has been uploaded.";
        return $targetFile;
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }

}
function csvUpload($csv)
{
    $targetDir = __DIR__ . "/uploads/";
    $targetFile = $targetDir . basename($csv["name"]);
    echo basename($csv["name"])."<br>".$targetFile;
    $FileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);

    if (file_exists($targetFile))
    {
        echo "Sorry, file already exists.";
        die();

    }
    if ($csv["size"] > 5000000)
    {
        echo "Sorry, your file is too large.";
        die();

    }
    if ($FileExtension != "csv")
    {
        echo "Sorry, only csv files are allowed.";
        die();

    }
    if (move_uploaded_file($csv["tmp_name"], $targetFile))
    {
        echo "The file " . basename($csv["name"]) . " has been uploaded.";
        return $targetFile;
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }

}

if(!empty($_POST))
{
    $databaseDriver=connect();
    updateUser($databaseDriver);

    if(isset($_FILES['image1']))
    {
        foreach($_FILES as $imageKey )
        {
            if(strpos($imageKey['type'],'image')!==false) {
                echo "is image<br>";
                $targetFile=imageUpload($imageKey);
                updateFileTable($databaseDriver,$targetFile);
                updateUploadInfoTable($databaseDriver,$targetFile);
            }
        }

    }

    if(isset($_FILES['excel']) && $_FILES['excel']['name']!='')
    {
        $targetFile = excelUpload($_FILES['excel']);
        updateFileTable($databaseDriver,$targetFile);
        updateUploadInfoTable($databaseDriver,$targetFile);
    }
    if(isset($_FILES['csv']) && $_FILES['csv']['name']!='')
    {
        $targetFile = csvUpload($_FILES['csv']);
        updateFileTable($databaseDriver,$targetFile);
        updateUploadInfoTable($databaseDriver,$targetFile);
    }
}
?>
