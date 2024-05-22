<?php
include("conn/connection.php") ;
extract($_POST);

if( empty($_POST['voucher_no']) || empty($_POST['p_sl_no']) )	{ }else	{
		$query="insert into store_in 
		(purchase_date, 
			voucher_no, 
				purchase_by, 
					vendor, 
						p_sts, 
							p_sl_no, 
								p_id, 
									brand, 
										fiber_id, 
											fiberstart, 
												fiberend, 
													fibertotal, 
														quantity, 
															price, 
																rimarks, 
																	entry_by, 
																		entry_time) 
																			VALUES ('$purchase_date',
																		'$voucher_no',
																	'$purchase_by',
																'$vendor',
															'$p_sts',
														'$p_sl_no',
													'$p_id',
												'$brand',
											'$fiber_id',
										'$fiberstart',
									'$fiberend',
								'$fibertotal',
							'$quantity',
						'$price',
					'$rimarks',
				'$entry_by',
			'$entry_time')";
		
		

		$sql = mysql_query($query);	}
if ($sql)
	{
		header("location: ProductIn");
	}
else
	{
		echo 'Error, Please try again';
	}
mysql_close($con);
?>