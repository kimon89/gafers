$(function(){
	$.ajax({
		url: "/gamedata.json",
		dataType:"json"
	}).done(function(data){
		// var options = {
	 //    	//serviceUrl: '/post/gamesearch',
	 //    	minChars: 3,
		// 	lookup : data.suggestions,
		//     onSelect: function (suggestion) {
		//         alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
		//     }
		// };
		// //console.log(options.lookup);
		// $('#game-autocomplete').autocomplete(options);
		// 
		
		$("#game-autocomplete").tokenInput("/url/to/your/script/",{
			prePopulate:data
		});
	});
	
});
