<?php
$titel = "New Signup";
$NewSignup = 'active';
include('include/hader.php');
$sts = $_GET['ids'];
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NewSignup' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn10" href="NewSignup"> Pending</a>
			<a class="btn ownbtn3" href="NewSignup?ids=done"> Done</a>
			<a class="btn ownbtn1" href="SignUp">SignUp New</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>New Signup Clients</h1>
        </div>
    </div><!--pageheader-->
		<?php if($sts == 'delete') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted.
			</div><!--alert-->
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header">
				Signup List
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive" />
                    <colgroup>
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
						<col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">ID</th>
							<th class="head0">Name</th>
							<th class="head1">Address</th>
							<th class="head0">Cell</th>
							<th class="head1">Cell-2</th>
							<th class="head0">E-Mail</th>
							<th class="head1">Package</th>
							<th class="head0">Signup Date</th>
							<th class="head1">Image</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($sts == 'done'){
							$sql = mysql_query("SELECT c.id, c.c_name, c.cell, c.cell1, c.cell2, c.p_m, c.email, c.address, c.join_date, c.occupation, c.previous_isp, c.nid, c.p_id, p.p_name, p.bandwith, p.p_price, c.signup_fee, c.note, c.image, c.sts, c.disclaimer FROM clients_signup AS c
													LEFT JOIN package AS p
													ON p.p_id = c.p_id
													WHERE c.sts = '1' ORDER BY c.id DESC");
							while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['image'] == ''){
										$aaaa = 'emp_images/no_img.jpg';
									}else{
										$aaaa = $row['image'];
									}
									
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td>{$row['c_name']}</td>
											<td>{$row['address']}</td>
											<td>{$row['cell']}</td>
											<td>{$row['cell2']}</td>
											<td>{$row['email']}</td>
											<td>{$row['p_name']}-{$row['bandwith']}-{$row['p_price']}</td>
											<td>{$row['join_date']}</td>
											<td><img src='{$aaaa}' height='50px' width='50px'></td>
											<td>Added in Clients</td>
										</tr>\n ";
								}
						}
						else{
							$sql = mysql_query("SELECT c.id, c.c_name, c.cell, c.cell1, c.cell2, c.p_m, c.email, c.address, c.join_date, c.occupation, c.previous_isp, c.nid, c.p_id, p.p_name, p.bandwith, p.p_price, c.signup_fee, c.note, c.image, c.sts, c.disclaimer FROM clients_signup AS c
													LEFT JOIN package AS p
													ON p.p_id = c.p_id
													WHERE c.sts = '0' ORDER BY c.id DESC");
							while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['image'] == ''){
										$aaaa = 'emp_images/no_img.jpg';
									}else{
										$aaaa = $row['image'];
									}
									
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td>{$row['c_name']}</td>
											<td>{$row['address']}</td>
											<td>{$row['cell']}</td>
											<td>{$row['cell2']}</td>
											<td>{$row['email']}</td>
											<td>{$row['p_name']}-{$row['bandwith']}-{$row['p_price']}</td>
											<td>{$row['join_date']}</td>
											<td><img src='{$aaaa}' height='50px' width='50px'></td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><form action='ClientAdd' method='post'><input type='hidden' name='way' value='newsignup' /><input type='hidden' name='signup_id' value='{$row['id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-ok'></i></button></form></li>
													<li><form action='NewSignupDelete' method='post'><input type='hidden' name='signupid' value='{$row['id']}' /><button class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
								}
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
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>

<style>
#dyntable_length{display: none;}
</style>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>