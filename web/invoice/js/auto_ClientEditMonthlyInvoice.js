/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */
	      
//adds extra table rows
var i=2;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case"/></td>';
	html += '<td class="center" style="border-top: 1px solid #dddddd;width: 30%;"><input type="text" style="width: 92%;" name="vlanId[]" id="ivlanId_'+i+'" placeholder="VLAN ID" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="vlanName[]" id="vlanName_'+i+'" placeholder="VLAN Name" class="form-control" autocomplete="off"></td>';
	html += '</tr>';
	$('.nnew').append(html);
	i++;
});

var i=2;
$(".addmore5").on('click',function(){
	html = '<tr>';
	html += '<td class="center" style="width: 1%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case5"/><input type="hidden" name="mid[]" id="mid_'+i+'" value="'+i+'"/></td>';
	html += '<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="methodname[]" id="methodname_'+i+'" placeholder="Online Method Name" class="form-control" autocomplete="off" required=""></td>';
	html += '<td class="center" style="border-top: 1px solid #dddddd;"><input type="checkbox" name="online[]" id="online_'+i+'" value="1" checked="checked">&nbsp;<b>Yes</b></td>';
	html += '</tr>';
	$('.nnew5').append(html);
	i++;
});


var x=2;
$(".addmore1").on('click',function(){
	html = '<tr>';
	html += '<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case1"/></td>';
	html += '<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="ipaddress[]" id="ipaddress_'+x+'" placeholder="IP Address '+x+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '</tr>';
	$('.nnew1').append(html);
	x++;
});

var aa=200;
$(".addmoreedit").on('click',function(){
	html = '<tr>';
	html += '<td class="center"><input type="checkbox" class="case2"/></td>';
	html += '<input type="hidden" style="width: 85%;" data-type="productCode" name="itemNo[]" required="" id="itemNo_'+aa+'" class="form-control changesNo autocomplete_txt" autocomplete="off">';
	html += '<td class="center"><input type="text" style="width: 92%;" placeholder="Like: BDIX, Youtube" data-type="productName" name="itemName[]" required="" id="itemName_'+aa+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;" name="itemDes[]" id="itemDes_'+aa+'" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="quantity[]" id="quantity_'+aa+'" required="" class="form-control changesNo autocomplete_txt" autocomplete="on" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-weight: bold;text-align: center;" data-type="productUnit" class="" name = "unit[]" id = "unit_'+aa+'" class="changesNo form-control autocomplete_txt" autocomplete="off" readonly/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="uniteprice[]" id="uniteprice_'+aa+'" required="" class="form-control changesNo autocomplete_txt" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" data-type="productVat" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="vat[]" class="changesNo" id="vat_'+aa+'" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_'+aa+'" readonly class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('.nnew20').append(html);
	aa++;
});


//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
	calculateTotal();
});

//to check all checkboxes
$(document).on('change','#check_all5',function(){
	$('input[class=case5]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete5").on('click', function() {
	$('.case5:checkbox:checked').parents("tr").remove();
	$('#check_all5').prop("checked", false); 
	calculateTotal();
});

$(document).on('change','#check_all1',function(){
	$('input[class=case1]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete1").on('click', function() {
	$('.case1:checkbox:checked').parents("tr").remove();
	$('#check_all1').prop("checked", false); 
	calculateTotal();
});

$(document).on('change','#check_all2',function(){
	$('input[class=case2]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete2").on('click', function() {
	$('.case2:checkbox:checked').parents("tr").remove();
	$('#check_all2').prop("checked", false); 
	calculateTotal();
});

//autocomplete script for Product
$(document).on('focus','.autocomplete_txt',function(){
	type = $(this).data('type');
	
	if(type =='productCode')autoTypeNo=0;
	if(type =='productName')autoTypeNo=1;
	if(type =='productDes')autoTypeNo=2;
	if(type =='productUnit')autoTypeNo=3;
	if(type =='productVat')autoTypeNo=4;
	
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'invoice/ajax_invoice.php',
				dataType: "json",
				method: 'post',
				data: {
				   name_startsWith: request.term,
				   type: type
				},
				 success: function( data ) {
					 response( $.map( data, function( item ) {
					 	var code = item.split("|");
						return {
							label: code[autoTypeNo],
							value: code[autoTypeNo],
							data : item
						}
					}));
				}
			});
		},
		autoFocus: true,	      	
		minLength: 0,
		select: function( event, ui ) {
			var names = ui.item.data.split("|");						
			id_arr = $(this).attr('id');
	  		id = id_arr.split("_");
			$('#itemNo_'+id[1]).val(names[0]);
			$('#itemName_'+id[1]).val(names[1]);
			$('#itemDes_'+id[1]).val(names[2]);
			$('#unit_'+id[1]).val(names[3]);
			$('#vat_'+id[1]).val(names[4]);
			$('#uniteprice_'+id[1]).val(0);
			$('#quantity_'+id[1]).val(0);
			$('#price_'+id[1]).val(0.00);
			calculateTotal();
		}
	});
});

//price change
$(document).on('change keyup blur','.changesNo',function(){
	id_arr = $(this).attr('id');
	id = id_arr.split("_");
	quantity = $('#quantity_'+id[1]).val();
	price = $('#uniteprice_'+id[1]).val();
	vat = $('#vat_'+id[1]).val();
	
	if( quantity !='' && price !='' && vat !='' ){
		$('#price_'+id[1]).val( (((parseFloat(price)*parseFloat(quantity))*parseFloat(vat))/100+(parseFloat(price)*parseFloat(quantity))).toFixed(2) );
		}
	else{
		$('#price_'+id[1]).val(0);
	}
	calculateTotal();
});

$(document).on('change keyup blur','#tax',function(){
	calculateTotal();
});

$(document).on('change keyup blur','.datepicker',function(){
	calculateTotal();
});

//total price calculation 
function calculateTotal(){
	subTotal = 0 ; total = 0; 
	$('.totalLinePrice').each(function(){
		if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
	});
	$('#subTotal').val( subTotal.toFixed(2) );
	tax = $('#tax').val();
	if(tax != '' && typeof(tax) != "undefined" ){
		//taxAmount = subTotal * ( parseFloat(tax) /100 );
		//$('#taxAmount').val(taxAmount.toFixed(2));
		total = subTotal - tax;
	}else{
		//$('#taxAmount').val(0);
		total = subTotal;
	}
	$('#totalAftertax').val( total.toFixed(2) );
	calculateAmountDue();
}

$(document).on('change keyup blur','#amountPaid',function(){
	calculateAmountDue();
});

//due amount calculation
function calculateAmountDue(){
	amountPaid = $('#amountPaid').val();
	total = $('#totalAftertax').val();
	if(amountPaid != '' && typeof(amountPaid) != "undefined" ){
		amountDue = parseFloat(total) - parseFloat( amountPaid );
		$('.amountDue').val( amountDue.toFixed(2) );
	}else{
		total = parseFloat(total).toFixed(2);
		$('.amountDue').val( total );
	}
}

//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}