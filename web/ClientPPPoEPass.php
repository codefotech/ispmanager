<?php
include("conn/connection.php") ;
include("mk_api.php");
ini_alter('date.timezone','Asia/Almaty');
extract($_POST);

$todayy = date('d', time());

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
		
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port'];


if($_POST['pass1']!= $_POST['pass2'])
 {
     echo("Oops! Password did not match! Try again. ");
 }
 
 $cpass = sha1($pass2);
 
if($passway == 'mk'){
			$API = new routeros_api();
			$API->debug = false;
			if($API->connect($ServerIP, $Username, $Pass, $Port)) {
			   $arrID =	$API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"password" => $pass2));
				$API->disconnect();
			}
			else{ echo "Error!! No Connected Network Found.";} ?>
			
<html>
<body>
     <form action="ClientEdit" method="post" name="ok">
       <input type="hidden" name="sts" value="mk">
       <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }
 
if($passway == 'tis'){
		$query ="update login set password = '$cpass', pw = '$pass2' WHERE id = '$lid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
 ?>	
<html>
<body>
     <form action="<?php if($breseller == '2'){echo 'ClientEditInvoice';} else{echo 'ClientEdit';}?>" method="post" name="ok">
       <input type="hidden" name="sts" value="tis">
       <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>

<?php } if($passway == 'both'){
	 $API = new routeros_api();
			$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
			   $arrID =	$API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"password" => $pass2));
				$API->disconnect();
				
		$query ="update login set password = '$cpass', pw = '$pass2' WHERE id = '$lid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			}else{ echo "Error!! No Connected Network Found.";} ?>

<html>
<body>
     <form action="ClientEdit" method="post" name="ok">
       <input type="hidden" name="sts" value="mk">
       <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>

<?php } ?>