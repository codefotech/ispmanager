<?php
include("../web/conn/connection.php") ;

  if($_POST) 
  {
      $name     = strip_tags($_POST['c_id']);
	  $sql = mysql_query("SELECT user_id FROM login WHERE user_id='$name'");
	  $row = mysql_fetch_array($sql);
	  $aaa = $row['user_id'];
	  
	  if($aaa != '')
	  { ?>
			<select name="" class="chzn-select" style="width:100%;color: red;height: 27px;" required="">
				<option value="">Sorry Username Already Taken</option>
			</select>
	 <?php }
	  else
	  {
	  echo "<span style='color:green;font-size: 10px;font-weight: bold;'>[Available]</span>";
	  }
  }
?>