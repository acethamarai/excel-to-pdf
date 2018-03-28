/**
 * My Javascript Functions
 * ------------------
 * You should not use this file in production.
 */
//$(document).ready(function(){
$(function () {
  'use strict'
	
	 $('.sisdelete').on('click', function () {
	      alert("r");

	  });
	
	 $('#chkParent').click(function() {
        var isChecked = $(this).prop("checked");
        $('#SingeBatch tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
    });

    $('#SingeBatch tr:has(td)').find('input[type="checkbox"]').click(function() {
        var isChecked = $(this).prop("checked");
        var isHeaderChecked = $("#chkParent").prop("checked");
        if (isChecked == false && isHeaderChecked)
            $("#chkParent").prop('checked', isChecked);
        else {
            $('#SingeBatch tr:has(td)').find('input[type="checkbox"]').each(function() {
                if ($(this).prop("checked") == false)
                    isChecked = false;
            });
            $("#chkParent").prop('checked', isChecked);
        }
    });
});
function nameLook() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("SingeBatch");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[2];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
	}