<?php

include "conn.php";

if (isset($_POST['export'])) 
{
	 header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Id','Name','Task name','status'));
    $query = "SELECT tasks.id, users.name, tasks.tname, tasks.ttype
		FROM users
		INNER JOIN tasks ON users.id = tasks.userid ORDER BY id ASC";
		$result = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			fputcsv($output, $row);
		}
		fclose($output);
}



?>