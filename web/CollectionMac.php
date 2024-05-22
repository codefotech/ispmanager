<?php
$titel = "Collection";
$Billing = 'active';
include('include/hader.php');
include("conn/connection.php") ;

$dateTime = date('Y-m-d', time());
$today_date = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
if($user_type == 'billing'){
	if($today_date != ''){
$sql = mysql_query("SELECT p.id, p.pay_date, p.pay_date_time, p.sender_no, p.trxid, b.bank_name, c.c_id, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
					FROM payment AS p 
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN package AS pk ON c.p_id = pk.p_id
					LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
					LEFT JOIN bank AS b ON b.id = p.bank
					WHERE c.mac_user = '0' AND p.pay_ent_date = '$today_date' AND p.pay_ent_by = '$e_id' ORDER BY p.id ASC");
}
else{
$sql = mysql_query("SELECT p.id, p.pay_date, p.pay_date_time, p.sender_no, p.trxid, b.bank_name, c.c_id, c.address, c.cell, pk.p_price, p.pay_mode, pk.p_name, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
					FROM payment AS p 
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN package AS pk ON c.p_id = pk.p_id
					LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
					LEFT JOIN bank AS b ON b.id = p.bank
					WHERE c.mac_user = '0' AND p.pay_ent_by = '$e_id' ORDER BY p.id ASC");
}
}
else{
	
if($user_type == 'mreseller'){
if($today_date != ''){
$sql = mysql_query("SELECT p.id, p.pay_date, p.pay_date_time, p.sender_no, p.trxid, b.bank_name, c.c_id, c.address, c.cell, pk.p_price_reseller AS p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
					FROM payment_mac_client AS p 
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN package AS pk ON c.p_id = pk.p_id
					LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
					LEFT JOIN bank AS b ON b.id = p.bank
					WHERE c.mac_user = '1' AND p.pay_ent_date = '$today_date' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
}
else{
$sql = mysql_query("SELECT p.id, p.pay_date, p.pay_date_time, p.sender_no, p.trxid, b.bank_name, c.c_id, c.address, c.cell, pk.p_price_reseller AS p_price, p.pay_mode, pk.p_name, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
					FROM payment_mac_client AS p 
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN package AS pk ON c.p_id = pk.p_id
					LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
					LEFT JOIN bank AS b ON b.id = p.bank
					WHERE c.mac_user = '1' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
}
}
else{
if($today_date != ''){
$sql = mysql_query("SELECT p.id, p.pay_date, p.pay_date_time, p.sender_no, p.trxid, b.bank_name, c.c_id, c.address, c.cell, pk.p_price, pk.p_name, p.pay_mode, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
					FROM payment AS p 
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN package AS pk ON c.p_id = pk.p_id
					LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
					LEFT JOIN bank AS b ON b.id = p.bank
					WHERE c.mac_user = '0' AND p.pay_ent_date = '$today_date' ORDER BY p.id ASC");
}
else{
$sql = mysql_query("SELECT p.id, p.pay_date, p.pay_date_time, p.sender_no, p.trxid, b.bank_name, c.c_id, c.address, c.cell, pk.p_price, p.pay_mode, pk.p_name, p.pay_amount, p.bill_discount, p.pay_ent_by, e.e_name, p.pay_desc
					FROM payment AS p 
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN package AS pk ON c.p_id = pk.p_id
					LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
					LEFT JOIN bank AS b ON b.id = p.bank
					WHERE c.mac_user = '0' ORDER BY p.id ASC");
}
}}
$queryr = mysql_query("SELECT c_id, c_name, cell, address FROM clients ORDER BY c_name");
?>
	<div class="pageheader">
        <div class="searchbar">
			<!---<a class="btn btn-primary" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i>  New Payment</a>--->
			<a class="btn" href="Collection">All Collection</a>
			<a class="btn btn-primary" href="Collection?id=<?php echo $dateTime;?>">  Today's Collection</a>
			
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Collection</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<h5>All Collection List</h5>
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
							<th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Client ID/Mobile</th>
							<th class="head1">Package</th>
							<th class="head0">Discount</th>
							<th class="head1">Amount</th>
							<th class="head0">Mathod</th>
							<th class="head0">SenderNo/TrxId</th>
							<th class="head1">Recive by/Bank</th>
							<th class="head0">Note</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php

								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									$yrdata= strtotime($row['pay_date_time']);
									$date = date('d F, Y', $yrdata);
									$time = date('H:i', $yrdata);
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$date}</td>
											<td>{$row['c_id']}<br>{$row['cell']}<br>{$row['address']}</td>
											<td>{$row['p_name']}<br>{$row['p_price']}TK</td>
											<td>{$row['bill_discount']}</td>
											<td>{$row['pay_amount']}TK</td>
											<td>{$row['pay_mode']}</td>
											<td>{$row['sender_no']}<br>{$row['trxid']}</td>
											<td>{$row['e_name']}<br>{$row['bank_name']}</td>
											<td>{$row['pay_desc']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='BillPaymentView?id=",$id,"{$row['c_id']}' data-original-title='View' class='btn col1' target='_blank'><i class='iconfa-eye-open'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
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
</style>