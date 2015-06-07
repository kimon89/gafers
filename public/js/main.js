$(function(){
    
    var FormManager = {
        init:function(){
            FormManager.getGamedata(FormManager.initAutocomplete);
        },
        getGamedata:function(callback){
            $.ajax({
                url: "/gamedata.json",
                dataType:"json"
            }).done(callback);
        },
        initAutocomplete:function(data){
            var options = {
                minChars: 2,
                lookup : data.suggestions,
                onSelect: function (suggestion) {

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
        }
    };
    FormManager.init();
	
    
    $('#post-form').submit(function(e){
        e.preventDefault();
        if($('#file_input').attr('type') == 'text') {
            
        } else {
            
        }
//        $.each($(this).serializeArray(), function(i, field) {
//            if(field.name)
//            field.name = field.value;
//        });
    });
    
    $('.file_type').change(function(){
       $('#file_input').attr('type',$(this).val()); 
    });
});
