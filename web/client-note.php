<?php
include("conn/connection.php") ;
$c_id = $_GET['c_id'];

$sqlc1 = mysql_query("SELECT note_auto, note, c_name FROM clients WHERE c_id = '$c_id'");
$rowc1 = mysql_fetch_assoc($sqlc1);
$note_auto = $rowc1['note_auto'];
$c_name = $rowc1['c_name'];
$note = $rowc1['note'];

if($c_id != ''){
?>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5" style="font-weight: bold;color: #f55;font-size: 17px;"><?php echo $c_name.' ['.$c_id.']';?></h5>
			</div>
			<div class="modal-body">
			<div class="row">
				
				<table class="table table-bordered table-invoice" style="width: 100%; float: left;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;width: 13%;">Auto Note</td>
											<td class="width70" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;padding: 5px 8px;"><p style="color: red;font-weight: bold;font-size: 15px;"><?php echo $note_auto;?></p></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;width: 13%;">Note</td>
											<td class="width70" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;padding: 5px 8px;"><p style="font-weight: bold;"><?php echo $note;?></p></td>
										</tr>
									</table>
			</div>
			</div>
		</div>
	</div>	

<?php } else{echo 'Something wrong!!!';}?>