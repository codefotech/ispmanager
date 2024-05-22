<?php
include("conn/connection.php") ;
$p_id = $_GET['p_id'];
$remaining = $_GET['remaining'];

$sqlc1 = mysql_query("SELECT id, pro_name, pro_details, unit, vat, sl_sts FROM product WHERE id = '$p_id'");
$rowc1 = mysql_fetch_assoc($sqlc1);
$pp_id = $rowc1['id'];
$pro_name = $rowc1['pro_name'];
$pro_details = $rowc1['pro_details'];
$unit = $rowc1['unit'];
$vat = $rowc1['vat'];
$sl_sts = $rowc1['sl_sts'];

if($pp_id != ''){
?>
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="p_id" value="<?php echo $pp_id;?>" />
	<input type="hidden" name="typ" value="productedit" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Edit Instrument Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Instrument Name:</div>
						<div class="col-2"><input type="text" name="pro_name" id="" value="<?php echo $pro_name;?>" placeholder="Ex: Switch, Router etc" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Instrument Details:</div>
						<div class="col-2"><input type="text" name="pro_details" id="" value="<?php echo $pro_details;?>" placeholder="" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Unit:</div>
						<div class="col-2"><input type="text" name="unit" id="" value="<?php echo $unit;?>" placeholder="" style="width: 25%;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Vat(%):</div>
						<div class="col-2"><input type="text" name="vat" id="" value="<?php echo $vat;?>" placeholder="" style="width: 25%;" required=""/></div>
					</div>
					<?php if($sl_sts == '1'){?>
					<div class="popdiv">
						<div class="col-1">Have S/L No?</div>
						<div class="col-2">
							<input type="radio" name="sl_sts" value="1" <?php if ('1' == $sl_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
						</div>
					</div>
					<?php } else{ ?>
					<div class="popdiv">
						<div class="col-1">Have S/L No?</div>
						<div class="col-2">
							<input type="radio" name="sl_sts" value="0" <?php if ('0' == $sl_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</div>
					</div>
					<?php } ?>
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

