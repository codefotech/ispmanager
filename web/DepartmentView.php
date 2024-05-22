<?php
$titel = "Add Department";
$Employee = 'active';
include('include/hader.php');
include("conn/connection.php");

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
<div class="pageheader" style="min-height: auto !important; padding: 10px !important;">
	<ul class="mediamgr_menu">
		<li class="manuli" style="width: 13% !important;"><a href = "DepartmentAdd" class="btn selectall sub_menu"><span class="icon-plus"></span> Add Department</a></li>
		<li class="manuli" style="width: 13% !important;"><a href = "DepartmentEdit" class="btn selectall sub_menu"><span class="icon-edit"></span> Edit Department</a></li>
		<li class="manuli" style="width: 13% !important;"><a href = "3" class="btn selectall sub_menu_activ"><span class="icon-eye-open"></span> View Department </a></li>
    </ul>
</div><!--pageheader-->	
				<table id="dyntable" class="table table-bordered responsive" style="">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr style="font-size: 11px;">
                            <th class="head1">Department ID</th>
                            <th class="head0">Department Name</th>
                        </tr>
                    </thead>
					<tbody class="abcd123">
						<?php
							$sql = mysql_query("SELECT * FROM  department_info ORDER BY dept_name");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['dept_id']}</td>
											<td>{$row['dept_name']}</td>
										</tr>\n ";
								}  
						?>
					</tbody>    
                </table>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>