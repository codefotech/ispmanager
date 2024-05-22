<?php
$titel = "SMS";
$SMS = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-comment"></i></div>
        <div class="pagetitle">
            <h1>SMS Template</h1>
        </div>
    </div><!--pageheader-->

		<div class="messagepanel">
			<div class="messagecontent">
                        <div class="messageleft" style="float: right;width: 25%;">
                            <ul class="msglist" style="height: max-content;">
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Client Company ID</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Client PPPoE ID</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Client Password</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Client Full Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Full Address</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Fathers Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Email Address</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Package Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Package Price</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Package Bandwidth</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Permanent Discount</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Extra Bill]</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Payment Deadline [10/20]</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Billing Deadline [10/20]</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Total Due Amount</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Cable Type [UTP/FIBER]</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Billman Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Technician Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Zone Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Box Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Zone Employee Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Zone Employee Cell</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Zone Reseller Name</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'>Zone Reseller Cell</h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'><?php echo $comp_name;?></h4>
                                    </div>
                                </li>
                                <li class="list-group-item" style="padding: 8px;border-right: 0px solid gray;border-top: 0px solid gray;border-left: 0px solid gray;margin-bottom: 0px;">
                                    <div class="summary" style="margin: 0px;">
                                        <h4 style='font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;'><?php echo $company_cell;?></h4>
                                    </div>
                                </li>
                            </ul>
                        </div><!--messageleft-->
                        <div class="messageleft" style="float: right;width: 20%;border-left: 1px solid #bbb;border-right: 1px solid #bbb;">
                            <ul class="msglist" style="height: max-content;">
                                <li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{company_id}}">{{company_id}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{c_id}}">{{c_id}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{password}}">{{password}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{c_name}}">{{c_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{address}}">{{address}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{father_name}}">{{father_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{email}}">{{email}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{package_name}}">{{package_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{package_price}}">{{package_price}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{package_bandwidth}}">{{package_bandwidth}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{p_discount}}">{{p_discount}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{extra_bill}}">{{extra_bill}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{payment_deadline}}">{{payment_deadline}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{billing_deadline}}">{{billing_deadline}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{due_amount}}">{{due_amount}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{cable_type}}">{{cable_type}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{bill_man}}">{{bill_man}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{technician}}">{{technician}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{zone_name}}">{{zone_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{box_name}}">{{box_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{zone_employee_name}}">{{zone_employee_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{zone_employee_cell}}">{{zone_employee_cell}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{zone_reseller_name}}">{{zone_reseller_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{zone_reseller_cell}}">{{zone_reseller_cell}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{company_name}}">{{company_name}}</button>
									</div>
								</li>
								<li style="padding: 0px;">
                                    <div class="summary" style="margin: 0px;">
										 <button type="submit" class="btn" style='color: #555;margin: 0px;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 15px;font-weight: bold;width: 100%;border: 1px solid white;' value="{{company_cell}}">{{company_cell}}</button>
									</div>
								</li>
                            </ul>
                        </div><!--messageleft-->
			        <form id="form" class="stdform" method="post" action="SMSSavedTemplatesAddQuery">
                        <div class="messageright" style="margin: 0;min-height: 1185px;border-width: 0px;">
                            <div class="messageview">
									<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
									<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
									<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="add_by" />
									<input type="hidden" value="add" name="template_way"/>
								<p>
									<label style="font-weight: bold;">Template Name*</label>
									<span class="field"><input type="text" name="template_name" id="" required="" class="input-xlarge" /></span>
								</p>
								<p>
									<label style="font-weight: bold;">Template For*</label>
									<span class="field">
										<select class="chzn-select" name="template_for" style="width: 38%;" required="" >
											<option value="Clients">Clients</option>
											<option value="Mac-Reseller">Mac-Reseller</option>
											<option value="Employee">Employee</option>
										</select>
									</span>
								</p>
								<p>
									<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
									<span class="field"><textarea type="text" name="sms_msg" id="sms_msg" style="width:90%;height: 476px;line-height: 30px;font-size: 16px;font-weight: bold;" required="" id="" placeholder="" class="input-large" /></textarea></span>
								</p>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								<div class="modal-footer">
									<button type="reset" class="btn ownbtn11">Reset</button>
									<button class="btn ownbtn2" type="submit">Submit</button>
								</div>
                            </div><!--messageview-->
							
                        </div><!--messageright-->
					</form>
            </div><!--messagecontent-->
		</div>

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
  <script type="text/javascript">
let currentInput = $('#sms_msg');
$(document).on('focus', 'textarea', function() {
	currentInput = $(this);
})

$( 'button[type=submit]' ).on('click', function(){
  let cursorPos = currentInput.prop('selectionStart');
  let v = currentInput.val();
  let textBefore = v.substring(0,  cursorPos );
  let textAfter  = v.substring( cursorPos, v.length );
  currentInput.val( textBefore+ $(this).val() +textAfter );
});
  </script>
  
<style>
.kghhgk{
    font-family: Monaco,Menlo,Consolas,"Courier New",monospace;
    font-size: 15px;
    font-weight: bold;
}
</style>