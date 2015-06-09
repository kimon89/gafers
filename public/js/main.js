
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
        form_container_el:null,
        error_el:null,
        file_type_el:null,
        file_input_el:null,
        title_input_el:null,
        game_autocomplete_el:null,
        unique_id:null,
        user_id:null,
        game_input_el:null,
        progress_bar_upload:null,
        progress_bar_convert:null,
        progress:null,
        overlay:null,
        token:null,

        formData:{
            title:null,
            game_id:null,

        },

        errors:{
            error_count:0,
            error_list:{}
        },
        init:function(form){
            FormManager.form_el = $(form);
            FormManager.form_container_el = $(form).parent();
            FormManager.user_id = FormManager.form_el.attr('user-id');
            FormManager.title_input_el = FormManager.form_el.find('#title-input');
            FormManager.game_input_el = FormManager.form_el.find('#game-input');
            FormManager.progress_bar_upload = $('.progress-bar-upload');
            FormManager.progress_bar_convert = $('.progress-bar-convert');
            FormManager.progress = $('.progress');
            FormManager.overlay = $('.overlay');
            FormManager.token = FormManager.form_el.find('#token').val();
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
        validateForm:function(callback){
            FormManager.formData.title = FormManager.title_input_el.val();
            FormManager.formData.game_id = FormManager.game_input_el.val();
            
            if (FormManager.file_input_el.attr('type') == 'file') {
                FormManager.formData.file = FormManager.file_input_el[0].files[0];
            }

            if (FormManager.formData.title.length < 5){
                FormManager.errors.error_count++;
                FormManager.errors.error_list.title = 'Title has to be at least 5 characters long.';
            }
            if (FormManager.formData.game_id == 0) {
                FormManager.errors.error_count++;
                FormManager.errors.error_list.game = 'A game from the list needs to be selected.';
            }
            if (FormManager.errors.error_count > 0) {
                FormManager.showErrors();
            } else {
                callback(true)
            }

        },
        showErrors: function(){
            FormManager.error_el = $('<div>').addClass('alert alert-danger');
            FormManager.error_el.append($('<strong>Whoops!</strong>').html('There were some problems with your input.'));
            var error_list = $('<ul>');
            $.each(FormManager.errors.error_list,function(k,v){
                if (k !== 'error_count') {
                    error_list.append($('<li>').html(v));
                }
            });

            //FormManager.file_input_el.parents('.form-group').addClass('has-error');
            FormManager.error_el.append(error_list);
            FormManager.form_container_el.prepend(FormManager.error_el);
        },
        clearErrors:function(){
            FormManager.errors.error_count = 0;
            FormManager.errors.error_list = {};
            if (FormManager.error_el !== null) {
                FormManager.error_el.remove();
            }
        },
        submitForm:function(){
            FormManager.clearErrors();
            FormManager.validateForm(function(response){
                if (response == true) {
                    var track_key = Math.abs(String(FormManager.unique_id + $.now()).hashCode());
                    FormManager.submitContent(track_key,function(response){
                        var data = {
                            gif:response.gifUrl,
                            mp4:response.mp4Url,
                            webm:response.webmUrl,
                            title:FormManager.formData.title,
                            game_id:FormManager.formData.game_id,
                            _token:FormManager.token
                        };
                        $.ajax({
                            url:"/post/create",
                            data:data,
                            method:'POST'
                        }).done(function(data){
                             console.log(data);
                        });
                    });
                }
            });
        },
        submitContent:function(track_key, callback){
            FormManager.progress.css('display','block');
            FormManager.overlay.css('display','block');
            FormManager.progress_bar_upload.addClass('active');
            FormManager.progress_bar_upload.css('width','25%');
            FormManager.progress_bar_upload.html('Uploading: 25%');
            if(FormManager.file_input_el.attr('type') == 'text') {
                FormManager.convertFile();
            } else {
                var fd = new FormData();
                fd.append('key',track_key);
                fd.append('acl','private');
                fd.append('AWSAccessKeyId','AKIAIT4VU4B7G2LQYKZQ');
                fd.append('policy','eyAiZXhwaXJhdGlvbiI6ICIyMDIwLTEyLTAxVDEyOjAwOjAwLjAwMFoiLAogICAgICAgICAgICAiY29uZGl0aW9ucyI6IFsKICAgICAgICAgICAgeyJidWNrZXQiOiAiZ2lmYWZmZSJ9LAogICAgICAgICAgICBbInN0YXJ0cy13aXRoIiwgIiRrZXkiLCAiIl0sCiAgICAgICAgICAgIHsiYWNsIjogInByaXZhdGUifSwKCSAgICB7InN1Y2Nlc3NfYWN0aW9uX3N0YXR1cyI6ICIyMDAifSwKICAgICAgICAgICAgWyJzdGFydHMtd2l0aCIsICIkQ29udGVudC1UeXBlIiwgIiJdLAogICAgICAgICAgICBbImNvbnRlbnQtbGVuZ3RoLXJhbmdlIiwgMCwgNTI0Mjg4MDAwXQogICAgICAgICAgICBdCiAgICAgICAgICB9');
                fd.append('success_action_status','200');
                fd.append('signature','mk9t/U/wRN4/uU01mXfeTe2Kcoc=');
                fd.append('Content-Type','image/gif');
                fd.append('file',FormManager.file_input_el[0].files[0],track_key);
           
                $.ajax({
                    url:"https://gifaffe.s3.amazonaws.com/",
                    data:fd,
                    method:'POST',
                    contentType:false,
                    processData: false,
                    cache:false
                }).done(function(data){
                    console.log(data);
                     FormManager.convertFile(track_key,function(data){
                         callback(data);
                     });
                });
            }
        },
        convertFile:function(track_key,callback){
            FormManager.progress_bar_upload.removeClass('active');
            FormManager.progress_bar_upload.removeClass('progress-bar-striped');
            FormManager.progress_bar_upload.css('width','50%');
            FormManager.progress_bar_upload.html('Uploading: Done');
            FormManager.progress_bar_convert.addClass('active');
            FormManager.progress_bar_convert.css('width','25%');
            FormManager.progress_bar_convert.html('Converting: 50%');
            if (track_key != null) {
                $.ajax({
                    url:"http://upload.gfycat.com/transcode/" + track_key,
                    dataType:'json'
                }).done(function(data){
                    if (data.task == "error") {
                        FormManager.errors.error_list.file = 'Please make sure the file is a gif or a video of length no more than 15 seconds and size no more than 300mb';
                        FormManager.resetProgress();
                        FormManager.showErrors();
                    } else {
                        FormManager.progress_bar_convert.removeClass('active');
                        FormManager.progress_bar_convert.removeClass('progress-bar-striped');
                        FormManager.progress_bar_convert.html('Converting: Done');
                        FormManager.progress_bar_convert.css('width', '50%');
                        callback(data);
                    }
                });
            }
        },
        resetProgress:function(){
            FormManager.progress_bar_convert.removeClass('active');
            FormManager.progress_bar_upload.removeClass('active');
            FormManager.progress_bar_convert.removeClass('progress-bar-striped');
            FormManager.progress_bar_upload.removeClass('progress-bar-striped');
            FormManager.progress_bar_convert.html('');
            FormManager.progress_bar_upload.html('');
            FormManager.progress_bar_convert.css('width', '0%');
            FormManager.progress_bar_upload.css('width', '0%');
            FormManager.progress.css('display', 'none');
            FormManager.overlay.css('display', 'none');
        },
        contentStatus:function(track_key){
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
                    FormManager.game_input_el.val(suggestion.data);
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
