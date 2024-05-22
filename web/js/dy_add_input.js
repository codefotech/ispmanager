											   
      function showFatherHusband()
          {
              var father_husband = (document.getElementById("father_husband").value);
			  
			  var father_husband_name = document.getElementById("father_husband_name");
			  
			   var Father = document.getElementById("father");
              var Husband = document.getElementById("husband");
			  
			  

                Father.style.display = "none";
                Husband.style.display = "none";
				
				  
				  if (father_husband == "0") 
                      { 
					    father_husband_name.style.display = "";
					    
                      }
                                           
                  else if (father_husband == "1") 
                      { 
					    father_husband_name.style.display = "none";
					    Father.getElementsByTagName('label')[0].innerHTML="Father's Name";
                        Father.style.display = "";
                      }

                 else if (father_husband == "2") 
                     {
					  father_husband_name.style.display = "none";
					  Husband.getElementsByTagName('label')[0].innerHTML="Husband's Name";
                      Husband.style.display = "";
                     }
          }
		  
	
	
	
	function ValidateAlpha(evt)
        {
            var keyEntry = (evt.which) ? evt.which : evt.keyCode;
            if (((keyEntry >= '65') && (keyEntry <= '90')) || ((keyEntry >= '97') && (keyEntry <= '122')) || (keyEntry == '46') || (keyEntry == '32') || keyEntry == '45')
 
		    return true;
		 
		  else
		 
			{
			 
			  alert('Please Enter Only Character values.');
			 
			  return false;
			 
			}
        }
		
		
		
		function validation1(evt1)
        {
            var keyEntry1 = (evt1.which) ? evt1.which : evt1.keyCode;
            if (((keyEntry1 >= '65') && (keyEntry1 <= '90')) || ((keyEntry1 >= '97') && (keyEntry1 <= '122')) || (keyEntry1 == '46') || (keyEntry1 == '32') || keyEntry1 == '45')
 
		    return true;
		 
		  else
		 
			{
			 
			  alert('Please Enter Only Character values.');
			 
			  return false;
			 
			}
        }
		
		
		function validation2(evt2)
        {
            var keyEntry2 = (evt2.which) ? evt2.which : evt2.keyCode;
            if (((keyEntry2 >= '65') && (keyEntry2 <= '90')) || ((keyEntry2 >= '97') && (keyEntry2 <= '122')) || (keyEntry2 == '46') || (keyEntry2 == '32') || keyEntry2 == '45')
 
		    return true;
		 
		  else
		 
			{
			 
			  alert('Please Enter Only Character values.');
			 
			  return false;
			 
			}
        }
		
		function validation3(evt3)
        {
            var keyEntry3 = (evt3.which) ? evt3.which : evt3.keyCode;
            if (((keyEntry3 >= '65') && (keyEntry3 <= '90')) || ((keyEntry3 >= '97') && (keyEntry3 <= '122')) || (keyEntry3 == '46') || (keyEntry3 == '32') || keyEntry3 == '45')
 
		    return true;
		 
		  else
		 
			{
			 
			  alert('Please Enter Only Character values.');
			 
			  return false;
			 
			}
        }
		
		
 function isNumberKey(evt)
 {  
					//var e = evt || window.event;
					var charCode = (evt.which) ? evt.which : evt.keyCode;
						if (charCode != 46 && charCode > 31 
						&& (charCode < 48 || charCode > 57))
						{
						 return false;
						}
						
						return true;
}
	
	 
function isNumberKey0(evt0)
 {  
					//var e = evt || window.event;
					var charCode0 = (evt0.which) ? evt0.which : evt0.keyCode;
						if (charCode0 != 46 && charCode0 > 31 
						&& (charCode0 < 48 || charCode0 > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 
	 function isNumberKeyp1(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 

function isNumberKeyp2(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 function isNumberKeyp3(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 


function isNumberKeyp4(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 
	 function isNumberKeyp5(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 
	 function isNumberKeyp6(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 function isNumberKeyp7(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 
	 function isNumberKeyp8(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 

function isNumberKeyp9(evtp)
 {  
					//var e = evt || window.event;
					var charCodep = (evtp.which) ? evtp.which : evtp.keyCode;
						if (charCodep != 46 && charCodep > 31 
						&& (charCodep < 48 || charCodep > 57))
						{
						 return false;
						}
						
						return true;
} 
	 
	 function isNumberKey1(evt1)
 {  
					//var e = evt || window.event;
					var charCode1 = (evt1.which) ? evt1.which : evt1.keyCode;
						if (charCode1 != 46 && charCode1 > 31 
						&& (charCode1 < 48 || charCode1 > 57))
						{
						 return false;
						}
						
						return true;
}
	 
	 
	 function isNumberKey2(evt2)
 {  
					//var e = evt || window.event;
					var charCode2 = (evt2.which) ? evt2.which : evt2.keyCode;
						if (charCode2 != 46 && charCode2 > 31 
						&& (charCode2 < 48 || charCode2 > 57))
						{
						 return false;
						}
						
						return true;
}
	 
	 
	 function isNumberKey3(evt3)
 {  
					//var e = evt || window.event;
					var charCode3 = (evt3.which) ? evt3.which : evt3.keyCode;
						if (charCode3 != 46 && charCode3 > 31 
						&& (charCode3 < 48 || charCode3 > 57))
						{
						 return false;
						}
						
						return true;
}
	 
	 function isNumberKey4(evt4)
 {  
					//var e = evt || window.event;
					var charCode4 = (evt4.which) ? evt4.which : evt4.keyCode;
						if (charCode4 != 46 && charCode4 > 31 
						&& (charCode4 < 48 || charCode4 > 57))
						{
						 return false;
						}
						
						return true;
}


function isNumberKey5(evt5)
 {  
					//var e = evt || window.event;
					var charCode5 = (evt5.which) ? evt5.which : evt5.keyCode;
						if (charCode5 != 46 && charCode5 > 31 
						&& (charCode5 < 48 || charCode5 > 57))
						{
						 return false;
						}
						
						return true;
}

	
function isNumberKey6(evt6)
 {  
					//var e = evt || window.event;
					var charCode6 = (evt6.which) ? evt6.which : evt6.keyCode;
						if (charCode6 != 46 && charCode6 > 31 
						&& (charCode6 < 48 || charCode6 > 57))
						{
						 return false;
						}
						
						return true;
}


function isNumberKey7(evt7)
 {  
					//var e = evt || window.event;
					var charCode7 = (evt7.which) ? evt7.which : evt7.keyCode;
						if (charCode7 != 46 && charCode7 > 31 
						&& (charCode7 < 48 || charCode7 > 57))
						{
						 return false;
						}
						
						return true;
}


function isNumberKey8(evt8)
 {  
					//var e = evt || window.event;
					var charCode8 = (evt8.which) ? evt8.which : evt8.keyCode;
						if (charCode8 != 46 && charCode8 > 31 
						&& (charCode8 < 48 || charCode8 > 57))
						{
						 return false;
						}
						
						return true;
}


function isNumberKey9(evt9)
 {  
					//var e = evt || window.event;
					var charCode9 = (evt9.which) ? evt9.which : evt9.keyCode;
						if (charCode9 != 46 && charCode9 > 31 
						&& (charCode9 < 48 || charCode9 > 57))
						{
						 return false;
						}
						
						return true;
}
	
function click_division()
{ 
 
	 var click_division_check=document.getElementById("division").value;
	 if(click_division_check=="1st division" || click_division_check=="2nd division" || click_division_check=="3rd division")
	 {
	  division();
	 }
 }
function division()
{ var disable1 = document.getElementById("division");
  
  if (disable1.value != "" || disable1.value.length > 0) 
  {   
      document.getElementById("cgpa").disabled = true;
  }
}

function click_cgpa()
{ 
 
	 var click_cgpa_check=document.getElementById("cgpa").value;
	 if(click_cgpa_check==0)
	 {
	  
	 }
	 else
	 {
	 cgpa();
	 }
 }
function cgpa()
{
var  disable2= document.getElementById("cgpa");
  if (disable2.value != "" || disable2.value.length > 0) 
  {
      document.getElementById("division").disabled = true;
  }
}
		  
	

function click_division2()
{ 
 
	 var click_division_check2=document.getElementById("division2").value;
	 if(click_division_check2=="1st division" || click_division_check2=="2nd division" || click_division_check2=="3rd division")
	 {
	  division2();
	 }
 }
function division2()
{ var disable12 = document.getElementById("division2");
  
  if (disable12.value != "" || disable12.value.length > 0) 
  {   
      document.getElementById("cgpa2").disabled = true;
  }
}

function click_cgpa2()
{ 
 
	 var click_cgpa_check2=document.getElementById("cgpa2").value;
	 if(click_cgpa_check2==0)
	 {
	  
	 }
	 else
	 {
	 cgpa2();
	 }
 }
function cgpa2()
{
var  disable22= document.getElementById("cgpa2");
  if (disable22.value != "" || disable22.value.length > 0) 
  {
      document.getElementById("division2").disabled = true;
  }
}



function click_division3()
{ 
 
	 var click_division_check3=document.getElementById("division3").value;
	 if(click_division_check3=="1st division" || click_division_check3=="2nd division" || click_division_check3=="3rd division")
	 {
	  division3();
	 }
 }
function division3()
{ var disable13 = document.getElementById("division3");
  
  if (disable13.value != "" || disable13.value.length > 0) 
  {   
      document.getElementById("cgpa3").disabled = true;
  }
}

function click_cgpa3()
{ 
 
	 var click_cgpa_check3=document.getElementById("cgpa3").value;
	 if(click_cgpa_check3==0)
	 {
	  
	 }
	 else
	 {
	 cgpa3();
	 }
 }
function cgpa3()
{
var  disable23= document.getElementById("cgpa3");
  if (disable23.value != "" || disable23.value.length > 0) 
  {
      document.getElementById("division3").disabled = true;
  }
}

function click_division4()
{ 
 
	 var click_division_check4=document.getElementById("division4").value;
	 if(click_division_check4=="1st division" || click_division_check4=="2nd division" || click_division_check4=="3rd division")
	 {
	  division4();
	 }
 }
function division4()
{ var disable14 = document.getElementById("division4");
  
  if (disable14.value != "" || disable14.value.length > 0) 
  {   
      document.getElementById("cgpa4").disabled = true;
  }
}

function click_cgpa4()
{ 
 
	 var click_cgpa_check4=document.getElementById("cgpa4").value;
	 if(click_cgpa_check4==0)
	 {
	  
	 }
	 else
	 {
	 cgpa4();
	 }
 }
function cgpa4()
{
	  var  disable24= document.getElementById("cgpa4");
	  if (disable24.value != "" || disable24.value.length > 0) 
	  {
		  document.getElementById("division4").disabled = true;
	  }
}
	
	
	
	function click_division5()
{ 
 
	 var click_division_check5=document.getElementById("division5").value;
	 if(click_division_check5=="1st division" || click_division_check5=="2nd division" || click_division_check5=="3rd division")
	 {
	  division5();
	 }
 }
function division5()
{ var disable15 = document.getElementById("division5");
  
  if (disable15.value != "" || disable15.value.length > 0) 
  {   
      document.getElementById("cgpa5").disabled = true;
  }
}

function click_cgpa5()
{ 
 
	 var click_cgpa_check5=document.getElementById("cgpa5").value;
	 if(click_cgpa_check5==0)
	 {
	  
	 }
	 else
	 {
	 cgpa5();
	 }
 }
function cgpa5()
{
var  disable25= document.getElementById("cgpa5");
  if (disable25.value != "" || disable25.value.length > 0) 
  {
      document.getElementById("division5").disabled = true;
  }
}



function click_division6()
{ 
 
	 var click_division_check6=document.getElementById("division6").value;
	 if(click_division_check6=="1st division" || click_division_check6=="2nd division" || click_division_check6=="3rd division")
	 {
	  division6();
	 }
 }
function division6()
{ var disable16 = document.getElementById("division6");
  
  if (disable16.value != "" || disable16.value.length > 0) 
  {   
      document.getElementById("cgpa6").disabled = true;
  }
}

function click_cgpa6()
{ 
 
	 var click_cgpa_check6=document.getElementById("cgpa6").value;
	 if(click_cgpa_check6==0)
	 {
	  
	 }
	 else
	 {
	 cgpa6();
	 }
 }
function cgpa6()
{
var  disable26= document.getElementById("cgpa6");
  if (disable26.value != "" || disable26.value.length > 0) 
  {
      document.getElementById("division6").disabled = true;
  }
}
	
	
	
	function click_division7()
{ 
 
	 var click_division_check7=document.getElementById("division7").value;
	 if(click_division_check7=="1st division" || click_division_check7=="2nd division" || click_division_check7=="3rd division")
	 {
	  division7();
	 }
 }
function division7()
{ var disable17 = document.getElementById("division7");
  
  if (disable17.value != "" || disable17.value.length > 0) 
  {   
      document.getElementById("cgpa7").disabled = true;
  }
}

function click_cgpa7()
{ 
 
	 var click_cgpa_check7=document.getElementById("cgpa7").value;
	 if(click_cgpa_check7==0)
	 {
	  
	 }
	 else
	 {
	 cgpa7();
	 }
 }
function cgpa7()
{
var  disable27= document.getElementById("cgpa7");
  if (disable27.value != "" || disable27.value.length > 0) 
  {
      document.getElementById("division7").disabled = true;
  }
}
	
	
	
	
	function click_division8()
{ 
 
	 var click_division_check8=document.getElementById("division8").value;
	 if(click_division_check8=="1st division" || click_division_check8=="2nd division" || click_division_check8=="3rd division")
	 {
	  division8();
	 }
 }
function division8()
{ var disable18 = document.getElementById("division8");
  
  if (disable18.value != "" || disable18.value.length > 0) 
  {   
      document.getElementById("cgpa8").disabled = true;
  }
}

function click_cgpa8()
{ 
 
	 var click_cgpa_check8=document.getElementById("cgpa8").value;
	 if(click_cgpa_check8==0)
	 {
	  
	 }
	 else
	 {
	 cgpa8();
	 }
 }
function cgpa8()
{
var  disable28= document.getElementById("cgpa8");
  if (disable28.value != "" || disable28.value.length > 0) 
  {
      document.getElementById("division8").disabled = true;
  }
}
	
	
	
	function click_division9()
{ 
 
	 var click_division_check9=document.getElementById("division9").value;
	 if(click_division_check9=="1st division" || click_division_check9=="2nd division" || click_division_check9=="3rd division")
	 {
	  division9();
	 }
 }
function division9()
{ var disable19 = document.getElementById("division9");
  
  if (disable19.value != "" || disable19.value.length > 0) 
  {   
      document.getElementById("cgpa9").disabled = true;
  }
}

function click_cgpa9()
{ 
 
	 var click_cgpa_check9=document.getElementById("cgpa9").value;
	 if(click_cgpa_check9==0)
	 {
	  
	 }
	 else
	 {
	 cgpa9();
	 }
 }
function cgpa9()
{
var  disable29= document.getElementById("cgpa9");
  if (disable29.value != "" || disable29.value.length > 0) 
  {
      document.getElementById("division9").disabled = true;
  }
}
	
	
	
	function click_division9()
{ 
 
	 var click_division_check9=document.getElementById("division9").value;
	 if(click_division_check9=="1st division" || click_division_check9=="2nd division" || click_division_check9=="3rd division")
	 {
	  division9();
	 }
 }
function division10()
{ var disable20 = document.getElementById("division10");
  
  if (disable20.value != "" || disable20.value.length > 0) 
  {   
      document.getElementById("cgpa10").disabled = true;
  }
}

function click_cgpa10()
{ 
 
	 var click_cgpa_check10=document.getElementById("cgpa10").value;
	 if(click_cgpa_check10==0)
	 {
	  
	 }
	 else
	 {
	 cgpa10();
	 }
 }
function cgpaa10()
{
var  disable30= document.getElementById("cgpa10");
  if (disable30.value != "" || disable30.value.length > 0) 
  {
      document.getElementById("division10").disabled = true;
  }
}	
	
	 function add_extra_field()
	 {
	           var addMore=document.getElementById("AddMore");
	            addMore.style.display="none";
	             var add00= document.getElementById("add");
	             add00.style.display ="";
	              var add01= document.getElementById("add1");
	               add01.style.display ="";
	 }	  
	 
	 
	 function add_extra_field1()
	 {
	 
	 
	            addMore11=document.getElementById("add1");
	           addMore11.style.display="none";
	  
	             var add10= document.getElementById("add21");
	               add10.style.display ="";
	  
	            var add11= document.getElementById("add22");
	             add11.style.display ="";
	 }	 
	 
	 function add_extra_field2()
	 {
	 
	 
	 addMore21=document.getElementById("add22");
	  addMore21.style.display="none";
	    
	  var add21= document.getElementById("add31");
	  add21.style.display ="";
	  
	  var add22= document.getElementById("add32");
	  add22.style.display ="";
	 }	 
	 
	 
	 function add_extra_field3()
	 {
	 
	 
	 addMore31=document.getElementById("add32");
	  addMore31.style.display="none";
	    
	  var add31= document.getElementById("add41");
	  add31.style.display ="";
	  
	  var add32= document.getElementById("add42");
	  add32.style.display ="";
	 }	 
	 
	 
	 function add_extra_field4()
	 {
	 
	 addMore41=document.getElementById("add42");
	  addMore41.style.display="none";
	    
	  var add41= document.getElementById("add51");
	  add41.style.display ="";
	  
	  var add42= document.getElementById("add52");
	  add42.style.display ="";
	 }
	 function add_extra_field5()
	 {
	 
	 addMore51=document.getElementById("add52");
	  addMore51.style.display="none";
	    
	  var add51= document.getElementById("add61");
	  add51.style.display ="";
	  
	  var add52= document.getElementById("add62");
	  add52.style.display ="";
	 }
	function add_extra_field6()
	 {
	 
	 addMore61=document.getElementById("add62");
	  addMore61.style.display="none";
	    
	  var add61= document.getElementById("add71");
	  add61.style.display ="";
	  
	  var add62= document.getElementById("add72");
	  add62.style.display ="";
	 }
function add_extra_field7()
	 {
	 
	 addMore71=document.getElementById("add72");
	  addMore71.style.display="none";
	    
	  var add71= document.getElementById("add81");
	  add71.style.display ="";
	  
	  var add72= document.getElementById("add82");
	  add72.style.display ="";
	 }	 
function add_extra_field8()
	 {
	 
	 addMore81=document.getElementById("add82");
	  addMore81.style.display="none";
	    
	  var add81= document.getElementById("add91");
	  add81.style.display ="";
	  
	  var add82= document.getElementById("add92");
	  add82.style.display ="";
	 }	 
function add_extra_field9()
	 {
	 
	 addMore91=document.getElementById("add92");
	  addMore91.style.display="none";
	    
	  var add91= document.getElementById("add101");
	  add91.style.display ="";
	  
	  var add92= document.getElementById("add102");
	  add92.style.display ="";
	 }	 
function add_extra_field10()
	 {
	 
	 addMore101=document.getElementById("add102");
	  addMore101.style.display="none";
	    
	  var add101= document.getElementById("add111");
	  add101.style.display ="";
	  
	  var add102= document.getElementById("add112");
	  add102.style.display ="";
	 }	 
function add_extra_field11()
	 {
	 
	 addMore111=document.getElementById("add112");
	  addMore111.style.display="none";
	    
	  var add111= document.getElementById("add121");
	  add111.style.display ="";
	  
	  var add112= document.getElementById("add122");
	  add112.style.display ="";
	 }	 
function add_extra_field12()
	 {
	 
	 addMore121=document.getElementById("add122");
	  addMore121.style.display="none";
	    
	  var add121= document.getElementById("add131");
	  add121.style.display ="";
	  
	  var add122= document.getElementById("add132");
	  add122.style.display ="";
	 }	 
function add_extra_field13()
	 {
	 
	 addMore131=document.getElementById("add132");
	  addMore131.style.display="none";
	    
	  var add131= document.getElementById("add141");
	  add131.style.display ="";
	  
	  var add132= document.getElementById("add142");
	  add132.style.display ="";
	 }	 
function add_extra_field14()
	 {
	 
	 addMore141=document.getElementById("add142");
	  addMore141.style.display="none";
	    
	  var add141= document.getElementById("add151");
	  add141.style.display ="";
	  
	  var add142= document.getElementById("add152");
	  add142.style.display ="";
	 }	 
function add_extra_field15()
	 {
	 
	 addMore151=document.getElementById("add152");
	  addMore151.style.display="none";
	    
	  var add151= document.getElementById("add161");
	  add151.style.display ="";
	  
	  var add152= document.getElementById("add162");
	  add152.style.display ="";
	 }	 
function add_extra_field16()
	 {
	 
	 addMore161=document.getElementById("add162");
	  addMore161.style.display="none";
	    
	  var add161= document.getElementById("add171");
	  add161.style.display ="";
	  
	  var add162= document.getElementById("add172");
	  add162.style.display ="";
	 }	 
function add_extra_field17()
	 {
	 
	 addMore171=document.getElementById("add172");
	  addMore171.style.display="none";
	    
	  var add171= document.getElementById("add181");
	  add171.style.display ="";
	  
	  var add172= document.getElementById("add182");
	  add172.style.display ="";
	 }	 
function add_extra_field18()
	 {
	 
	 addMore181=document.getElementById("add62");
	  addMore181.style.display="none";
	    
	  var add181= document.getElementById("add191");
	  add181.style.display ="";
	  
	  var add182= document.getElementById("add192");
	  add182.style.display ="";
	 }	 
function add_extra_field19()
	 {
	 
	 addMore191=document.getElementById("add192");
	  addMore191.style.display="none";
	    
	  var add191= document.getElementById("add201");
	  add191.style.display ="";
	  
	  var add192= document.getElementById("add202");
	  add192.style.display ="";
	 }	 
	 
	 
	 function remove_extra_field1()
	 {
	  var rem10= document.getElementById("add");
	  rem10.style.display ="none";
	  var rem11= document.getElementById("add1");
	  rem11.style.display ="none";
	  var ret1=document.getElementById("AddMore");
	  ret1.style.display="";
	 }	  
	 
	 
	 function remove_extra_field2()
	 {
	  
	  var rem20= document.getElementById("add22");
	  rem20.style.display ="none";
	  
	  rem21= document.getElementById("add21");
	  rem21.style.display ="none";
	  
	  var ret20=document.getElementById("add");
	  ret20.style.display="";
	  
	  var ret21= document.getElementById("add1");
	  ret21.style.display ="";
	 }	
	 
	 
	 function remove_extra_field3()
	 {
	  
	  var rem30= document.getElementById("add32");
	  rem30.style.display ="none";
	  
	  rem31= document.getElementById("add31");
	  rem31.style.display ="none";
	  
	  var ret30=document.getElementById("add21");
	  ret30.style.display="";
	  
	  var ret31= document.getElementById("add22");
	  ret31.style.display ="";
	 }	

function remove_extra_field4()
	 {
	  
	  var rem40= document.getElementById("add42");
	  rem40.style.display ="none";
	  
	  rem41= document.getElementById("add41");
	  rem41.style.display ="none";
	  
	  var ret40=document.getElementById("add31");
	  ret40.style.display="";
	  
	  var ret41= document.getElementById("add32");
	  ret41.style.display ="";
	 }	
		
	function remove_extra_field5()
	 {
	  
	  var rem50= document.getElementById("add52");
	  rem50.style.display ="none";
	  
	  rem51= document.getElementById("add51");
	  rem51.style.display ="none";
	  
	  var ret50=document.getElementById("add41");
	  ret50.style.display="";
	  
	  var ret51= document.getElementById("add42");
	  ret51.style.display ="";
	 }	
	function remove_extra_field6()
	 {
	  
	  var rem60= document.getElementById("add62");
	  rem60.style.display ="none";
	  
	  rem61= document.getElementById("add61");
	  rem61.style.display ="none";
	  
	  var ret60=document.getElementById("add51");
	  ret60.style.display="";
	  
	  var ret61= document.getElementById("add52");
	  ret61.style.display ="";
	 }
	 function remove_extra_field7()
	 {
	  
	  var rem70= document.getElementById("add72");
	  rem70.style.display ="none";
	  
	  rem71= document.getElementById("add71");
	  rem71.style.display ="none";
	  
	  var ret70=document.getElementById("add61");
	  ret70.style.display="";
	  
	  var ret71= document.getElementById("add62");
	  ret71.style.display ="";
	 }
	 function remove_extra_field8()
	 {
	  
	  var rem80= document.getElementById("add82");
	  rem80.style.display ="none";
	  
	  rem81= document.getElementById("add81");
	  rem81.style.display ="none";
	  
	  var ret80=document.getElementById("add71");
	  ret80.style.display="";
	  
	  var ret81= document.getElementById("add72");
	  ret81.style.display ="";
	 }
	 function remove_extra_field9()
	 {
	  
	  var rem90= document.getElementById("add92");
	  rem90.style.display ="none";
	  
	  rem91= document.getElementById("add91");
	  rem91.style.display ="none";
	  
	  var ret90=document.getElementById("add81");
	  ret90.style.display="";
	  
	  var ret91= document.getElementById("add82");
	  ret91.style.display ="";
	 }
	 function remove_extra_field10()
	 {
	  
	  var rem100= document.getElementById("add102");
	  rem100.style.display ="none";
	  
	  rem101= document.getElementById("add101");
	  rem101.style.display ="none";
	  
	  var ret100=document.getElementById("add91");
	  ret100.style.display="";
	  
	  var ret101= document.getElementById("add92");
	  ret101.style.display ="";
	 }
	 function remove_extra_field11()
	 {
	  
	  var rem110= document.getElementById("add112");
	  rem110.style.display ="none";
	  
	  rem111= document.getElementById("add111");
	  rem111.style.display ="none";
	  
	  var ret110=document.getElementById("add101");
	  ret110.style.display="";
	  
	  var ret111= document.getElementById("add102");
	  ret111.style.display ="";
	 }
	 function remove_extra_field12()
	 {
	  
	  var rem120= document.getElementById("add122");
	  rem120.style.display ="none";
	  
	  rem121= document.getElementById("add121");
	  rem121.style.display ="none";
	  
	  var ret120=document.getElementById("add111");
	  ret120.style.display="";
	  
	  var ret121= document.getElementById("add112");
	  ret121.style.display ="";
	 }
	 function remove_extra_field13()
	 {
	  
	  var rem130= document.getElementById("add132");
	  rem130.style.display ="none";
	  
	  rem131= document.getElementById("add131");
	  rem131.style.display ="none";
	  
	  var ret130=document.getElementById("add121");
	  ret130.style.display="";
	  
	  var ret131= document.getElementById("add122");
	  ret131.style.display ="";
	 }
	 function remove_extra_field14()
	 {
	  
	  var rem140= document.getElementById("add142");
	  rem140.style.display ="none";
	  
	  rem141= document.getElementById("add141");
	  rem141.style.display ="none";
	  
	  var ret140=document.getElementById("add131");
	  ret140.style.display="";
	  
	  var ret141= document.getElementById("add132");
	  ret141.style.display ="";
	 }
	 function remove_extra_field15()
	 {
	  
	  var rem150= document.getElementById("add152");
	  rem150.style.display ="none";
	  
	  rem151= document.getElementById("add151");
	  rem151.style.display ="none";
	  
	  var ret150=document.getElementById("add141");
	  ret150.style.display="";
	  
	  var ret151= document.getElementById("add142");
	  ret151.style.display ="";
	 }
	 function remove_extra_field16()
	 {
	  
	  var rem160= document.getElementById("add162");
	  rem160.style.display ="none";
	  
	  rem161= document.getElementById("add161");
	  rem161.style.display ="none";
	  
	  var ret160=document.getElementById("add151");
	  ret160.style.display="";
	  
	  var ret161= document.getElementById("add152");
	  ret161.style.display ="";
	 }
	 function remove_extra_fiel17()
	 {
	  
	  var rem170= document.getElementById("add172");
	  rem170.style.display ="none";
	  
	  rem171= document.getElementById("add171");
	  rem171.style.display ="none";
	  
	  var ret170=document.getElementById("add161");
	  ret170.style.display="";
	  
	  var ret71= document.getElementById("add162");
	  ret71.style.display ="";
	 }
	 function remove_extra_field18()
	 {
	  
	  var rem180= document.getElementById("add182");
	  rem180.style.display ="none";
	  
	  rem181= document.getElementById("add181");
	  rem181.style.display ="none";
	  
	  var ret180=document.getElementById("add171");
	  ret180.style.display="";
	  
	  var ret181= document.getElementById("add172");
	  ret181.style.display ="";
	 }
	 function remove_extra_field19()
	 {
	  
	  var rem190= document.getElementById("add192");
	  rem190.style.display ="none";
	  
	  rem191= document.getElementById("add191");
	  rem191.style.display ="none";
	  
	  var ret190=document.getElementById("add181");
	  ret190.style.display="";
	  
	  var ret191= document.getElementById("add182");
	  ret191.style.display ="";
	 }
	 function remove_extra_field20()
	 {
	  
	  var rem200= document.getElementById("add202");
	  rem200.style.display ="none";
	  
	  rem201= document.getElementById("add201");
	  rem201.style.display ="none";
	  
	  var ret200=document.getElementById("add191");
	  ret200.style.display="";
	  
	  var ret201= document.getElementById("add192");
	  ret201.style.display ="";
	 }
	 
	 function add_extra_field_org()
	 {
	 var addMoreorg=document.getElementById("AddMore_org");
	  addMoreorg.style.display="none";
	  var addorg00= document.getElementById("add_org");
	  addorg00.style.display ="";
	  var addorg01= document.getElementById("add_org1");
	  addorg01.style.display ="";
	 }	  
	 
	 
	 function add_extra_field_org1()
	 {
	 addMore_org11=document.getElementById("add_org1");
	  addMore_org11.style.display="none";
	  
	  var add_org10= document.getElementById("add_org21");
	  add_org10.style.display ="";
	  
	  var add_org11= document.getElementById("add_org22");
	  add_org11.style.display ="";
	 }	 
	 
	 function add_extra_field_org2()
	 {
	 
	 
	 addMore_org21=document.getElementById("add_org22");
	  addMore_org21.style.display="none";
	    
	  var add_org21= document.getElementById("add_org31");
	  add_org21.style.display ="";
	  
	  var add_org22= document.getElementById("add_org32");
	  add_org22.style.display ="";
	 }	 
	 
	 
	 function add_extra_field_org3()
	 {
	 
	 
	 addMore_org31=document.getElementById("add_org32");
	  addMore_org31.style.display="none";
	    
	  var add_org31= document.getElementById("add_org41");
	  add_org31.style.display ="";
	  
	  var add_org32= document.getElementById("add_org42");
	  add_org32.style.display ="";
	 }	 
	 
	 
	 function add_extra_field_org4()
	 {
	 
	 addMore_org41=document.getElementById("add_org42");
	  addMore_org41.style.display="none";
	    
	  var add_org41= document.getElementById("add_org51");
	  add_org41.style.display ="";
	  
	  var add_org42= document.getElementById("add_org52");
	  add_org42.style.display ="";
	 }	 
	 
	 
	 function remove_extra_field_org1()
	 {
	  var rem_org10= document.getElementById("add_org");
	  rem_org10.style.display ="none";
	  var rem_org11= document.getElementById("add_org1");
	  rem_org11.style.display ="none";
	  var ret_org1=document.getElementById("AddMore_org");
	  ret_org1.style.display="";
	 }	 
	         
			


function remove_extra_field_org2()
	 {
	  
	  var rem_org20= document.getElementById("add_org22");
	  rem_org20.style.display ="none";
	  
	  rem_org21= document.getElementById("add_org21");
	  rem_org21.style.display ="none";
	  
	  var ret_org20=document.getElementById("add_org");
	  ret_org20.style.display="";
	  
	  var ret_org21= document.getElementById("add_org1");
	  ret_org21.style.display ="";
	 }	
	 
	 
	 function remove_extra_field_org3()
	 {
	  
	  var rem_org30= document.getElementById("add_org32");
	  rem_org30.style.display ="none";
	  
	  rem_org31= document.getElementById("add_org31");
	  rem_org31.style.display ="none";
	  
	  var ret_org30=document.getElementById("add_org21");
	  ret_org30.style.display="";
	  
	  var ret_org31= document.getElementById("add_org22");
	  ret_org31.style.display ="";
	 }	
	 
	 	


function remove_extra_field_org4()
	 {
	  
	  var rem_org40= document.getElementById("add_org42");
	  rem_org40.style.display ="none";
	  
	  rem_org41= document.getElementById("add_org41");
	  rem_org41.style.display ="none";
	  
	  var ret_org40=document.getElementById("add_org31");
	  ret_org40.style.display="";
	  
	  var ret_org41= document.getElementById("add_org32");
	  ret_org41.style.display ="";
	 }	

		
		
		
		function remove_extra_field_org5()
	 {
	  
	  var rem_org50= document.getElementById("add_org52");
	  rem_org50.style.display ="none";
	  
	  rem_org51= document.getElementById("add_org51");
	  rem_org51.style.display ="none";
	  
	  var ret_org50=document.getElementById("add_org41");
	  ret_org50.style.display="";
	  
	  var ret_org51= document.getElementById("add_org42");
	  ret_org51.style.display ="";
	 }	



			 var clicked = false;
			 function sponsor()
			 {   
				 if(!clicked)
				 {
				   var self=document.getElementById("org_sponsor");
				   self.style.display="none";
				   var sponsor_info=document.getElementById("sponsor_info");
				   sponsor_info.style.display="";

				 }
				 else
				 {
				   var self=document.getElementById("org_sponsor");
				   self.style.display="";
				   var sponsor_info=document.getElementById("sponsor_info");
				   sponsor_info.style.display="none";
				 }
			 clicked = !clicked;
			 }
			 
                                                                    
			           
					  /* function check_image()
							{
							var file_up = document.getElementById("file").value;
							
							var ext = file_up.substring(file_up.lastIndexOf('.') + 1);
							if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "pjpeg" || ext=="PJPEG" || ext=="png" || ext=="PNG")
							{
							return true;
							} 
							else
							{
							var msg = document.getElementById("msg");
							msg.style.display="";
							document.getElementById("file").focus();
							return false;
							}
							}*/
							
					 /*function preview()
						{
						
						   
						//var filename = document.getElementById("file").value;
						//var Img = new Image ();
						//Img.src = filename;
						//document.images[0].src = Img.src;
						//alert ("Filename: '" + filename + "' width: " + Img.width + "height: " + Img.height);
						}*/
  

           
			 
			 		             
			 
			 
	 function Return_FormValidate()
		  {
		    var course_center=document.getElementById("course_center").value;
			
			if(course_center=="")
			 {
			 alert("You have to select a course center");
			 
			 document.stu_form.course_center.focus();
			 return false; 
			 
			
		 }
			 
			 var course=document.getElementById("course").value;	
                if(course=="")
			    {
			      alert("Please choose a course");
			      document.stu_form.course.focus();
				  return false;
			    }	
				
		    var Time_preference = document.getElementById("Time_preference").value;
		        if(Time_preference=="")
			   {
			    alert("Please select a time");
			    document.stu_form.Time_preference.focus();
				return false;
			   }
			  
			 var session = document.stu_form.session.value.length;
		     if(session==0)
			 {
			 alert("You can not keep this field blank");
			 document.stu_form.session.focus();
			 return false;
			 }
			 
			 var name = document.stu_form.name.value.length;
		     if(name==0)
			 {
			 alert("Please provide your name");
			 document.stu_form.name.focus();
			 return false;
			 }
			 
			   		var radioboxes=document.getElementsByName("sex");
              var right=false;
                for(var i=0,l=radioboxes.length;i<l;i++)
               {
                   if(radioboxes[i].checked)
             {
                   right=true;
               }
             }
              if(!right)
			  {alert("Please select your sex");
			  
			  return false;
			  }
			
			 	
             var father_husband_name = document.getElementById("father_husband").value;
			 
		        if(father_husband_name=="0")
			   {
			    alert("Please select your father or husband and give his name ");
			    document.stu_form.father_husband.focus();
				return false;
			   }

				
			 var mother=document.stu_form.mother.value.length;
			 if(mother==0)
			 {
			 alert("You have to give your mother's name");
			  document.stu_form.mother.focus();
			  return false;
			 }
			 
			  var blood_group=document.getElementById("blood_group").value;
			 if(blood_group==0)
			 {
			 alert("You have to choose your blood group");
			  document.stu_form.blood_group.focus();
			  return false;
			 }
			 
			     var x=document.stu_form.email.value;
                 var atpos=x.indexOf("@");
                 var dotpos=x.lastIndexOf(".");
                  var str = x.length;
                if(str==0){
                    alert("Please give your email address");
                  document.stu_form.email.focus();
				  return false;
                   }
               else if(atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
                 {
                alert("Not a valid e-mail address");
                 document.stu_form.email.focus();
				 return false;
                }
				else{return true;}

			var contact_info=document.stu_form.contact.value.length;
			 if(contact_info==0)
			 {
			 alert("You have to give your contact number");
			  document.stu_form.contact.focus();
			  return false;
			 }	
			 
				
			var pre_add=document.stu_form.pre_add.value.length;
			if(pre_add==0)
                    {alert("Please give your present address");
					document.stu_form.pre_add.focus();
			  return false;
					}
			 

               var par_add=document.stu_form.par_add.value.length;
			 if(par_add==0)
			 {
			 alert("Please give your parmanent address");
			  document.stu_form.par_add.focus();
			  return false;
			 }	

		  
		  
		   var checkboxs=document.getElementsByName("organization_sponsor_self");
              var okay=false;
                for(var i=0,l=checkboxs.length;i<l;i++)
               {
                   if(checkboxs[i].checked)
                 {
                   okay=true;
                 }
               }
              if(!okay)
			  
			  {alert("Please choose your financial sponsor");
			  			  return false;
			  }
			
                           
			var slip_no=document.stu_form.slip_no.value.length;
			 if(slip_no==0)
			 {
			 alert("Please give the slip serial number of Brac bank  ");
			  document.stu_form.slip_no.focus();
			  return false;
			 }
			return(true);
		}

