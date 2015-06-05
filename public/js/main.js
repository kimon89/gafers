$(function(){
	$.ajax({
		url: "/gamedata.json",
		dataType:"json"
	}).done(function(data){
		var games_input = $('#game-autocomplete');

		 var options = {
	     	minChars: 2,
		 	lookup : data.suggestions,
		 	lookupLimit:20,
		    onSelect: function (suggestion) {
		         //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
		    },
		    lookupFilter:function(suggestion, originalQuery, queryLowerCase){
	    	    var alias = false;
	    	   
                if (data.aliases[queryLowerCase] ) {
                    alias = data.aliases[queryLowerCase];
                }
                
                return  (alias ? (suggestion.value.toLowerCase().indexOf(alias) !== -1) : false) || (suggestion.value.toLowerCase().indexOf(queryLowerCase) !== -1);
                
		    }
		 };
		 $('#game-autocomplete').autocomplete(options);
	});
});
