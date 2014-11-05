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