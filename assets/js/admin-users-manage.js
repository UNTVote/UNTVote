// Dependencies: Fuelux, underscore.js

// This variable holds JSON data retrieved from AJAX call
var userData;

function populateUserTable() {

  var columns = [
		{
			label: 'First name',
			property: 'first_name',
			sortable: true
		},
		{
			label: 'Last name',
			property: 'last_name',
			sortable: true
		},
        {
			label: 'College',
			property: 'college',
			sortable: true
		},
        {
			label: 'Role',
			property: 'role',
			sortable: true
		},
        {
			label: 'Member since',
			property: 'created_on',
			sortable: true
		},
        {
			label: 'Last login',
			property: 'last_login',
			sortable: true
		},
		{
			label: 'Actions',
			property: 'action_buttons',
			sortable: false
		}
	];

    var users = userData;

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
		var items = $.extend([], users);
		var search;

		if(options.filter.value!=='All'){
			items = _.filter(items, function(item){
				return (item.role.search(options.filter.value)>=0);
			});
		}
		if(options.search){
			search = options.search.toLowerCase();
			items = _.filter(items, function(item){
				return (
					(item.first_name.toLowerCase().search(options.search)>=0) ||
                    (item.last_name.toLowerCase().search(options.search)>=0) ||
                    (item.college.toLowerCase().search(options.search)>=0) ||
                    (item.role.toLowerCase().search(options.search)>=0)
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
	$('#userTable').repeater({
		dataSource: dataSource
	});
}

$(document).ready(function() {
  $.ajax({
      type: "GET",
      dataType: "json",
      url: "UserData",
      success: function(data) {
        userData = data;
      },
      error: function() {
       console.log("Error getting JSON data from 'UserData' page");
      }
  });
});

// Runs after the all ajax calls are done
$(document).ajaxStop(function() {
  populateUserTable();

   var docDefinition = {
   content: [
     // if you don't need styles, you can use a simple string to define a paragraph
     'This is a standard paragraph, using default style',

     // using a { text: '...' } object lets you set styling properties
     { text: 'This paragraph will have a bigger font', fontSize: 15 },

     // if you set pass an array instead of a string, you'll be able
     // to style any fragment individually
     {
       text: [
         'This paragraph is defined as an array of elements to make it possible to ',
         { text: 'restyle part of it and make it bigger ', fontSize: 15 },
         'than the rest.'
       ]
     }
   ]
 };

   pdfMake.createPdf(docDefinition).download('optionalName.pdf');
});
