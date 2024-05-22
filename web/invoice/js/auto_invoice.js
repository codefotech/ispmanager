/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */
	      
//adds extra table rows
var i=2;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td class="center"><input type="checkbox" class="case"/></td>';
	html += '<td class="center case" style="font-size: 17px;font-weight: bold;padding: 10px 0;color: red;">'+i+'</td>';
	html += '<input type="hidden" style="width: 85%;" data-type="qtyy" name="qty[]" required="" id="qty_'+i+'" class="form-control autocomplete_txt" autocomplete="off">';
	html += '<input type="hidden" style="width: 85%;" data-type="productCode" name="itemNo[]" required="" id="itemNo_'+i+'" class="form-control autocomplete_txt" autocomplete="off">';
	html += '<td class="center"><input type="text" style="width: 92%;" data-type="productName" name="itemName[]" required="" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;" name="brand[]" id="brand_'+i+'" class="form-control" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;" name="slno[]" id="slno_'+i+'" class="form-control" autocomplete="off"></td>';
	html += '<td class="center"><select style="width: 92%;" class="form-control" name="prosts[]" id="prosts_'+i+'" autocomplete="off"><option value="Brand New">Brand New</option><option value="Replaced">Replaced</option><option value="Old">Old</option><option value="Repaird">Repaird</option></select></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="uniteprice[]" id="uniteprice_'+i+'" required="" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="quantity[]" id="quantity_'+i+'" class="form-control changesNo" autocomplete="on" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_'+i+'" readonly class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('.nnew').append(html);
	i++;
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

//autocomplete script for Client
$(document).on('focus','.autocompleteClint',function(){
	type = $(this).data('type');
	
	if(type =='clientId')autoTypeNo=0;	
	if(type =='clientName')autoTypeNo=1; 	
	
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'ajaxClint.php',
				dataType: "json",
				method: 'post',
				data: {
				   Clint_name_startsWith: request.term,
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
			$('#clientId').val(names[0]);
			$('#clientName').val(names[1]);
			$('#clientCell').val(names[2]);
			$('#clientAddress').val(names[3]);
		}		      	
	});
});

//autocomplete script for Model
$(document).on('focus','.autocompleteModel',function(){
	type = $(this).data('type');
	
	if(type =='model_id' )autoTypeNo=0;
	
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'ajaxModel.php',
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
			$('#itemModel_'+id[1]).val(names[0]);
		}		      	
	});
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
	if( quantity!='' && price !='' ) $('#price_'+id[1]).val( (((parseFloat(price)*parseFloat(quantity))*parseFloat(vat))/100+(parseFloat(price)*parseFloat(quantity))).toFixed(2) );	
	calculateTotal();
});

$(document).on('change keyup blur','#tax',function(){
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
