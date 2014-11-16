function createChart() {
   var data = {
    labels: ["Steve Jobs", "Jim Carey", "Jony Ive"],
    datasets: [
        {
            label: "Election results",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [45, 20, 34]
        }
    ]
  };

  // This will get the first returned node in the jQuery collection
  var ctx = $("#resultsChart").get(0).getContext("2d");

  // Create chart
  var resultsBarChart = new Chart(ctx).Bar(data, {
    barShowStroke: false,
    tooltipTitleFontStyle: "normal",
    responsive: true
  });
}

$(window).load(function() {
  createChart();
});


var electionResults;

function populateResults() {
  // Empty the candidate list
  $('#candidates').empty();

  $('#electionResultsPanel').fadeOut(500, function() {

    if (electionResults.total_candidates > 1) {

      // Sort candidates based on their votes (Highest votes first)
      electionResults.candidate.sort(function(a,b) {
        return parseFloat(b.votes) - parseFloat(a.votes);
      });

      // Add markup for the candidates
      $('#candidates').prepend('<div class="col-xs-12"><ul class="list-inline election-winners"><li><h1>1.</h1></li><li><img src="../../../assets/img/user-default.png" class="img-circle img-thumbnail" width="70"></li><li><ul class="list-unstyled"><li><H4>' + electionResults.candidate[0].candidate_first_name + " " + electionResults.candidate[0].candidate_last_name + '</H4></li><li class="text-muted">' + electionResults.candidate[0].votes + ' votes</li></ul></li></ul></div><div class="col-xs-12"><ul class="list-inline election-winners"><li><h1>2.</h1></li><li><img src="../../../assets/img/user-default.png" class="img-circle img-thumbnail" width="70"></li><li><ul class="list-unstyled"><li><H4>' + electionResults.candidate[1].candidate_first_name + " " + electionResults.candidate[1].candidate_last_name + '</H4></li><li class="text-muted">' + electionResults.candidate[1].votes + ' votes</li></ul></li></ul></div>');

    }

    $('#electionName').html(electionResults.election_name);
    $('#electionDates').html(" (" + electionResults.start_date + " - " + electionResults.end_date + ")");
    $('#totalVotes').html(electionResults.total_votes);
    $('#registeredVoters').html(electionResults.total_voters);
    $('#totalCandidates').html(electionResults.total_candidates);
    $('#electionCategory').html(electionResults.category);

    $('#electionResultsPanel').fadeIn(500);
  });
}

function getElectionResults(electionID){

  var postData = {elections: electionID};

  $.ajax({
      url : "../admin/ElectionResults",
      type: "POST",
      data : postData,
      success: function(data, textStatus, jqXHR)
      {
        electionResults = data;
        populateResults();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        console.log("Error getting JSON data from 'ElectionResults'");
        alert("Sorry, we couldn't load results for that election");
      }
  });
}

$(document).ready(function() {

  $('#electionsList').on('change', function() {
    getElectionResults(this.value);
  });

});