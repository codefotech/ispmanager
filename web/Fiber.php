<?php
$titel = "Store Cable";
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

$sql1 = mysql_query("SELECT * FROM fiber WHERE sts = '0' ORDER BY pro_name ASC");
?>
	<div class="pageheader">
		<div class="searchbar">
		<?php if(in_array(185, $access_arry)){?>
			<a class="btn ownbtn2" href="ProductInFiber"><i class="iconfa-signin"></i>  IN </a>
		<?php } if(in_array(186, $access_arry)){?>
			<a class="btn ownbtn1" href="ProductOutFiber"><i class="iconfa-signout"></i>  OUT </a>
		<?php } if(in_array(191, $access_arry)){?>
			<a class="btn ownbtn8" href="FiberStoreInDetails"> Purchase Details </a>
		<?php } if(in_array(192, $access_arry)){?>
			<a class="btn ownbtn6" href="FiberStoreOutDetails"> Store Out Details </a>
		<?php } if(in_array(197, $access_arry)){?>
			<a class="btn ownbtn5" href="Fibers"> Fibers </a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-qrcode"></i></div>
        <div class="pagetitle">
            <h1>Store Fiber</h1>
        </div>
    </div><!--pageheader-->
<?php if(in_array(182, $access_arry)){?>
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
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">S/L</th>
							<th class="head1">Fiber Name</th>
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
									$id = $row['id'];										
										$sqls = mysql_query("SELECT id, IFNULL(SUM(fibertotal), 0) AS tolt_in, IFNULL(SUM(fibertotal_out), 0) AS tolt_out FROM store_in_out_fiber WHERE p_id = '$id' AND status = '0'");
										$res = '';
										$res1 = mysql_fetch_array($sqls);
										$aa = $res1['tolt_in'];
										$bb = $res1['tolt_out'];
										$totl_fiber = $aa - $bb;
										
										if($aa != '0' && in_array(191, $access_arry)){
											$fff = "<a data-placement='top' data-rel='tooltip' href='FiberStoreInDetails?pid={$id}' style='font-size: 13px;'>{$aa} M</a>";
										}
										else{
											$fff = "{$aa}";
										}
										
										if($bb != '0' && in_array(192, $access_arry)){
											$hhh = "<a data-placement='top' data-rel='tooltip' href='FiberStoreOutDetails?pid={$id}' style='font-size: 13px;'>{$bb} M</a>";
										}
										else{
											$hhh = "{$bb}";
										}
										
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$row['pro_name']}</td>
											<td><b>{$fff}</b></td>
											<td><b>{$hhh}</b></td>
											<td><b>{$totl_fiber} M</b></td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>			
	</div>
<?php }}
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
    });
</script>

<style>
#dyntable_length{display: none;}
</style>