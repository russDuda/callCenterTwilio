<?php
header('Content-type: text/xml');
?>
<Response>
<Dial callerId="+16504883238"><?php echo htmlspecialchars($_REQUEST["tocall"]); ?></Dial>
</Response>
