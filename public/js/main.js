$(function(){
	$.ajax({
		url: "/gamedata.json",
		dataType:"json"
	}).done(function(data){
		 var options = {
	     	minChars: 2,
		 	lookup : data.suggestions,
		     onSelect: function (suggestion) {
		         alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
		     }
		 };
		 $('#game-autocomplete').autocomplete(options);
	});
});
