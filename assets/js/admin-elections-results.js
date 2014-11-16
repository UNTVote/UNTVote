var electionResults;
var pdfDoc;

function createChart() {
  var candidates = [];
  var voteData = [];

  if (electionResults.total_candidates > 1) {
    $("#resultsChart").show();
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
    var ctx = $("#resultsChart").get(0).getContext("2d");

    // Create chart
    var resultsBarChart = new Chart(ctx).Bar(data, {
      barShowStroke: false,
      tooltipTitleFontStyle: "normal",
      responsive: true
    });
  }
  else {
   $("#resultsChart").hide();
  }
}

function populateResults() {
  // Empty the candidate list
  $('#candidates').empty();

  $('#electionResultsPanel').fadeOut(500);

  setTimeout(function() {
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
  }, 800);


  // Show chart after the fade animations
  setTimeout(function (){
    createChart();
  }, 1000);
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

function createPDF(){
   pdfDoc = {
      pageSize: 'A4',

      pageMargins: [ 40, 40, 40, 40 ],

      content: [
       {  text: 'UNTVote - Election Results\n\n',
          style: 'header',
          fontSize: 18
       },

       {
		  text: [
            { text: 'Election: ', bold: true },
            { text: electionResults.election_name + '\n\n'}
          ]
       },

       {
		  text: [
            { text: 'Winner: ', bold: true },
            { text: electionResults.candidate[0].candidate_first_name + ' ' + electionResults.candidate[0].candidate_last_name + ' '},
            { text: '(' + electionResults.candidate[0].votes + ' votes)\n\n'}
          ]
       },

       {
		  text: [
            { text: 'Total votes: ', bold: true },
            { text: electionResults.total_votes + '\n\n' }
          ]
       },

       {
		  text: [
            { text: 'Registered votes: ', bold: true },
            { text: electionResults.total_voters + '\n\n' }
          ]
       },

       {
		  text: [
            { text: 'Total candidates: ', bold: true },
            { text: electionResults.total_candidates + '\n\n' }
          ]
       },

       {
		  text: [
            { text: 'Category: ', bold: true },
            { text: electionResults.category + '\n\n' }
          ]
       },

       {
		  text: [
            { text: 'Election period: ', bold: true },
            { text: electionResults.start_date + ' - ' + electionResults.end_date }
          ]
       }
     ],

     styles: {
       header: {
         fontSize: 22,
         bold: true
       },
     }
 };

}

function printPDF() {
  pdfMake.createPdf(pdfDoc).print();
}

function downloadPDF(){
  pdfMake.createPdf(pdfDoc).download(electionResults.election_name.replace(/\s+/g, '-') + '-election.pdf');
}

$(document).ready(function() {

  $('#electionsList').on('change', function() {
    getElectionResults(this.value);
  });

  $('#btnPrint').on('click', function () {
    createPDF();
    printPDF();
  });

  $('#btnDownload').on('click', function () {
    createPDF();
    downloadPDF();
  });
});