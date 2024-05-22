<?php
$titel = "Store Instruments";
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
?>
	<div class="pageheader">
		<div class="searchbar">
		<?php if(in_array(183, $access_arry)){?>
			<a class="btn ownbtn2" href="ProductInInstruments"><i class="iconfa-signin"></i>  IN </a>
		<?php } if(in_array(184, $access_arry)){?>
			<a class="btn ownbtn1" href="ProductOutInstruments"><i class="iconfa-signout"></i>  OUT </a>
		<?php } if(in_array(189, $access_arry)){?>
			<a class="btn ownbtn8" href="InstrumentsStoreInDetails"> Purchase Details </a>
		<?php } if(in_array(190, $access_arry)){?>
			<a class="btn ownbtn6" href="InstrumentsStoreOutDetails"> Store Out Details </a>
		<?php } if(in_array(187, $access_arry)){?>
			<a class="btn ownbtn5" href="Products"> Instruments </a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-qrcode"></i></div>
        <div class="pagetitle">
            <h1>Store Instruments</h1>
        </div>
    </div><!--pageheader-->
	<?php if(in_array(181, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<h4><b>Instruments Summary</b></h4>
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
										$hhh = "<a data-placement='top' data-rel='tooltip' href='InstrumentsStoreInDetails?pid={$rowq['ppp_id']}' style='font-size: 13px;'>{$ee}</a>";
									}
									else{
										$hhh = "{$ee}";
									}
									
									if($ww != '0' && in_array(190, $access_arry)){
										$fff = "<a data-placement='top' data-rel='tooltip' href='InstrumentsStoreOutDetails?pid={$rowq['ppp_id']}' style='font-size: 13px;'>{$ww}</a>";
									}
									else{
										$fff = "{$ww}";
									}
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$rowq['pro_name']}</td>
											<td><b>{$hhh}</b></td>
											<td><b>{$fff}</b></td>
											<td><b>{$qq}</b></td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>			
	</div>
	<?php } ?>
<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			

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