<?php
include("conn/connection.php") ;
extract($_POST);if( empty($_POST['d_id']) || empty($_POST['d_name']) )	{ }else	{
		$query="insert into department_info (dept_id, dept_name) VALUES ('$d_id', '$d_name')";
		$sql = mysql_query($query);	}
mysql_close($con);
?><html><body>     <form action="Employee" method="post" name="ok">       <input type="hidden" name="sts" value="add">     </form>     <script language="javascript" type="text/javascript">		document.ok.submit();     </script></body></html>