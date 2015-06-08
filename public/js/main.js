$(function(){

    String.prototype.hashCode = function() {
          var hash = 0, i, chr, len;
          if (this.length == 0) return hash;
          for (i = 0, len = this.length; i < len; i++) {
            chr   = this.charCodeAt(i);
            hash  = ((hash << 5) - hash) + chr;
            hash |= 0; // Convert to 32bit integer
          }
          return hash;
    };


    var FormManager = {
        form_el:null,
        file_type_el:null,
        file_input_el:null,
        game_autocomplete_el:null,
        unique_id:null,
        user_id:null,
        init:function(form){
            FormManager.form_el = $(form);
            FormManager.user_id = FormManager.form_el.attr('user-id');
            FormManager.unique_id = FormManager.user_id+'gaferscomfrm';
            FormManager.file_type_el = FormManager.form_el.find('.file-type');
            FormManager.file_input_el = FormManager.form_el.find('#file-input');
            FormManager.game_autocomplete_el = FormManager.form_el.find('#game-autocomplete');

            FormManager.getGamedata(FormManager.initAutocomplete);

            FormManager.file_type_el.change(function(){
               FormManager.file_input_el.attr('type',$(this).val()); 
            });
            FormManager.form_el.submit(function(e){
                e.preventDefault();
                FormManager.submitForm();
            });
        },
        submitForm:function(){
            var track_key = Math.abs(String(FormManager.unique_id + $.now()).hashCode());
            FormManager.submitContent(track_key,function(response){
                console.log(response);
            });
        },
        submitContent:function(track_key, callback){

            if(FormManager.file_input_el.attr('type') == 'text') {
                $.ajax({
                    url:"http://upload.gfycat.com/transcode/",
                    data:{fetchUrl:FormManager.file_input_el.val()},
                    //contentType:'text/plain'
                }).done(function(data){
                    if(data.isOk == undefined) {
                        callback(false);
                    } else {
                        callback(data);
                    }
                });
            } else {
                console.log(FormManager.file_input_el.val());
                var fd = new FormData();
                fd.append('key',track_key);
                fd.append('acl','private');
                fd.append('AWSAccessKeyId','AKIAIT4VU4B7G2LQYKZQ');
                fd.append('policy','eyAiZXhwaXJhdGlvbiI6ICIyMDIwLTEyLTAxVDEyOjAwOjAwLjAwMFoiLAogICAgICAgICAgICAiY29uZGl0aW9ucyI6IFsKICAgICAgICAgICAgeyJidWNrZXQiOiAiZ2lmYWZmZSJ9LAogICAgICAgICAgICBbInN0YXJ0cy13aXRoIiwgIiRrZXkiLCAiIl0sCiAgICAgICAgICAgIHsiYWNsIjogInByaXZhdGUifSwKCSAgICB7InN1Y2Nlc3NfYWN0aW9uX3N0YXR1cyI6ICIyMDAifSwKICAgICAgICAgICAgWyJzdGFydHMtd2l0aCIsICIkQ29udGVudC1UeXBlIiwgIiJdLAogICAgICAgICAgICBbImNvbnRlbnQtbGVuZ3RoLXJhbmdlIiwgMCwgNTI0Mjg4MDAwXQogICAgICAgICAgICBdCiAgICAgICAgICB9');
                fd.append('success_action_status','200');
                fd.append('signature','mk9t/U/wRN4/uU01mXfeTe2Kcoc=');
                fd.append('Content-Type','image/gif');
                fd.append('file',FormManager.file_input_el.val());
                

                $.ajax({
                    url:"https://gifaffe.s3.amazonaws.com/",
                    data:fd,
                    method:'POST',
                    contentType:false,
                    processData: false,
                    cache:false,
                    dataType:'json'
                }).done(function(data){
                    if(data.isOk == undefined) {
                        callback(false);
                    } else {
                        callback(data);
                    }
                });
            }
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
             FormManager.game_autocomplete_el.autocomplete(options);
        }
    };
    FormManager.init('#post-form');
});
