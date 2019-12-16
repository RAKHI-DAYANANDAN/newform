<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "username"=> $_POST['username'],
      "name"=> $_POST['name'],
      "email"=> $_POST['email'],
      "password"=> $_POST['password'],
      "mobileno"=> $_POST['mobileno']
    );

	 
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users1",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
   
	
	
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['username']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>

  <form method="post" name="form" onsubmit="return validate()">
  <script>
  function validate()
{
	var uname=document.forms["form"]["username"].value;
	if(uname=="")
	{
		alert("enter your username");
		document.forms["form"]["username"].focus();
		return false;
		
	}
	var name=document.forms["form"]["name"].value;
	if(name=="")
	{
		alert("enter your name");
		document.forms["form"]["name"].focus();
		return false;
		
	}
	var email=document.forms["form"]["email"].value;
	var atposition=email.indexOf("@");
	var dotposition=email.indexOf(".");
	if(atposition<1 ||dotposition<atposition+2||dotposition+2>=email.length)
	{
		alert("enter valid email");
		document.forms["form"]["email"].focus();
		return false;
	}
	
	var password=document.form["form"]["password"].value;
	if(password=="")
	{
		alert("enter your password");
		document.forms["form"]["password"].focus();
		return false;
		
	}
	var mbno=document.form["form"]["mobileno"].value;
	if(mbno=="")
	{
		alert("enter your mobileno");
		document.forms["form"]["mobileno"].focus();
		return false;
		
	}
}
	</script>
  
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="name"> Name</label>
    <input type="text" name="name" id="name">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="password">Password</label>
    <input type="text" name="password" id="password">
	<label for="mobileno">Mobile no</label>
    <input type="text" name="mobileno" id="mobileno">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
