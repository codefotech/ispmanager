<?php
include("conn/connection.php") ;
extract($_POST);
	$new_id = $datimg;
	
//................IMAGE.......................//

    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    if (! file_exists($_FILES["image"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
		$errorrr = 'Yes';
		$message = "Choose image file to upload.";
    }
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
        );
		$errorrr = 'Yes';
		$message = "Upload valiid images. Only PNG and JPEG are allowed.";
    }
	 
	else{
			$uploadfile = "emp_images/".$new_id."_". basename($_FILES["image"]["name"]);
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadfile)) {
				$response = array(
					"type" => "success",
					"message" => "Image uploaded successfully."
				);
				
			$imglink = "emp_images/".$new_id."_". basename($_FILES["image"]["name"]);
			
			$errorrr = 'No';
			$message = "Image uploaded successfully.";
			} else {
				$response = array(
					"type" => "error",
					"message" => "Problem in uploading image files."
				);
			$imglink = "";
			$errorrr = 'Yes';
			$message = "Problem in uploading image files.";
			}
    }
	
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
	elseif(($_FILES["nid_f_image"]["size"] > 500000)) {
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
	elseif(($_FILES["nid_b_image"]["size"] > 500000)) {
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
//................IMAGE.......................//
		
		
		if($disclaimer == 'Yes'){
			$query = "insert into clients_signup (c_name, cell, cell1, cell2, cell3, cell4, email, address, previous_isp, join_date, occupation, connectivity_type, nid, p_id, p_m, signup_fee, note, entry_date, entry_time, disclaimer, image, nid_f_image, nid_b_image,ip)
					  VALUES ('$c_name', '$cell', '$cell1', '$cell2', '$cell3', '$cell4', '$email', '$address', '$previous_isp', '$entry_date', '$occupation', '$connectivity_type', '$nid', '$p_id', '$p_m', '$signup_fee', '$note', '$entry_date', '$entry_time', '$disclaimer', '$uploadfile', '$uploadfile1', '$uploadfile2', '$client_ip')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		else{
			echo 'Invilade Id';
		}		

?>

<html>
<body>
     <form action="SignUp" method="post" name="cus_id">
       <input type="hidden" name="c_name" value="<?php echo $c_name; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
     <noscript><input type="submit" value="<? echo $new_id; ?>"></noscript>
</body>
</html>
