<?php
session_start();
include 'conn.php';
$user = "select * from users";
$result = mysqli_query($conn,$user);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Task to user</title>
</head>
<body>
<form action="task.php" method="POST">

Task Name  <input type="text" name="task" required>
<br>
<br>
User
  <select name="username" >
	<?php
if($result->num_rows > 0)
{
	while ($row = $result->fetch_assoc()) 
	{
		?>
		<option value="<?php echo $row['id']; ?>">
		<?php echo $row['name']; ?>
		</option>

	<?php
	}
}
?>

</select>
<br><br>
<input type="radio" name="status" value="Pending" checked=""> Pending
<input type="radio" name="status" value="Completed"> Completed
<br><br>
<input type="submit" name="submit">

</form>

<?php

if (isset($_REQUEST['submit'])) 
{
	$task = trim($_REQUEST['task']);
	$status = $_REQUEST['status'];
	$userid = $_REQUEST['username'];
	
	$query = mysqli_query($conn,"insert into tasks(tname,ttype,userid) values ('$task','$status','$userid')");
	$result = mysqli_query($conn,$query);
	$n = mysqli_affected_rows($conn);
	if($n){
			header('Location: '.$_SERVER['PHP_SELF']);
			}
			else
			{
			echo "<script>alert('something went wrong')</script>";
			}
		}
?>
<div style="padding-top: 150px; width:50%;">
<h1 style="text-align: center;">Inserted Records</h1>
<form action="export.php" method="POST">
<input type="submit" name="export" value="CSV export">
</form>
			<table style="width:100%; border: 1px solid black;">
				<thead  >
				
					<tr style="border: 1px solid black; border-collapse: collapse;">
						<th>Id</th>
						<th>Name</th>
						<th>Task name</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody style="text-align:center;">
					<?php
					$task = "SELECT users.name, tasks.tname, tasks.ttype,tasks.id
							FROM users
							INNER JOIN tasks ON users.id = tasks.userid ORDER BY id ASC";
					$data = mysqli_query($conn,$task);


					if($data->num_rows > 0){
						while($rows = $data->fetch_assoc()){
					?>

					<tr>
						<td><?php echo $rows['id']?></td>
						<td><?php echo $rows['name']?></td>
						<td><?php echo $rows['tname'];?></td>
						<td><?php echo $rows['ttype'];?></td>
					</tr>

					<?php
						}
					}else{
					?>
					<p style="color: red;">No Users found!!</p>

				<?php } ?>

<br>
</body>
</html>