<?php include_once('company_info.php'); 
if($user_type == 'admin' || $user_type == 'superadmin'){
	$con_no = '01732197767';
	$con_nooo = '<a href="tel:'.$con_no.'">'.$con_no.'</a>';
}
else{
	$con_nooo = '<a href="tel:'.$company_cell.'">'.$company_cell.'</a>';
}
$startat = $_SERVER['REQUEST_TIME_FLOAT'];
$endsss = microtime(true);
$loadTime = $endsss - $startat;
$loadTimeMs = number_format($loadTime, 4);
?>
</div><!--maincontentinner--> 
       </div><!--maincontent-->
			<div class="footer" id="cont">
				<table style="width:100%">
					<tr>
						<td style="text-align: left; width: 50%;">
							<div id="left">
								<span style="font-weight: bold;font-size: 12px;"><?php echo $user_infoo.' | '.$loadTimeMs.' Sec(s)';?></span>
							</div>
						</td>
						<td style="text-align: right; width: 50%;">
							<div id="right">
								<span style="font-weight: bold;font-size: 12px;"><?php echo $footer.'  |  '.$con_nooo;?></span>
							</div>
						</td>
					</tr>
				</table>
            </div><!--footer-->
    </div><!--rightpanel-->
</div><!--mainwrapper-->
</body>
</html>