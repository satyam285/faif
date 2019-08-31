<?php
	require "config/database.php";
	$db = new Database();
	$con = $db->connect();

	$table = "registrations";

	$query = 'INSERT INTO '.$table.' (event_id, name, email, contact, designation, organisation, address, confirmation , participation) VALUES("'.$_POST['event_id'].'" , "'.$_POST['Name'].'" ,"'.$_POST['Email'].'" , "'.$_POST['Contact'].'" ,"'.$_POST['Designation'].'" , "'.$_POST['Organisation'].'" , "'.$_POST['Address'].'" , "'.$_POST['Confirmation'].'" , "'.$_POST['Participation'].'")';


	$con->query($query);

	$res = $con->query('SELECT * FROM '.$table.' ORDER BY reg_id DESC LIMIT 1');

	$row = $res->fetch_assoc();

	$reg_id = $row['reg_id'];
	$name = $row['name'];
	$email = $row['email'];
	$event_id = $row['event_id'];

	echo "Congratulations You have registered for the Event. <br> Your Registration ID is : ".$reg_id;

	$res = $con->query('SELECT * FROM events WHERE event_id = "'.$event_id.'"');	

	$row = $res->fetch_assoc();

	$event_title = $row['title'];
	$date_from = $row['date_from'];
	$date_to = $row['date_to'];
	$time_from = $row['time_from'];
	$time_to = $row['time_to'];
	$venue = $row['venue'];

	$contact = $_POST['Contact'];
	$organisation = $_POST['Organisation'];
	$designation = $_POST['Designation'];

	//mail($_POST['Email'], "Pdf Generator Link ", " Click on the link given to generate Pdf <br>"."http://localhost/faif/pdf_generation/late_qr.php?contact=".$contact);                                               ///Mail to the user

	echo "<br>wait while you are automatically being redirected<br>"

?>

<form method="POST" action="pdf_generation/qr.php" style="display: hidden" id = "form1">
	<input type="text" name="reg_id" value = "<?php echo $reg_id ?>">
	<input type="text" name="name" value = "<?php echo $name ?>">
	<input type="email" name="email" value = "<?php echo $email ?>">
	<input type="text" name="contact" value = "<?php echo $contact ?>">
	<input type="text" name="organisation" value = "<?php echo $organisation ?>">
	<input type="text" name="designation" value = "<?php echo $designation ?>">
	<input type="date" name="date_from" value = "<?php echo $date_from ?>">
	<input type="date" name="date_to" value = "<?php echo $date_to ?>">
	<input type="text" name="time_from" value = "<?php echo $time_from ?>">
	<input type="text" name="time_to" value = "<?php echo $time_to ?>">
	<input type="text" name="venue" value = "<?php echo $venue ?>">
	<input type="text" name="event_title" value = "<?php echo $event_title ?>">
	<input type="text" name="event_id" value = "<?php echo $_POST['event_id'] ?>">
	<input type="submit">
</form>


<script type="text/javascript">
	var form = document.getElementById("form1");
	form.submit();
</script>