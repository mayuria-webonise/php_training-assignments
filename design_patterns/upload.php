<?php
class UploadProductImages
{
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

}


?>
