<?php 
	require "config/database.php";

	$db = new Database();
	$con = $db->connect();

	$table = "events";

	$title = $_POST['Title'];
	$date_from = $_POST['FromDate'];


	$query = 'INSERT INTO '.$table.' (title, description, date_from, date_to, time_from, time_to, venue, address) VALUES("'.$title.'" , "'.$_POST['Description'].'" ,"'.$date_from.'" , "'.$_POST['ToDate'].'" ,"'.$_POST['FromTime'].'" , "'.$_POST['ToTime'].'" ,"'.$_POST['Venue'].'" , "'.$_POST['Address'].'")';


	if($con->query($query)){

		$q = "SELECT * FROM events WHERE title='$title'";
		$r = $con->query($q);
		$row = $r->fetch_assoc();

		$info = pathinfo($_FILES['pic']['name']);
		$ext = $info['extension']; // get the extension of the file
		$newname = $row['event_id'].".".$ext; 

		$target = 'event_img/'.$newname;
		move_uploaded_file( $_FILES['pic']['tmp_name'], $target);


		echo "<h2>Event Added Successfully</h2>";

		echo "<a href = 'event_list.php'> Event List </a>";
	}
	else{
		echo "Database Error".$con->error;
	}

	$con->close();


?>