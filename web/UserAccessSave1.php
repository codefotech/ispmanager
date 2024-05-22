<?php
session_start();
include("conn/connection.php") ;
extract($_POST);

$Reports = (isset($_POST['module2'])) ? 1 : 0;
$Salary = (isset($_POST['module3'])) ? 1 : 0;
$Zone = (isset($_POST['module4'])) ? 1 : 0;
$Employee = (isset($_POST['module5'])) ? 1 : 0;
$Users  = (isset($_POST['module6'])) ? 1 : 0;
$Package  = (isset($_POST['module7'])) ? 1 : 0;
$Clients = (isset($_POST['module8'])) ? 1 : 0;
$Billing = (isset($_POST['module11'])) ? 1 : 0;
$UserLoginReport = (isset($_POST['module14'])) ? 1 : 0;
$Support = (isset($_POST['module23'])) ? 1 : 0;
$SignupBill = (isset($_POST['module25'])) ? 1 : 0;
$Upcoming = (isset($_POST['module26'])) ? 1 : 0;
$LocationChange = (isset($_POST['module27'])) ? 1 : 0;
$PackageChange  = (isset($_POST['module29'])) ? 1 : 0;
$Store  = (isset($_POST['module31'])) ? 1 : 0;
$ClientsBill = (isset($_POST['module32'])) ? 1 : 0;
$ReportGraph = (isset($_POST['module35'])) ? 1 : 0;
//$UserAccess = (isset($_POST['module36'])) ? 1 : 0;
$SMS = (isset($_POST['module37'])) ? 1 : 0;
$backup_db = (isset($_POST['module38'])) ? 1 : 0;
$MacReseller = (isset($_POST['module39'])) ? 1 : 0;
$MacResellerBillHistory = (isset($_POST['module40'])) ? 1 : 0;
$Expanse = (isset($_POST['module41'])) ? 1 : 0;
$NewSignup  = (isset($_POST['module42'])) ? 1 : 0;
$Network  = (isset($_POST['module43'])) ? 1 : 0;
$Bank  = (isset($_POST['module46'])) ? 1 : 0;
$FundTransfer  = (isset($_POST['module47'])) ? 1 : 0;
$Loan  = (isset($_POST['module48'])) ? 1 : 0;
$VendorBill  = (isset($_POST['module49'])) ? 1 : 0;
$NetworkTree  = (isset($_POST['module50'])) ? 1 : 0;
$MacResellerActiveClients  = (isset($_POST['module51'])) ? 1 : 0;
$Agent  = (isset($_POST['module52'])) ? 1 : 0;
$AgentView  = (isset($_POST['module53'])) ? 1 : 0;
$Server  = (isset($_POST['module54'])) ? 1 : 0;

$mod1 = mysql_query("UPDATE module SET $type = '$Reports' WHERE id = 2");
$mod2 = mysql_query("UPDATE module SET $type = '$Salary' WHERE id = 3");
$mod3 = mysql_query("UPDATE module SET $type = '$Zone' WHERE id = 4");
$mod5 = mysql_query("UPDATE module SET $type = '$Employee' WHERE id = 5");
$mod6 = mysql_query("UPDATE module SET $type = '$Users' WHERE id = 6");
$mod6 = mysql_query("UPDATE module SET $type = '$Package' WHERE id = 7");
$mod8 = mysql_query("UPDATE module SET $type = '$Clients' WHERE id = 8");
$mod11 = mysql_query("UPDATE module SET $type = '$Billing' WHERE id = 11");
$mod12 = mysql_query("UPDATE module SET $type = '$UserLoginReport' WHERE id = 14");
$mod13 = mysql_query("UPDATE module SET $type = '$Support' WHERE id = 23");
$mod14 = mysql_query("UPDATE module SET $type = '$SignupBill' WHERE id = 25");
$mod15 = mysql_query("UPDATE module SET $type = '$Upcoming' WHERE id = 26");
$mod16 = mysql_query("UPDATE module SET $type = '$LocationChange' WHERE id = 27");
$mod17 = mysql_query("UPDATE module SET $type = '$PackageChange' WHERE id = 29");
$mod18 = mysql_query("UPDATE module SET $type = '$Store' WHERE id = 31");
$mod19 = mysql_query("UPDATE module SET $type = '$ClientsBill' WHERE id = 32");
$mod21 = mysql_query("UPDATE module SET $type = '$ReportGraph' WHERE id = 35");
//$mod22 = mysql_query("UPDATE module SET $type = '$UserAccess' WHERE id = 36");
$mod23 = mysql_query("UPDATE module SET $type = '$SMS' WHERE id = 37");
$mod24 = mysql_query("UPDATE module SET $type = '$backup_db' WHERE id = 38");
$mod25 = mysql_query("UPDATE module SET $type = '$MacReseller' WHERE id = 39");
$mod26 = mysql_query("UPDATE module SET $type = '$MacResellerBillHistory' WHERE id = 40");
$mod27 = mysql_query("UPDATE module SET $type = '$Expanse' WHERE id = 41");
$mod28 = mysql_query("UPDATE module SET $type = '$NewSignup' WHERE id = 42");
$mod29 = mysql_query("UPDATE module SET $type = '$Network' WHERE id = 43");
$mod30 = mysql_query("UPDATE module SET $type = '$Bank' WHERE id = 46");
$mod31 = mysql_query("UPDATE module SET $type = '$FundTransfer' WHERE id = 47");
$mod32 = mysql_query("UPDATE module SET $type = '$Loan' WHERE id = 48");
$mod33 = mysql_query("UPDATE module SET $type = '$VendorBill' WHERE id = 49");
$mod34 = mysql_query("UPDATE module SET $type = '$NetworkTree' WHERE id = 50");
$mod35 = mysql_query("UPDATE module SET $type = '$MacResellerActiveClients' WHERE id = 51");
$mod36 = mysql_query("UPDATE module SET $type = '$Agent' WHERE id = 52");
$mod37 = mysql_query("UPDATE module SET $type = '$AgentView' WHERE id = 53");
$mod38 = mysql_query("UPDATE module SET $type = '$Server' WHERE id = 54");

