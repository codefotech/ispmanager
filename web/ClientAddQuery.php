<?php
include("conn/connection.php");
include("mk_api.php");
extract($_POST);

$new_id = str_replace(' ', '', $c_id);

$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$new_id'");
$rowc = mysql_fetch_assoc($sqlc);

$sqlc1 = mysql_query("SELECT b_name FROM box WHERE box_id = '$box_id'");
$rowc1 = mysql_fetch_assoc($sqlc1);

$bname = $rowc1['b_name'];

ini_alter('date.timezone','Asia/Almaty');
$bill_date_time = date('Y-m-d H:i:s', time());
$today_daaate = date('Y-m-d', time());
$fst_daaate = date('Y-m-01', time());
$lastday_thismonth = date('Y-m-t', time());

if($rowc['user_id'] == ''){

$cellc = filter_var($cell, FILTER_SANITIZE_NUMBER_INT);
$cellc1 = filter_var($cell1, FILTER_SANITIZE_NUMBER_INT);
$cellc2 = filter_var($cell2, FILTER_SANITIZE_NUMBER_INT);
$cellc3 = filter_var($cell3, FILTER_SANITIZE_NUMBER_INT);
$cellc4 = filter_var($cell4, FILTER_SANITIZE_NUMBER_INT);

$sqlq = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, add_date_time, note FROM mk_con WHERE id = '$mk_id'");
$row2 = mysql_fetch_assoc($sqlq);

$Pass= openssl_decrypt($row2['Pass'], $row2['e_Md'], $row2['secret_h']);
$API = new routeros_api();
$API->debug = false;
if ($API->connect($row2['ServerIP'], $row2['Username'], $Pass, $row2['Port'])) {

	$pass = sha1($passid);

//................IMAGE.......................//

    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    if($old_image == 'no'){
		$file_extension = pathinfo($_FILES["main_image"]["name"], PATHINFO_EXTENSION);
		if(! file_exists($_FILES["main_image"]["tmp_name"])) {
			$response = array(
				"type" => "error",
				"message" => "Choose image file to upload."
			);
			$errorrr = 'Yes';
			$message = "Choose main_image file to upload.";
		}
		elseif(! in_array($file_extension, $allowed_image_extension)) {
			$response = array(
				"type" => "error",
				"message" => "Upload valiid images. Only PNG and JPEG are allowed."
			);
			$errorrr = 'Yes';
			$message = "Upload valiid images. Only PNG and JPEG are allowed.";
		}
		elseif(($_FILES["main_image"]["size"] > 500000000)) {
			$response = array(
				"type" => "error",
				"message" => "Image size exceeds 500KB"
			);
			$errorrr = 'Yes';
			$message = "Image size exceeds 500KB";
		}
		else{
				$uploadfile = "emp_images/".$new_id."_". basename($_FILES["main_image"]["name"]);
				if (move_uploaded_file($_FILES["main_image"]["tmp_name"], $uploadfile)) {
					
					$orig_image = imagecreatefromjpeg($uploadfile);
					$image_info = getimagesize($uploadfile); 
					$width_orig  = $image_info[0]; // current width as found in image file
					$height_orig = $image_info[1]; // current height as found in image file
					$width = 350; // new image width
					$height = 525; // new image height
					$destination_image = imagecreatetruecolor($width, $height);
					imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					imagejpeg($destination_image, $uploadfile, 100);
					
					$response = array(
						"type" => "success",
						"message" => "Image uploaded successfully."
					);
					
				$imglink = "emp_images/".$new_id."_". basename($_FILES["main_image"]["name"]);
				
				$errorrr = 'No';
				$message = "Image uploaded successfully.";
				}
				else{
					$response = array(
						"type" => "error",
						"message" => "Problem in uploading image files."
					);
				$imglink = "";
				$errorrr = 'Yes';
				$message = "Problem in uploading image files.";
				}
		}
	}
	else{
		$uploadfile = $old_image;
	}
	
	if($old_nid_f_image == 'no'){
		$file_extension1 = pathinfo($_FILES["nid_f_image"]["name"], PATHINFO_EXTENSION);
		if(! file_exists($_FILES["nid_f_image"]["tmp_name"])) {
			$response = array(
				"type" => "error",
				"message" => "Choose nid_f_image file to upload."
			);
			$errorrr = 'Yes';
			$message = "Choose nid_f_image file to upload.";
		}
		elseif(! in_array($file_extension1, $allowed_image_extension)) {
			$response = array(
				"type" => "error",
				"message" => "Upload valiid images. Only PNG and JPEG are allowed."
			);
			$errorrr = 'Yes';
			$message = "Upload valiid images. Only PNG and JPEG are allowed.";
		}
		elseif(($_FILES["nid_f_image"]["size"] > 500000000)) {
			$response = array(
				"type" => "error",
				"message" => "Image size exceeds 500KB"
			);
			$errorrr = 'Yes';
			$message = "Image size exceeds 500KB";
		}
		else{
				$uploadfile1 = "emp_images/".$new_id."_f_nid_". basename($_FILES["nid_f_image"]["name"]);
				if (move_uploaded_file($_FILES["nid_f_image"]["tmp_name"], $uploadfile1)) {
					
					$orig_image1 = imagecreatefromjpeg($uploadfile1);
					$image_info1 = getimagesize($uploadfile1); 
					$width_orig1  = $image_info1[0]; // current width as found in image file
					$height_orig1 = $image_info1[1]; // current height as found in image file
					$width1 = 320; // new image width
					$height1 = 200; // new image height
					$destination_image1 = imagecreatetruecolor($width1, $height1);
					imagecopyresampled($destination_image1, $orig_image1, 0, 0, 0, 0, $width1, $height1, $width_orig1, $height_orig1);
					imagejpeg($destination_image1, $uploadfile1, 100);
					
					$response = array(
						"type" => "success",
						"message" => "Image uploaded successfully."
					);
					
				$imglink1 = "emp_images/".$new_id."_f_nid_". basename($_FILES["nid_f_image"]["name"]);
				$errorrr = 'No';
				$message = "Image uploaded successfully.";
				}
				else{
					$response = array(
						"type" => "error",
						"message" => "Problem in uploading image files."
					);
				$imglink1 = "";
				$errorrr = 'Yes';
				$message = "Problem in uploading image files.";
				}
		}
	}
		else{
			$uploadfile1 = $old_nid_f_image;
		}
	
	if($old_nid_b_image == 'no'){
		$file_extension2 = pathinfo($_FILES["nid_b_image"]["name"], PATHINFO_EXTENSION);
		if(! file_exists($_FILES["nid_b_image"]["tmp_name"])) {
			$response = array(
				"type" => "error",
				"message" => "Choose image file to upload."
			);
			$errorrr = 'Yes';
			$message = "Choose nid_b_image file to upload.";
		}
		 elseif(! in_array($file_extension2, $allowed_image_extension)) {
			$response = array(
				"type" => "error",
				"message" => "Upload valiid images. Only PNG and JPEG are allowed."
			);
			$errorrr = 'Yes';
			$message = "Upload valiid images. Only PNG and JPEG are allowed.";
		}
		elseif(($_FILES["nid_b_image"]["size"] > 500000000)) {
			$response = array(
				"type" => "error",
				"message" => "Image size exceeds 500KB"
			);
			$errorrr = 'Yes';
			$message = "Image size exceeds 500KB";
		}
		else{
			$uploadfile2 = "emp_images/".$new_id."_b_nid_". basename($_FILES["nid_b_image"]["name"]);
				if (move_uploaded_file($_FILES["nid_b_image"]["tmp_name"], $uploadfile2)) {
					
					$orig_image2 = imagecreatefromjpeg($uploadfile2);
					$image_info2 = getimagesize($uploadfile2); 
					$width_orig2  = $image_info2[0]; // current width as found in image file
					$height_orig2 = $image_info2[1]; // current height as found in image file
					$width2 = 320; // new image width
					$height2 = 200; // new image height
					$destination_image2 = imagecreatetruecolor($width2, $height2);
					imagecopyresampled($destination_image2, $orig_image2, 0, 0, 0, 0, $width2, $height2, $width_orig2, $height_orig2);
					imagejpeg($destination_image2, $uploadfile2, 100);
					
					
					$response = array(
						"type" => "success",
						"message" => "Image uploaded successfully."
					);
					
				$imglink2 = "emp_images/".$new_id."_b_nid_". basename($_FILES["nid_b_image"]["name"]);
				$errorrr = 'No';
				$message = "Image uploaded successfully.";
				} else {
					$response = array(
						"type" => "error",
						"message" => "Problem in uploading image files."
					);
				$imglink2 = "";
				$errorrr = 'Yes';
				$message = "Problem in uploading image files.";
				}
			
		}
	}
		else{
			$uploadfile2 = $old_nid_b_image;
		}
//................IMAGE.......................//


if($breseller == '1'){
		$nombre =  $new_id;
        $target = $ip;
		$maxlimit=    $raw_upload.''.'M/'.''.$raw_download.''.'M';
        $API->comm("/queue/simple/add", array(
          "name"     => $nombre,
          "target" => $target,
          "max-limit"  => $maxlimit,
        ));
		
$API->disconnect();
	
		if($new_id != ''){
			$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, box_id, bill_man, technician, payment_deadline, termination_date, breseller, b_date, cell, cell1, cell2, cell3, cell4, email, address, thana, join_date, occupation, con_type, connectivity_type, ip, mac, req_cable, cable_type, con_sts, nid, p_m, signup_fee, note, entry_by, entry_date, entry_time, calculation, raw_download, raw_upload, youtube_bandwidth, total_bandwidth, bandwidth_price, youtube_price, total_price, father_name, old_address, flat_no, house_no, road_no, onu_mac, agent_id, com_percent, count_commission, latitude, longitude)
					  VALUES ('$new_id', '$com_id', '$c_name', '$z_id', '$mk_id', '$box_id', '$bill_man', '$technician', '$payment_deadline', '$termination_date', '$breseller', '$b_date', '$cellc', '$cellc1', '$cellc2', '$cellc3', '$cellc4', '$email', '$address', '$thana', '$join_date', '$occupation', '$con_type', '$connectivity_type', '$ip', '$mac', '$req_cable', '$cable_type', '$con_sts', '$nid', '$p_m', '$signup_fee', '$note','$entry_by', '$entry_date', '$entry_time', '$calculation', '$raw_download', '$raw_upload', '$youtube_bandwidth', '$total_bandwidth', '$bandwidth_price', '$youtube_price', '$bill_amount', '$father_name', '$old_address', '$flat_no', '$house_no', '$road_no', '$onu_mac', '$agent_id', '$com_percent', '$count_commission', '$latitude', '$longitude')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result)
			{
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, email, image, nid_fond, nid_back, pw) VALUES ('$c_name', '$new_id', '$new_id', '$pass', 'breseller', '$email', '$uploadfile', '$uploadfile1', '$uploadfile2', '$passid')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
			
			}
			
			$query20 = "UPDATE app_config SET last_id = '$com_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
			
			if($calculation == 'Manual')
			{
			$query2 = "insert into billing (c_id, bill_date, p_price, bill_amount, bill_date_time) VALUES ('$new_id', '$entry_date', '$bill_amount', '$bill_amount', '$bill_date_time')";
			$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			
			if($qcalculation == 'No')
			{
				$query2 = "insert into billing (c_id, bill_date, p_price, bill_amount, bill_date_time) VALUES ('$new_id', '$entry_date', '$bill_amount', '0.00', '$bill_date_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}
			}
			
			if($calculation == 'Auto')
			{
			$todayy = date('d', time());
			$lastdayofthismonth = date('t');
			$aa = ($lastdayofthismonth - $todayy)+1;
			$onedaynewprice = $bill_amount / $lastdayofthismonth;
			$unusedday = $aa * $onedaynewprice;
			$discountt = $bill_amount - $unusedday;
				
			$query2 = "insert into billing (c_id, bill_date, p_price, bill_amount, day, bill_date_time) VALUES ('$new_id', '$entry_date', '$bill_amount', '$unusedday', '$aa', '$bill_date_time')";
			$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");
			}

		}
		else{
			echo 'Invilade Id';
		}		
	
}

