 <?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
require "../config.php";
require "../common.php";

if (isset($_POST['login'])) {

  
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
		$sql = "SELECT * 
            FROM users1
            WHERE username=:username && password=:password";

		
    $username = $_POST['username'];
	$password = $_POST['password'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->bindParam(':password', $password, PDO::PARAM_STR);
	
    $statement->execute();
	

	
		if($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$usernameExists=1;
     }
	 else
		 {
           $usernameExists=0;
       }
	
	if($usernameExists)
	{
		echo "login sucessfully";
		
	}
	else{
		echo "unsucessful";
	}
  }
	   catch(PDOException $error)
	   {
      echo $sql . "<br>" . $error->getMessage();
  }

	}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['login']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['username']); ?> successfully submitted.</blockquote>
  <?php endif; ?>

  <h2>Login</h2>
  

    <form method="post">
    <label for="username">Email or Username</label>
    <input type="text" name="username" id="username">
    <label for="password">Password</label>
    <input type="text" name="password" id="password"><br><br>
	<input type="submit" name="login" value="login">
	<input type="submit" name="Reset" value="Reset">
	</form>
	
<?php require "templates/footer.php"; ?>
	 
	