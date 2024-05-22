<?php
$titel = "Collection Receive";
$CollectionReceive = 'active';
include('include/hader.php');
include("conn/connection.php") ;

//---------- Permission -----------
$e_id = $_SESSION['SESS_EMP_ID'];
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'CollectionReceive' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result = mysql_query("SELECT c.id, c.c_date, c.c_clint, c.c_amount, e.e_name, c.rec_date_time FROM collection AS c 
						LEFT JOIN emp_info AS e ON e.e_id = c.ent_by
						WHERE c.sts = '0'");
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="POST" action="CollectionReceiveSave">
	<input type="hidden" name="rec_by" value="<?php echo $e_id; ?>" />
	<input type="hidden" name="rec_date_time" value="<?php echo date("Y-m-d H:i:s"); ?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Receive Collection</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Date: </div>
						<div class="col-2"> 
							<select name="id" class="chzn-select"  style="width: 280px;" required="" />
								<option value="">Choose User Type</option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value=<?php echo $row['id']?>><?php echo $row['e_name']?> - [<?php echo $row['c_clint']?>] - [<?php echo $row['c_amount']?>]</option>
									<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Note: </div>
						<div class="col-2"> 
							<input style="" id="" type="text" name="note" class="input-xlarge" value="">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Receive Collection</a>
        </div>
        <div class="pageicon"><i class="iconfa-ok"></i></div>
        <div class="pagetitle">
            <h1>Collection Receive</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<h5>All Collection Receive List</h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head1">S/L</th>
                            <th class="head0">Date</th>
							<th class="head1">Total Client</th>
							<th class="head0">Total Amount</th>
							<th class="head1">Receive By</th>
							<th class="head0">Receive Date</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sql = mysql_query("SELECT c.c_date, c.c_clint, c.c_amount, e.e_name, c.rec_date_time FROM collection AS c 
													LEFT JOIN emp_info AS e ON e.e_id = c.rec_by
													WHERE c.sts = '1'");
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['rec_date_time'] == '0000-00-00 00:00:00'){
										$rec_dt = '';
									}
									else{
										$rec_dt = $row['rec_date_time'];
									}
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$row['c_date']}</td>
											<td>{$row['c_clint']}</td>
											<td>{$row['c_amount']}</td>
											<td>{$row['e_name']}</td>
											<td>{$rec_dt}</td
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