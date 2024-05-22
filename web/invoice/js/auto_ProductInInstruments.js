var aaa=2;
$(".addmorenew").on('click',function(){
	html = '<tr>';
	html += '<td class="center"><input type="checkbox" class="case2"/></td>';
	html += '<td class="center case2" style="font-size: 17px;font-weight: bold;padding: 10px 0;color: red;">'+aaa+'.</td>';
	html += '<input type="hidden" data-type="productCode" name="itemNo[]" required="" id="itemNo_'+aaa+'" class="changesNo form-control autocomplete_txt" autocomplete="off">';
	html += '<td class="center"><input type="text" style="width: 92%;" data-type="productName" name="productName[]" required="" placeholder="Like: Router, Onu" id="itemName_'+aaa+'" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td class="center"><input type="text" style="width: 88%;" name="brand[]" placeholder="Brand Name" id="brand_'+aaa+'" required="" class="changesNo form-control" autocomplete="off"></td>';
	html += '<td class="center"><select style="width: 92%;text-align: center;" name="psts[]" id="psts_'+aaa+'" required="" ><option value="Brand New">Brand New</option><option value="Replaced">Replaced</option><option value="Old">Old</option><option value="Repaird">Repaird</option></select></td>';
	html += '<td class="center"><input type="text" style="width: 70%;font-weight: bold;text-align: center;" data-type="productUnit" class="" name="unit[]" id="unit_'+aaa+'" class="changesNo form-control" autocomplete="off" readonly /></td>';
	
	html += '<td class="center"><input type="text" style="width: 80%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="quantity[]" class="changesNo form-control qqqq" id="quantity_'+aaa+'" style="width: 92%;font-weight: bold;" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center" style="padding: 0.2% 0% 0.1% 0%;font-size: 13px;vertical-align: middle;font-weight: bold;color: #ff00008a;"><div id="slno'+aaa+'">SELECT PRODUCT</div></td>';
	
	html += '<input type="hidden" placeholder="" style="width: 92%;font-weight: bold;text-align: center;" data-type="qtystsss" name = "qtysts[]" required="" id = "qtysts_'+aaa+'" class="changesNo form-control autocomplete_txt" autocomplete="off"/>';
	
	html += '<td class="center"><input type="text" style="width: 80%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="uniteprice[]" class="changesNo form-control" id="uniteprice_'+aaa+'" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center"><input type="text" style="width: 70%;font-size: 14px;font-weight: 700;text-align: center;" data-type="productVat" required="" name="vat[]" class="changesNo form-control" id="vat_'+aaa+'" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>';
	html += '<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_'+aaa+'" readonly class="totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	
	$('.nnew200').append(html);
	aaa++;
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
$(document).on('focus keyup','.autocomplete_txt',function(){
	type = $(this).data('type');
	
	if(type =='productCode')autoTypeNo=0;
	if(type =='productName')autoTypeNo=1;
	if(type =='productUnit')autoTypeNo=2;
	if(type =='productVat')autoTypeNo=3;
	if(type =='qtystsss')autoTypeNo=4;
	
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'invoice/ajax_productInInstruments.php',
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
			$('#unit_'+id[1]).val(names[2]);
			$('#vat_'+id[1]).val(names[3]);
			$('#qtysts_'+id[1]).val(names[4]);
			$('#uniteprice_'+id[1]).val(0);
			$('#price_'+id[1]).val(0.00);
			$('#quantity_'+id[1]).val();
		calculateTotal();
		}
	});
});

//price change
$(document).on('change keyup','.changesNo',function(){
	id_arr = $(this).attr('id');
	id = id_arr.split("_");
	itemName = $('#itemName_'+id[1]).val();
	quantity = $('#quantity_'+id[1]).val();
	price = $('#uniteprice_'+id[1]).val();
	vat = $('#vat_'+id[1]).val();
	qtysts = $('#qtysts_'+id[1]).val();
	
	if( quantity !='' && price !='' && vat !='' ){ 
		$('#price_'+id[1]).val( (((parseFloat(price)*parseFloat(quantity))*parseFloat(vat))/100+(parseFloat(price)*parseFloat(quantity))).toFixed(2) );	
	}
	else{
		$('#price_'+id[1]).val(0);
	}
	calculateTotal();
});

//price change
$(document).on('change keyup blur','.qqqq',function(){
	var id_arr = $(this).attr('id');
	var id = id_arr.split("_");
	var itemNo = $('#itemNo_'+id[1]).val();
	var quantity = $('#quantity_'+id[1]).val();
	var qtysts = $('#qtysts_'+id[1]).val();
	
	container = document.getElementById("slno"+id[1]);
	while (container.hasChildNodes()) {
		container.removeChild(container.lastChild);
	}
	if( qtysts == '1' ){
		if(quantity < '0' || quantity == ''){
			container.appendChild(document.createTextNode("NEED QUANTITY"));
		}
		else{
			for (let i=1; i<=quantity; i++){

				input = document.createElement("input");
				input.type = "text";
				input.name = "slno["+itemNo+"][]";
				input.required = "required=''";
				input.id = "slno_"+itemNo+"_"+ i;
				input.placeholder = itemName + " S/L No: " + i;
				input.autocomplete = "off";
				input.className = "edhgdfh_"+itemNo+"_"+ i;
				input.style = "width: 80%;padding: 0px 4px 0px 4px;margin-bottom: 1px;margin-left: 3px;text-align: center;float: left;";
				container.appendChild(input);
				
				div = document.createElement("div");
				div.style = "width: 10%;float: left;";
				div.id = "edhgdfhss_"+itemNo+"_"+ i;
				container.appendChild(div);
				container.appendChild(document.createElement("br"));
				
			//start sl number check
				setTimeout(function(){
					
					var sl = "#slno_"+itemNo+"_"+ i;
					var slDiv = "#edhgdfhss_"+itemNo+"_"+ i;
					
					$(document).on('change keyup',sl,function(a){
						var val_1 = $(sl).val();
						if(val_1.length > 0)
						{
							$(slDiv).html('<img src="images/loaders/loader2.gif" alt="" width="15px" height="15px">');
							$.ajax({ 
								type: 'POST',
								url: "product-sl-chack.php",
								data:{duration: val_1},
								success:function(data){
									$(slDiv).html(data);
								}
							});
						}
						else{
							$(slDiv).html("");
						}
					});
					
				},1000);
			//end sl number check
			}
		}
	}
	else if( qtysts == '' ){
		container.appendChild(document.createTextNode("SELECT PRODUCT"));
	}
	else{
		container.appendChild(document.createTextNode("NO NEED"));
	}
});


$(document).on('change keyup blur','#tax',function(){
	calculateTotal();
});

$(document).on('change keyup blur','.datepicker',function(){
	calculateTotal();
});


//total price calculation 
function calculateTotal(){
	subTotal = 0; total = 0; 
	$('.totalLinePrice').each(function(){
		if( $(this).val() != '' )subTotal += parseFloat( $(this).val() );
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
	$('#v_totalAftertax').val( total.toFixed(2) );
	$('#e_totalAftertax').val( total.toFixed(2) );
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
