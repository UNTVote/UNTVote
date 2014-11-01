// Dependencies: Fuelux, underscore

function electionData() {
  
  //These are the buttons that go inside each row
  var actionButtons = "<button class='btn btn-xs btn-primary'>Edit</button>&nbsp;<button class='btn btn-xs btn-danger'>Delete</button>";
  
  // All data from the database goes here
  return [
        {
			"name": "Election XYZ",
			"category": "Engineering",
            "start": "09-11-2014",
            "end": "11-12-2014",
			"actions": actionButtons,
            "status": "Active"
		},
		{
			"name": "Election DFK",
			"category": "Journalism",
            "start": "08-23-2014",
            "end": "09-15-2014",
			"actions": actionButtons,
            "status": "Active"
		},
		{
			"name": "Election EIR",
			"category": "Arts & Science",
            "start": "10-21-2014",
            "end": "12-12-2014",
			"actions": actionButtons,
            "status": "Active"
		},
        {
			"name": "Election SPD",
			"category": "TV & Radio",
            "start": "12-01-2014",
            "end": "12-31-2014",
			"actions": actionButtons,
            "status": "Upcoming"
		},
        {
			"name": "Election SPD",
			"category": "Business",
            "start": "09-14-2014",
            "end": "11-04-2014",
			"actions": actionButtons,
            "status": "Upcoming"
		},
		{
			"name": "Election WEY",
			"category": "Engineering",
            "start": "08-25-2014",
            "end": "09-08-2014",
			"actions": actionButtons,
            "status": "Active"
		}
  ];
}

function populateElectionTable() {
  
  var columns = [
		{
			label: 'Election Name',
			property: 'name',
			sortable: true
		},
		{
			label: 'Category',
			property: 'category',
			sortable: true
		},
        {
			label: 'Start Date',
			property: 'start',
			sortable: true
		},
        {
			label: 'End Date',
			property: 'end',
			sortable: true
		},
		{
			label: 'Actions',
			property: 'actions',
			sortable: false
		}
	];
    
    var elections = electionData();
	
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
		var items = $.extend([], elections);
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
					(item.name.toLowerCase().search(options.search)>=0) ||
                    (item.category.toLowerCase().search(options.search)>=0) ||
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
	$('#electionTable').repeater({
		dataSource: dataSource
	});
   
}

$(document).ready(function() {
  populateElectionTable();
});
