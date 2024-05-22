<?php
include("conn/connection.php") ;
$invoice_id = $_GET['invoice_id'];

$queryrtre = mysql_query("SELECT id, i_name, i_des, i_unit, vat, use_sts FROM invoice_item WHERE sts = '0' AND id = '$invoice_id'");
$rowss = mysql_fetch_assoc($queryrtre);

if($rowss['i_name'] != '' || $rowss['id'] != ''){
?>
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="InvoiceEdit" />
	<input type="hidden" name="invoice_id" value="<?php echo $rowss['id'];?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Edit Invoice Particular</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Name*</div>
						<div class="col-2"><input type="text" name="i_name" value="<?php echo $rowss['i_name'];?>" placeholder="Ex: Youtube, BDIX" style="width: 100%;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Description</div>
						<div class="col-2"><input type="text" name="i_des" value="<?php echo $rowss['i_des'];?>" placeholder="Ex: Box Address" style="width: 100%;" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Unit*</div>
						<div class="col-2"><input type="text" name="i_unit" value="<?php echo $rowss['i_unit'];?>" placeholder="Ex: Mbps, KG, Pis" style="width: 50%;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">VAT*</div>
						<div class="col-2"><input type="text" name="vat" value="<?php echo $rowss['vat'];?>" placeholder="Onu Details" style="width: 20%;" required=""/>&nbsp; (%)</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Status*</div>
						<div class="col-2">
							<select data-placeholder="Status" name="use_sts" class="chzn-select" style="width:100px;" style="font-size: 15px;">
								<option value="0" <?php if($rowss['use_sts'] == '0') echo 'selected="selected"';?>>Active</option>
								<option value="1" <?php if($rowss['use_sts'] == '1') echo 'selected="selected"';?>>Inactive</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
<?php } else{echo 'Something wrong!!!';}?>