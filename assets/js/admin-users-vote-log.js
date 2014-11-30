var logData;

function populateLogTable() {

  var columns = [
		{
			label: 'Confirmation#',
			property: 'confirmation_number',
			sortable: true
		},
		{
			label: 'Voter',
			property: 'voter_name',
			sortable: true
		},
        {
			label: 'Election',
			property: 'election_name',
			sortable: true
		},
        {
			label: 'Voted for',
			property: 'candidate',
			sortable: true
		},
        {
			label: 'Time voted',
			property: 'vote_time',
			sortable: true
		}
	];

    var elections = logData;

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

		if(options.filter.value!=='all'){
			items = _.filter(items, function(item){
				return (item.status.search(options.filter.value)>=0);
			});
		}
		if(options.search){
			search = options.search.toLowerCase();
			items = _.filter(items, function(item){
				return (
					(item.confirmation_number.toLowerCase().search(options.search.toLowerCase())>=0) ||
                    (item.voter_name.toLowerCase().search(options.search.toLowerCase())>=0) ||
                    (item.election_name.toLowerCase().search(options.search.toLowerCase())>=0) ||
                    (item.candidate.toLowerCase().search(options.search.toLowerCase())>=0)
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
	$('#voteLogTable').repeater({
		dataSource: dataSource
	});
}

// Runs after the all ajax calls are done
$(document).ajaxStop(function() {
  populateLogTable();
});

$(document).ready(function() {
  $.ajax({
      type: "GET",
      dataType: "json",
      url: "../admin/VoteLog",
      success: function(data, textStatus, jqXHR) {
        logData = data;
      },
      error: function(jqXHR, textStatus, errorThrown) {
       console.error("Error getting JSON data from 'VoteLog' page");
      }
  });
});