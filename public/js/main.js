$(function(){
    var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

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
        userData:null,
        init:function(user,hash){
            var _this = this;
            _this.navigationBar(user);
            _this.initRouter(hash);
        },
        initRouter:function(){
            var _this = this;
            
            //landing
            var slashes = window.location.pathname.split("/");
            var state = slashes[1];
            var data = slashes.slice(2,slashes.length);
            _this.goToState(state,data);

            var action = function (e,el){
                if (!el.data('ignore')) {
                    e.preventDefault();

                    if (el.data('action')) {
                        _this[el.data('action')]();
                        return;
                    }

                    var slashes = el.attr('href').split("/");
                    if (slashes == '#') {
                        return;
                    }
                    var state = slashes[1];
                    var data = slashes.slice(2,slashes.length);
                    _this.goToState(state,data);
                }
            };
            //go to page
            $('body').on('click','a',function(e){
                action(e,$(this));
            });
            //go to page
            $('body').on('click','button',function(e){
                if ($(this).data('action')) {
                        action(e,$(this));
                    }
            });
            window.onpopstate = function(event){
                var slashes = document.location.pathname.split("/");
                var state = slashes[1];
                var data = slashes.slice(2,slashes.length);
                _this.goToState(state,data,false);
            };

            $(window).on('beforeunload ',function() {
                if (_this.uploadInProgress) {
                    return 'Your file is still uploading. If you leave the page uploading will stop.';
                }
            });

            
        },
        goToState:function(state,data,pushState){
            var _this = this;
            pushState = pushState == undefined ? true : pushState;
            //revert previous stage
            if (_this.lastState !== null) {
                _this.prevState = _this.lastState;
                var prevSlashes = _this.lastState.split("/");
                var prevFunctionName = prevSlashes[0] == '' ? 'home' : prevSlashes[0];
                _this[prevFunctionName+'Revert']();
            }  

            //set new stage
            var url = state == '/' ? '' : state;
            if (data && data.length) {
                url += '/' + data.join('/')
            }
            _this.lastState = state;
            if (pushState) {
                window.history.pushState(state, state, "https://"+base_url + '/' + url);
            }
            
            //call function
            var functionName = state;
            if (state == '' || state == 'top') {
                functionName = 'home';
            } 
            if (state == 'recent') {
                functionName = 'home';
                data.type = 'recent';
            }
            if (state == 'category') {
                functionName = 'home';
                data.type = 'category';
            }

            //naviagation bar
            var dataStr = decodeURIComponent(data.join('-')).toLowerCase().replace(/ /g, '-');
            var navClass = state == '' ? 'top' : state+(dataStr.length?'-'+dataStr:'');
            if($('.nav li.'+navClass).length){
                $('.nav li').removeClass('active');
                $('.nav li.'+navClass).addClass('active');
            }

            ga('send', 'pageview');
            
            _this[functionName](data);
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
                        callback(_this.userData);
                    }
                }).fail(function(response){
                    _this.userData = false;
                    callback(_this.userData);
                });
            } else {
                callback(_this.userData);
            }
        },
        render:function(source,data){
            var _this = this;
            var source   = $(source).html();
            var template = Handlebars.compile(source);
            var data = data ? data : {}; 
            data.csrf_token = csrf_token;
            var html    = template(data);
            return html;
        },
        navigationBar:function(data){
            var _this = this;
            if (_this.elements.navigationBar != null) {
                _this.elements.navigationBar.remove();
            }
            var html = this.render("#navigation-bar",data);
            _this.elements.navigationBar = $(html);
            $('.container.main').before(_this.elements.navigationBar);
            _this.elements.navigationBar.find('form').on('submit',function(e){
                e.preventDefault();
            });
            getGamedata(function(data){
                var options = {
                minChars: 2,
                lookup : data.suggestions,
                onSelect: function (suggestion) {
                    _this.goToState('game',[encodeURIComponent(suggestion.value)]);
                },
                lookupFilter:function(suggestion, originalQuery, queryLowerCase){
                    var alias = false;
                    if (data.aliases[queryLowerCase] ) {
                        alias = data.aliases[queryLowerCase];
                    }
                    return  (alias ? (suggestion.value.toLowerCase().indexOf(alias) !== -1) : false) || (suggestion.value.toLowerCase().indexOf(queryLowerCase) !== -1);
                }
            };
            _this.elements.navigationBar.find('input').autocomplete(options);
            });
        },
        gameRevert:function(){
            var _this = this;
            if (_this.elements.gamePage != null) {
                _this.elements.gamePage.remove();
            }
        },
        game:function(data,initial){
            var _this = this;
            var initial = initial == undefined ? true : initial;
            $.ajax({
                url:"https://"+base_url+"/game/"+data[0],
                method:'GET',
                dataType:'json'
            }).done(function(response){
                var dataForTemplate = response.data;
                if (initial) {
                    var listTemplatehtml = _this.render("#list-template",dataForTemplate);
                    _this.elements.gamePage = $(listTemplatehtml);
                    $('.container.main').append(_this.elements.gamePage);
                }
                var postsHtml = _this.render("#posts-template",{posts:dataForTemplate});
                _this.elements.gamePage.find('.posts').append(postsHtml);
            });
        },
        topRevert:function(){
            var _this = this;
            _this.homeRevert();
        },
        top:function(){

        },
        recentRevert:function(){
            var _this = this;
            _this.homeRevert();
            
        },
        recent:function(){
            var _this = this;

        },
        home:function(data,initial,callback){
            var _this = this;
            _this.revertVoteTrigger();
            var initial = initial == undefined ? true : initial;
            var page = data.page ? data.page : 1;
            var type = data.type ? data.type : 'top';
            delete data.page;
            delete data.type;
            $.ajax({
                url:"https://"+base_url+"/"+type+"/"+(data[0]?data[0]+"/":"")+page,
                method:'GET',
                dataType:'json'
            }).done(function(response){
                if (!initial) {
                    $('.loader').remove();
                }

                var dataForTemplate = response.data;
                dataForTemplate.isMobile = isMobile;
                dataForTemplate.featured.forEach(function(v,k){
                    v.postLocation = "https://"+base_url+"/gaf/"+v.url_key;
                    v.game.url_name = encodeURIComponent(v.game.name);
                });
                dataForTemplate.posts.forEach(function(v,k){
                    v.game.url_name = encodeURIComponent(v.game.name);
                });
                if (initial) {
                    var html = _this.render("#homepage-template",dataForTemplate);
                    _this.elements.homePage = $(html);
                    $('.container.main').append(_this.elements.homePage);
                }
                if (dataForTemplate.featured.length) {
                    dataForTemplate.featured[dataForTemplate.featured.length-1].last = true;
                    var featuredHtml = _this.render("#homepage-featured",dataForTemplate);
                    var postsHtml = _this.render("#homepage-posts",dataForTemplate);
                    _this.elements.homePage.find('.featured').append(featuredHtml);
                    _this.elements.homePage.find('.posts').append(postsHtml);
                }
                var videos = $('.homepage video');
                
                var loading = false;
                $(window).on('homepage-scroll', function(){
                    videos.each(function(k,el){
                        var rect = el.getBoundingClientRect();
                        if (rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) 
                            && rect.right <= (window.innerWidth || document.documentElement.clientWidth) ) {
                             videos.each(function(k,el){
                                $(el).css('opacity','0.5');
                                el.pause();
                            });
                            $(el).css('opacity','1');
                            el.play();
                            if (!loading) {
                                if ($(el).attr('data-last')) {
                                    $(window).off('homepage-scroll');
                                    $(el).removeAttr('data-last');
                                        loading = true;
                                        window.setTimeout(function(){
                                            _this.home($.extend({page:page+1,type:type},data),false,function(){
                                                loading = false;
                                            });
                                    },300);
                                    
                                }
                            }
                        }
                    });
                });
                $(window).on('DOMContentLoaded load resize scroll', function(){
                    $(window).trigger('homepage-scroll');
                });
                
                _this.voteTrigger();

                if (callback) {
                    callback();
                }
            });               
        },
        category:function(data,initial){
            var _this = this;
        },
        categoryRevert:function(){
            var _this = this;
            _this.homeRevert();
        },
        gaf:function(data){
            var _this = this;
            _this.gafRevert();
            $.ajax({
                url:"https://"+base_url+"/gaf/" + data[0],
                method:'GET',
                dataType:'json'
            }).done(function(response){
                var videoPaused = false;
                var dataForTemplate = response.data;
                dataForTemplate.isMobile = isMobile;
                dataForTemplate.postLocation = window.location;
                var html = _this.render("#post-template",dataForTemplate);
                _this.elements.gafPage = $(html);
                $('.container.main').append(_this.elements.gafPage);
                _this.comments(response.data.post.id);

                var video = _this.elements.gafPage.find('video')[0];
                var seekBar = $('#seekBarInner');
                var seekBarCont = $('#seekBar');
                var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
                var seekBarContWidth = seekBarCont.width();
                var timeDrag = false;
                var videoTime = $('.video-time');
                var manualPause = false;

                if (video) {
                    $(video).on('click',function(){
                        if (video.paused) {
                            $('.video-play').trigger('click');
                        } else {
                            $('.video-pause').trigger('click');
                        }
                    });

                    _this.elements.gafPage.find('.glyphicon-resize-full').on('click',function(){
                        if (typeof(video.webkitRequestFullScreen) == 'function'){
                            video.webkitRequestFullScreen();
                        } else if(typeof(video.mozRequestFullScreen) == 'function'){
                            video.mozRequestFullScreen();
                        }else if(typeof(video.requestFullScreen) == 'function') {
                            video.requestFullScreen();
                        }
                        
                    });

                    var updateTime = function(){
                        videoTime.html(parseFloat(video.currentTime).toPrecision(3));
                    };

                    var renderProgress = function(){
                       // is percent correct?
                       if (timeDrag == false){
                           var percent = (100 / video.duration) * video.currentTime;
                           seekBar.css('width',percent+'%');
                           requestAnimationFrame(renderProgress);
                           updateTime();
                        }
                    };
                        renderProgress();

                    var updatebar = function(x) {
                        var progress = $('#seekBar');
                        var maxduration = video.duration; //Video duraiton
                        var position = x - progress.offset().left; //Click pos
                        var percentage = 100 * position / progress.width();
                     
                        //Check within range
                        if(percentage > 100) {
                            percentage = 100;
                        }
                        if(percentage < 0) {
                            percentage = 0;
                        }
                     
                        //Update progress bar and video currenttime
                        $('#seekBarInner').css('width', percentage+'%');
                        video.currentTime = maxduration * percentage / 100;
                    };

                    $('#seekBar').mousedown(function(e) {
                        video.pause();
                        timeDrag = true;
                        updatebar(e.pageX);
                    });
                    $(document).mouseup(function(e) {
                        if(timeDrag) {
                            if(!manualPause){
                                video.play();
                            }
                            timeDrag = false;
                            updatebar(e.pageX);
                        }
                        renderProgress();
                    });
                    $(document).mousemove(function(e) {
                        if(timeDrag) {
                            updatebar(e.pageX);
                            updateTime();
                        }
                    });

                    $('body').on('click','.video-pause',function(){
                        manualPause = true;
                        video.pause();
                        $(this).removeClass('glyphicon-pause video-pause');
                        $(this).addClass('glyphicon-play video-play');
                    });

                    $('body').on('click','.video-play',function(){
                        video.play();
                        $(this).removeClass('glyphicon-play video-play');
                        $(this).addClass('glyphicon-pause video-pause');
                    });
                }

                _this.voteTrigger();
            });
        },
        revertVoteTrigger:function(){
            var _this = this;
            $('body').off('click','.post-vote');
        },
        voteTrigger:function(){
            var _this = this;
            $('body').on('click','.post-vote',function(){          
                    var el = $(this);
                    _this.getUserData(function(user){
                        if (user === false) {
                            _this.login();
                            return;
                        } else {
                            var data = {
                                post_id:el.data('postid'),
                                _token:csrf_token
                            };
                            $.ajax({
                                url:"https://"+base_url+"/post/vote",
                                data:data,
                                method:'POST',
                                dataType:'json'
                            }).done(function(response){
                                var postPointsEl = el.parent().find('.post-points');
                                var curPts = parseInt(postPointsEl.html());
                                var newPts = el.hasClass('voted') ? curPts-1 : curPts+1 ;
                                postPointsEl.html(newPts);
                                el.toggleClass('voted');
                            }).fail(function(response){
                                //alert(response.responseJSON);
                            });
                        }
                    });
                });
        },
        commentsRevert:function(){
            var _this = this;
            $('body').off('click','.comment-area');
            $('body').off('click','.more-comments');
            $('body').off('click','.more-replies');
            $('body').off('click','.comment-reply-button');
            $('body').off('keyup','.comment-area');
            $('body').off('click','.comment-vote');
            if (_this.elements.comments != null) {
                _this.elements.comments.remove();
                _this.elements.comments = null;
            }
        },
        comments:function(postId, commentId, page,initial){
            var _this = this;
            _this.commentsRevert();
            var initial = initial == undefined ? true : false;
            var commentId = commentId ? commentId : 0;
            var page = page ? page : 1;
            $.ajax({
                url:"https://"+base_url+"/comment/view/" + postId + "/" + page + "/" + commentId,
                method:'GET',
                dataType:'json'
            }).done(function(response){
                if(response.success && response.data) { 
                    if (initial) {
                        var containerHtml = _this.render('#comments-container',{postId:postId});
                        _this.elements.comments = $(containerHtml);
                        $('.post-info').after(_this.elements.comments);
                    }
                    var commentsHtml = _this.render("#comments-template",{
                        comments:response.data.comments,
                        more:response.data.more,
                        page:page+1
                    });
                    _this.elements.comments.find('.comments-holder > div').append(commentsHtml);
                    var i = 0;
                    $('.comments-holder .comment-row').each(function(k,v){
                        var commentEl = $(v);
                        var repliesHtml = _this.render("#replies-template",{
                            replies:response.data.comments[i].replies.replies,
                            parentId:commentEl.data('commentid')
                        });
                        var html = _this.render("#replies-container-template",{
                            repliesHtml:repliesHtml,
                            more:response.data.comments[i].replies.more,
                            commentId:commentEl.data('commentid'),
                            page:2
                        });
                        commentEl.after(html);
                        i++;
                    });

                        $('body').on('click','.comment-area',function(){
                            var commentArea = $(this);
                            _this.getUserData(function(user){
                                if (user === false) {
                                    commentArea.attr('disabled','disabled');
                                    _this.login();
                                }
                            });
                        });

                        $('body').on('click','.more-comments',function(){
                            var page = $(this).data('page');
                            var commentId = $(this).data('commentid');
                            $(this).remove();
                            _this.comments(postId,commentId,page,false);
                        });

                        $('body').on('click','.more-replies',function(){
                            var el = $(this);
                            var page = el.data('page');
                            var commentId = el.data('commentid');
                            var limit = 40;
                            var offset = 1;
                            $.ajax({
                                url:"https://"+base_url+"/comment/replies/" + commentId + "/" + page + "/" + limit + "/" + offset,
                                method:'GET',
                                dataType:'json'
                            }).done(function(response){
                                var html = _this.render("#replies-template",{
                                    replies:response.data.replies,
                                    more:response.data.more,
                                    page:3,
                                    parentId:commentId
                                });
                                el.parents('.replies').children('div').children('.row:nth-child(1)').children('div').append(html);
                                el.remove();
                            });
                        });

                        $('body').on('click','.comment-reply-button',function(){
                            var button = $(this);
                            _this.getUserData(function(user){
                                if (user === false) {
                                    _this.login();
                                    return;
                                }
                                if (button.hasClass('reply-on')) {
                                    button.next().remove();
                                    button.removeClass('reply-on');
                                    return;
                                }
                                var html = _this.render('#comments-reply-template',{
                                    commentId:button.data('commentid'),
                                    replyTo:'@'+button.parents().find('.comment-author span').html()+" "
                                });
                                button.after(html);
                                button.addClass('reply-on');
                            });
                        });

                        $('body').on('keyup','.comment-area',function comment(e){
                            var commentArea = $(this);
                            if((e.keyCode || e.which) == 13) {
                                e.preventDefault();
                                var data = {
                                    _token:csrf_token,
                                    content:$(this).val(),
                                };
                                //means its a reply
                                if ($(this).data('commentid')){
                                    data.reply_id = $(this).data('commentid');
                                } else {
                                    data.post_id = $(this).data('postid');
                                }

                                _this.commentSubmit(data,function(response){
                                    if (response.success) {
                                        commentArea.parents('.comment').find('.comment-reply-button').removeClass('reply-on');
                                        //means its a reply
                                        if (data.reply_id) {
                                            var html = _this.render('#replies-template',{
                                                replies:[response.data],
                                                parentId:data.reply_id
                                            });
                                            var reply = $(html);
                                            //reply to 0 level comment
                                            if (commentArea.parents('.comment-row-level-0').length > 0) {
                                                commentArea.parents('.comment-row-level-0').next().children('div').children('.row:nth-child(1)').children('div').append(reply);
                                            } else {
                                                //reply to 1 level comment
                                                commentArea.parents('.replies').children('div').children('.row:nth-child(1)').children('div').append(reply);

                                            }
                                        } else {
                                            var commentHtml = _this.render('#comments-template',{comments:[response.data]});
                                            
                                            var repliesHtml = _this.render("#replies-container-template",{
                                                commentId:response.data.id,
                                                page:2
                                            });

                                            html = commentHtml + repliesHtml;
                                            var comment = $(html);
                                            $('.comments-holder > div').prepend(html);
                                        }
                                        
                                        commentArea.remove();
                                    } else {
                                        console.log(response);
                                    }
                                });
                               
                             }
                        });

                        $('body').on('click','.comment-vote',function(e){
                            var el = $(this);
                            _this.getUserData(function(user){
                                if (user === false) {
                                    _this.login();
                                    return;
                                } else {
                                    var data = {
                                        commentId:el.data('commentid'),
                                        _token:csrf_token
                                    };
                                    $.ajax({
                                        url:"https://"+base_url+"/comment/vote",
                                        data:data,
                                        method:'POST',
                                        dataType:'json'
                                    }).done(function(response){
                                        var cur_pts = el.parent('.points').find('span:first-child').html();
                                        cur_pts = el.hasClass('voted') ? --cur_pts : ++cur_pts ;
                                        el.parent('.points').find('span:first-child').html(cur_pts);
                                        el.toggleClass('voted');
                                    }).fail(function(response){
                                        //alert(response.responseJSON);
                                    });
                                }
                            });
                        });
                    
                } 
            }).fail(function(response){
                console.log(response.responseJSON);
            });
        },
        commentSubmit:function(data,callback){
            var _this = this;
            $.ajax({
                url:"https://"+base_url+"/comment/create",
                data:data,
                method:'POST',
                dataType:'json'
            }).done(function(response){
                callback(response);
            }).fail(function(response){
                callback(response.responseJSON);
            });
        },
        reply:function(data) {
            var _this = this;
            
        },
        replyRevert:function(){
            var _this = this;
        },
        gafRevert:function(){
            var _this = this;
            _this.revertVoteTrigger();
            if (_this.elements.gafPage) {
                _this.elements.gafPage.remove();
                _this.elements.gafPage = null;
            }
        },
        post:function(data){
            var _this = this;
            $('.post-button').attr('disabled',true);
            if (_this.elements.postForm && _this.uploadInProgress){
                _this.elements.postForm.modal('show');
                return;
            }
            _this.postRevert();
            if (data != undefined) {
                data.csrf_token = csrf_token;
            } else {
                data = {csrf_token:csrf_token};
            }
            var html = _this.render("#post-form-template",data);
            _this.elements.postForm = $(html).modal('show');
            _this.elements.postForm.on('shown.bs.modal',function(e){
                _this.postFormManager = new PostForm('#post-form');
                _this.elements.postForm.on('hidden.bs.modal', function (e) {
                    if (!_this.uploadInProgress) {
                        $('.upload-progress').each(function(k,el){
                            if(!$(el).hasClass('hidden')) {
                                $(el).addClass('hidden');
                            }
                        });
                        _this.postRevert();
                    }
                });
            });
            
            $(_this.elements.postForm.find('form')).on('submit',function(e){
                e.preventDefault();
                _this.elements.postForm.find('.btn.submit').attr('disabled',true);
                _this.postFormManager.validateInput(function(response){
                    var formData = _this.postFormManager.formData;
                    if (response === true) {
                        _this.uploadInProgress = true;
                        _this.postFormManager.submit(function(response){
                            if (response.error){
                                _this.postRevert();
                                var data = {
                                    errors:{file:response.error},
                                    title:formData.title,
                                    file:formData.file,
                                    game:formData.game,
                                    gameId:formData.gameId
                                };
                                data['selectedCategory'+formData.categoryId] = true;
                                _this.post(data);
                            } else {
                                _this.elements.postForm.find('.btn-primary.submit').removeClass('btn-primary').addClass('btn-success').html('Success!');
                                window.setTimeout(function() {
                                    $('.nav .upload-progress').addClass('done');
                                    $('body').on('click','.nav .upload-progress.done',function(){
                                        _this.goToState('gaf',[response.data]);
                                    });
                                    var formOpen = _this.elements.postForm.data('bs.modal').isShown ? true : false;
                                    _this.postRevert(function(){
                                        //go to page only if form is still there
                                        if (formOpen) {
                                            _this.goToState('gaf',[response.data]);
                                        }
                                    });
                                }, 2000);
                                _this.uploadInProgress = false;
                            }
                        });
                    } else {
                        _this.uploadInProgress = false;
                        _this.postRevert(function(){
                            var data = {
                                errors:response.errorList,
                                title:formData.title,
                                file:formData.file,
                                game:formData.game,
                                gameId:formData.gameId
                            };
                            data['selectedCategory'+formData.categoryId] = true;
                            _this.post(data);
                        });
                    }
                });
            });
        },
        postRevert:function(callback){
            var _this = this;
            $('.post-button').removeAttr('disabled');
            if (_this.postFormManager) {
                _this.postFormManager.destroy();
                _this.postFormManager = null;
            }
            if (_this.elements.postForm) {
                //register new hidden event
                _this.elements.postForm.on('hidden.bs.modal',function(){
                    if (_this.elements.postForm != null) {
                        _this.elements.postForm.remove();
                        _this.elements.postForm = null;   
                    }
                    if (callback) {
                        callback();
                    }
                });
                //check if its already hidden or not
                if (_this.elements.postForm.hasClass('in')){
                    _this.elements.postForm.modal('hide');
                } else {
                    //if its already hidden just remove it
                    if (_this.elements.postForm) {
                        _this.elements.postForm.remove();
                        _this.elements.postForm = null;
                        if (callback) {
                            callback();
                        }
                    }
                }
            }
        },
        homeRevert:function(){
            var _this = this;
            if (_this.elements.homePage != null) {
                _this.elements.homePage.remove();
                _this.elements.homePage = null;
                $(window).off('homepage-scroll');
            }
        },
        logout:function(){
            $.ajax({
                url:"https://"+base_url+"/auth/logout",
                method:'GET',
                dataType:'json'
            }).done(function(response){
                if (response.success) {
                    // var Backlen=history.length;   
                    // history.go(-Backlen);
                    // window.location = '/';
                    location.reload();
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
                    location.reload();
                    // _this.elements.loginForm.modal('hide');
                    // _this.userData = response.data;
                    // _this.navigationBar(response.data);
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
                            location.reload();
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
            
            if (_this.elements.loginForm != null) {
                _this.elements.loginForm.remove();
            }
            if (_this.elements.registrationForm != null) {
                _this.elements.registrationForm.remove();
            }

            var data = data ? data : {};

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
                    location.reload();
                } 
            }).fail(function(response){
                _this.register({
                    errors:response.responseJSON,
                    formData:data
                });
            });
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
                    //is there user looking at his own profile?
                    _this.getUserData(function(userData){
                        response.data.ownProfile = (userData && userData.id == response.data.id) ? true : false;

                        var html    = template(response.data);
                        _this.elements.profilePage = $(html);
                        $('.container.main').append(_this.elements.profilePage);  
                    });
                       
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
        },
        feedbackRevert:function(callback){
            var _this = this;
            if (_this.elements.feedbackForm != null) {
                _this.elements.feedbackForm.on('hidden.bs.modal', function (e) {
                    _this.elements.feedbackForm.remove();
                    _this.elements.feedbackForm = null;
                    callback();
                });
                if (_this.elements.feedbackForm.hasClass('in')){
                        _this.elements.postForm.modal('hide');
                } else {
                    //if its already hidden just remove it
                    if (_this.elements.feedbackForm != null) {
                        _this.elements.feedbackForm.remove();
                        _this.elements.feedbackForm = null;
                        if (callback){
                            callback();
                        }
                    }
                }
            } else {
                callback();
            }

        },
        feedback:function(){
            var _this = this;
            _this.feedbackRevert(function(){
                var html = _this.render("#feedback-form-template",[]);
                _this.elements.feedbackForm = $(html).modal('show');
                _this.elements.feedbackForm.find('form').on('submit',function(e){
                    e.preventDefault();
                    var form_el = $(this);
                    $.ajax({
                        url: "https://"+base_url+"/feedback",
                        dataType:"json",
                        method:"POST",
                        data:{
                            _token:csrf_token,
                            content:_this.elements.feedbackForm.find('#content-input').val(),
                            email:_this.elements.feedbackForm.find('#email-input').val()
                        }
                    }).done(function(data){
                        form_el.find('.btn-primary.submit').removeClass('btn-primary').addClass('btn-success').html('Success!');
                        window.setTimeout(function() {
                            _this.elements.feedbackForm.modal('hide');
                        }, 1000);
                    });
                });
            });
        }
    };

    function getGamedata(callback){
        $.ajax({
            url: "https://"+base_url+"/gamedata.json",
            dataType:"json"
        }).done(function(data){
            callback(data);
        });
    };




    function PostForm(formEl){
        this.formEl = $(formEl);
        this.elList = {};
        this.formData = {};
        this.errors = {
            errorCount:0,
            errorList:{},
        };
        this.destroy = function(){
            var _this = this;
        };
        this.init = function(){
            var _this = this;

            _this.elList.csrf_token = _this.formEl.find('#token');
            _this.elList.title = _this.formEl.find('#title-input');
            _this.elList.game = _this.formEl.find('#game-input');
            _this.elList.fileTypeText = _this.formEl.find('#file-type-text');
            _this.elList.fileTypeFile = _this.formEl.find('#file-type-file');
            _this.elList.fileTypeSelect = _this.formEl.find('.file-type-select');
            _this.elList.category = _this.formEl.find('.category');
            _this.elList.fileType = _this.formEl.find('.file-type');
            _this.elList.file = _this.formEl.find('#file-input');
            _this.elList.url = _this.formEl.find('#url-input');
            _this.elList.gameAutocomplete = _this.formEl.find('#game-autocomplete');

            getGamedata(function(data){
                _this.gamedata = data;
                _this.initAutocomplete(data);
            });

            if (!_this.elList.category.find('.btn.active')[0]) {
                _this.elList.category.find('.btn.category-other').addClass('active');
            }

            $('.upload-progress').each(function(k,el){
                if(!$(el).hasClass('hidden')) {
                    $(el).addClass('hidden');
                }
            });
            $('.upload-progress .progress-bar').css('width','0%');
            $('.upload-progress .progress-bar').removeClass('progress-bar-success');
            $('body').off('click','.nav .upload-progress.done');
            $('.nav .upload-progress').removeClass('done');

            _this.elList.fileTypeSelect.find('.btn').on('click',function(){
                var type = $(this).data('type');
                _this.elList.fileTypeSelect.find('.btn').removeClass('active');
                $(this).addClass('active'); 
                var uploadProgressEl = $('.upload-progress');
                if(type == 'url') {
                    _this.elList.fileType.find('input[type=text]').removeClass('hidden');
                    _this.formEl.find('.file-name').html('');
                    _this.elList.file.val('');
                    uploadProgressEl.each(function(k,el){
                        if (!$(el).hasClass('hidden')){
                            $(el).addClass('hidden');
                        }
                    });
                    $('#url-input').focus();
                } 
            });

            $('body').on('click','.glyphicon-remove-sign',function(){
                _this.elList.gameAutocomplete.removeAttr('disabled');
                _this.elList.gameAutocomplete.val('');
                _this.elList.gameAutocomplete.focus();
                $(this).addClass('hidden');
            });

            $('body').on('change','#file-input',function(){
                $('.filename').html(_this.elList.file.val().split("\\").pop());
                $('.upload-progress').removeClass('hidden');
                var textEl = _this.elList.fileType.find('input[type=text]');
                if (!textEl.hasClass('hidden')) {
                    textEl.addClass('hidden');
                }
            });

        };
        this.validateInput = function(callback){
            var _this = this;
            _this.errors.errorCount = 0;
            _this.errors.errorList = {};

            _this.formData.csrf_token = this.elList.csrf_token.val();
            _this.formData.title = _this.elList.title.val();
            _this.formData.gameId = _this.elList.game.val();
            _this.formData.game = _this.elList.gameAutocomplete.val();
            _this.formData.categoryId = _this.elList.category.find('.btn.active > input').val();
            _this.formData.game = _this.formData.game == ''? false : _this.formData.game;
            _this.formData.fileType = $('.file-type-select .btn.active').data('type');
            if (_this.formData.fileType == 'upload') {
                _this.formData.file = _this.elList.file;
                if (_this.formData.file[0].files[0] == undefined || _this.formData.file[0].files[0].size/(1024*1024) > 300) {
                    _this.errors.errorCount++;
                    _this.errors.errorList.file = 'Please select a gif or video file of max 15 seconds and 300mb size';
                }
            } else if (_this.formData.fileType == 'url') {
                _this.formData.url = _this.elList.url.val();
                if (_this.formData.url == '') {
                    _this.errors.errorCount++;
                    _this.errors.errorList.file = 'Please select a gif or video file of max 15 seconds and 300mb size';
                }
            } else {
                _this.errors.errorCount++;
                _this.errors.errorList.file = 'Please select a gif or video file of max 15 seconds and 300mb size';    
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
        this.initAutocomplete = function(data){
            var _this = this;
            var options = {
                minChars: 2,
                lookup : data.suggestions,
                onSelect: function (suggestion) {
                    _this.elList.game.val(suggestion.data);
                    _this.elList.gameAutocomplete.attr('disabled',true);
                    _this.elList.gameAutocomplete.parent().next('.glyphicon-remove-sign').removeClass('hidden');
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
            //generate a track key
            var trackKey = Math.abs(String('gafers' + $.now()).hashCode());
            //submit the file or url
            _this.upload(trackKey, function(response){
                //uploading finished now submit the rest
                //of the form
                var data = {};
                data.title = _this.formData.title;
                data.game_id = _this.formData.gameId;
                data.category_id = _this.formData.categoryId;
                data._token = _this.formData.csrf_token;
                data.track_key = trackKey;
                
                //this file alreay exists
                if (response.gfyname) {
                    data.filename = response.gfyname;
                }
                
                //submit a create request
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
            if (_this.formData.fileType == 'upload') {
                var fd = new FormData();
                fd.append('key',trackKey);
                fd.append('acl','private');
                fd.append('AWSAccessKeyId','AKIAIT4VU4B7G2LQYKZQ');
                fd.append('policy','eyAiZXhwaXJhdGlvbiI6ICIyMDIwLTEyLTAxVDEyOjAwOjAwLjAwMFoiLAogICAgICAgICAgICAiY29uZGl0aW9ucyI6IFsKICAgICAgICAgICAgeyJidWNrZXQiOiAiZ2lmYWZmZSJ9LAogICAgICAgICAgICBbInN0YXJ0cy13aXRoIiwgIiRrZXkiLCAiIl0sCiAgICAgICAgICAgIHsiYWNsIjogInByaXZhdGUifSwKCSAgICB7InN1Y2Nlc3NfYWN0aW9uX3N0YXR1cyI6ICIyMDAifSwKICAgICAgICAgICAgWyJzdGFydHMtd2l0aCIsICIkQ29udGVudC1UeXBlIiwgIiJdLAogICAgICAgICAgICBbImNvbnRlbnQtbGVuZ3RoLXJhbmdlIiwgMCwgNTI0Mjg4MDAwXQogICAgICAgICAgICBdCiAgICAgICAgICB9');
                fd.append('success_action_status','200');
                fd.append('signature','mk9t/U/wRN4/uU01mXfeTe2Kcoc=');
                fd.append('Content-Type','image/gif');
                fd.append('file',_this.formData.file[0].files[0],trackKey);
           
                $.ajax({
                    url:"https://gifaffe.s3.amazonaws.com/",
                    data:fd,
                    method:'POST',
                    contentType:false,
                    processData: false,
                    cache:false,
                     xhr: function(){
                        var xhr = new window.XMLHttpRequest();
                        //Upload progress
                        xhr.upload.addEventListener("progress", function(evt){
                          if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            $('.upload-progress .progress-bar').css('width',(percentComplete*100)+'%');
                            if (percentComplete === 1) {
                                $('.upload-progress .progress-bar').addClass('progress-bar-success');
                            }
                          }
                        }, false);
                        return xhr;
                      },
                }).done(function(data){
                    _this.formEl.find('.upload-progress').addClass('hidden');
                    callback(data);
                });
            } else {
                $.ajax({
                    url:"https://upload.gfycat.com/transcodeRelease/" + trackKey,
                    data:{fetchUrl:_this.formData.url},
                    dataType:'json',
                }).done(function(data){
                    callback(data);
                });
            }
        };
        this.init();
    };
    //user_data from php at app
    DOMManager.init(user_data,hash);
});
