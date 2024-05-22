<?php
$titel = "Store";
$Store = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$type = $_GET['id'];
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$sql = mysql_query("SELECT p.id AS ppp_id, p.pro_name, p.pro_details, IFNULL(s.inqty,0) AS inqty, IFNULL(s.outqty,0) AS outqty, IFNULL(s.remainingqty,0) AS remainingqty FROM product AS p
					LEFT JOIN
					(SELECT i.id, i.p_id, i.inqty, IFNULL(o.qty, 0) AS outqty, (i.inqty - (IFNULL(o.qty, 0))) AS remainingqty from
						(SELECT id, SUM(quantity) AS inqty, p_id FROM store_in_instruments GROUP BY p_id) AS i
						LEFT JOIN
						(SELECT p_id, IFNULL(SUM(qty), 0) AS qty FROM store_out_instruments GROUP BY p_id) AS o
						ON i.p_id = o.p_id
						GROUP BY i.p_id) AS s
						ON s.p_id = p.id WHERE p.sts = '0' ORDER BY p.pro_name");

$sql1 = mysql_query("SELECT * FROM fiber WHERE sts = '0' ORDER BY pro_name ASC");
?>
	<div class="pageheader">
		<div class="searchbar">
		<?php if(in_array(183, $access_arry) || in_array(184, $access_arry) || in_array(189, $access_arry) || in_array(190, $access_arry)){ ?>
			<a class="btn ownbtn2" href="Instruments"> Instruments</a>
		<?php } if(in_array(185, $access_arry) || in_array(186, $access_arry) || in_array(191, $access_arry) || in_array(192, $access_arry)){?>
			<a class="btn ownbtn3" href="Fiber"> Fiber</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-qrcode"></i></div>
        <div class="pagetitle">
            <h1>Store</h1>
        </div>
    </div><!--pageheader-->
<?php if(in_array(181, $access_arry) || in_array(182, $access_arry)){ if(in_array(181, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<h4><b>Instruments Summary</b></h4>
		</div>
			<div class="box-body">
				<table id="dyntable2" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">S/L</th>
							<th class="head1">Item Name</th>
                            <th class="head0">Stock In</th>
							<th class="head1">Stock Out</th>
							<th class="head0">Remaining Stock</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowq = mysql_fetch_assoc($sql) )
								{
									$ee = number_format($rowq['inqty'],0);
									$ww = number_format($rowq['outqty'],0);
									$qq = number_format($rowq['remainingqty'],0);
									if($ee != '0' && in_array(189, $access_arry)){
										$hhh = "<a data-placement='top' data-rel='tooltip' href='InstrumentsStoreInDetails?pid={$rowq['ppp_id']}' style='font-size: 16px;'>{$ee}</a>";
									}
									else{
										$hhh = "{$ee}";
									}
									
									if($ww != '0' && in_array(190, $access_arry)){
										$fff = "<a data-placement='top' data-rel='tooltip' href='InstrumentsStoreOutDetails?pid={$rowq['ppp_id']}' style='font-size: 16px;'>{$ww}</a>";
									}
									else{
										$fff = "{$ww}";
									}
									echo
										"<tr class='gradeX'>
											<td style='font-size: 16px;font-weight: bold;vertical-align: middle;text-align: center;width: 25px;'>$x</b></td>
											<td style='vertical-align: middle;font-weight: bold;font-size: 14px;'>{$rowq['pro_name']}</td>
											<td style='vertical-align: middle;font-weight: bold;'>{$hhh}</td>
											<td style='vertical-align: middle;font-weight: bold;'>{$fff}</td>
											<td><b style='font-size: 18px;'>{$qq}</b></td>
											
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>			
	</div>
<?php } if(in_array(182, $access_arry)){?>
<div class="box box-primary">
		<div class="box-header">
			<h4><b>Fiber Summary</b></h4>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">S/L</th>
							<th class="head1">Item Name</th>
                            <th class="head0">Stock In (Meter)</th>
							<th class="head1">Stock Out (Meter)</th>
							<th class="head0">Remaining (Meter)</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql1) )
								{
									$pro_name = $row['pro_name'];
									$id2 = $row['id'];										
										$sqls = mysql_query("SELECT id, IFNULL(SUM(fibertotal), 0) AS tolt_in, IFNULL(SUM(fibertotal_out), 0) AS tolt_out FROM store_in_out_fiber WHERE p_id = '$id2' AND status = '0'");
										$res = '';
										$res1 = mysql_fetch_array($sqls);
										$aa = $res1['tolt_in'];
										$bb = $res1['tolt_out'];
										$totl_fiber = $aa - $bb;
										
										if($aa != '0' && in_array(191, $access_arry)){
											$fff = "<a data-placement='top' data-rel='tooltip' href='FiberStoreInDetails?pid={$id2}' style='font-size: 16px;'>{$aa} M</a>";
										}
										else{
											$fff = "{$aa}";
										}
										
										if($bb != '0' && in_array(192, $access_arry)){
											$hhh = "<a data-placement='top' data-rel='tooltip' href='FiberStoreOutDetails?pid={$id2}' style='font-size: 16px;'>{$bb} M</a>";
										}
										else{
											$hhh = "{$bb}";
										}
									
									echo
										"<tr class='gradeX'>
											<td style='font-size: 16px;font-weight: bold;vertical-align: middle;text-align: center;width: 25px;'>$x</td>
											<td style='vertical-align: middle;font-weight: bold;font-size: 14px;'>{$row['pro_name']}</td>
											<td style='vertical-align: middle;font-weight: bold;'>{$fff}</td>
											<td style='vertical-align: middle;font-weight: bold;'>{$hhh}</td>
											<td><b style='font-size: 18px;'>{$totl_fiber} M</b></td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>			
	</div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			

<?php
}}}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'asc']],
            "sScrollY": "800px"
        });
    });
</script>

<style>
#dyntable_length{display: none;}
.hhhhh{font-weight: bold;font-size: 14px;}
</style>