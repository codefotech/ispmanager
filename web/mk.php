<?php
include("conn/connection.php");

$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);
?>
<html>
<body>
    <form action="testttttt" method="post" name="ok">
		<select data-placeholder="" id="mk_id" name="mk_id" style="width:250px;" required="">
			<option value=""></option>
				<?php while ($row11=mysql_fetch_array($result11)) { ?>
			<option value="<?php echo $row11['id']?>"><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
				<?php } ?>
		</select><br>
		<input type="password" name="pass" style="width:250px;" required=""><br>
		<button class="btn ownbtn2" type="submit">Submit</button>
    </form>
</body>
</html>