<?php
//including the database connection file
include_once("config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users daily BY id DESC"); // mysql_query is deprecated
$result = mysqli_query($mysqli, "SELECT * FROM notices "); // using mysqli_query instead
?>

<?php 
	session_start(); //starting the session, to use and store data in session variable

	//if the session variable is empty, this means the user is yet to login
	//user will be sent to 'login.php' page to allow the user to login
	if (!isset($_SESSION['usernames'])) {
		$_SESSION['msg'] = "You have to log in first";
		header('location: login.php');
	}

	// logout button will destroy the session, and will unset the session variables
	//user will be headed to 'login.php' after loggin out
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['usernames']);
		header("location: login.php");
	}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<style>
html, body{
	background-color:rgba(170,170,170);
	height: 10%;
}
body {
 overflow-x: hidden; /* Hide horizontal scrollbar */
}
 .navbar{
	 background-color:#FFC72C;
 }
 
 #red{
	 color:#282828;
 }
 .mainpoint{
	 color:#002D72;
 }
 .button {
  background-color: #002D72;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> <!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Bootstrap JS-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Font Awesome Stylesheet-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> <!-- Bootstrap JS-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> <!-- Bootstrap JS-->
<link href="../assets/style.css" rel="stylesheet" type="text/css"> <!-- Link to CSS Stylesheet -->
<title> Daily Notices </title> <!--tab Title -->
<link rel="icon" href="https://sec.act.edu.au/wp-content/uploads/2017/10/Crest.png"> <!--This is the tab logo -->
 <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="../adminindex.php">
          <img src="https://sec.act.edu.au/wp-content/uploads/2017/10/St-Edmunds-College-Website-Logo.png" alt="">
      </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">  <!--Bootstrap code for making the navbar responsive. -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">  <!--This highlights the link and it pretty much shows the user what page they are -->
          <a id="red" class="nav-link" href="../adminindex.php" style="font-size:20px">Home
                <span class="sr-only" >(current)</span>
              </a>
        </li>	  
		<li  class="nav-item dropdown"> 
			<a class="nav-link dropdown-toggle" id="red" href="#" id="navbarDropdown" style="font-size:20px" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Users		</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a  id="red"style="font-size:20px" class="dropdown-item" href="../admincrud/userlist.php">View Admins</a>
				<a  id="red"style="font-size:20px" class="dropdown-item" href="../adminregister.php">Create admin user</a>
			</div>
      </li> 
        <li class="nav-item">
          <a  id="red" class="nav-link" href="#"  style="font-size:20px">Daily Notices</a>
        </li>
		<li id="red" class="nav-item dropdown">  <?php  if (isset($_SESSION['usernames'])) : ?>
			<a  id="red"class="nav-link dropdown-toggle" href="#" id="navbarDropdown" style="font-size:20px" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?php echo $_SESSION['firstname']; ?> <?php endif ?>			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a id="red" style="font-size:20px" class="dropdown-item" href="../adminindex.php?logout='1'">Logout</a>
			</div>
      </li>

      </ul>
    </div>
  </div>
</nav>
</head>
<body>
<br> <br> <br> <br> <br><br> <br><br> <br> 
<center> <h1 class="mainpoint"> Daily Notices @ Eddies </h1> </center>
						<input type="text" id="search" placeholder="Type to search"> <!--This is the search menu. This search menu was sourced from: http://jsfiddle.net/7BUmG/2/ -->

	<table class='table table-bordered table-striped'id='example'>

	<tr bgcolor='#CCCCCC'>
		<td>ID</td>
		<td>Topic</td>
		<td>Info</td>
		<td>Tools</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['id']."</td>";
		echo "<td>".$res['topic1']."</td>";
		echo "<td>".$res['subinfo1']."</td>";	
		echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | </td>";		
	}
	?>
	</table>
</body>
	<script>
var $rows = $('#example tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>
</html>
