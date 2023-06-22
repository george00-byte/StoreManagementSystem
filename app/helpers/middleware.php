<?php 

function usersOnly($redirect= "/login.php")
{
	if(empty($_SESSION['id']))
	{
		$_SESSION['message']="You need to login first";
		$_SESSION['type']="error";

		header('location: '.BASE_URL.$redirect);
		exit(0);
	}
}


function adminOnly($redirect= "/login.php")
{
	if(empty($_SESSION['id']) || empty($_SESSION['admin']))
	{
		$_SESSION['message']="You are not authorised";
		$_SESSION['type']="error";

		header('location: '.BASE_URL.$redirect);
		exit(0);
	}
}



function guestOnly($redirect= "/index.php")
{
	if(isset($_SESSION['id']))
	{
		header('location: '.BASE_URL.$redirect);
		exit(0);
	}
}





function storeOnly($redirect= "/index.php")
{
	if($_SESSION['admin']!== 1)
	{
		$_SESSION['message']="You are not authorised";
		$_SESSION['type']="error";

		header('location: '.BASE_URL.$redirect);
		exit(0);
	}
}


function managerOnly($redirect= "/index.php")
{
	if($_SESSION['admin']!== 2)
	{
		$_SESSION['message']="You are not authorised";
		$_SESSION['type']="error";

		header('location: '.BASE_URL.$redirect);
		exit(0);
	}
}



?>