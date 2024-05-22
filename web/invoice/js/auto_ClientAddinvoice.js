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

var x=2;
$(".addmore1").on('click',function(){
	html = '<tr>';
	html += '<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input type="checkbox" class="case1"/></td>';
	html += '<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="ipaddress[]" id="ipaddress_'+x+'" placeholder="IP Address '+x+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '</tr>';
	$('.nnew1').append(html);
	x++;
});

var a=2;
$(".addmore2").on('click',function(){
	html = '<tr>';
	html += '<td class="center"><input type="checkbox" class="case2"/></td>';
	html += '<td class="center case2" style="font-size: 17px;font-weight: bold;padding: 10px 0;color: red;">'+a+'</td>';
	html += '<input type="hidden" style="width: 85%;" data-type="productCode" name="itemNo[]" required="" id="itemNo_'+a+'" class="form-control autocomplete_txt" autocomplete="off">';
	html += '<td class="center"><input type="text" style="width: 92%;" placeholder="Like: BDIX, Youtube" data-type="productName" name="itemName[]" required="" id="itemName_'+a+'" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;" data-type="productDes" name="itemDes[]" id="itemDes_'+a+'" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="quantity[]" id="quantity_'+a+'" required="" class="form-control changesNo" autocomplete="on" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-weight: bold;text-align: center;" data-type="productUnit" class="" name = "unit[]" id = "unit_'+a+'" class="changesNo form-control autocomplete_txt" autocomplete="off" readonly/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="uniteprice[]" id="uniteprice_'+a+'" required="" class="changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" data-type="productVat" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="vat[]" class="changesNo" id="vat_'+a+'" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_'+a+'" readonly class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('.nnew2').append(html);
	a++;
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
			$('#quantity_'+id[1]).val(0);
			$('#uniteprice_'+id[1]).val(0);
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
	
	if( quantity !='' && price !='' && vat !='' ) {
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