<?php 
session_start();
class hangman
{
	private $word;
	
	function __construct($word)
	{
		$this->word=$word;
	}
	function display_word()
	{
		$_SESSION['puzzle']=$this->word;
		foreach ($_SESSION['blank_spaces'] as $key => $value) 
		{
			$_SESSION['puzzle']=substr_replace($_SESSION['puzzle'],'_',$_SESSION['blank_spaces'][$key],1);
		}
		return $_SESSION['puzzle']."<br/>";

	}
    function winCondition(){
        if(empty($_SESSION['blank_spaces']))
        {
            return true;
        }
    }
    function checkRightGuess()
    {
        $guess=$_POST['letter'];
        foreach ($_SESSION['blank_spaces'] as $key => $value) {
            if($this->word[$_SESSION['blank_spaces'][$key]]==$guess)
            {
                unset($_SESSION['blank_spaces'][$key]);
                $_SESSION['chances']=$_SESSION['chances']+1;
                return true;
            }

        }
    }
	function guess()
    {
		$_SESSION['chances']=$_SESSION['chances']-1;
        if($this->checkRightGuess()){
            echo "right guess<br/>";
        }
        if($this->winCondition())
        {
            echo "you won<br/>";
            die();
        }
        echo "chances ".$_SESSION['chances']."<br/>";
        echo $this->display_word();
		return 0;
	}

}

$game=new hangman("welcome");

if(!isset($_SESSION['blank_spaces']))
{
	$_SESSION['blank_spaces']= array(1,3,4);
}
if(!isset($_SESSION['chances']))
{
	$_SESSION['chances']=5;
}

if(isset($_POST['submit']))
{
	if($_SESSION['chances']<=0)
	{
		echo "no trials";
		session_unset(); 
		session_destroy(); 
	}
	else
		$game->guess();
}
if(isset($_POST['restart']))
{
    echo "restarting game<br>";
	session_unset();
	session_destroy();
    $_SESSION['blank_spaces']= array(1,3,4);
    echo $game->display_word();
}
		
?>
<html>
	<body>
		<form action="index.php" method="post">
	Guess the letter: <input type="text" name="letter"><br/><br/>
		<input type="submit" value="submit" name="submit">
		<input type="submit" value="restart_game" name="restart">
		</form>
	</body>
</html>