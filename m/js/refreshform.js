/**
* Bootstrap.js by @fat & @mdo
* plugins: bootstrap-transition.js, bootstrap-modal.js, bootstrap-dropdown.js, bootstrap-scrollspy.js, bootstrap-tab.js, bootstrap-tooltip.js, bootstrap-popover.js, bootstrap-affix.js, bootstrap-alert.js, bootstrap-button.js, bootstrap-collapse.js, bootstrap-carousel.js, bootstrap-typeahead.js
* Copyright 2012 Twitter, Inc.
* http://www.apache.org/licenses/LICENSE-2.0.txt
*/
$(document).ready(function() {
$("#submit").click(function() {
var id = $("#id").val();
var pro_id = $("#pro_id").val();
//var contact = $("#contact").val();
//var gender = $("input[type=radio]:checked").val();
//var msg = $("#msg").val();
if (id == '' || pro_id == '') {
alert("Insertion Failed Some Fields are Blank....!!");
} else {
// Returns successful data submission message when the entered information is stored in database.
$.post("Refreshform.php", {
id1: id,
pro_id1: pro_id
//contact1: contact,
//gender1: gender,
//msg1: msg
}, function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
});
}
});
});