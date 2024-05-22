<?php
include("conn/connection.php") ;

  if($_POST) 
  {
      $name     = strip_tags($_POST['c_id']);
	  $sql = mysql_query("SELECT user_id FROM login WHERE user_id='$name'");
	  $row = mysql_fetch_array($sql);
	  $aaa = $row['user_id'];
	  
	  if($aaa != '')
	  { ?>
		<p>
			<label style="width: 130px;font-weight: bold;"></label>
			<span class="field" style="margin-left: 0px;">
				<select name="" class="chzn-select" style="width:250px;color: red;height: 27px;" required="">
					<option value="">Sorry Username Already Taken</option>
				</select>
			</span>
		</p>
	  <?php }
	  else
	  {?>
		<p>
			<label style="width: 130px;font-weight: bold;"></label>
			<span class="field" style="margin-left: 0px;"><?php echo "<span style='color:green;font-weight: bold;'>Available</span>";?></span>
		</p>
	  <?php
	  }
  }
?>