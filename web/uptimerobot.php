<?php 
$monitorID = $_GET['monitorID'];
$monitorURL = $_GET['monitorURL'];
$alertType = $_GET['alertType'];

//Database Information
				$servername = "localhost";
				$username = "asthatecnet_saltsync";
				$password = "Online_123456";
				$dbname = "asthatecnet_saltsync";

				
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "INSERT INTO users (c_id, firstName, lastName)
				VALUES ('$monitorID', '$monitorURL', '$alertType')";
				
if ($conn->query($sql) === TRUE) {
					
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				$conn->close();

?>