$modo11 = mysql_query("UPDATE module SET position = '$pos2' WHERE id = '$posid2'");
$modo12 = mysql_query("UPDATE module SET position = '$pos3' WHERE id = '$posid3'");
$modo13 = mysql_query("UPDATE module SET position = '$pos4' WHERE id = '$posid4'");
$modo14 = mysql_query("UPDATE module SET position = '$pos5' WHERE id = '$posid5'");
$modo15 = mysql_query("UPDATE module SET position = '$pos6' WHERE id = '$posid6'");
$modo16 = mysql_query("UPDATE module SET position = '$pos7' WHERE id = '$posid7'");
$modo17 = mysql_query("UPDATE module SET position = '$pos8' WHERE id = '$posid8'");
$modo18 = mysql_query("UPDATE module SET position = '$pos11' WHERE id = '$posid11'");
$modo19 = mysql_query("UPDATE module SET position = '$pos14' WHERE id = '$posid14'");
$modo110 = mysql_query("UPDATE module SET position = '$pos23' WHERE id = '$posid23'");
$modo111 = mysql_query("UPDATE module SET position = '$pos25' WHERE id = '$posid25'");
$modo112 = mysql_query("UPDATE module SET position = '$pos26' WHERE id = '$posid'26");
$modo113 = mysql_query("UPDATE module SET position = '$pos27' WHERE id = '$posid27'");
$modo114 = mysql_query("UPDATE module SET position = '$pos29' WHERE id = '$posid29'");
$modo115 = mysql_query("UPDATE module SET position = '$pos31' WHERE id = '$posid31'");
$modo116 = mysql_query("UPDATE module SET position = '$pos32' WHERE id = '$posid32'");
$modo118 = mysql_query("UPDATE module SET position = '$pos35' WHERE id = '$posid35'");
//$modo119 = mysql_query("UPDATE module SET position = '$pos36' WHERE id = '$posid36'");
$modo120 = mysql_query("UPDATE module SET position = '$pos37' WHERE id = '$posid37'");
$modo121 = mysql_query("UPDATE module SET position = '$pos38' WHERE id = '$posid38'");
$modo122 = mysql_query("UPDATE module SET position = '$pos39' WHERE id = '$posid39'");
$modo123 = mysql_query("UPDATE module SET position = '$pos40' WHERE id = '$posid40'");
$modo124 = mysql_query("UPDATE module SET position = '$pos41' WHERE id = '$posid41'");
$modo125 = mysql_query("UPDATE module SET position = '$pos42' WHERE id = '$posid42'");
$modo126 = mysql_query("UPDATE module SET position = '$pos43' WHERE id = '$posid43'");
$modo127 = mysql_query("UPDATE module SET position = '$pos46' WHERE id = '$posid46'");
$modo128 = mysql_query("UPDATE module SET position = '$pos47' WHERE id = '$posid47'");
$modo129 = mysql_query("UPDATE module SET position = '$pos48' WHERE id = '$posid48'");
$modo130 = mysql_query("UPDATE module SET position = '$pos49' WHERE id = '$posid49'");
$modo131 = mysql_query("UPDATE module SET position = '$pos50' WHERE id = '$posid50'");
$modo132 = mysql_query("UPDATE module SET position = '$pos51' WHERE id = '$posid51'");
$modo133 = mysql_query("UPDATE module SET position = '$pos52' WHERE id = '$posid52'");
$modo134 = mysql_query("UPDATE module SET position = '$pos53' WHERE id = '$posid53'");
$modo133 = mysql_query("UPDATE module SET position = '$pos54' WHERE id = '$posid54'");

?>
<html>
<body>
     <form action="UserAccess" method="post" name="done">
       <input type="hidden" name="sts" value="update">
       <input type="hidden" name="type" value="<?php echo $type;?>">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
<?php

mysql_close($con);
?>