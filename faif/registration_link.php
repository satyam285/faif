<?php
$event_id = $_GET['event_id'];
$encoded_id = '97*56%*'.$event_id.'/02?>';
echo "<br>Copy the Below Link<br>";
echo "<a href='register.php?encoded_id=".$encoded_id."'>http://localhost/faif/register.php?encoded_id=".$encoded_id."</a>";
?>