<?php
$titel = "Store Reports (Cable)";
$Reports = 'active';
$ReportStoreCable = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
$result1=mysql_query($query1);

$query="SELECT id, pro_name, pro_details FROM fiber WHERE sts = '0' ORDER BY pro_name ASC";
$result=mysql_query($query);

$query2="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
$result2=mysql_query($query2);

$query3="SELECT id, pro_name, pro_details FROM fiber WHERE sts = '0' ORDER BY pro_name ASC";
$result3=mysql_query($query3);
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Store (Cable)</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/Reports_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 440px;">
						<center>
						<h4>Cable Store Report </h4><br/>
								<div class="tabbedwidget">
                            <ul>
							<?php if(in_array(170, $access_arry)){?>
                                <li><a href="#tabs-2">Cable In</a></li>
							<?php } if(in_array(171, $access_arry)){?>
                                <li><a href="#tabs-3">Cable Out</a></li>
							<?php } ?>
                            </ul>
							<br/><br/>
							<?php if(in_array(170, $access_arry)){?>
							<div id="tabs-2" style="min-height: 500px;">
                                 <form id="" name="form" class="stdform" method="post" action="fpdf/ReportCableIn" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="p_id" class="chzn-select"  style="width:345px;">
												<option value="all"> All Cable </option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
												<option value="<?php echo $row['id'] ?>"><?php echo $row['pro_name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus2">
										<select data-placeholder="Choose a Zone" name="e_id" class="chzn-select"  style="width:345px;">
												<option value="all"> Purchase By All Employee </option>
											<?php while ($row=mysql_fetch_array($result1)) { ?>
												<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_name']?> - <?php echo $row['e_des']?> - <?php echo $row['e_id']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus3">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date" style="width:15%;"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date" style="width:15%;"/>
										</div>
									</div>
									<div class="animate_cus4">
										<button class="btn ownbtn2" style='width: 30%;' type="submit">SUBMIT</i></button>
									</div>
								</form>
                            </div>
							<?php } if(in_array(171, $access_arry)){?>
							<div id="tabs-3" style="min-height: 500px;">
                                <form id="" name="form" class="stdform" method="post" action="fpdf/ReportCableOut" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="p_id" class="chzn-select"  style="width:345px;">
												<option value="all"> All Cable </option>
											<?php while ($row=mysql_fetch_array($result3)) { ?>
												<option value="<?php echo $row['id'] ?>"><?php echo $row['pro_name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus2">
										<select data-placeholder="Choose a Zone" name="e_id" class="chzn-select"  style="width:345px;">
												<option value="all"> Use By All Employee </option>
											<?php while ($row=mysql_fetch_array($result2)) { ?>
												<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_name']?> - <?php echo $row['e_des']?> - <?php echo $row['e_id']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus3">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date" style="width:15%;"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date" style="width:15%;"/>
										</div>
									</div>
									<div class="animate_cus4">
										<button class="btn ownbtn2" style='width: 30%;' type="submit">SUBMIT</i></button>
									</div>
								</form>
                            </div>
							<?php } ?>
                        </div><!--tabbedwidget-->
						</center>
					</div>
				</div>
			</div>
		</div>
<?php
}
else{
	session_unset();
	session_destroy();
}
include('include/footer.php');
?>