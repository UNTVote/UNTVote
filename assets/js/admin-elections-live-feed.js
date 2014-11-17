var interval = null;
var electionID;
var electionResults;

function createChart() {
  var candidates = [];
  var voteData = [];

  if (electionResults.total_candidates >= 1) {
    $("#liveFeedChart").show();

    // Get all candidates to an array
    $.each(electionResults.candidate, function(key,value) {
      candidates.push(value.candidate_first_name + ' ' + value.candidate_last_name);
    });

    // Get all votes to an array
    $.each(electionResults.candidate, function(key,value) {
      voteData.push(value.votes);
    });

   var data = {
    labels: candidates,
    datasets: [
        {
            label: "Election results",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: voteData
        }
      ]
    };

    // This will get the first returned node in the jQuery collection
    var ctx = $("#liveFeedChart").get(0).getContext("2d");

    // Create chart
    var resultsBarChart = new Chart(ctx).Bar(data, {
      barShowStroke: false,
      tooltipTitleFontStyle: "normal",
      animation: false,
      responsive: true
    });
  }
  else {
   $("#liveFeedChart").hide();
  }
}

function populateResults() {

  setTimeout(function() {

   if (electionResults.total_candidates >= 1) {

      // Sort candidates based on their votes (Highest votes first)
      electionResults.candidate.sort(function(a,b) {
        return parseFloat(b.votes) - parseFloat(a.votes);
      });

    }

    if (electionResults.candidate[0].votes == 0) {
      $('#leadingCandidate').html("No votes yet");
    }
    else if (electionResults.candidate[0].votes == electionResults.candidate[1].votes && electionResults.candidate[0].votes > 0) {
      $('#leadingCandidate').html("It's a tie");
    }
    else {
      $('#leadingCandidate').html(electionResults.candidate[0].candidate_first_name + ' ' + electionResults.candidate[0].candidate_last_name + ' is leading');
    }

    $('#electionName').html(electionResults.election_name);
    $('#totalVotes').html(electionResults.total_votes);
    $('#registeredVoters').html(electionResults.total_voters);
    $('#startDate').html(electionResults.start_date);
    $('#endDate').html(electionResults.end_date);

    $('#totalCandidates').html(electionResults.total_candidates);
    $('#electionCategory').html(electionResults.category);

    createChart();

  }, 500);

}

function getElectionResults(){
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
        clearInterval(interval);
        alert("Sorry, we couldn't load results for that election");
      }
  });
}

function keepRefreshing() {
  // Refresh every two seconds
  interval = setInterval(getElectionResults,2000);
}

function changedElection() {
  $('#liveFeedPanel').fadeOut(500);
  getElectionResults();
  $('#liveFeedPanel').fadeIn(500);
  keepRefreshing();
}

$(document).ready(function() {

  $('#liveElectionsList').on('change', function() {
    clearInterval(interval);
    electionID = this.value;
    changedElection();
  });

});