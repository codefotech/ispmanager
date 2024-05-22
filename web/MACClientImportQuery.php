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
				$user_name = $c_id;
				$e_id = $c_id;
				$user_id = $c_id;
				$user_type = 'client';
				$log_sts = '1';
            }
			$pw = "";
            if (isset($column[1])) {
                $pw = mysqli_real_escape_string($conn, $column[1]);
				$password = sha1($pw);
            }
            $address = "";
            if (isset($column[2])) {
                $address = mysqli_real_escape_string($conn, $column[2]);
            }
			
            $cellaa = "";
            if (isset($column[3])) {
                $cellaa = mysqli_real_escape_string($conn, $column[3]);
				$cell = '88'.$cellaa;
            }
			
			$p_id = "";
            if (isset($column[4])) {
                $p_id = mysqli_real_escape_string($conn, $column[4]);
				$id_get = mysqli_query($conn, "SELECT mk_profile, p_price FROM package WHERE p_id = '$p_id'");
				$ids = mysqli_fetch_array($id_get);
				$mk_profile = $ids['mk_profile'];
				$p_price = $ids['p_price'];
            }
			
/*			$z_id = "";
            if (isset($column[5])) {
                $z_id = mysqli_real_escape_string($conn, $column[5]);
            }
			
			$mk_id = "";
            if (isset($column[6])) {
                $mk_id = mysqli_real_escape_string($conn, $column[6]);
            }
*/
//			$termination_date = '2020-10-20';
//			$end_date = '2020-10-21';
			$p_m = 'Home Cash';
//			$join_date = '2020-10-21';
			$con_type = 'Home';
			$connectivity_type = 'Shared';
			$cable_type = 'UTP';
			$con_sts = 'Inactive';
			
            $sqlInsert = "INSERT into clients (c_id,c_name,z_id,mk_id,termination_date,cell,p_m,address,join_date,con_type,connectivity_type,cable_type,con_sts,mac_user,p_id)
                   values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $paramType = "sssssssssssssss";
            $paramArray = array(
                $c_id,
                $c_id,
				$z_id,
                $mk_id,
                $termination_date,
                $cell,
                $p_m,
                $address,
                $end_date,
                $con_type,
                $connectivity_type,
                $cable_type,
                $con_sts,
                $mac_user,
				$p_id
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
			
			if (! empty($insertId)) {
				$sqlInsert1 = "INSERT into login (user_name,e_id,user_id,pw,password,user_type,log_sts)
					   values (?,?,?,?,?,?,?)";
				$paramType1 = "sssssss";
				$paramArray1 = array(
					$c_id,
					$c_id,
					$c_id,
					$pw,
					$password,
					$user_type,
					$log_sts
				);
				$insertId1 = $db->insert($sqlInsert1, $paramType1, $paramArray1);
			}
			
			if (! empty($insertId1)) {
				$sqlInsert2 = "INSERT into billing_mac (c_id,z_id,p_id,start_date,end_date,days,p_price)
					   values (?,?,?,?,?,?,?)";
				$paramType2 = "sssssss";
				$paramArray2 = array(
					$c_id,
					$z_id,
					$p_id,
					$termination_date,
					$end_date,
					$days,
					$p_price
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
											
										$arrID = $API->comm("/ppp/secret/getall", 
										array(".proplist"=> ".id","?name" => $c_id,));

										$API->comm("/ppp/secret/set",
										array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
												$API->disconnect();
									}
			}
        }
    }
//	echo 'Done';
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