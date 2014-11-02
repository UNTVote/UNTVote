$(function () {
  var nameTextBox = $('#electionName');
  var panelLabel = $('#panelTitle');
  
  // Change panel title as the user types in a name
  nameTextBox.on('keyup', function () {
    if (nameTextBox.val().length <= 0) { panelLabel.html("Untitled election"); }
    else { panelLabel.html(nameTextBox.val()); }
  });
});

$(document).ready(function (){
  
  // Initialize candidate list
  $('#candidateList').multiselect({
    maxHeight: 200,
    enableCaseInsensitiveFiltering: true,
    disableIfEmpty: true 
  });
  
  // Initialize datepickers
  $('#startDate, #endDate').datepicker();
  
  // When the start date changed by user
  $('#startDate').on('changed.fu.datepicker dateClicked.fu.datepicker', function (evt, startDate) {
    
    $('#endDate').datepicker('setDate', startDate);
    $('#endDate').datepicker({
      restricted: [{ from: '01/01/1900', to: startDate }]
    });
    
  });

  
});