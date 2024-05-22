<?php
include("conn/connection.php") ;
$invoice_id = $_GET['invoice_id'];

$quesdd = mysql_query("SELECT c_id FROM billing_invoice WHERE invoice_id = '$invoice_id' AND sts = '0' ORDER BY id ASC LIMIT 1");
$rowwdd = mysql_fetch_assoc($quesdd);
$cid = $rowwdd['c_id'];

$sqlasa = mysql_query("SELECT `invoice_id`, `invoice_date`, `c_id`, `item_id`, `item_name`, `description`, `quantity`, `unit`, `uniteprice`, `vat`, `start_date`, `end_date`, `days`, `total_price`, `due_deadline`, `date_time` FROM billing_invoice WHERE invoice_id = '$invoice_id' AND sts = '0'");

if($invoice_id != ''){
?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Invoice Details</h5>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
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
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">invoice_date</th>
							<th class="head0 right">item_name</th>
							<th class="head1 right">description</th>
							<th class="head0 right">quantity</th>
							<th class="head1 center">unit</th>
							<th class="head0 center">uniteprice</th>
							<th class="head1 center">vat</th>
							<th class="head1 center">start_date</th>
							<th class="head1 center">end_date</th>
							<th class="head1 center">total_price</th>
							<th class="head0 center hidedisplay">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $row = mysql_fetch_assoc($sqlasa) )
								{									
									echo
										"<tr class='gradeX'>
											<td>{$row['invoice_date']}</td>
											<td class='center'>{$row['item_name']}</td>
											<td class='right'>{$row['description']}</td>
											<td class='right'>{$row['quantity']}</td>
											<td class='right'>{$row['unit']}</td>
											<td class='center'>{$row['uniteprice']}</td>
											<td class='center'>{$row['vat']}</td>
											<td class='center'>{$row['start_date']}</td>
											<td class='center'>{$row['end_date']}</td>
											<td class='center'>{$row['total_price']}</td>
											<td class='center hidedisplay' style='width: 70px !important;'>
												<ul class='tooltipsample'>
												{$ee}{$ss}
												</ul>
											</td>
										</tr>\n";
								}
								
									
							?>
					</tbody>
				</table>
									</div>
				</div>
			</div>
		</div>	
<?php } else{echo 'Something wrong!!!';}?>