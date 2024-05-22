<?php
include("conn/connection.php") ;
extract($_POST);if( empty($_POST['d_id']) || empty($_POST['d_name']) )	{ }else	{
		$query="UPDATE department_info SET dept_name = '$d_name' WHERE dept_id = '$d_id'";
		$sql = mysql_query($query);	}
?><html><body>     <form action="Employee" method="post" name="ok">       <input type="hidden" name="sts" value="edit">     </form>     <script language="javascript" type="text/javascript">		document.ok.submit();     </script></body></html>