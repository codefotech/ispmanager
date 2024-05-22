<?php
include("../conn/connection.php") ;
extract($_POST);

	
		$query = ("INSERT INTO clients (clientName, clients_phone, clients_address) VALUES ('$ClintName', '$ClintPhone', '$ClintAddress')");
		

		$sql = mysql_query($query);
		if ($sql){ ?>
			<html>
			<body>
				 <form action="Sales" method="post" name="ok">
					<input type="hidden" name="sts" value="return">
				 </form>

				 <script language="javascript" type="text/javascript">
					document.ok.submit();
				 </script>
			</body>
			</html>

<?php }	else { 
				die('Error: ' . mysql_error());
			}
?>
