<?php
// @start snippet
include 'Services/Twilio/Capability.php';

$accountSid = 'ACb19363393f835935bbdb6b63b749495b';
$authToken  = '5996782fcbcdb88ff4c8ae18fd6d6930';
$clientName = 'russ';

$token = new Services_Twilio_Capability($accountSid, $authToken);
$token->allowClientOutgoing('APe86b3eb8c889c0b7d4878face53e04d1');
$token->allowClientIncoming($clientName);
// @end snippet
?>

<!DOCTYPE HTML>
	<head><html>

		<title>
			Twilio Client Click to Call
		</title>
		<!-- @start snippet -->
		<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<link href="client.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript">
		$(document).ready(function(){

			Twilio.Device.setup("<?php echo $token->generateToken();?>");
			var connection=null;
			
			$("#call").click(function() {  
				params = { "tocall" : $('#tocall').val()};
				connection = Twilio.Device.connect(params);
			});
			$("#hangup").click(function() {  
				Twilio.Device.disconnectAll();
			});

			Twilio.Device.ready(function (device) {
				$('#status').text('Ready');
			});

			Twilio.Device.incoming(function (conn) {
				if (confirm('Accept incoming call from ' + conn.parameters.From + '?')){
					connection=conn;
				    conn.accept();
				}
			});

			Twilio.Device.offline(function (device) {
				$('#status').text('Offline');
			});

			Twilio.Device.error(function (error) {
				$('#status').text(error);
			});

			Twilio.Device.connect(function (conn) {
				$('#status').text("Successfully established call");
				toggleCallStatus();
			});

			Twilio.Device.disconnect(function (conn) {
				$('#status').text("Call ended");
				toggleCallStatus();
			});
			
			function toggleCallStatus(){
				$('#call').toggle();
				$('#hangup').toggle();
				$('#dialpad').toggle();
			}

			$.each(['0','1','2','3','4','5','6','7','8','9','star','pound'], function(index, value) { 
		    	$('#button' + value).click(function(){ 
					if(connection) {
						if (value=='star')
							connection.sendDigits('*')
						else if (value=='pound')
							connection.sendDigits('#')
						else
							connection.sendDigits(value)
						return false;
					} 
					});
			});
			
		});

		</script>
		<script type="text/javascript">
var getQueue = {
				getCall : function() {
					$.ajax({
						url: 'dequeue.php',
						type: 'GET',
						data : { agentName : "<?php echo $clientName; ?>" },
						success: function(data){
							if((data!=null) && (data!='')) {
								alert(data);
							} else {
								alert("no data returned");
							}
						}

					});
					}
				};
		</script>
		<!-- @end snippet -->
	</head>
	<body>
		<div align="center">
			<!-- @start snippet -->
			Number to call: <input type="text" id="tocall" value="" />
			<input type="button" id="call" value="Start Call" class="call"/>
			<input type="button" id="hangup" value="Hangup Call" class="hangup" style="display:none;"/>
			<div id="status">
				Offline
			</div>
			<div id="dialpad" style="display:none;">
				<table>
				<tr>
				<td><input type="button" value="1" id="button1"></td>
				<td><input type="button" value="2" id="button2"></td>
				<td><input type="button" value="3" id="button3"></td>
				</tr>
				<tr>
				<td><input type="button" value="4" id="button4"></td>
				<td><input type="button" value="5" id="button5"></td>
				<td><input type="button" value="6" id="button6"></td>
				</tr>
				<tr>
				<td><input type="button" value="7" id="button7"></td>
				<td><input type="button" value="8" id="button8"></td>
				<td><input type="button" value="9" id="button9"></td>
				</tr>
				<tr>
				<td><input type="button" value="*" id="buttonstar"></td>
				<td><input type="button" value="0" id="button0"></td>
				<td><input type="button" value="#" id="buttonpound"></td>
				</tr>
				</table>
			</div>1
			<!-- @end snippet -->
			<a onclick="getQueue.getCall();">Get Call From Queue</a>
		</div>
	</body>
</html>
