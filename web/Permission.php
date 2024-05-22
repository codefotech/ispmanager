<?php
$titel = "User Permission";
include('include/hader.php');

$user_type = $_SESSION['SESS_USER_TYPE'];
if($user_type == 'admin' || $user_type == 'superadmin'){

?>
<script>
$('input[type=checkbox]').live("change",function(){
    var target = $(this).parent().find('input[type=hidden]').val();
    if(target == 0)
    {
        target = 1;
    }
    else
    {
        target = 0;
    }
    $(this).parent().find('input[type=hidden]').val(target);
});
</script>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-key"></i></div>
        <div class="pagetitle">
            <h1>User Permission [Under Construction]</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<h5>User Permission</h5>
		</div>
		
		<form class="stdform" method="post" action="#" name="form" enctype="multipart/form-data"><!---action="PermissionSave"--->
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
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
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">Page name</th>
                            <th class="head0 center">Admin</th>
                            <th class="head1 center">accounts</th>
							<th class="head0 center">Billing</th>
							<th class="head1 center">Tecnecal Support</th>
							<th class="head0 center">Client</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sql = mysql_query("SELECT * FROM module ORDER BY position");
							while( $row = mysql_fetch_assoc($sql) ){ ?>
										<tr class='gradeX'>
											<td><input type="hidden" name="id[]" id="" value="<?php echo $row['id'];?>"/><?php echo $row['module_name'];?></td>
											<td class='center'><input type='checkbox' name='admin[]' value='1' <?php if($row['admin'] == 1){echo 'checked="checked"';} ?> /></td>
											<td class='center'><input type='checkbox' name='accounts[]' value='1' <?php if($row['accounts'] == 1){echo 'checked="checked"';} ?> /></td>
											<td class='center'><input type='checkbox' name='billing[]' value='1' <?php if($row['billing'] == 1){echo 'checked="checked"';} ?> /></td>
											<td class='center'><input type='checkbox' name='ets[]' value='1' <?php if($row['ets'] == 1){echo 'checked="checked"';} ?> /></td>
											<td class='center'><input type='checkbox' name='client[]' value='1' <?php if($row['client'] == 1){echo 'checked="checked"';} ?> /></td>
										</tr>
								<?php } ?>
					</tbody>
				</table>
			</div>	
			<div class="modal-footer">
                <!-- <button type="submit" class="btn btn-primary">Confirm</button> -->
            </div>
		</form>
	</div>

<?php
}
else{
	echo 'you do not have to access this page';
}
include('include/footer.php');
?>

