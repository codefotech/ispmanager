<?php
$titel = "Employee";
$Employee = 'active';
include('include/hader.php');
include("conn/connection.php");
$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$query = mysql_query("SELECT * from emp_info where e_id ='$id'");
$row = mysql_fetch_assoc($query);

$a = $row['e_name'];
$b = $row['e_id'];
$c = $row['e_dept'];
$d = $row['e_f_name'];
$e = $row['e_m_name'];
$f = $row['e_gender'];
$g = $row['e_b_date'];
$h = $row['e_des'];
$i = $row['per_address'];
$j = $row['e_pe_dis'];
$k = $row['e_pe_tha'];
$l = $row['pre_address'];
$m = $row['e_pr_dis'];
$n = $row['e_pr_tha'];
$o = $row['e_j_date'];
$p = $row['married_stu'];
$q = $row['exp1'];
$r = $row['exp2'];
$s = $row['exp3'];
$t = $row['e_cont_per'];
$u = $row['e_cont_office'];
$v = $row['e_cont_family'];
$w = $row['ref_contact1'];
$x = $row['ref_contact2'];
$y = $row['ref_contact3'];
$z = $row['email'];
$aa = $row['skype'];
$aaa = $row['e_image'];
?>
<link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css" />
<link rel="stylesheet" href="css/resume.css" type="text/css" />
	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=1050, height=800, left=50, top=25";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/resume_print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/reset-fonts-grids_print.css" type="text/css" />');
		   docprint.document.write('<head><title>Nepia</title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
	
<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<button class="btn ownbtn1" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Employee</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<h5>Employee Information</h5>
		</div>
		<div class="box-body">
			<div id="divid">
				<div id="doc2" class="yui-t7">
					<div id="inner">
						<div id="hd">
							<div class="yui-gc">
								<div class="yui-u first">
									<h1><?php echo $a; ?></h1>
									<h2><?php echo $h; ?></h2>
									<h2><?php echo $c; ?></h2>
									<a href=""><?php echo $z; ?></a>
									<h3><?php echo $u; ?></h3>
								</div>
								<div class="yui-u">
									<div class="contact-info userloggedinfo1">
										<img src="<?php echo $aaa; ?>" alt="" height=80px; width=80px; />										
									</div><!--// .contact-info -->
								</div>
							</div><!--// .yui-gc -->
						</div><!--// hd -->
							<div id="yui-main">
								<div class="yui-b">

									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Profile</h2>
										</div>
										<div class="yui-u">
												<div class="talent">
													<h2><b style="padding-right:4px;">Father:</b> &nbsp; &nbsp;<?php echo $d; ?></h2>
													<h2><b style="padding-right:0px;">Mother:</b> &nbsp; &nbsp;<?php echo $e; ?></h2>
													<h2><b style="padding-right:0px;">Gender:</b> &nbsp; &nbsp;<?php echo $f; ?></h2>
												</div>
												
												<div class="talent">
													<h2><b style="padding-right:7px;">Date of Birth:</b> &nbsp; &nbsp;<?php echo $g; ?></h2>
													<h2><b style="padding-right:8px;">Joining Date:</b> &nbsp; &nbsp;<?php echo $o; ?></h2>
													<h2><b>Marital Status:</b> &nbsp; &nbsp;<?php echo $p; ?></h2>
												</div>
										</div>
									</div><!--// .yui-gf -->
									<?php $sql1 = mysql_query("SELECT * from emp_edu_info where e_id ='$id'"); 
										$row1 = mysql_fetch_assoc($sql1);
										if($row1==0){} 
										else{ 
										?>
									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Education</h2>
										</div>
										<div class="yui-u">
											<table class="abctable" width="100%" border="1">
												<thead>
													<tr>
														<th><b>Degree</b></th>
														<th><b>Institution Name</b></th>
														<th><b>Group/Subject</b></th>
														<th><b>Result</b></th>
													</tr>
												</thead>
												<tbody class="abcd123">
													<?php
														$sqls = mysql_query("SELECT * from emp_edu_info where e_id ='$id'");
														while( $rows = mysql_fetch_assoc($sqls) )
															{
																echo
																	"<tr>
																		<td>{$rows['edu_fild']}</td>
																		<td>{$rows['edu_inst']}</td>
																		<td>{$rows['edu_group']}</td>
																		<td>{$rows['edu_result']}</td>
																	</tr>\n ";
															}  
													?>
												</tbody>
											</table>
										</div>
									</div><!--// .yui-gf -->
									<?php } ?>
									<?php 
									if($q==0 && $s==0 && $r==0){}
									else{
									?>

									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Experience</h2>
										</div>
										<div class="yui-u">
											<div class="talent">
												<p><?php echo $q; ?></p> <br />
												<p><?php echo $s; ?></p>
											</div>

											<div class="talent">
												<p><?php echo $r; ?></p>
											</div>
										</div>
									</div><!--// .yui-gf-->
									<?php } ?>
									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Address</h2>
										</div>
										<div class="yui-u">
											<div class="talent">
											<h2><b>Present Address</b></h2>
												<p><?php echo $l; ?><br> <?php echo $m; ?><br> <?php echo $n; ?></p>
											</div>

											<div class="talent">
											<h2><b>Permanent Address</b></h2>
												<p><?php echo $i; ?><br> <?php echo $j; ?><br> <?php echo $k; ?></p>
											</div>
										</div>
									</div><!--// .yui-gf-->
									<div class="yui-gf">
					
										<div class="yui-u first">
											<h2 style="font-size:14px;">Contacts</h2>
										</div><!--// .yui-u -->
										<div class="yui-u">

												<div class="talent">
													<h2><b style="padding-right:18px;">Office:</b> &nbsp; &nbsp;<?php echo $u; ?></h2>
													<h2><b>Personal:</b> &nbsp; &nbsp;<?php echo $t; ?></h2>
													<h2><b style="padding-right:13px;">Family:</b> &nbsp; &nbsp;<?php echo $v; ?></h2>
												</div>
												
												<div class="talent">
													<h2><b>Reference:</b> &nbsp; &nbsp;<?php echo $w; ?></h2>
													<h2><b>Reference:</b> &nbsp; &nbsp;<?php echo $x; ?></h2>
													<h2><b>Reference:</b> &nbsp; &nbsp;<?php echo $y; ?></h2>
												</div>

										</div>
									</div><!--// .yui-gf -->
									
								</div><!--// .yui-b -->
							</div><!--// yui-main -->
						<div id="ft">
							<p><?php echo $CompanyName; ?> &mdash; <a href=""><?php echo $CompanyEmail; ?></a> &mdash; <?php echo $CompanyPhone; ?></p>
						</div><!--// footer -->
					</div><!-- // inner -->
				</div><!--// doc -->
			</div>
		</div>	
		<div class="modal-footer">
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<button class="btn ownbtn1" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')">Print</button>
		</div>
	</div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>