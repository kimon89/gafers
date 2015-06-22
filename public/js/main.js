
$(function(){
    var base_url = location.href.split( '/' )[2];
    var hash = location.href.split( '#' )[1];

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

    var DOMManager = {
        elements:{
            loginForm:null,
            registrationForm:null,
            profilePage:null,
            navigationBar:null
        },
        lastState:'home',
        prevState:'home',
        noRevertList:[
            'loginFacebook',
            'post',
            'login'
        ],
        userData:null,
        init:function(user,hash){
            var _this = this;
            _this.navigationBar(user);
            _this.initRouter(hash);
        },
        initRouter:function(){
            var _this = this;
            var path = window.location.pathname;
            var state = path == '/' ? 'home' : path;
            history.replaceState(state, state, state);

            _this.goToState(state);
            $('body').on('click','a',function(e){
                e.preventDefault();
                var slashes = $(this).attr('href').split("/");
                if (slashes != '#') {
                    var functionName = slashes[1];
                    functionName = functionName == '' ? 'home' : functionName;
                    var data = slashes.slice(2,slashes.length);
                    _this.prevState = window.history.state;
                    if (functionName !== 'logout') {
                        var state = $(this).attr('href');
                        state = (state == '/' || state == '') ? '/home' : state;
                        window.history.pushState(state, state, state);
                        _this.lastState = state;
                    }   

                    if (_this.prevState) {
                        if (_this.noRevertList.indexOf(functionName) < 0){
                            var prevSlashes = _this.prevState.split("/");
                            var prevFunctionName = prevSlashes[0] == '' ? prevSlashes[1] : prevSlashes[0];
                            _this[prevFunctionName+'Revert']();
                        }
                    }   

                    if (functionName) {
                        _this[functionName](data);
                    }
                }
            });
            window.onpopstate = function(event){
                _this.goToState(event.state);
            };
        },
        goToState:function(state){
            var _this = this;
            if (_this.lastState) {
                var prevSlashes = _this.lastState.split("/");
                var prevFunctionName = prevSlashes[0] == '' ? prevSlashes[1] : prevSlashes[0];
                _this[prevFunctionName+'Revert']();
            }  

            var slashes = state.split("/");
            var functionName = slashes[1] == undefined ? slashes[0] : slashes[1];
            functionName = functionName == '' ? 'home' : functionName;
            var data = slashes.slice(2,slashes.length);   

            if (functionName) {
                _this[functionName](data);
            }       

            _this.lastState = state;
        },
        getUserData:function(callback){
            var _this = this;
            if (_this.userData == null) {
                $.ajax({
                    url:"https://"+base_url+"/user/get/data",
                    method:'GET',
                    dataType:'json'
                }).done(function(response){
                    if (response.success) {
                        _this.userData = response.data;
                        console.log(_this.userData);
                        callback(_this.userData);
                    }
                });
            } else {
                callback(_this.userData);
            }
        },
        render:function(source,data){
            var _this = this;
            var source   = $(source).html();
            var template = Handlebars.compile(source);
            var html    = template(data);
            return html;
        },
        gaf:function(data){
            console.log(data);
            // $.ajax({
            //     url:"https://"+base_url+"/post/",
            //     method:'GET',
            //     dataType:'json'
            // }).done(function(response){
            //     var featured = response.data.slice(0,1);
            //     var posts = response.data.slice(1,response.data.length);
            //     var dataForTemplate = {featured:featured,posts:posts};
            //     var html = _this.render("#homepage-template",dataForTemplate);
            //     _this.elements.homePage = $(html);
            //     $('.container.main').append(_this.elements.homePage);
            // });
        },
        gafRevert:function(){

        },
        navigationBar:function(data){
            var _this = this;
            if (_this.elements.navigationBar != null) {
                _this.elements.navigationBar.remove();
            }
            var html = this.render("#navigation-bar",data);
            _this.elements.navigationBar = $(html);
            $('.container.main').before(_this.elements.navigationBar);
        },
        home:function(data){
            var _this = this;
            _this.homeRevert();
            $.ajax({
                url:"https://"+base_url+"/",
                method:'GET',
                dataType:'json'
            }).done(function(response){
                var featured = response.data.slice(0,1);
                var posts = response.data.slice(1,response.data.length);
                var dataForTemplate = {featured:featured,posts:posts};
                var html = _this.render("#homepage-template",dataForTemplate);
                _this.elements.homePage = $(html);
                $('.container.main').append(_this.elements.homePage);
            });
        },
        post:function(data){
            var _this = this;

            _this.postRevert();
            var postForm;
            if (data != undefined) {
                data.csrf_token = csrf_token;
            } else {
                data = {csrf_token:csrf_token};
            }
            var html = _this.render("#post-form-template",data);
            _this.elements.postForm = $(html).modal('show');
            _this.elements.postForm.on('shown.bs.modal',function(e){
                postForm = new PostForm('#post-form');
                _this.elements.postForm.on('hidden.bs.modal', function (e) {
                    window.history.go(-1);
                });
            });
            
            $(_this.elements.postForm.find('form')).on('submit',function(e){
                e.preventDefault();
                postForm.validateInput(function(response){
                    if (response === true) {
                        postForm.submit(function(response){
                            if (response.error){
                                _this.postRevert();
                                _this.post({
                                    errors:{file:response.error},
                                    title:postForm.formData.title,
                                    file:postForm.formData.file,
                                    fileTypeText:(postForm.elList.fileTypeText.prop('checked')  ? 'checked="checked"' : ''),
                                    fileTypeFile:(postForm.elList.fileTypeFile.prop('checked')  ? 'checked="checked"' : ''),
                                    fileType:(postForm.elList.fileTypeText.prop('checked') ? 'text' : 'file')
                                });
                            } else {
                                _this.postRevert();
                                alert('done');
                            }
                        });
                    } else {
                        _this.postRevert();
                        _this.post({
                            errors:response.errorList,
                            title:postForm.formData.title,
                            file:postForm.formData.file,
                            fileTypeText:(postForm.elList.fileTypeText.prop('checked')  ? 'checked="checked"' : ''),
                            fileTypeFile:(postForm.elList.fileTypeFile.prop('checked')  ? 'checked="checked"' : ''),
                            fileType:(postForm.elList.fileTypeText.prop('checked') ? 'text' : 'file')
                        });
                    }
                });

            });
        },
        postRevert:function(){
            var _this = this;
            if (_this.elements.postForm != null) {
                _this.elements.postForm.remove();
            }
        },
        homeRevert:function(){
            var _this = this;
            if (_this.elements.homePage != null) {
                _this.elements.homePage.remove();
            }
        },
        logout:function(){
            $.ajax({
                url:"https://"+base_url+"/auth/logout",
                method:'GET',
                dataType:'json'
            }).done(function(response){
                if (response.success) {
                    var Backlen=history.length;   
                    history.go(-Backlen);
                    window.location = '/';
                }  
            });
        },
        logoutRevert:function(){

        },
        login:function(data){
            var _this = this;
            if (_this.elements.loginForm != null) {
                _this.elements.loginForm.remove();
            }
            var source   = $("#login-form-template").html();
            var template = Handlebars.compile(source);
            var html    = template(data);
            _this.elements.loginForm = $(html).modal('show');
            _this.elements.loginForm.on('hidden.bs.modal', function (e) {
                _this.elements.loginForm.remove();
                if (_this.prevState == '/login') {
                    window.history.go(-2);
                } else {
                    window.history.go(-1);
                }
            });
            $(_this.elements.loginForm.find('form')).on('submit',function(e){
                $(this).find('input[name=_token]').val(csrf_token);
                e.preventDefault();
                var data = $(this).serialize();
                _this.loginSubmit(data);
            });
        },
        loginSubmit:function(data){
            var _this = this;
            $.ajax({
                url:"https://"+base_url+"/auth/login",
                data:data,
                method:'POST',
                dataType:'json'
            }).done(function(response){
                if(response.success && response.data) {
                    _this.elements.loginForm.modal('hide');
                    _this.navigationBar(response.data);
                } 
            }).fail(function(response){
                _this.login({errors:response.responseJSON});
            });
        },
        loginFacebook:function(){
            var _this = this;
            FB.login(function(response){
                FB.api('/me', function(user_data) {
                    var data = user_data;
                    data._token = csrf_token;
                    $.ajax({
                        url:"https://"+base_url+"/provider-callback/facebook",
                        data:data,
                        method:'POST',
                        dataType:'json'
                    }).done(function(response){
                        if(response.success && response.data) {
                            if (_this.elements.loginForm) {
                                _this.loginRevert();
                            }
                            if (_this.elements.registrationForm) {
                                _this.registerRevert();
                            }
                            _this.navigationBar(response.data);
                        }  
                    });
                });
        }, {scope: 'email,public_profile'});
        },
        loginRevert:function(){
            var _this = this;
            if (_this.elements.loginForm != null) {
                _this.elements.loginForm.modal('hide');
            }
        },
        register:function(data){
            var _this = this;
            if (_this.elements.registrationForm != null) {
                _this.elements.registrationForm.remove();
            }
            var source   = $("#register-form-template").html();
            var template = Handlebars.compile(source);
            if (data.formData) {
                var tempFormData = {};
                for(var i=0; i<data.formData.length; i++){
                    tempFormData[data.formData[i].name] = data.formData[i].value;
                }
                data.formData = tempFormData;
            } else {
                data.formData = {};
            }
            var html    = template(data);
            _this.elements.registrationForm = $(html).modal('show');
            $(_this.elements.registrationForm).on('hidden.bs.modal', function (e) {
                _this.elements.registrationForm.remove();
                if (_this.prevState == '/register') {
                    window.history.go(-2);
                } else {
                    window.history.go(-1);
                }
            });
            $(_this.elements.registrationForm.find('form')).on('submit',function(e){
                $(this).find('input[name=_token]').val(csrf_token);
                e.preventDefault();
                var data = $(this).serializeArray();
                _this.registerSubmit(data);
            });
        },
        registerSubmit:function(data){
            var _this = this;
            $.ajax({
                url:"https://"+base_url+"/auth/register",
                data:data,
                method:'POST',
                dataType:'json'
            }).done(function(response){
                if(response.success && response.data) {
                    _this.elements.registrationForm.modal('hide');
                    _this.navigationBar(response.data);
                } 
            }).fail(function(response){
                _this.register({
                    errors:response.responseJSON,
                    formData:data
                });
            });
        },
        registerRevert:function(){
            var _this = this;
            if (_this.elements.registrationForm != null) {
                _this.elements.registrationForm.modal('hide');
            }
        },
        user:function(data){
            var _this = this;
            _this.userRevert();
            var username = data[0];
            $.ajax({
                url:"https://"+base_url+"/user/"+username,
                method:'GET',
                dataType:'json'
            }).done(function(response){
                if(response.success && response.data) {
                    var source   = $("#profile-template").html();
                    var template = Handlebars.compile(source);
                    var html    = template(response.data);
                    _this.elements.profilePage = $(html);
                    $('.container.main').append(_this.elements.profilePage);     
                } 
            }).fail(function(data){

            });
        },
        userRevert:function(){
            var _this = this;
            if (_this.elements.profilePage != null) {
                _this.elements.profilePage.remove();
            }
        },
        loginFacebookRevert:function(){

        },
        settings:function(data){
            var _this = this;
            _this.settingsRevert();
            _this.getUserData(function(userData){
                userData.csrf_token = csrf_token;
                var templateData = {};
                templateData.user = userData;
                if (data.errors) {
                    templateData.errors = data.errors;
                }
                if (data.success) {
                    templateData.success = data.success;
                }

                _this.elements.settingsPage = $(_this.render('#settings-template',templateData));
                $('.container.main').append(_this.elements.settingsPage); 
                _this.elements.settingsPage.find('form').on('submit',function(e){
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    //validation
                    var toSubmit = false;
                    for(var i = 0; i<data.length;i++) {
                        if(data[i].name == 'username'){
                            if(data[i].value != userData.username){
                                toSubmit = true;
                            } else {
                                data.splice(i,1);
                            }
                        }
                    }
                    if (toSubmit == true) {
                        _this.submitSettings(data);
                    } else {
                        alert('nothing changed');
                    }
                });
            });
        },
        submitSettings:function(data){
            var _this = this;
            $.ajax({
                url:"https://"+base_url+"/user/settings/submit",
                data:data,
                method:'POST',
                dataType:'json'
            }).done(function(response){
                _this.userData = response.data;
                _this.navigationBar(response.data);
                _this.settings({success:true});
            }).fail(function(response){
                _this.settings({errors:response.responseJSON});
            });
        },
        settingsRevert:function(){
            var _this = this;
            if (_this.elements.settingsPage != null) {
                _this.elements.settingsPage.remove();
            }
        }
    };



    function PostForm(formEl){
        this.formEl = $(formEl);
        this.elList = {};
        this.formData = {};
        this.errors = {
            errorCount:0,
            errorList:{},
        };
        this.init = function(){
            var _this = this;

            _this.elList.csrf_token = _this.formEl.find('#token');
            _this.elList.title = _this.formEl.find('#title-input');
            _this.elList.game = _this.formEl.find('#game-input');
            _this.elList.fileTypeText = _this.formEl.find('#file-type-text');
            _this.elList.fileTypeFile = _this.formEl.find('#file-type-file');
            _this.elList.fileType = _this.formEl.find('.file-type');
            _this.elList.file = _this.formEl.find('#file-input');
            _this.elList.gameAutocomplete = _this.formEl.find('#game-autocomplete');

            _this.getGamedata(function(data){
                _this.initAutocomplete(data);
            });

            _this.elList.fileType.change(function(){
                _this.elList.file.prop('type',$(this).val()); 
            });

        };
        this.validateInput = function(callback){
            var _this = this;
            _this.errors.errorCount = 0;
            _this.errors.errorList = {};

            _this.formData.csrf_token = this.elList.csrf_token.val();
            _this.formData.title = this.elList.title.val();
            _this.formData.gameId = this.elList.game.val();
            _this.formData.file = this.elList.file.attr('type') == 'file' ? this.elList.file[0].files[0] : this.elList.file.val();
            
            if (_this.elList.file.attr('type') == 'file') {
                if (_this.elList.file[0].files[0] == undefined) {
                    _this.errors.errorCount++;
                    _this.errors.errorList.file = 'Please select a gif or video file of max 15 seconds and 300mb size';
                }
            } else {
                if (_this.elList.file.val() == '') {
                    _this.errors.errorCount++;
                    _this.errors.errorList.file = 'Please select a gif or video file of max 15 seconds and 300mb size';
                }
            }

            if (_this.formData.title.length < 5){
                _this.errors.errorCount++;
                _this.errors.errorList.title = 'Title has to be at least 5 characters long.';
            }
            if (_this.formData.gameId == 0) {
                _this.errors.errorCount++;
                _this.errors.errorList.game = 'A game from the list needs to be selected.';
            } 

            _this.validateGame(_this.formData.gameId,function(data){
                if(data.success == false) {
                    _this.errors.errorCount++;
                    _this.errors.errorList.game = 'A game from the list needs to be selected.';
                }


                if (_this.errors.errorCount > 0) {
                    callback(_this.errors);
                } else {
                    callback(true);
                }
            });

        };
        this.validateGame = function(gameId,callback){
            var _this = this;
            $.ajax({
                    url: "https://"+base_url+"/validate-game",
                    data:{game_id:gameId},
                    dataType:"json"
                }).done(function(data){
                    callback(data);
                });
        };
        this.getGamedata = function(callback){
            var _this = this;
            $.ajax({
                url: "https://"+base_url+"/gamedata.json",
                dataType:"json"
            }).done(function(data){
                callback(data);
            });
        };
        this.initAutocomplete = function(data){
            var _this = this;
            var options = {
                minChars: 2,
                lookup : data.suggestions,
                onSelect: function (suggestion) {
                    _this.elList.game.val(suggestion.data);
                },
                lookupFilter:function(suggestion, originalQuery, queryLowerCase){
                    var alias = false;
                    if (data.aliases[queryLowerCase] ) {
                        alias = data.aliases[queryLowerCase];
                    }
                    return  (alias ? (suggestion.value.toLowerCase().indexOf(alias) !== -1) : false) || (suggestion.value.toLowerCase().indexOf(queryLowerCase) !== -1);
                }
            };
            _this.elList.gameAutocomplete.autocomplete(options);
        };
        this.submit = function(callback){
            var _this = this;
            var trackKey = Math.abs(String('gafers' + $.now()).hashCode());
            _this.upload(trackKey, function(response){
                var data = {};
                 if (response.gfyname){
                    data.title = _this.formData.title;
                    data.game_id = _this.formData.gameId;
                    data._token = _this.formData.csrf_token;
                    data.webm = data.webmUrl;
                    data.gif = data.gifUrl;
                    data.mp4 = data.mp4Url;
                    data.filename = data.gfyName;
                    data.track_key = trackKey;
                } else {
                    data.title = _this.formData.title;
                    data.game_id = _this.formData.gameId;
                    data._token = _this.formData.csrf_token;
                    data.track_key = trackKey;
                }
                $.ajax({
                    url:"https://"+base_url+"/post/create",
                    data:data,
                    method:'POST'
                }).done(function(response){
                     callback(response);
                }).fail(function(response){
                    callback({error:response.responseJSON});
                });
            });
        };
        this.upload = function(trackKey, callback){
            var _this = this;
            if (_this.elList.file.prop('type') == 'file') {
                var fd = new FormData();
                fd.append('key',trackKey);
                fd.append('acl','private');
                fd.append('AWSAccessKeyId','AKIAIT4VU4B7G2LQYKZQ');
                fd.append('policy','eyAiZXhwaXJhdGlvbiI6ICIyMDIwLTEyLTAxVDEyOjAwOjAwLjAwMFoiLAogICAgICAgICAgICAiY29uZGl0aW9ucyI6IFsKICAgICAgICAgICAgeyJidWNrZXQiOiAiZ2lmYWZmZSJ9LAogICAgICAgICAgICBbInN0YXJ0cy13aXRoIiwgIiRrZXkiLCAiIl0sCiAgICAgICAgICAgIHsiYWNsIjogInByaXZhdGUifSwKCSAgICB7InN1Y2Nlc3NfYWN0aW9uX3N0YXR1cyI6ICIyMDAifSwKICAgICAgICAgICAgWyJzdGFydHMtd2l0aCIsICIkQ29udGVudC1UeXBlIiwgIiJdLAogICAgICAgICAgICBbImNvbnRlbnQtbGVuZ3RoLXJhbmdlIiwgMCwgNTI0Mjg4MDAwXQogICAgICAgICAgICBdCiAgICAgICAgICB9');
                fd.append('success_action_status','200');
                fd.append('signature','mk9t/U/wRN4/uU01mXfeTe2Kcoc=');
                fd.append('Content-Type','image/gif');
                fd.append('file',this.elList.file[0].files[0],trackKey);
           
                $.ajax({
                    url:"https://gifaffe.s3.amazonaws.com/",
                    data:fd,
                    method:'POST',
                    contentType:false,
                    processData: false,
                    cache:false
                }).done(function(data){
                    callback(data);
                });
            } else {
                $.ajax({
                    url:"https://upload.gfycat.com/transcodeRelease/" + trackKey,
                    data:{fetchUrl:_this.formData.file},
                    dataType:'json'
                }).done(function(data){
                    callback(data);
                });
            }
        };
        this.init();
    };
    DOMManager.init(user_data,hash);
});
