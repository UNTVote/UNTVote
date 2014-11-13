$(function () {
  var nameTextBox = $('#formEditElection #electionName');
  var panelLabel = $('#formEditElection #panelTitle');

  // Change panel title as the user types in a name
  nameTextBox.on('keyup', function () {
    if (nameTextBox.val().length <= 0) { panelLabel.html("Untitled election"); }
    else { panelLabel.html(nameTextBox.val()); }
  });
});

$(document).ready(function (){
  var startDate = $('#formEditElection #startDate');
  var startDateInput = $('#formEditElection #startDateInput');
  var endDate = $('#formEditElection #endDate');
  var endDateInput = $('#formEditElection #endDateInput');

  // Initialize category list
  $('#formEditElection #categoryList').multiselect({
    maxHeight: 200,
    enableCaseInsensitiveFiltering: true,
    disableIfEmpty: true
  });

  // Initialize candidate list
  $('#formEditElection #candidateList').multiselect({
    maxHeight: 200,
    enableCaseInsensitiveFiltering: true,
    disableIfEmpty: true
  });

  // Initialize datepickers
  startDate.datepicker();
  endDate.datepicker();

  // Populate dates from server data
  startDate.datepicker('setDate', startDateInput.attr('data-start-date'));
  endDate.datepicker('setDate', endDateInput.attr('data-end-date'));

  // When the start date changed by user
  startDate.on('changed.fu.datepicker dateClicked.fu.datepicker', function (evt, startDateVal) {

    endDate.datepicker('setDate', startDateVal);

  });

  // If the end date is before the start date
  endDate.on('changed.fu.datepicker dateClicked.fu.datepicker', function (evt, endDateVal) {

    if(endDateInput.val() < startDateInput.val()){
      window.ParsleyUI.addError(endDateInput.parsley(), "invalidDate" , "Please select a date after the start date");
    }

    if(endDateInput.val() >= startDateInput.val()){
      window.ParsleyUI.removeError(endDateInput.parsley(), "invalidDate");
    }
  });

});