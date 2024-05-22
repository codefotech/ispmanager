<?php
$titel = "Expense";
$Expanse = 'active';
include('include/hader.php');
$ctgry = isset($_GET['ctgry']) ? $_GET['ctgry'] : '';
$exstatus = isset($_GET['exstatus']) ? $_GET['exstatus'] : '';
extract($_POST);

$eiddd = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Expanse' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '41' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$yrmo = date('Y-m', time());
//$lastyear = date('Y', strtotime(date('Y')." -1 year")).'-12-31';
$yerfstday = date('Y-1-1', time());

if($ctgry == '0'){
	$tname1 = "Office Expense";
}
elseif($ctgry == '1'){
	$tname1 = "Vendor Bill Pay";
}
elseif($ctgry == '2'){
	$tname1 = "Agent Commission Pay";
}
elseif($ctgry == '3'){
	$tname1 = "Investment Expense";
}
else{
	$tname1 = "All Expense";
}

if(in_array(253, $access_arry)){

if($ctgry != ''){
$queryyutyu = mysql_query("SELECT DATE_FORMAT(a.ex_date, '%Y') AS ex_y, DATE_FORMAT(a.ex_date, '%c') AS ex_m, DATE_FORMAT(a.ex_date, '%e') AS ex_d, sum(a.oamount) AS office_exp FROM 
							(
							SELECT ex_date, sum(amount) AS oamount FROM `expanse` WHERE `status` = '2' AND category = '$ctgry' AND ex_date BETWEEN CURDATE() - INTERVAL 1 DAY AND DATE (NOW()) GROUP BY ex_date
							) AS a
							GROUP BY a.ex_date");
}
else{
$queryyutyu = mysql_query("SELECT DATE_FORMAT(a.ex_date, '%Y') AS ex_y, DATE_FORMAT(a.ex_date, '%c') AS ex_m, DATE_FORMAT(a.ex_date, '%e') AS ex_d, sum(a.oamount) AS office_exp FROM 
							(
							SELECT ex_date, sum(amount) AS oamount FROM `expanse` WHERE `status` = '2' AND ex_date BETWEEN CURDATE() - INTERVAL 1 DAY AND DATE (NOW()) GROUP BY ex_date
							) AS a
							GROUP BY a.ex_date");
}

while($r=mysql_fetch_assoc($queryyutyu)){
	
	$ex_y = $r['ex_y'];
	$ex_m = $r['ex_m']-1;
	$ex_d = $r['ex_d'];
	$datemonth = $ex_y.', '.$ex_m.', '.$ex_d;
	$office_exp = $r['office_exp'];
	$myurl[]="[new Date(".$datemonth."), ".$office_exp."]";
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["calendar"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
       dataTable.addRows([
			<?php echo(implode(",",$myurl));?>
]);
        var chart = new google.visualization.Calendar(document.getElementById('chart_div'));
		
  var options = {
//    title: '<?php echo $tname1;?>',
    title: '',
	fontSize: 12,
    height: $(".pageheader").width()/5.2,
//	width: 1000,
    calendar: {
				cellSize: $(".pageheader").width()/58,
//				cellSize: 20,
				underMonthSpace: 12,
				cellColor: {
					stroke: '#0866c6',
					strokeOpacity: .2,
					strokeWidth: .5
					},
				noDataPattern: {
					   backgroundColor: '#b94a48',
					   color: '#b94a48'
					},
				focusedCellColor: {
					stroke: '#d3362d',
					strokeOpacity: 1,
					strokeWidth: 1
					},
				monthOutlineColor: {
					stroke: 'green',
					strokeOpacity: .8,
					strokeWidth: 1
					},
				unusedMonthOutlineColor: {
					stroke: 'red',
					strokeOpacity: .7,
					strokeWidth: 1
					},
				dayOfWeekLabel: {
//					fontName: 'Times-Roman',
					fontSize: 12,
//					color: 'black',
//					bold: false,
//					italic: false
					},
				monthLabel: {
					fontName: 'RobotoLight, Helvetica Neue, Helvetica, sans-serif',
					fontSize: 16,
					color: '#317eac',
					bold: true,
					italic: false
					},
				}
			};

       chart.draw(dataTable, options);
   }
    </script>
<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2266" style="background: white;">
	<div class="modal-header" style="background: transparent;padding: 9px 15px;border-bottom: 1px solid #eee;color: #555;">
		<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
		<h3 id="myModalLabel">Status</h3>
	</div>
	<div class="modal-body">
		<div id='Pointdiv1'></div>
	</div>
	<div class="modal-footer">
		<button data-dismiss="modal" class="btn ownbtn3">Thanks!!</button>
	</div>
</div>
	<div class="pageheader">
        <div class="searchbar">
			<div class="input-append">
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($exstatus == '0'){echo '#1770b2;color: #1770b2;';} elseif($exstatus == '1'){echo '#b94a48;color: #b94a48;';} elseif($exstatus == '2'){echo '#23772c;color: #23772c;';} else{echo '#457303;color: #457303;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($exstatus == '0'){ echo 'Pending';} elseif($exstatus == '1'){ echo 'Rejected';} elseif($exstatus == '2'){ echo 'Approved';} else{ echo 'All Status';}?> 
					<span class="caret" style="border-top: 4px solid <?php if($exstatus == '0'){echo '#1770b2';} elseif($exstatus == '1'){echo '#b94a48';} elseif($exstatus == '2'){echo '#23772c';} else{echo '#457303';}?>;"></span></button>
					<ul class="dropdown-menu" style="min-width: 115px;border-radius: 0px 0px 5px 5px;">
						<li <?php if($exstatus == ''){echo 'style="display: none;"';}?>><a href="Expanse" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #457303;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="All Expense">All Status</a></li>
						<li <?php if($exstatus == '0'){echo 'style="display: none;"';}?>><a href="Expanse?exstatus=0" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #1770b2;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Pending">Pending</a></li>
						<li <?php if($exstatus == '1'){echo 'style="display: none;"';}?>><a href="Expanse?exstatus=1" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #b94a48;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Rejected">Rejected</a></li>
						<li <?php if($exstatus == '2'){echo 'style="display: none;"';}?>><a href="Expanse?exstatus=2" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #23772c;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Agent Commission Pay">Approved</a></li>
					</ul>
				</div>
			</div>
			<div class="input-append">
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($ctgry == '0'){echo '#00a65a;color: #00a65a;';} elseif($ctgry == '1'){echo '#b94a48;color: #b94a48;';} elseif($ctgry == '2'){echo '#f89406;color: #f89406;';} elseif($ctgry == '3'){echo '#9100a6bd;color: #9100a6bd;';} else{echo '#8b00ff;color: #8b00ff;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($ctgry == '0'){ echo 'Office Expense';} elseif($ctgry == '1'){ echo 'Vendor Bill Pay';} elseif($ctgry == '2'){ echo 'Agent Commission Pay';} elseif($ctgry == '3'){ echo 'Investment Expense';} else{ echo 'All Expense';}?> 
					<span class="caret" style="border-top: 4px solid <?php if($ctgry == '0'){echo '#00a65a';} elseif($ctgry == '1'){echo '#b94a48';} elseif($ctgry == '2'){echo '#f89406';} elseif($ctgry == '3'){echo '#9100a6bd';} else{echo '#8b00ff';}?>;"></span></button>
					<ul class="dropdown-menu" style="min-width: 115px;border-radius: 0px 0px 5px 5px;">
						<li <?php if($ctgry == ''){echo 'style="display: none;"';}?>><a href="Expanse" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b00ff;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="All Expense">All Expense</a></li>
						<li <?php if($ctgry == '0'){echo 'style="display: none;"';}?>><a href="Expanse?ctgry=0" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #00a65a;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New PPPoE Client">Office Expense</a></li>
						<li <?php if($ctgry == '1'){echo 'style="display: none;"';}?>><a href="Expanse?ctgry=1" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #b94a48;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Vendor Bill Pay">Vendor Bill Pay</a></li>
						<li <?php if($ctgry == '3'){echo 'style="display: none;"';}?>><a href="Expanse?ctgry=3" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #9100a6bd;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Investment Expense">Investment Expense</a></li>
						<li <?php if($ctgry == '2'){echo 'style="display: none;"';}?>><a href="Expanse?ctgry=2" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #f89406;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Agent Commission Pay">Agent Commission Pay</a></li>
					</ul>
				</div>
			</div>
		<?php if(in_array(201, $access_arry) || in_array(202, $access_arry) || in_array(203, $access_arry) ||in_array(204, $access_arry)){?>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="ExpenseType">Expense Type</a>
		<?php } if(in_array(198, $access_arry) || in_array(199, $access_arry) || in_array(200, $access_arry)){?>
			<a class="btn" href='ExpanseAdd' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;">Add Expense </a>
		<?php } ?>
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Expense</h1>
        </div>
    </div><!--pageheader-->
	<?php if(in_array(253, $access_arry)){?>
		<div style="background: #d6f1f773;padding-left: 2%;" id="chart_div"></div>
	<?php } if('approve' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Approve!!</strong> <?php echo $titel;?>
			 Successfully Approved.
		</div>
		<!--alert-->
		<?php } if('reject' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Reject!!</strong> <?php echo $titel;?>
			 Successfully Rejected.
		</div>
		<!--alert-->
		<?php } if('add' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong>
			<?php echo $titel;?>
			 Successfully Added.
		</div>
		<!--alert-->
		<?php } if('edit' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong>
			<?php echo $titel;?>
			 Successfully Edited in Your System.
		</div>
		<!--alert-->
		<?php } if('error' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Error!!</strong> This <?php echo $titel;?> Already Added.
		</div> 
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header">
				<?php echo $tname1;?>
			</div>
			<div class="box-body">
				<table id="dyntable2" class="table table-bordered responsive">
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">ID</th>
							<th class="head0 center">Date/Time</th>
							<th class="head1 center">Head/Type</th>
							<th class="head0 center">Entry By/Bank/Note</th>
                            <th class="head1 center">Vendor/Agent</th>
                            <th class="head0 center">Amount</th>
							<th class="head1">Checked by/Note</th>
							<th class="head0 center">Status</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$allcexp = "SELECT e.id, b.sort_name, e.category ,IFNULL(x.e_name, '') AS agent_name, x.e_cont_per AS agent_cell, IFNULL(v.v_name, '-') AS v_name, v.cell, b.id AS bank_id, e.check_by, z.dept_name AS ckdept_name, q.e_name AS checkby, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS check_date, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, a.e_id, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, e.entry_by, e.enty_date, DATE_FORMAT(e.enty_date, '%D %b-%y %h:%i%p') AS entydate, DATE_FORMAT(e.enty_date, '%Y-%m') AS entyyrmo, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													LEFT JOIN department_info AS z ON z.dept_id = q.dept_id 
													LEFT JOIN vendor AS v ON v.id = e.v_id
													LEFT JOIN agent AS x ON x.e_id = e.agent_id WHERE e.id != ''";
											if ($exstatus != ''){
												$allcexp .= " AND e.status = '$exstatus'";
											}
											if ($ctgry != ''){
												$allcexp .= " AND e.category = '$ctgry' AND e.ex_date BETWEEN '$yerfstday' AND DATE (NOW())";
											}
											if(!in_array(250, $access_arry)){
												$allcexp .= " AND e.ex_by = '$e_id' OR e.entry_by = '$e_id'";
											}
										
									$allcexp .= " ORDER BY e.id DESC";
									$sql = mysql_query($allcexp);
									while( $row = mysql_fetch_assoc($sql) )
									{
										if($row['status'] == '0'){
											$exxxx = "<img src='/web/images/pending.jpg' width='100' height='35' style='padding: 10px 0px;'/>";
											$collrrr = 'style="color: #333333;font-weight: bold;font-size: 16px;padding: 20px 10px;"';
											$edittttt = 'ExpanseEdit';
											$editid = $row['id'];
											
											if($row['entyyrmo'] == $yrmo){
												if(in_array(252, $access_arry)){
													$xxx = "<li><form action='{$edittttt}' method='post'><input type='hidden' name='exid' value='{$editid}'/> <button class='btn' style='border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;margin: 2px 0 0 0;' title='Edit Expense'><i class='iconfa-edit'></i></button></form></li>";
												}
												elseif($row['entry_by'] == $e_id){
													$xxx = "<li><form action='{$edittttt}' method='post'><input type='hidden' name='exid' value='{$editid}'/> <button class='btn' style='border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;margin: 2px 0 0 0;' title='Edit Expense'><i class='iconfa-edit'></i></button></form></li>";
												}
												else{
													$xxx = "";
												}
											}
											else{
													$xxx = "";
											}
											
											if(in_array(251, $access_arry) && $row['entry_by'] != $e_id){
												$yyy = "<li><button value='{$editid}&check_by={$eiddd}&ex_sts=reject' class='btn' style='border-radius: 3px;border: 1px solid red;color: red;padding: 6px 10px;margin: 2px 0 0 0' href='#myModal2266' data-toggle='modal' data-placement='top' data-rel='tooltip' type='submit' title='Reject' onClick='getRoutePoint(this.value)'><i class='iconfa-thumbs-down'></i></button>
															<button value='{$editid}&check_by={$eiddd}&ex_sts=approve' class='btn' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 10px;margin: 2px 0 0 2px;' href='#myModal2266' data-toggle='modal' data-placement='top' data-rel='tooltip' type='submit'title='Approve' onClick='getRoutePoint(this.value)'><i class='iconfa-thumbs-up'></i></button>
														</li>";
											}
											else{
												$yyy = '';
											}
										}
										if($row['status'] == '1'){
											$exxxx = "<img src='/web/images/rejected.jpg' width='100' height='35' style='padding: 10px 0px;'/>";
											$collrrr = 'style="color: #b94a48;font-weight: bold;font-size: 16px;padding: 20px 10px;"';
											$edittttt = '';
											$editid = '';
											$xxx = '';
											$yyy = '';
										}
										if($row['status'] == '2'){
											$exxxx = "<img src='/web/images/approved.jpg' width='100' height='35' style='padding: 10px 0px;'/>";
											$collrrr = 'style="color: #00a65a;font-weight: bold;font-size: 16px;padding: 20px 10px;"';
											$edittttt = '';
											$editid = '';
											$xxx = '';
											$yyy = '';
										}
										if($row['category'] == '0'){
											$categoryyy = "<span class='label label-success' style='font-weight: bold;margin: 5px 0px;border-radius: 7px;'>Office<span>";
										}
										if($row['category'] == '1'){
											$categoryyy = "<span class='label label-important' style='font-weight: bold;margin: 5px 0px;border-radius: 7px;'>Bill Pay<span>";
										}
										if($row['category'] == '2'){
											$categoryyy = "<span class='label label-warning' style='font-weight: bold;margin: 5px 0px;border-radius: 7px;'>Commission<span>";
										}
										if($row['category'] == '3'){
											$categoryyy = "<span class='label label-warning' style='font-weight: bold;margin: 5px 0px;border-radius: 7px;background: #9100a6bd !important;'>Investment<span>";
										}
										
										if($row['note'] != ''){
											$textt = "<i class='iconfa-info-sign'></i>";
										}
										else{
											$textt = '';
										}
										if($row['check_note'] != ''){
											$textte = "<i class='iconfa-info-sign'></i>";
										}
										else{
											$textte = '';
										}
										echo
											"<tr class='gradeX'>
												<td style='padding: 20px 10px;font-weight: bold;' class='center'>{$row['id']}</td>
												<td style='padding: 20px 10px;font-weight: bold;' class='center'>{$row['entydate']}</td>
												<td class='center'><b>{$row['ex_type']}</b><br>{$categoryyy}</td>
												<td><div class='myDIVV'><b>{$row['e_name']} ({$row['e_id']})</b> {$textt}</div>{$row['sort_name']} ({$row['bank_id']})<div class='hidee'>{$row['note']}</div></td>
												<td class='center'><b>{$row['v_name']}{$row['agent_name']}</b><br>{$row['cell']}{$row['agent_cell']}</td>
												<td class='center' $collrrr>{$row['amount']}</td>
												<td><div class='myDIVV'><b>{$row['checkby']}</b> {$textte}</div>{$row['check_date']} <div class='hidee'>{$row['check_note']}</div></td>
												<td class='center'>{$exxxx}</td>
												<td class='center' style='width: 150px;'>
												<ul class='tooltipsample' style='padding: 10px 0;'>
													<li><form action='ExpanseView' method='post'><input type='hidden' name='ex_id' value='{$row['id']}'/><button class='btn' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;margin: 2px 0 0 0;' title='View Expense'><i class='iconfa-eye-open'></i></button></form></li>
													{$xxx}{$yyy}
												</ul>
												</td>
											</tr>\n";
									}
						
							?>
                    </tbody>
				</table>
			</div>			
		</div>
<?php
}
else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'desc']],
            "sScrollY": "1500px"
        });
    });
	

$( document ).click(function() {
  $( "#toggle" ).toggle( "slide" );
});
</script>

<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePoint(afdId) {		
		
		var strURL="expanse-check-query.php?ex_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}

.hidee {
  display: none;
}
    
.myDIVV:hover + .hidee {
  display: block;
  color: red;
  font-weight: bold;
}
</style>