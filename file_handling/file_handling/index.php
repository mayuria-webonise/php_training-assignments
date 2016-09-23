<?php
function listOfBooks($bookName)
{
    $listFile =__DIR__."/list.txt";
    if(file_exists($listFile)){
        $listFileHandle=fopen($listFile,'a');
    }
    else{
        $listFileHandle=fopen($listFile,'w');
    }
    fwrite($listFileHandle,$bookName."<br>");
    fclose($listFileHandle);
}
function showListofBooks(){
    $listFile =__DIR__."/list.txt";
    if(!file_exists($listFile)){
        throw new Exception("no books");
    }
    else{
        $listFileHandle=fopen($listFile,'r');
        while(!feof($listFileHandle)){
            echo fgets($listFileHandle);
        }
    }
    fclose($listFileHandle);
}
function createBook()
{
    $filename =__DIR__.'/'.$_POST['book_name'].".txt";
    if(file_exists($filename)){
        throw new Exception("file already exists try new file name");
    }
    else {
        $newBook = fopen($filename, 'w');
    }
    fwrite($newBook,$_POST['author_name']."<br>");
    fwrite($newBook,$_POST['book_name']."<br>");
    fwrite($newBook,$_POST['content']."<br>");
    listOfBooks($_POST['book_name']);
    fclose($newBook);
}
function readBook()
{
    $fileName =__DIR__.'/'.$_POST['book_name'].".txt";
    if(!file_exists($fileName))
    {
        throw new Exception("file not found");
    }
    else{
        $bookToRead = fopen($fileName, 'r');
    }

    while(!feof($bookToRead)){
        echo fgets($bookToRead);
    }
    fclose($bookToRead);
}
function editBook()
{
    $fileName =__DIR__.'/'.$_POST['book_name'].".txt";
    if(!file_exists($fileName))
    {
        throw new Exception("file not found");
    }
    else{
        $BookToEdit = fopen($fileName, 'a');
    }
    fwrite($BookToEdit,$_POST['content']."<br>");
    fclose($BookToEdit);

}
function mandetaryFieldsErrorHandler($errorNo,$errorString){
    echo "<b>Error:</b> [$errorNo] $errorString<br>";
    echo "Ending Script";
    die();
}
set_error_handler("mandetaryFieldsErrorHandler",E_USER_NOTICE);

if(isset($_POST['create']))
{
    if(!strcmp($_POST['book_name'],""))
    {
        trigger_error('book name is mandetory field');
    }
    try {
        createBook();
    }catch (Exception $e){
        echo $e->getMessage();
    }
}
if(isset($_POST['read']))
{
    if(!strcmp($_POST['book_name'],""))
    {
        trigger_error('book name is mandetory field');
    }
    try {
        readBook();
    }catch (Exception $e){
        echo $e->getMessage();
    }
}
if(isset($_POST['append']))
{

    if(!strcmp($_POST['book_name'],""))
    {
        trigger_error('book name is mandetory field');
    }
    try {
        editBook();
    }catch (Exception $e){
        echo $e->getMessage();
    }
}
if(isset($_POST['list_of_books']))
{
    try{
        showListofBooks();
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

?>
<html>
<form action="index.php" method="post" id="usrform">
   Author Name: <input type="text" name="author_name"><br>
    Book Name: <input type="text" name="book_name"><br>
    <input type="submit" name="create" value="create"><br>
    <input type="submit" name="read" value ="read"><br>
    <input type="submit" name="append" value ="append"><br>
    <input type="submit" name="list_of_books" value ="list of books"><br>
</form>

<textarea name="content" form="usrform">Enter text here...</textarea>
</html>