<?php
function curlPost()
{
    echo "hello";
    echo "<pre>" , print_r($_POST);
    echo "<pre>" , print_r($_FILES);
    $data = array(
        'name' => $_POST['name'],
        'email' => $_POST['email'],
    );
    echo array_keys($_FILES);
    foreach(array_keys($_FILES) as $imageKey )
    {
        $data [$imageKey] = new CURLFile($_FILES[$imageKey]['tmp_name'],$_FILES[$imageKey]['type'],$_FILES[$imageKey]['name']);
    }
    $curl_connection = curl_init();
    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_POST, true);
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl_connection, CURLOPT_URL, "http://local.curlDemo.com/upload.php");
    curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($curl_connection);
    echo "<pre>" ,print_r($result);
    print_r(curl_getinfo($curl_connection));
    echo curl_errno($curl_connection);
    curl_error($curl_connection);
    curl_close($curl_connection);


}
curlPost();
?>