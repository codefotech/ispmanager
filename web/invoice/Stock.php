<?php
session_start();
include("../conn/connection.php") ;
extract($_POST);
$e_id = $_SESSION['SESS_EMP_ID'];

$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'invoice/Stock' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="jquery autocomplete invoice, jquery autocomplete invoice module, invoice using jqueryautocomplete, jquery invoice module  autocomplete, invoice using jquery autocomplete">
    <meta name="keywords" content="jquery autocomplete invoice, jquery autocomplete invoice module, invoice using jqueryautocomplete, jquery invoice module  autocomplete, invoice using jquery autocomplete">
    <meta name="author" content="muni">
    <link rel="icon" href="../../favicon.ico">

    <title>Invoice</title>

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

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"> <a href="../welcome"><i class="fa fa-home"></i>Home</a> </li>
            <!--<li><a href="Sales">Sales </a></li>-->
            <li><a href="Stock"><i class="fa fa-bank"></i>Stock</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container content">
		<br>
		<form method="POST" action="StockSave">
			<input type="hidden" value="<?php echo $e_id; ?>" name="EntBy" />
			<input type="hidden" name="EntDate" value="<?php echo date('Y-m-d h:i:s'); ?>" />
			<div class='row'> 
				<!---<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
					<input type="hidden" name="clientId" data-type="clientId" class="form-control autocompleteClint" id="clientId" autocomplete="off" placeholder="Client Id">
					<div class="form-group">
						<input type="text" name="clientName" data-type="clientName" class="form-control autocompleteClint" id="clientName" autocomplete="off" placeholder="Client Name">
					</div>
					<div class="form-group">
						<input type="text" name="clientCell" class="form-control" id="clientCell" placeholder="Client Cell No">
					</div>
					<div class="form-group">
						<textarea class="form-control" name="clientAddress" rows='1' id="clientAddress" placeholder="Client Address"></textarea>
					</div>
					
				</div>-->
				<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
					<div class="form-group">
						<input type="text" name="challanNo" class="form-control" id="challanNo" required="" placeholder="Challan No">
					</div>
					<div class="form-group">
						<input type="date" name="invoiceDate" readonly class="form-control" id="" required="" value="<?php echo date('Y-m-d h:i:s'); ?>" placeholder="Invoice Date">
						<input type="hidden" name="invoiceTime" class="form-control" value="<?php echo date("h:i:s");?>" id="" placeholder="Invoice Time">
					</div>
					<!---<div class="form-group">
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
								<th width="38%">Item Name</th>
								<th width="15%">Sale Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input class="case" type="checkbox"/></td>
								<td><input type="text" data-type="productCode" name="itemNo[]" id="itemNo_1" required="" class="form-control autocomplete_txt" autocomplete="off"></td>
								<td><input type="text" data-type="productName" name="itemName[]" id="itemName_1" required="" class="form-control autocomplete_txt" autocomplete="off"></td>
								<td><input type="text" name="price[]" id="price_1" class="form-control" readonly autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
								<td><input type="text" name="quantity[]" id="quantity_1" class="form-control changesNo" required="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
								<td><input type="text" name="total[]" id="total_1" class="form-control totalLinePrice" readonly autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class='row'>
				<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
					<button class="btn btn-danger delete" type="button">- Delete</button>
					<button class="btn btn-success addmore" type="button">+ Add More</button>
				</div>
			</div>	
			<div class='row'>
				<div class='col-xs-12 col-sm-8 col-md-8 col-lg-7'>
					<h3>Notes: </h3>
					<div class="form-group">
						<textarea class="form-control" name="invoiceNote" rows='3' id="notes" placeholder="Some Notes (Optional)"></textarea>
					</div>
				</div>
				<div class='col-xs-12 col-sm-4 col-md-4 col-lg-5'>
					<div class="form-inline">
						<!--<div class="form-group">
							<label>Subtotal: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" class="form-control" id="subTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<div class="form-group">
							<label>Discount: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" name="discount" class="form-control" id="tax" placeholder="Discount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>-->
						<div class="form-group">
							<label>Total: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" class="form-control" name="paidAmount" id="totalAftertax" placeholder="Total" readonly onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<!--<div class="form-group">
							<label>Amount Paid: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" name="paidAmount" class="form-control amountDue" id="amountDue" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>
						<div class="form-group">
							<label>Amount Due: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon">Tk</div>
								<input type="text" class="form-control amountDue" id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
							</div>
						</div>-->
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
    <script src="js/auto_stock.js"></script>
  </body>
</html>
<?php
}
else{
	header("location: ../index");
}
?>