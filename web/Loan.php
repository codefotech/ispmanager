<?php
$titel = "Loan";
$Loan = 'active';
include('include/hader.php');
extract($_POST);


//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Loan' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$this_month_yr = date('Y-m', time());
?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn" href="ReportLoanLedger">Ledger</a>
			<a class="btn btn-primary" href="LoanReceiveAdd"><i class="iconfa-plus"></i> Loan Receive</a>
			<a class="btn btn-primary" href="LoanPaymentAdd"><i class="iconfa-plus"></i> Loan Payment</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Loan</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		

				<div class="box">
                         <div class="box-header">
                             <h3 class="box-title">List of Loan Receive </h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                             <table class="table responsive table-bordered">
                                 <thead>
                                     <tr>
                                         <th>ID </th>
                                         <th>Date </th>
                                         <th>Loan From</th>
                                         <th>Receive To</th>
                                         <th>Amount</th>
                                         <th>Note</th>
                                         <th class='center'>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
									<?php
										$sql = mysql_query("SELECT a.id, b.bank_name, t.name, a.amount, a.loan_date, a.note FROM loan_receive AS a
													LEFT JOIN loan_from AS t ON t.id = a.loan_from
													LEFT JOIN bank AS b ON b.id = a.bank
													ORDER BY a.id DESC LIMIT 100");
										while( $row = mysql_fetch_assoc($sql) )
										{
											$yrdata1= strtotime($row['loan_date']);
											$month_yr = date('Y-m', $yrdata1);
											
											if($this_month_yr == $month_yr){
												$aaaa = "<form action='LoanDelete' method='post'><input type='hidden' name='loan_id' value='{$row['id']}' /><button class='btn col5' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form>";
											}
											else{
												$aaaa = "";
											}
											echo
												"<tr>
													<td>{$row['id']}</td>
													<td>{$row['loan_date']}</td>
													<td>{$row['name']}</td>
													<td>{$row['bank_name']}</td>
													<td><a href='#'>{$row['amount']}</a></td>
													<td>{$row['note']}</td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li>{$aaaa}</li>
														</ul>
													</td>
												</tr>";
										}  
									?>
                                 </tbody>
                             </table>
                         </div>
                         <!-- /.box-body -->
                     </div>		
	<div class="box">
                         <div class="box-header">
                             <h3 class="box-title">List of Loan Payment </h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                             <table class="table responsive table-bordered">
                                 <thead>
                                     <tr>
                                         <th>Id </th>
                                         <th>Date </th>
                                         <th>Payment To</th>
                                         <th>Payment From</th>
                                         <th>Amount </th>
                                         <th>Note </th>
                                         <th class='center'>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
									<?php
										$sql = mysql_query("SELECT a.id, b.bank_name, t.name, a.amount, a.payment_date, a.note FROM loan_payment AS a
													LEFT JOIN loan_from AS t ON t.id = a.loan_payment_to
													LEFT JOIN bank AS b ON b.id = a.bank
													ORDER BY a.id DESC LIMIT 100");
										while( $row = mysql_fetch_assoc($sql) )
										{
											$yrdata12= strtotime($row['payment_date']);
											$month_yrr = date('Y-m', $yrdata12);
											
											if($month_yrr == $month_yr){
												$aaaa1 = "<form action='LoanPaymentDelete' method='post'><input type='hidden' name='loan_id' value='{$row['id']}' /><button class='btn col5' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form>";
											}
											else{
												$aaaa1 = "";
											}
											echo
												"<tr>
													<td>{$row['id']}</td>
													<td>{$row['payment_date']}</td>
													<td>{$row['name']}</td>
													<td>{$row['bank_name']}</td>
													<td><a href='#'>{$row['amount']}</a></td>
													<td>{$row['note']}</td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li>{$aaaa1}</li>
														</ul>
													</td>
												</tr>";
										}  
									?>
                                 </tbody>
                             </table>
                         </div>
                         <!-- /.box-body -->
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
			"iDisplayLength": 20,
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