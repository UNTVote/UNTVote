// Dependencies: Fuelux, underscore.js

// This variable holds JSON data retrieved from AJAX call
var userElectionData;

function populateUserElectionTable() {

  var columns = [
		{
			label: 'Election Name',
			property: 'election_name',
			sortable: true
		},
		{
			label: 'College',
			property: 'college',
			sortable: true
		},
        {
			label: 'Start Date',
			property: 'start_date',
			sortable: true
		},
        {
			label: 'End Date',
			property: 'end_date',
			sortable: true
		},
        {
			label: 'Status',
			property: 'status',
			sortable: true
		},
		{
			label: 'Actions',
			property: 'actionButtons',
			sortable: false
		}
	];

    var userElections = userElectionData;

    var delays = ['50', '100', '200', '500', '800'];

	var dataSource, filtering;

	dataSource = function(options, callback){
		var items = filtering(options);
		var resp = {
			count: items.length,
			items: [],
			page: options.pageIndex,
			pages: Math.ceil(items.length/(options.pageSize || 50))
		};
		var i, l;

		i = options.pageIndex * (options.pageSize || 50);
		l = i + (options.pageSize || 50);
		l = (l <= resp.count) ? l : resp.count;
		resp.start = i + 1;
		resp.end = l;

        if(options.view==='list'){
            resp.columns = columns;
            for(i; i<l; i++){
                resp.items.push(items[i]);
            }
            setTimeout(function(){
              callback(resp);
            }, delays[Math.floor(Math.random() * 4)]);
        }
	};

	filtering = function(options){
		var items = $.extend([], userElections);
		var search;

		if(options.filter.value!=='All'){
			items = _.filter(items, function(item){
				return (item.status.search(options.filter.value)>=0);
			});
		}
		if(options.search){
			search = options.search.toLowerCase();
			items = _.filter(items, function(item){
				return (
					(item.election_name.toLowerCase().search(options.search)>=0) ||
                    (item.college.toLowerCase().search(options.search)>=0) ||
                    (item.status.toLowerCase().search(options.search)>=0)
				);
			});
		}
        if(options.sortProperty){
			items = _.sortBy(items, function(item){
				return item[options.sortProperty];
			});
			if(options.sortDirection==='desc'){
				items.reverse();
			}
		}

		return items;
	};

	// Repeater initialize
	$('#userElectionTable').repeater({
		dataSource: dataSource
	});
}

$(document).ready(function() {
  $.ajax({
      type: "GET",
      dataType: "json",
      url: "user/UserElectionData",
      success: function(data) {
        userElectionData = data;
      },
      error: function() {
       console.log("Error getting JSON data from 'UserElectionData' page");
      }
  });
});

// Runs after the all ajax calls are done
$(document).ajaxStop(function() {
  populateUserElectionTable();
});
