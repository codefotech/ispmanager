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
				$user_type = 'client';
				$log_sts = '1';
            }
			$pw = "";
            if (isset($column[1])) {
                $pw = mysqli_real_escape_string($conn, $column[1]);
				$password = sha1($pw);
            }
			
			$cname = "";
            if (isset($column[2])) {
                $cname = mysqli_real_escape_string($conn, $column[2]);
				$c_name = $cname;
            }
			
			$cellaa = "";
            if (isset($column[3])) {
                $cellaa = mysqli_real_escape_string($conn, $column[3]);
				$cell = '88'.$cellaa;
            }
			
			$cellaaa = "";
            if (isset($column[4])) {
                $cellaaa = mysqli_real_escape_string($conn, $column[4]);
				$cell1 = $cellaaa;
            }
			
			$emailll = "";
            if (isset($column[5])) {
                $emailll = mysqli_real_escape_string($conn, $column[5]);
				$email = $emailll;
            }
			
            $address = "";
            if (isset($column[6])) {
                $address = mysqli_real_escape_string($conn, $column[6]);
            }
			
            $joining = "";
            if (isset($column[7])) {
                $joining = mysqli_real_escape_string($conn, $column[7]);
				$join_date = $joining;
            }
			
			$p_id = "";
            if (isset($column[8])) {
                $p_id = mysqli_real_escape_string($conn, $column[8]);
				$id_get = mysqli_query($conn, "SELECT mk_profile, p_price FROM package WHERE p_id = '$p_id'");
				$ids = mysqli_fetch_array($id_get);
				$mk_profile = $ids['mk_profile'];
				$p_price = $ids['p_price'];
            }
			
			$n_id = "";
            if (isset($column[9])) {
                $n_id = mysqli_real_escape_string($conn, $column[9]);
				$nid = $n_id;
            }
			
			$noteee = "";
            if (isset($column[10])) {
                $noteee = mysqli_real_escape_string($conn, $column[10]);
				$note = $noteee;
            }
			
			$consts = "";
            if (isset($column[11])) {
                $consts = mysqli_real_escape_string($conn, $column[11]);
				$con_sts = $consts;
            }
			$com_id = "";
            if (isset($column[12])) {
                $com_id = mysqli_real_escape_string($conn, $column[12]);
            }
			
			if($consts == 'Active'){
				$packageoneday = $p_price/30;
				$termination_date = $enddate;
				$start_date = strtotime($startdate);
				$end_date = strtotime($enddate);
				$days = abs($end_date - $start_date) / 86400;
				$bill_amount = $days*$packageoneday;
			}
			else{
				$termination_date = $yesterday_date;
				$start_date = strtotime($startdate);
				$end_date = strtotime($yesterday_date);
				$days = abs($end_date - $start_date) / 86400;
				$bill_amount = '0.00';
			}
			
            $sqlInsert = "INSERT into clients (c_id,com_id,c_name,z_id,mk_id,termination_date,cell,cell1,p_m,address,join_date,con_type,connectivity_type,cable_type,con_sts,mac_user,p_id)
                   values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $paramType = "sssssssssssssssss";
            $paramArray = array(
                $c_id,
				$com_id,
                $c_name,
				$z_id,
                $mk_id,
                $termination_date,
                $cell,
                $cell1,
                $p_m,
                $address,
                $join_date,
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
					$c_name,
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
				$sqlInsert2 = "INSERT into billing_mac (c_id,z_id,p_id,start_date,end_date,days,p_price,bill_amount,entry_date)
					   values (?,?,?,?,?,?,?,?,?)";
				$paramType2 = "sssssssss";
				$paramArray2 = array(
					$c_id,
					$z_id,
					$p_id,
					$startdate,
					$termination_date,
					$days,
					$p_price,
					$bill_amount,
					$entry_date
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
					<a class="" href="MACClientImport2"><?php echo $type.' '.$message;?></a>
                    <br />
        </div>
    </div>
</body>

</html>