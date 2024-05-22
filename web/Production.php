<?php
$titel = "Production";
$Production = 'active';
include('include/hader.php');
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Production' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result = mysql_query("SELECT * FROM raw_material_roll WHERE sts = '1'");

$result1 = mysql_query("SELECT * FROM raw_material_roll WHERE ro_id = '$roid'");
$row1 = mysql_fetch_array($result1);

?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="StockFactoryAdd"><i class="iconfa-plus"></i>  New Stock</a>
        </div>
        <div class="pageicon"><i class="iconfa-repeat"></i></div>
        <div class="pagetitle">
            <h1>Production</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Production Entry</h5>
				</div>
					<div class="modal-body">
						<form id="" name="form1" class="stdform" method="POST" action="<?php echo $PHP_SELF;?>">
							<p>
								<label>Raw Material (Roll) Number</label>
									<select data-placeholder="Choose a Roll Name" name="roid" style="width:50%;" class="chzn-select" onchange="submit();">
										<option value="">Type a Raw Material (Roll) Number</option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value=<?php echo $row['ro_id']?> <?php if($row['ro_id'] == $roid){ echo 'selected'; }?> ><?php echo $row['ro_id']; ?> - <?php echo $row['ro_name']; ?> (<?php echo $row['weight']; ?>)</option>
											<?php } ?>
									</select>
							</p>
						</form>	
				<form id="" name="form1" class="stdform" method="post" action="ProductionSave">
					<input type="hidden" value="<?php echo $roid; ?>" name="ro_id" />
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="pro_by" />
						<p>
							<label>Raw Material (Roll) Name</label>
							<span class="field"><input type="text" name="ro_name" id="" style="width:61%;" value="<?php echo $row1['ro_name']; ?>" class="input-xxlarge" readonly placeholder="Roll Name" /></span>
						</p>
						<p>
							<label>Roll Weight</label>
							<span class="field"><input type="text" name="weight_out" id="" style="width:61%;" value="<?php echo $row1['weight']; ?>" class="input-xxlarge" readonly placeholder="Roll Weight In Kg" /></span>
						</p>
						<p>
							<label>Production Date</label>
							<span class="field"><input type="text" name="production_date" style="width:61%;" id="" value="<?php echo date('Y-m-d'); ?>" class="input-xxlarge datepicker" /></span>
						</p>
						<p>
							<label>Production Amount</label>
							<span class="field"><input type="text" name="production_amount" style="width:61%;" id="" class="input-xxlarge" placeholder="Production Amount" /></span>
						</p>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="dsc_pro" id="" style="width:61%;" placeholder="Write Your Entry Note" class="input-xxlarge" /></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn">Reset</button>
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</form>			
			</div>
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
                            <th class="head0">Roll Id</th>
                            <th class="head1">Roll Name</th>
							<th class="head0">Weight</th>
							<th class="head1">Production Date</th>
                            <th class="head0">Production Quentity</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sql = mysql_query("SELECT r.ro_id, r.ro_name, r.weight_out, r.production_date, r.production_amount FROM raw_material_roll AS r
													WHERE r.sts = '2'
													ORDER BY ro_id DESC LIMIT 10");
									while( $row = mysql_fetch_assoc($sql) )
									{
										echo
											"<tr class='gradeX'>
												<td>{$row['ro_id']}</td>
												<td>{$row['ro_name']}</td>
												<td>{$row['weight_out']} KG</td>
												<td>{$row['production_date']}</td>
												<td>{$row['production_amount']}</td>
											</tr>\n ";
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