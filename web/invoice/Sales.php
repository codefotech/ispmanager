<?php
session_start();
include("../conn/connection.php") ;
extract($_POST);
$e_id = $_SESSION['SESS_EMP_ID'];

date_default_timezone_set('Asia/Dhaka');

if ($sts=='return'){
		$sql11 = mysql_query("SELECT clientId, clientName, clients_phone, clients_address FROM clients ORDER BY clientId DESC LIMIT 1");
		$row = mysql_fetch_array($sql11);
		
		$clientId1 = $row['clientId'];
		$clientName1 = $row['clientName'];
		$clients_phone1 = $row['clients_phone'];
		$clients_address1 = $row['clients_address'];
		$sss= $clientName1.' - '.$clients_phone1;
}

$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'invoice/Sales' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="../../favicon.ico">

    <title>Sales</title>

    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Noto+Serif:400,700"> 
    <!-- Bootstrap core CSS -->
    <link href="css/jquery-ui.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <script src="js/ie.js"></script>

  </head>

  <body>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form method="POST" action="ClientSave">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"> New Client </h4>
			  </div>
			  <div class="modal-body">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Clint Name</div>
						<input type="text" class="form-control" id="" name="ClintName" placeholder="Clint name" ondrop="return false;" onpaste="return false;">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Phone No &nbsp;&nbsp;</div>
						<input type="text" class="form-control" id="" name="ClintPhone" placeholder="Phone no" ondrop="return false;" onpaste="return false;">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Address   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<input type="text" class="form-control" id="" name="ClintAddress" placeholder="Address" ondrop="return false;" onpaste="return false;">
					</div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			  </div>
			</div>
		  </div>
		</form> 
	</div>
	
	
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"> <a href="../welcome"><i class="fa fa-home"></i>Home</a> </li>
            <li><a href="Sales"><i class="fa fa-bank"></i>Sales </a></li>
            <!--<li><a href="Stock">Stock</a></li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container content">
		<br>
		<form method="POST" action="SalesSave">
			<input type="hidden" value="<?php echo $e_id; ?>" name="EntBy" />
			<input type="hidden" name="EntDate" value="<?php echo date('Y-m-d h:i:s'); ?>" />
			<div class='row'>
				<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
					<input type="hidden" name="clientId" data-type="clientId" class="form-control autocompleteClint" id="clientId" value="<?php echo $clientId1;?>" autocomplete="off" placeholder="Client Id">
					<div class="form-group">
						<input type="text" name="clientName" data-type="clientName" class="form-control autocompleteClint" id="clientName" value="<?php echo $sss;?>" autocomplete="off" placeholder="Client Name">
					</div>
					<!--
					<div class="form-group">
						<input type="text" name="clientCell" class="form-control" id="clientCell" placeholder="Client Cell No">
					</div>
					-->
					<div class="form-group">
						<textarea class="form-control" name="clientAddress" rows='1' id="clientAddress"  placeholder="Client Address"><?php echo $clients_address1;?></textarea>
					</div>
					
				</div>
				<div class='col-xs-12 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-4 col-md-4 col-lg-4'>
					<div class="form-group">
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Add New Client</button>
					</div>
					<div class="form-group">
						<input type="date" name="invoiceDate" required="" readonly class="form-control" value="<?php echo date('Y-m-d');?>" id="" placeholder="Invoice Date">
						<input type="time" name="invoiceTime" class="form-control" readonly value="<?php echo date("h:i:s");?>" id="" placeholder="Invoice Time">
					</div>
					<!--<div class="form-group">
						<input type="text" class="form-control amountDue" id="amountDueTop" onkeypress="return IsNumeric(event);" placeholder="Amount Due">
					</div>-->
				</div>
			</div>
			<br>
			<div class='row'>
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
								<th width="15%">Item No</th>
								<th width="23%">Item Name</th>
								<th width="15%">Model</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input class="case" type="checkbox"/></td>
								<td><input type="text" data-type="productCode" name="itemNo[]" required="" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off"></td>
								<td><input type="text" data-type="productName" name="itemName[]" required="" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off"></td>
								<td><input type="text" data-type="model_name" name="itemModel[]" id="itemModel_1" class="form-control autocompleteModel" autocomplete="off"></td>
								<td><input type="text" name="price[]" id="price_1" class="form-control changesNo" readonly autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
								<td><input type="text" name="quantity[]" id="quantity_1" class="form-control changesNo" required="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
								<td><input type="text" name="total[]" id="total_1" class="form-control totalLinePrice" readonly autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class='row'>
				<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
					<button class="btn btn-danger delete" type="button"> Delete </button>
					<button class="btn btn-success addmore" type="button"> Add More </button>
				</div>
			</div>	
			<div class='row'>
				<div class='col-xs-12 col-sm-8 col-md-8 col-lg-7'>
					<h3>Notes: </h3>
					<div class="form-group">
						<textarea class="form-control" name="invoiceNote" rows='3' id="notes" placeholder="Sales Note......."></textarea>
					</div>
				</div>
				<div class='col-xs-12 col-sm-4 col-md-4 col-lg-5'>
					<div class="form-inline">
						<div class="form-group">
							<label>Subtotal: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">৳</div>
								<input type="text" class="form-control" id="subTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<div class="form-group">
							<label>Discount: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">৳</div>
								<input type="text" name="discount" class="form-control" id="tax" placeholder="Discount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<div class="form-group">
							<label>Total: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">৳</div>
								<input type="text" class="form-control" name="paidAmount" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<!--
						<div class="form-group">
							<label>Amount Paid: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" name="paidAmount" class="form-control" required="" id="amountPaid" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<div class="form-group">
							<label>Amount Due: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" class="form-control amountDue" id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
			<div class='row'>
				<div class="form-group text-center">
					<input class="btn btn-success submit_btn invoice-save-btm" type="submit" value="Save Invoice" name="invoice_btn" data-loading-text="Saving Invoice...">
				</div>
			</div>
		</form>	
    </div>

	<h2>&nbsp;</h2>
    <footer class="footer">
      <div class="container">
        <p class="text-muted text-center" style="color:#fff">© 2016. Agrotec Group, All Rights Reserved. v2.3</p>
      </div>
    </footer>


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/auto_sale.js"></script>
  </body>
</html>
<?php
}
else{
	header("location: ../index");
}
?>