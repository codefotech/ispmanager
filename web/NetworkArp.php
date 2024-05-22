<?php
$titel = "Network Active Conniction";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = $_GET['id'];
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ip/arp/getall');
								$ssss = count($arrID);
}

?>
	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-screenshot"></i></div>
        <div class="pagetitle">
            <h1>ARP List</h1>
        </div>
    </div><!--pageheader-->					
	<?php if($sts == 'inactive') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Inactive from Your Mikrotik.			
	</div><!--alert-->
	<?php } if($sts == 'macadd') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> MAC Address Successfully added in Mikrotik PPPoE and Application.			
	</div><!--alert-->
	<?php } ?>
		<div class="box box-primary">
			<div class="box-header" style="font-size: 20px;padding: 15px 0px 2px 15px;">
				Total ARP:  <i style='color: #317EAC'><?php echo "$ssss"; ?></i>
			</div>
			<div class="box-body">
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">ID/Name/Cell/Zone</th>
							<th class="head1">Bandwidth</th>
							<th class="head0">Deadline</th>
							<th class="head1">IP</th>
							<th class="head0">Mac</th>
							<th class="head1 center">MissMatch</th>
							<th class="head0 center">Status</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ip/arp/getall');
								foreach($arrID as $x => $x_value) {
									
									$aaaaa = $x_value['address'];
									$mkmac = $x_value['mac-address'];
									$sql44 = mysql_query("SELECT c.c_name, c.c_id, c.payment_deadline, m.Name, p.mk_profile, c.raw_download, c.raw_upload, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, c.ip, c.mac FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												WHERE c.ip = '$aaaaa' ORDER BY c.id DESC");
									$rows1 = mysql_fetch_assoc($sql44);
									
									$cid = $rows1['c_id'];
									$app_download = $rows1['raw_download'];
									$app_upload = $rows1['raw_upload'];
									$bothdownloadupload = $app_upload.'M/'.$app_download.'M';
									
									$download = $rows1['raw_download'] * 1000000;
									$upload = $rows1['raw_upload'] * 1000000;
									$downloadupload = $upload.'/'.$download;
									
									$sqlcon = mysql_query("SELECT s.c_id, s.con_sts, DATE_FORMAT(s.update_date, '%D %M %Y') AS update_date, s.update_time, s.update_by, e.e_name FROM con_sts_log AS s 
									LEFT JOIN emp_info AS e ON e.e_id = s.update_by
									LEFT JOIN clients AS c ON c.c_id = s.c_id 
									WHERE c.ip = '$cid' AND s.con_sts = 'Inactive' ORDER BY s.id DESC LIMIT 1");
									$rowcon = mysql_fetch_assoc($sqlcon);
									
									if($rows1['c_name'] == ''){
										$colorrrr = 'style="color: red;"'; 
										$qqqqq = 'ID Not Matched'; 
										$bbbbb = '';
										$wwww = 'Not found in application databse';
										$dddd = "";
										} 
										else{
											$colorrrr = ''; 
											$qqqqq = "<a data-placement='top' data-rel='tooltip' href='ClientView?id=".$rows1['c_id']."' data-original-title='View Client' target='_blank' class='btn col1'><i class='fa iconfa-eye-open'></i></a>";
												if($x_value['disabled'] == 'false' && $rows1['con_sts'] == 'Active'){
													$clss = 'act';
													$ee = 'Active';
													$wwww = '';
													$colorrrr = '';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' class='btn {$clss}'>{$ee}</a>";
													$dddd = "";
												}
												if($x_value['disabled'] == 'true' && $rows1['con_sts'] == 'Inactive'){
													$clss = 'inact';
													$ee = 'Inactive';
													$colorrrr = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = $ee.' in application and Mikrotik Since '.$rowcon['update_date'].' by '.$empname.'.';
													$bbbbb = '';
													$dddd = "<a data-placement='top' data-rel='tooltip' style='color: red;' class='btn {$clss}' onclick='return checksts()'>Inactive</a>";
												}
												if($x_value['disabled'] == 'false' && $rows1['con_sts'] == 'Inactive'){
													$clss = 'inact';
													$ee = 'Inactive';
													$colorrrrq = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = $ee.' in application (Since '.$rowcon['update_date'].' by '.$empname.') but Active in Mikrotik.';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' href='NetworkActiveTOInactive?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Inactive him in Mikrotik</a>";
													$dddd = "OR<br><a data-placement='top' data-rel='tooltip' style='color: green;' href='ClientStatus?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Active him in Application</a>";
												}
												
												if($x_value['disabled'] == 'true' && $rows1['con_sts'] == 'Active'){
													$clss = 'inact';
													$ee = 'Active';
													$colorrrr = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = 'Inactive in Mikrotik but Active in application';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' style='color: green;' href='NetworkInactiveTOActive?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Active him in Mikrotik</a>";
													$dddd = "OR<br><a data-placement='top' data-rel='tooltip' href='ClientStatus?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Inactive him in Application</a>";
												}
										if($rows1['mac'] != $mkmac){
											$colorrrrr = 'style="color: red;"'; 
											$macccc = "
											<form action='MkToTisMac' method='post' enctype='multipart/form-data'>
												<input type='hidden' name='mk_id' value='{$mk_id}'/> 
												<input type='hidden' name='mkc_id' value='{$aaaaa}'/> 
												<input type='hidden' name='mkmac' value='{$mkmac}'/>
												<input type='hidden' name='c_id' value='{$rows1['c_id']}'/>
												<input type='hidden' name='breseller' value='1'/>
												<button class='btn col2'><i class='iconfa-signin'></i></button>
											</form>"; 
											$macnot = 'MK: '.$mkmac.'<br> AP: '.$rows1['mac'];
											$massmac = '<br>MAC Address are not same.';
										}
										else{
											$colorrrrr = ''; 
											$macccc = ""; 
											$macnot = 'MK: '.$mkmac.'<br> AP: '.$rows1['mac'];
											$massmac = '';
										}
											}
										
									
									echo "<tr class='gradeX'>
											<td $colorrrr><b>" . $rows1['c_id'] . "</b><br>". $rows1['c_name'] ."<br> ". $rows1['cell'] ."<br>" . $rows1['z_name']."</td>
											<td>" . $bothdownloadupload ."</td>
											<td>" . $rows1['payment_deadline'] ."</td>
											<td $colorrrr><b>" . $x_value['address'] ."</b></td>
											<td $colorrrrr><b>" . $macnot ."</b></td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr $colorrrrr><b>".$wwww.$massmac."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$bbbbb."<br>".$dddd."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$qqqqq."<br>".$macccc."</b></li>
												</ul>
											</td>
										</tr>";
									
								}
						}
						else{echo 'Selected Network are not Connected.';}
							?>
					</tbody>
				</table>
			</div>			
		</div>
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
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>