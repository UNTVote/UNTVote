$(function () {
  var nameTextBox = $('#electionName');
  var panelLabel = $('#panelTitle');
  
  nameTextBox.on('keyup', function () {
    if (nameTextBox.val().length <= 0) { panelLabel.html("Untitled election"); }
    else { panelLabel.html(nameTextBox.val()); }
  });
});

$(document).ready(function (){
  
  $('#startDate, #endDate').datepicker({
    allowPastDates: false
  });
  
  $('#candidateList').multiselect({
    maxHeight: 200,
    enableCaseInsensitiveFiltering: true,
    disableIfEmpty: true 
  });
  
});