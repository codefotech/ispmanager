<?php
use Phppot\DataSource;
extract($_POST); 
require_once 'include/DataSource.php';
require_once 'mk_api.php';
$db = new DataSource();
$conn = $db->getConnection();

$API = new routeros_api();
$API->debug = false;

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $c_id = "";
            if (isset($column[0])) {
                $c_id = mysqli_real_escape_string($conn, $column[0]);
				$e_id = $c_id;
				$user_id = $c_id;
				$user_type = 'client';
				$log_sts = '0';
				$discount = '0.00';
				$mac_user = '0';
            }
			$pw = "";
            if (isset($column[1])) {
                $pw = mysqli_real_escape_string($conn, $column[1]);
				$dfdfgfh = $pw;
				$password = sha1($dfdfgfh);
            }
			
			$c_name = "";
            if (isset($column[2])) {
                $c_name = mysqli_real_escape_string($conn, $column[2]);
            }
			
            $address = "";
            if (isset($column[3])) {
                $address = mysqli_real_escape_string($conn, $column[3]);
            }
			
            $cell = "";
            if (isset($column[4])) {
                $cell = mysqli_real_escape_string($conn, $column[4]);
            }
			
			$p_id = "";
            if (isset($column[5])) {
                $p_id = mysqli_real_escape_string($conn, $column[5]);
				$id_get = mysqli_query($conn, "SELECT mk_profile, p_price FROM package WHERE p_id = '$p_id'");
				$ids = mysqli_fetch_array($id_get);
				$mk_profile = $ids['mk_profile'];
				$p_price = $ids['p_price'];
            }
			
			$payment_deadline = "";
            if (isset($column[6])) {
                $payment_deadline = mysqli_real_escape_string($conn, $column[6]);
            }
			
			$nid = "";
            if (isset($column[7])) {
                $nid = mysqli_real_escape_string($conn, $column[7]);
            }
			
			$bill_amount = "";
            if (isset($column[8])) {
                $bill_amount = mysqli_real_escape_string($conn, $column[8]);
            }
			
			$con_sts = "";
            if (isset($column[9])) {
                $con_sts = mysqli_real_escape_string($conn, $column[9]);
            }
			
			$com_id = "";
            if (isset($column[10])) {
                $com_id = mysqli_real_escape_string($conn, $column[10]);
            }
			
			if($con_sts == 'Inactive'){
				$ppp_price = '0.00';
				$disable = 'Yes';
			}
			else{
				$ppp_price = $p_price;
				$disable = 'No';
			}

			$p_m = 'Home Cash';
			$con_type = 'Home';
			$connectivity_type = 'Shared';
			$cable_type = 'UTP';
			
            $sqlInsert = "INSERT into clients (c_id,com_id,c_name,payment_deadline,b_date,z_id,mk_id,cell,p_m,address,join_date,con_type,connectivity_type,cable_type,con_sts,mac_user,p_id,nid)
                   values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $paramType = "ssssssssssssssssss";
            $paramArray = array(
                $c_id,
				$com_id,
                $c_name,
				$payment_deadline,
				$payment_deadline,
				$z_id,
                $mk_id,
                $cell,
                $p_m,
                $address,
                $bill_date,
                $con_type,
                $connectivity_type,
                $cable_type,
                $con_sts,
                $mac_user,
				$p_id,
				$nid
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
			
			if (! empty($insertId)) {
				$sqlInsert1 = "INSERT into login (user_name,e_id,user_id,pw,password,user_type,log_sts)
					   values (?,?,?,?,?,?,?)";
				$paramType1 = "sssssss";
				$paramArray1 = array(
					$c_name,
					$c_id,
					$c_id,
					$dfdfgfh,
					$password,
					$user_type,
					$log_sts
				);
				$insertId1 = $db->insert($sqlInsert1, $paramType1, $paramArray1);
			}
			
			if (! empty($insertId1)) {
				$sqlInsert2 = "INSERT into billing (c_id,bill_amount,p_id,bill_date,discount,p_price,bill_date_time)
					   values (?,?,?,?,?,?,?)";
				$paramType2 = "sssssss";
				$paramArray2 = array(
					$c_id,
					$bill_amount,
					$p_id,
					$bill_date,
					$discount,
					$ppp_price,
					$bill_date_time
				);
				$insertId2 = $db->insert($sqlInsert2, $paramType2, $paramArray2);
            }
			
			
            if (! empty($insertId2)) {
                $type = "Success!!";
                $message = "Go Back to Application.";
            } else {
                $type = "error!!";
                $message = "Problem in Importing CSV Data. Go Back to Application.";
            }
			
			if($addmk == 'Yes'){
				$id_get = mysqli_query($conn, "SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
				$ids = mysqli_fetch_array($id_get);
				$ServerIP = $ids['ServerIP'];
				$Username = $ids['Username'];
				$Pass= openssl_decrypt($ids['Pass'], $ids['e_Md'], $ids['secret_h']);
				$Port = $ids['Port'];
									if($API->connect($ServerIP, $Username, $Pass, $Port)) {
											$service = 'pppoe';										
											$API->comm("/ppp/secret/add", array(
											  "name"     => $c_id,
											  "password" => $pw,
											  "profile"  => $mk_profile,
											  "service"  => $service,
											));
											
										$arrID	=	$API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
													$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => $disable,));
													$API->disconnect();
									}
			}
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: Arial;
    width: 550px;
}

.outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}

.input-row {
    margin-top: 0px;
    margin-bottom: 20px;
}

.btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
}

.outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
}

.outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

.outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display: none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
</head>

<body>
    <div class="outer-scontainer">
        <div class="row">
					<a class="" href="MACClientImport"><?php echo $type.' '.$message;?></a>
                    <br />
        </div>
    </div>
</body>

</html>