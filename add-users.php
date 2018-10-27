<?php
include "conn.php";
session_start();
$user = mysqli_query($conn,'SELECT * FROM users');

if(isset($_SESSION['mobile_error'])){
?>
<p style="color: red;"><?php echo $_SESSION['mobile_error']; ?></p>
<?php } 
session_unset();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add users</title>

<style>

table, th, td {
border: 1px solid black;
border-collapse: collapse;
}

a{
	text-decoration:none;
	float: right;
	color: black;
	font-size: 25px;
}
button{
	float: right;
}


</style>

</head>
<body>
	
		<button><a href="task.php">Add Task To User</a></button>

		<form action="add-users.php" method="POST">
		Name :<br/>  
		<input type="text" name="name" required><br/>
		Mobile :<br/>
		<input type="text" name="mobile" required><br/>
		Email :<br/>
		<input type="email" name="email" required>  <br/><br/>

		<input type="submit" name="submit"  value="Add User" />

			<?php
			if (isset($_REQUEST['submit'])) 
			{

				$name = trim($_REQUEST['name']); 
				

				$mobile = trim($_REQUEST['mobile']);
				
				$email = trim($_REQUEST['email']);
				// var_dump(strlen($mobile) != 10);
				// exit();
				if(strlen($mobile) != 10){
					$_SESSION["mobile_error"] = "please insert 10 digit mobile number";
					header('Location: '.$_SERVER['PHP_SELF']);
					exit();
				}

				$mob = mysqli_query($conn, 'SELECT * FROM users where mobile = '.$mobile.'');

				if($mob->num_rows > 0){
					$_SESSION["mobile_error"] = "mobile number already exist";
					header('Location: '.$_SERVER['PHP_SELF']);
					exit();
				}

				
				$query = "insert into users (name,mobile,email) values ('$name','$mobile','$email')";


				$result = mysqli_query($conn,$query);
				$n = mysqli_affected_rows($conn);
				if($n){
					header('Location: '.$_SERVER['PHP_SELF']);
				}else{
					echo "<script>alert('something went wrong')</script>";
				}
			}
			?>

		<div style="padding-top: 150px; width:50%;">
			<h1 style="text-align: center;">User Details</h1>
			<table style="width:100%; border: 1px solid black;">
				<thead  >
				
					<tr style="border: 1px solid black; border-collapse: collapse;">
						<th>User Name</th>
						<th>Mobile</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody style="text-align:center;">
					<?php
					if($user->num_rows > 0){
						while($users = $user->fetch_assoc()){
					?>

					<tr>
						<td><?php echo $users['name']; ?></td>
						<td><?php echo $users['mobile']; ?></td>
						<td><?php echo $users['email']; ?></td>
					</tr>

					<?php
						}
					}else{
					?>
					<p style="color: red;">No Users found!!</p>

				<?php } ?>
				</tbody>
			</table>

		</div>
		<br>


	</body>
</html>