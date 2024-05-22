<?php
include("conn/connection.php") ;
$c_id = $_GET['c_id'];
$consts = $_GET['consts'];
if($c_id != '' || $consts != ''){
?>
	<form id="form2" class="stdform" method="post" action="ClientStatus">
	<input type="hidden" name="c_id" value="<?php echo $c_id;?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="padding: 2px 0px 3px 10px;">
				<h5 class="h5" style="font-weight: bold;color: #f55;font-size: 20px;">Going to <?php echo $consts;?> [<?php echo $c_id;?>]. Are you sure?</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="text-align: center;font-weight: bold;">Write Note</div>
						<div class="col-2">
							<textarea type="text" style="width:100%;" name="note" placeholder="Duble Click to Write..." /></textarea>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn ownbtn2" type="submit">Yes i'm & Proceed</button>
			</div>
		</div>
	</div>	
	</form>	
<?php } else{echo 'Something wrong!!!';}?>