elseif($breseller == '2'){
		$nombre =  $new_id;
        $target = $ip;
		
		if($new_id != ''){
 			$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, invoice_date, due_deadline, box_id, bill_man, technician, breseller, cell, cell1, cell2, cell3, cell4, email, address, thana, join_date, occupation, con_type, connectivity_type, ip, mac, discount, subtotal, total_price, pop, nttn, link_id, req_cable, cable_type, con_sts, nid, p_m, signup_fee, note, entry_by, entry_date, entry_time, father_name, old_address, flat_no, house_no, road_no, onu_mac, agent_id, com_percent, count_commission, latitude, longitude)
					  VALUES ('$new_id', '$com_id', '$c_name', '$z_id', '$mk_id', '$invoice_date', '$due_deadline', '$box_id', '$bill_man', '$technician', '$breseller', '$cellc', '$cellc1', '$cellc2', '$cellc3', '$cellc4', '$email', '$address', '$thana', '$join_date', '$occupation', '$con_type', '$connectivity_type', '$ip', '$mac', '$discount', '$subtotal', '$total_price', '$pop', '$nttn', '$link_id', '$req_cable', '$cable_type', 'Active', '$nid', '$p_m', '$signup_fee', '$note','$entry_by', '$entry_date', '$entry_time', '$father_name', '$old_address', '$flat_no', '$house_no', '$road_no', '$onu_mac', '$agent_id', '$com_percent', '$count_commission', '$latitude', '$longitude')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result)
			{
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, email, image, nid_fond, nid_back, pw) VALUES ('$c_name', '$new_id', '$new_id', '$pass', 'breseller', '$email', '$uploadfile', '$uploadfile1', '$uploadfile2', '$passid')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			
			$query20 = "UPDATE app_config SET last_id = '$com_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
		$yyr = date('Y', time());
		$yyy = date('y', time());
		$mmm = date('m', time());
		$ssss = date('s', time());
		$datffff = $yyy.$mmm.$ssss;
		
		$due_deadlinee = $yyr.'-'.$mmm.'-'.$due_deadline;
		$sqldd = ("SELECT invoice_id FROM billing_invoice ORDER BY id DESC LIMIT 1");
		$querydd2 = mysql_query($sqldd);
		$rowdd = mysql_fetch_assoc($querydd2);
		$old_idddd = $rowdd['invoice_id'];
		
		if($old_idddd == ''){
			$invoice_id_new = $datffff + 100;
		}
		else{
			$invoice_id_new = $old_idddd + 10;
		}
			
			$itemNo  = $_POST['itemNo'];
			$itemNameArray = $_POST['itemName'];
			$itemDesArray = $_POST['itemDes'];
			$quantityArray = $_POST['quantity'];
			$unitArray = $_POST['unit'];
			$unitepriceArray = $_POST['uniteprice'];
			$vatArray = $_POST['vat'];
			$priceArray = $_POST['price'];
			$lastdayofthismonth = date('t');
			
			foreach( $itemNo as $key => $productNo ){
			$itemNameValu =$itemNameArray[$key];
			$itemDesValu =$itemDesArray[$key];
			$quantityValu =$quantityArray[$key];
			$unitValu =$unitArray[$key];
			$unitepriceValu =$unitepriceArray[$key];
			$vatValu =$vatArray[$key];
			$priceValu =$priceArray[$key];
			
				if ($productNo != '' && $itemNameValu != '' && $quantityValu != '' && $unitValu != '' && $unitepriceValu != '' && $vatValu != '' && $priceValu != ''){
				$Sqls = ("INSERT INTO monthly_invoice (c_id, item_id, item_name, description, quantity, unit, uniteprice, vat, days, total_price) 
				VALUES ('$new_id', '$productNo', '$itemNameValu', '$itemDesValu', '$quantityValu', '$unitValu', '$unitepriceValu', '$vatValu', '$lastdayofthismonth', '$priceValu')");
				
				$resuls = mysql_query($Sqls) or die("inser_query failed: " . mysql_error() . "<br />");
					
					if($qcalculation == 'Manual'){
						$ffqlscv = ("INSERT INTO billing_invoice (invoice_id, invoice_date, c_id, item_id, item_name, description, quantity, unit, uniteprice, vat, days, total_price, start_date, end_date, due_deadline) 
							VALUES ('$invoice_id_new', '$fst_daaate', '$c_id', '$productNo', '$itemNameValu', '$itemDesValu', '$quantityValu', '$unitValu', '$unitepriceValu', '$vatValu', '$lastdayofthismonth', '$priceValu', '$fst_daaate', '$lastday_thismonth', '$due_deadlinee')");
						$resulsddjj = mysql_query($ffqlscv) or die("inser_query failed: " . mysql_error() . "<br />");
					}
					
					if($qcalculation == 'Auto'){
						$todayy = date('d', time());
						$aafyjk = ($lastdayofthismonth - 1)+1;
						$onedaynewprice = $priceValu / $lastdayofthismonth;
						$unusedday = $aafyjk * $onedaynewprice;
						$ffqls = ("INSERT INTO billing_invoice (invoice_id, invoice_date, c_id, item_id, item_name, description, quantity, unit, uniteprice, vat, days, total_price, start_date, end_date, due_deadline) 
							VALUES ('$invoice_id_new', '$today_daaate', '$c_id', '$productNo', '$itemNameValu', '$itemDesValu', '$quantityValu', '$unitValu', '$unitepriceValu', '$vatValu', '$aafyjk', '$unusedday', '$today_daaate', '$lastday_thismonth', '$due_deadlinee')");
						$resulsjj = mysql_query($ffqls) or die("inser_query failed: " . mysql_error() . "<br />");
					}
				}
			}
			
			$vlanId = $_POST['vlanId'];
			$vlanNameArray = $_POST['vlanName'];
			if ($vlanId != '' && $vlanNameArray != ''){
				foreach( $vlanId as $key => $vlanNo ){
				$vlanNameValu = $vlanNameArray[$key];
					
					$Sqls = ("INSERT INTO vlan (c_id, vlan_id, vlan_name) 
					VALUES ('$new_id', '$vlanNo', '$vlanNameValu')");
					
					$resuls = mysql_query($Sqls) or die("inser_query failed: " . mysql_error() . "<br />");
				}
			}
			
			$ipaddress = $_POST['ipaddress'];			
			if ($ipaddress != ''){
				foreach( $ipaddress as $key => $ipaddressNo ){					
					$Sqls = ("INSERT INTO ip_address (c_id, ip_address) 
					VALUES ('$new_id', '$ipaddressNo')");
					
					$resuls = mysql_query($Sqls) or die("inser_query failed: " . mysql_error() . "<br />");
				}
			}
		}
		else{
			echo 'Invilade Id';
		}
}
else{
$sqlqq = mysql_query("SELECT mk_profile, p_price FROM package WHERE p_id = '$p_id'");
$row22 = mysql_fetch_assoc($sqlqq);

//--------Add PPPoE in Mikrotik-------

		$nombre =  $new_id;
        $password = $passid;
        $service = 'pppoe';
        $profile = $row22['mk_profile'];
		$pprice = $row22['p_price'];
		$remote = $ip;

//--------Add PPPoE in Mikrotik-------
		
		
		if($new_id != ''){
			$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, box_id, bill_man, technician, payment_deadline, termination_date, b_date, cell, cell1, cell2, cell3, cell4, opening_balance, email, address, thana, previous_isp, join_date, occupation, con_type, connectivity_type, ip, mac, req_cable, cable_type, con_sts, nid, p_id, p_m, signup_fee, discount, extra_bill, note, entry_by, entry_date, entry_time, father_name, old_address, flat_no, house_no, road_no, onu_mac, agent_id, com_percent, count_commission, latitude, longitude)
					  VALUES ('$new_id', '$com_id', '$c_name', '$z_id', '$mk_id', '$box_id', '$bill_man', '$technician', '$payment_deadline', '$termination_date', '$b_date', '$cellc', '$cellc1', '$cellc2', '$cellc3', '$cellc4', '$opening_balance', '$email', '$address', '$thana', '$previous_isp', '$join_date', '$occupation', '$con_type', '$connectivity_type', '$ip', '$mac', '$req_cable', '$cable_type', '$con_sts', '$nid', '$p_id', '$p_m', '$signup_fee', '$discount', '$extra_bill', '$note','$entry_by', '$entry_date', '$entry_time', '$father_name', '$old_address', '$flat_no', '$house_no', '$road_no', '$onu_mac', '$agent_id', '$com_percent', '$count_commission', '$latitude', '$longitude')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result)
			{
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, email, image, nid_fond, nid_back, pw) VALUES ('$c_name', '$new_id', '$new_id', '$pass', 'client', '$email', '$uploadfile', '$uploadfile1', '$uploadfile2', '$passid')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");

			}
			if($cable_type == 'FIBER' && $diagram_way == '1'){
			$querytree="INSERT INTO network_tree (parent_id, in_port, in_color, out_port, fiber_code, z_id, device_type, name, location, mk_id, entry_by, entry_time, c_id, latitude, longitude)
					VALUES ('$parent_id', '$in_port', '$in_color', '1', '$fiber_code', '$z_id', '4', '$new_id', '$address', '$mk_id', '$entry_by', '$entry_date', '$new_id', '$latitude', '$longitude')";

			$resulttree = mysql_query($querytree) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			$query20 = "UPDATE app_config SET last_id = '$com_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
			if($way == 'newsignup'){
				$query2d = "UPDATE clients_signup SET sts  = '1' WHERE id = '$signup_id'";
				$result2d = mysql_query($query2d) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			if($qcalculation == 'Manual')
			{
				$dis_price = ($pprice - $discount) + $extra_bill;
				$query2 = "insert into billing (c_id, bill_date, p_id, p_price, discount, extra_bill, bill_amount, bill_date_time) VALUES ('$nombre', '$entry_date', '$p_id', '$pprice', '$discount', '$extra_bill', '$dis_price', '$bill_date_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}
			}
			
			if($qcalculation == 'No')
			{
				$query2 = "insert into billing (c_id, bill_date, p_id, p_price, discount, extra_bill, bill_amount, bill_date_time) VALUES ('$nombre', '$entry_date', '$p_id', '$pprice', '0.00', '0.00', '0.00', '$bill_date_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}
			}
			
			if($qcalculation == 'Auto')
			{
			$todayy = date('d', time());
			$lastdayofthismonth = date('t');
			$aa = $lastdayofthismonth - $todayy;

			$onedaynewprice = (($pprice + $extra_bill) - $discount) / $lastdayofthismonth;
			$unusedday = $aa * $onedaynewprice;
			$discountt = $pprice - $unusedday;
			
				$query2 = "insert into billing (c_id, bill_date, p_id, p_price, discount, extra_bill, bill_amount, day, bill_date_time) VALUES ('$nombre', '$entry_date', '$p_id', '$pprice', '$discountt', '$extra_bill', '$unusedday', '$aa', '$bill_date_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}
			}
			if($ppoe_comment == '0'){
				$comment = $c_name.'-'.$cellc.'-'.$address.'-'.$bname.'-'.$join_date.'-'.$pprice.'TK';
			}
			else{
				$comment = '';
			}
			
	if($ip != ''){
        $API->comm("/ppp/secret/add", array(
          "name"     => $nombre,
          "password" => $password,
          "profile"  => $profile,
          "service"  => $service,
		  "comment"  => $comment,
		  "remote-address" => $remote,
        ));
	}
	else{
		 $API->comm("/ppp/secret/add", array(
          "name"     => $nombre,
          "password" => $password,
          "profile"  => $profile,
          "service"  => $service,
		  "comment"  => $comment,
        ));
	}
$API->disconnect();
		}
		else{
			echo 'Invilade Id';
		}
}
?>

<html>
<body>
     <form action="Success" method="post" name="cus_id">
       <input type="hidden" name="new_id" value="<?php echo $new_id; ?>">
	   <input type="hidden" name="passid" value="<?php echo $passid; ?>">
	   <input type="hidden" name="sentsms" value="<?php echo $sentsms; ?>">
	   <input type="hidden" name="mk_name" value="<?php echo $row2['Name']; ?>">
	   	<input type="hidden" name="message" value="<?php echo $message;?>">
	   <input type="hidden" name="from_page" value="Add Client">
     </form>

     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
     <noscript><input type="submit" value="<? echo $new_id; ?>"></noscript>
</body>
</html>

<?php
$action_details = 'Add new client: '.$nombre.', Permanent discount amount: '.$discount.', Payment Deadline: '.$payment_deadline.', Billing Deadline: '.$b_date;
$query222 = "INSERT INTO emp_log (e_id, c_id, module_name, titel, date, time, action, action_details) VALUES ('$entry_by', '$nombre', 'Clients', 'Add_Client', '$entry_date', '$entry_time', 'Add_Client', '$action_details')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}

}
else{
	echo 'Selected Network are not Connected';
}
}
else{
	echo 'Client ID Already Existed';
}
?>