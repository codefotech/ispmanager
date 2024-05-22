<?php
$titel = "Fiber Store In Details";
$Store = 'active';
include('include/hader.php');
$pid = $_GET['pid'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(191, $access_arry)){
//---------- Permission -----------

$result1y = mysql_query("SELECT SUM(fibertotal) AS totalsize, SUM(fibertotal_out) AS totalout, (SUM(fibertotal) - SUM(fibertotal_out)) AS remain, SUM(price) AS totalprice FROM store_in_out_fiber WHERE `status` = '0' AND p_id = '$pid'");
$row2226 = mysql_fetch_assoc($result1y);

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<a class="btn ownbtn3" href="Fiber">Fiber Details</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Fiber Purchase Details</h1>
        </div>
    </div><!--pageheader-->
		<?php if($sts == 'main') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Edite Success!!</strong>
		</div><!--alert-->
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header" style="margin-bottom: -7px;">
				<h4><b><?php if($pid == ''){?> Fiber Summary <?php } else{ echo 'Intotal Fiber: '.$row2226['totalsize'].' Meter & Total Price: '.$row2226['totalprice'].' ৳  & Total Out: '.$row2226['totalout'].' Meter & Remaining: '.$row2226['remain'].' Meter'; }?></b></h4>
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
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">S/L</th>
							<th class="head1 center">Buy Date & Buyer</th>
							<th class="head0">S/L & Fiber ID</th>
							<th class="head1">Name/Brand/Condition</th>
							<th class="head0">Vendor</th>
							<th class="head0 center">Price</th>
							<th class="head0 center">Total_In</th>
							<th class="head1 center">Total_Out</th>
							<th class="head0 center">Remaining</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($pid == ''){
							$sql = mysql_query("SELECT i.id, DATE_FORMAT(i.purchase_date, '%D %M, %Y') AS purchasedate, i.purchase_date, i.entry_by, i.p_id, e.e_name AS purchase_by, v.v_name AS vendor, i.p_sts, i.p_sl_no, p.pro_name, i.brand, IF(i.fiber_id=0,NULL,i.fiber_id) AS fiber_id, IF(i.fibertotal=0,NULL,i.fibertotal) AS fibertotal, i.fibertotal_out, (i.fibertotal - i.fibertotal_out) AS remaining, i.price, a.e_name AS entryby, i.entry_time, CASE WHEN i.sts = 0 THEN 'Ready To Out' ELSE 'Already Out' END AS sts, i.rimarks FROM store_in_out_fiber AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN fiber AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by WHERE i.status = '0'
													ORDER BY i.purchase_date DESC");
						}
						else{
							$sql = mysql_query("SELECT i.id, DATE_FORMAT(i.purchase_date, '%D %M, %Y') AS purchasedate, i.purchase_date, i.voucher_no, i.p_id, i.entry_by, e.e_name AS purchase_by, v.v_name AS vendor, i.p_sts, i.p_sl_no, p.pro_name, i.brand, IF(i.fiber_id=0,NULL,i.fiber_id) AS fiber_id, IF(i.fibertotal=0,NULL,i.fibertotal) AS fibertotal, i.fibertotal_out, (i.fibertotal - i.fibertotal_out) AS remaining, i.price, a.e_name AS entryby, i.entry_time, CASE WHEN i.sts = 0 THEN 'Ready To Out' ELSE 'Already Out' END AS sts, i.rimarks FROM store_in_out_fiber AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN fiber AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by WHERE i.status = '0' AND  i.p_id = '$pid'
													ORDER BY i.purchase_date DESC");
						}
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['rimarks'] != ''){
											$textt = "<i class='iconfa-info-sign'></i>";
										}
										else{
											$textt = '';
										}
									if($row['fibertotal_out'] != '0'){
										if(in_array(192, $access_arry)){
											$fff = "<a data-placement='top' data-rel='tooltip' href='FiberStoreOutDetails?st_id={$row['id']}' style='font-size: 15px;'>{$row['fibertotal_out']} M</a>";
											$dddd = '';
											}
											else{
											$fff = "{$row['fibertotal_out']} M";
											$dddd = '';
											}
										}
										else{
											if(in_array(193, $access_arry)){
											$fff = "{$row['fibertotal_out']}";
											$dddd = "<li><form action='StoreInDelete' method='post'>
													<input type='hidden' name='id' value='{$row['id']}'/>
													<input type='hidden' name='store_type' value='fiber'/>
													<input type='hidden' name='e_id' value='{$e_id}'/>
													<input type='hidden' name='entryby' value='{$row['entryby']}'/>
													<input type='hidden' name='entry_by' value='{$row['entry_by']}'/>
													<button class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>";
											}
											else{
											$fff = "{$row['fibertotal_out']} M";
											$dddd = '';
											}
										}
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;padding: 20px 5px;'>{$row['id']}</td>
											<td class='center'><b>{$row['purchasedate']}</b><br>by<br>{$row['purchase_by']}</td>
											<td>{$row['p_sl_no']}<br>{$row['fiber_id']}</td>
											<td><b style='font-size: 14px;color: brown;'>{$row['pro_name']}</b><br>{$row['brand']}<br>{$row['p_sts']}</td>
											<td><div class='myDIVV'>{$row['vendor']} {$textt}</div><div class='hidee'>{$row['rimarks']}</div></td>
											<td class='center' style='padding: 20px 0px;font-size: 15px;color: maroon;'><b>{$row['price']}</b></td>
											<td class='center' style='padding: 20px 0px;font-size: 15px;color: green;'><b>{$row['fibertotal']} M</b></td>
											<td class='center' style='padding: 20px 0px;'><b>{$fff}</b></td>
											<td class='center' style='padding: 20px 0px;font-size: 17px;color: gray;'><b>{$row['remaining']} M</b></td>
											<td class='center'>
												<ul class='tooltipsample'>
													{$dddd}
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
			</div>			
		</div>
<?php } else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
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
</script>
<style>
#dyntable_length{display: none;}

.hidee {
  display: none;
}
    
.myDIVV:hover + .hidee {
  display: block;
  color: red;
  font-weight: bold;
  margin-top: 10px;
}
</style>