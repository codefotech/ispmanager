<?php 

$sms_footer = 'Thanks
'.$comp_name.'
'.$company_cell.'';

if($from_page = 'Add Client'){
	
$sms_body='Your ID: '.$user_id.'
PW: '.$passid.'
Pay Your Bill 01-07 of running month.

'.$sms_footer.'';
}


if($from_page = 'Add SMS'){
$sms_body = $sms_write;
}


?>
