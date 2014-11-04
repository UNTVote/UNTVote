var data = {
    labels: ["XVD", "PUE","JKK","OEE"],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [100,47,30,12]
        }
        
    ]
};  
	
// This will get the first returned node in the jQuery collection
var ctx = $("#user-result-chart").get(0).getContext("2d");
var myBarChart = new Chart(ctx).Bar(data);