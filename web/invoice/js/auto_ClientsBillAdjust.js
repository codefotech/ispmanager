
//adds extra table rows
var now = new Date();
var MonthLastDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
var MonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() + 12) % 12, 1);
var firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
var formatDateComponent = function(dateComponent) {
  return (dateComponent < 10 ? '0' : '') + dateComponent;
};

var formatDate = function(date) {
  return  formatDateComponent(date.getDate()) + '-' + formatDateComponent(date.getMonth() + 1) + '-' + date.getFullYear();
};

var aaa=200;
var lastdayyy = new Date(new Date(new Date().setMonth(now.getMonth() + 1)).setDate(0)).getDate();
var lastdayyy1 = (lastdayyy - now.getDate())+1;
$(".addmorenew").on('click change',function(){
	html = '<tr>';
	html += '<td class="center"><input type="checkbox" class="case2"/></td>';
	html += '<input type="hidden" style="width: 85%;" data-type="productCode" name="itemNo[]" required="" id="itemNo_'+aaa+'" class="form-control autocomplete_txt" autocomplete="off">';
	html += '<td class="center"><input type="text" style="width: 92%;" placeholder="Like: BDIX, Youtube" data-type="productName" name="itemName[]" required="" id="itemName_'+aaa+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;" name="itemDes[]" id="itemDes_'+aaa+'" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="quantity[]" id="quantity_'+aaa+'" required="" class="form-control changesNo" autocomplete="on" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-weight: bold;text-align: center;" data-type="productUnit" name = "unit[]" id = "unit_'+aaa+'" readonly="" class="changesNo form-control autocomplete_txt" autocomplete="off"/></td>';	
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" name="uniteprice[]" id="uniteprice_'+aaa+'" required="" class="form-control changesNo ui-autocomplete-input" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" data-type="productVat" required="" name="vat[]" class="changesNo" id="vat_'+aaa+'" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="start_date[]" id="startdate_'+aaa+'" value="'+formatDate(now)+'" class="changesNo form-control datepicker" placeholder="" readonly="" autocomplete="off"/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="end_date[]" id="enddate_'+aaa+'" value="'+formatDate(MonthLastDate)+'" class="changesNo form-control datepicker" placeholder="" readonly="" autocomplete="off"/></td>';
	html += '<td class="center"><input type="text" style="width: 80%;font-size: 14px;font-weight: 700;text-align: center;" data-type="daysss" required="" name="days[]" id="days_'+aaa+'" value="'+lastdayyy1+'" class="changesNo" placeholder="" readonly="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_'+aaa+'" readonly class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('.nnew200').append(html);
	aaa++;
	
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
        startDate: formatDate(MonthFirstDate),
        endDate: formatDate(MonthLastDate),
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
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
	if(type =='daysss')autoTypeNo=5;
	
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
			
			d1 = $('#startdate_'+id[1]).val().split('-');
			d2 = $('#enddate_'+id[1]).val().split('-');
			normd1 = [d1[1], d1[0], d1[2]];
			normd2 = [d2[1], d2[0], d2[2]];
			diff = Math.abs((Date.parse(normd1)) - Date.parse(normd2));
			days = Math.ceil(diff/(1000*60*60*24));

			$('#days_'+id[1]).val(days+1);
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
	d1 = $('#startdate_'+id[1]).val().split('-');
	d2 = $('#enddate_'+id[1]).val().split('-');
	normd1 = [d1[1], d1[0], d1[2]];
	normd2 = [d2[1], d2[0], d2[2]];
	diff = Math.abs((Date.parse(normd1)) - Date.parse(normd2));
	daysd = Math.ceil(diff/(1000*60*60*24));
	days = $('#days_'+id[1]).val(daysd+1);
	
	lastday = new Date(new Date(new Date().setMonth(d1[1])).setDate(0)).getDate();
	if( normd1 > normd2 ){
		$('#price_'+id[1]).val(0.00);
	}
	else{
		if( quantity !='' && price !='' && vat !='' ){
			$('#price_'+id[1]).val( (((((parseFloat(price)*parseFloat(quantity))*parseFloat(vat))/100+(parseFloat(price)*parseFloat(quantity)))/lastday)*(daysd+1)).toFixed(2) );	
		}
		else{
			$('#price_'+id[1]).val(0);
		}
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