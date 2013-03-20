<?php
 header('Content-type: text/xml');
 if(isset($_POST['tocall'])) {
 	echo '<?xml version="1.0" encoding="UTF-8"?>';
 	echo '<Response>';
	echo '<Dial callerId="+16504883832">';
	echo htmlspecialchars($_POST['tocall']);
	echo '</Dial>';
	echo '</Response>';
 } else { 	
 	echo '<?xml version="1.0" encoding="UTF-8"?>';
 	echo '<Response>';
 	echo '<Enqueue>SupportQueue</Enqueue>';
 	echo '</Response>';
 }
?>