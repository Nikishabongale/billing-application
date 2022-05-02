<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$dbPassword='';
		$user_name = $_POST["uname"];
		$password = $_POST["pswd"];
		$user_id='';
		//echo $user_name.' '.$password;
		$encrypted_pass = password_hash($password,PASSWORD_DEFAULT);
		$success = 0;
		$userNameLower = strtolower($user_name);
		$sql = "SELECT password,user_id FROM user where lower(user_name)="."'".$userNameLower."'";
		//echo $sql;
		$result = mysqli_query($conn, $sql);
		if (! empty($result)) 
		{
			$success = 1;
			while($row = $result->fetch_assoc()) 
			{
			  $dbPassword =  $row["password"];
			  $user_id = $row["user_id"];
			}
		}
		//echo $dbPassword.'<br>';
		if($success==1)
		{
			$verify = password_verify($password, $dbPassword);
			if ($verify) 
			{
				session_start();
				$_SESSION["user_id"] = $user_id;
				header('Location: /BillingApplication/navMenu/home/homePage.php');
				exit;
			}
			else 
			{
				header('Location: /BillingApplication/index.php?error=No user found with given username and password!');
				exit;
			}
		}
		else
		{
			
		}
		
	}
	mysqli_close($conn);
?>
