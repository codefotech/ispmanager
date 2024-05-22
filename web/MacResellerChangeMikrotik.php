<?php
$titel = "Mac Reseller Bill History";
$MacReseller = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");
extract($_POST);
date_default_timezone_set('Etc/GMT-6');
$todayyy = date('m-Y', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' OR 'MacResellerBillHistory' AND $user_type = '1'");
if($user_type == 'mreseller'){
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '40' AND $user_type = '1' or $user_type = '2'");
}
else{
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '39' AND $user_type = '1' or $user_type = '2'");
}
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------


$resulterer=mysql_query("SELECT z.z_id, z.z_name, e.z_id, e.e_name AS resellername, e.e_id AS resellerid, m.Name AS mkname, e.mk_id FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id LEFT JOIN mk_con AS m ON m.id = e.mk_id WHERE z.z_id = '$z_id'");
$rowtt = mysql_fetch_assoc($resulterer);
$resellr_mk_id= $rowtt['mk_id'];

$sql = mysql_query("SELECT p1.p_id, p1.mk_profile AS mk1, IFNULL(c.c_id, '0') AS totalclient FROM `package` AS p1 
					LEFT JOIN (SELECT p_id, COUNT(c_id) AS c_id FROM clients WHERE z_id = '$z_id' GROUP BY p_id)c ON c.p_id = p1.p_id
					WHERE p1.`mk_id` = '$resellr_mk_id' AND p1.z_id = '$z_id' AND p1.status = '0'");

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
													
?>

	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>MAC Reseller Payments & History</h1>
        </div>
    </div><!--pageheader-->					

	<?php if($sts == 'add') {?>
	<div class="alert alert-success">
	<button data-dismiss="alert" class="close" type="button">&times;</button>
	<strong>Success!!</strong> Reseller Paymnet Successfully Added in Your System.</div><!--alert-->
	<?php } ?>
	
	<div class="box box-primary">
		<div class="box-header">
			<div class="box-body">			
					<div class="row">
						<div style="padding-left: 15px; width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 48%; float: left;">
								<tr>
									<td class="width30">MAC Owner</td>
									<td class="width70"><strong><?php echo $row22['e_name']; ?></strong></td>
								</tr>
								<tr>
									<td>Contact No</td>
									<td><?php echo $row22['e_cont_per']; ?></td>
								</tr>
								<tr>
									<td>Address</td>
									<td><?php echo $row22['pre_address']; ?></td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 48%; float: left; margin-left: 15px;">
								<tr>
									<td class="width30">MAC Area</td>
									<td class="width70"><strong><?php echo $row22['z_name']; ?></strong></td>
								</tr>
								<tr>
									<td>Total Clients</td>
									<td><?php echo $row22['totalclients']; ?></td>
								</tr>
								<tr>
									<td>Active Clients</td>
									<td><?php echo $row2['activeclients']; ?></td>
								</tr>
							</table>
						</div><!--col-md-6-->
					</div>

            <br />
            <div class="clearfix"><br /></div>
		<div style="width: 100%;">
			<div style="width: 100%;">
				<table style="width:100%;background: #fdfdfd;font-size: 16px;height: 30px;margin-bottom: 3px;border: 2px solid #bbcadd;">
					<tr>
						<th style="text-align:left;padding: 5px 0px 2px 15px;color: #317eac;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Reseller Bills & Payments</th>
						<th style="text-align:right;padding: 0px 5px 1px 0px;color: #317eac;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">	
						
						<a data-placement='top' data-rel='tooltip'  href='fpdf/ReportMacResellerLedger?id=<?php echo $zz_id; ?>' class='btn' target="_blank"><i class='iconfa-print'></i>Print</a></th>
					</tr>	
				</table>
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
						<col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">S/L</th>
							<th class="head0">Package ID</th>
							<th class="head1">Old Mikrotik Profile</th>
							<th class="head1">New Mikrotik Profile</th>
							<th class="head0">Total Clients</th>
							<th class="head0">packsts</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$x = 1;	
								while( $row7 = mysql_fetch_assoc($sql) ){
									
								if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
									$API->write('/ppp/profile/getall', false);
									$API->write('?name='.$row7['mk1']);
									$res=$API->read(true);

									$mk2 = $res[0]['name']; 
									
									if($row7['mk1'] == $mk2){
										$packsts = 'OK';
									}
									else{
										$packsts = 'No';
									}
								
								}
									else{echo 'Selected Network are not Connected.';}
								
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;'>{$x}</td>
											<td>{$row7['p_id']}</td>
											<td>{$row7['mk1']}</td>
											<td>{$mk2}</td>
											<td class=''><b>{$row7['totalclient']}</b></td>
											<td class=''><b>{$packsts}</b></td>
										</tr>\n";
										$x++;
								}
								
							?>
					</tbody>
				</table>
			</div>	
			
		</div>

	</div>		</div>	</div>	

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 30,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[2,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>

<style>
#dyntable_length{display: none;}
#dyntable2_length{display: none;}
.dataTables_filter{display: none;}
.tabco{font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;font-weight: bold;}
.subto{
	border-bottom: 1px solid #ddd;
	display: block;
	font-family: 'RobotoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-size: 13px;
	padding: 7px 20px 8px 0px;
}
.subto2{
	display: block;
	font-family: 'RobotoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-size: 13px;
	padding: 7px 20px 8px 0px;
}
.totamm {text-align: right;width: 24%;float: right; margin: 0px 80px 0px 0px;;}
.totamm h2{
text-align: center;
line-height: normal;
border: 1px solid #ccc;
background: #fcfcfc;
padding: 10px 30px;
width: 250px;}
.totamm h2 span{
	    display: block;
    font-size: 12px;
    text-transform: uppercase;
    color: #666;
}
</style>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>