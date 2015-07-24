<style>
.featured{
}

.post-thumb{
	margin-bottom:20px;
}

.post-thumb  .title{
	overflow:hidden; 
    white-space:nowrap; 
    text-overflow: ellipsis;
    display: block;
}

.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid red;
  border-right: 1.1em solid grey;
  border-bottom: 1.1em solid grey;
  border-left: 1.1em solid grey;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

.post .glyphicon-comment{
	font-size:2em;
	float: right;
	text-align: center;
	color:grey;
}

.post .glyphicon-comment:hover{
	color:black;
}

.homepage > .row.content{
	margin-top:40px;
}

.row.post {
	margin-bottom:35px;
}

.post .post-title span{
	font-size: 1.35em;
  	font-weight: bolder;
  	overflow:hidden; 
    white-space:nowrap; 
    text-overflow: ellipsis;
    display:block;
}

.post .post-title span > a {
	color:black;
}

.post .post-title.full span {
	white-space:normal;
}

.post-vote{
	font-size:1.5em;
	color:grey;
	cursor:pointer;
}

.post-vote:hover{
	color:black;
}

.post .post-points,.post .post-vote{
	float:right;
}
.container.main a:hover {
	text-decoration:none;
}



.comment-user{
}

a.comment-author{
	position: absolute;
  top: 0;
  margin-top: -13px;
  margin-left:10px;
  background-color: white;
  padding: 3px;

}

.comment {
	margin-bottom:10px;
}

.comment-content{
	padding-left:20px;border: 1px solid rgb(218, 218, 218);
	border-radius: 5px;
	padding: 10px;
 	font-size:0.9em;
}

.comment-area{
	resize:none;
}

.comment-area.comment-reply{
	margin-top:15px;
}

.points{
	background-color: white;
  position: absolute;
  right: 0px;
  top: 0;
  margin-right:25px;
  padding: 3px;
  margin-top: -10px;
  font-size: 0.8em;
  color: rgb(92, 92, 92);
}

.points span .glyphicon-arrow-up{
	font-size: 1em;
  font-weight: bold;
}

.voted{
	color:rgb(29, 195, 50) !important;
}

.post-points{
		margin-top: -4px;
	  font-weight: 300;
	  margin-right: -2px;
	  color: grey;
	  font-size:1.8em;
}

.post-info{
	margin-bottom:10px;
}

.post-info > .row:first-child{
	  border-bottom: 1px solid rgb(218, 218, 218);
	  line-height: 0.8;
}

.post-views{
	line-height: 1.3;
}

.post-views .glyphicon-eye-open{
	padding:1px;
}

.post-game {
	text-align:right;
}

.post-game span{
	color: rgb(178, 178, 178);
  font-size: 1.3em;
}

.post-social{
	margin-top:5px;
}



.comment-reply-button{
	position: absolute;
  right: 0px;
  margin-top:-12px;
  padding: 3px;
  margin-bottom: -10px;
  background-color: white;
  font-size: 0.9em;
  margin-right:25px;
  cursor: pointer;
}

.comment-area.comment-reply{
	position:initial;
	margin-bottom:5px;
}

.comment-row{
	margin-top:10px;
}

.comments-holder{
	margin-top:10px;
}

.replies > div > .row:nth-child(2) > div{
	text-align:center;
}


.navbar-default a {
	color:black !important;
}

.navbar-brand{
	font-weight: bold;
	font-size:2em;
color:white !important;
}

.navbar-brand img {
	  margin-top: -12px;
  margin-left: 2px;
  float: left;
}
.navbar-brand div {
  float: left;
}

.navbar-brand span{
	background-color:black;
}
.navbar-brand span:first-child{
	color:#f31212;
	border-radius: 3px 0px 0px 3px;
}
.navbar-brand span:nth-child(2){
	color:#e8a70a;
}
.navbar-brand span:nth-child(3){
	color:#f3e012;
}
.navbar-brand span:nth-child(4){
	color:#0cdc11;
}
.navbar-brand span:nth-child(5){
	color:#8c6afb;
}
.navbar-brand span:nth-child(6){
	color:#7f07ab;
	border-radius: 0px 3px 3px 0px;
}

.navbar-brand span{
	padding:5px;
}

video{
	border-radius: 2px 2px 0px 0px;
}


#seekBar{
	width:100%;
	height:5px;
	position: relative;
	margin-top:-5px;
	transition:height 0.2s;
}

#seekBarInner{
	height:100%;
	background-color:rgb(242, 35, 35);
	width: 0;
  	position:absolute;
  	z-index:1;
  	border-radius: 0px 0px 2px 2px;
}

#seekBar{
	cursor: pointer;
}

.video-time{
	float:right;
}

.controls:hover #seekBar{
	height:10px;
}

.post .comment-count{
	font-size:0.4em;
	color: white;
	  position: absolute;
	  top: 0;
	  left: 0;
	  width: 100%;
	  padding-top: 3px;
}

.post-thumb .title{
	font-weight:bolder;
}

.post-thumb  > .thumb{
	background-color:rgb(166, 166, 166);
  font-size: 1.5em;
  text-align: center;
}

.user-username > div{
	font-size:2em;
	font-weight:bold;
}

 .btn.selected{
	  color: rgb(17, 190, 190);
  box-shadow: inset 0px 0px 2px rgb(182, 182, 182);
}

.upload-progress{
	border: 1px solid rgb(204, 204, 204);
  width: 100%;
  height: 10px;
  border-radius: 4px;
}

.upload-progress > div{
	width:0%;
	height:100%;
	  background-color: rgb(42, 197, 197);
}

.nav .upload-progress {
	margin-top:-15px;
}

.nav li a {
	font-weight:bolder;
}

.category-win,.category-win a,.btn.category-win.btn-default.active,.nav li.category-win>a{
	color: rgb(87, 190, 87);
}

.nav li.category-win.active a,.nav li.category-win:hover > a,.nav li.category-win > a:focus,.nav li.category-win.active > a:focus{ 
	color:rgb(95, 245, 95);
}

.category-fail,.category-fail a,.btn.category-fail.btn-default.active,.nav li.category-fail>a{

	color: rgb(226, 92, 92);
}

.nav li.category-fail.active a,.nav li.category-fail:hover > a,.nav li.category-fail > a:focus,.nav li.category-fail.active > a:focus{
	color:rgb(245, 19, 19);
}

video{
	cursor: pointer;
}

.btn.more-replies{
	padding:2px 8px;
}

.row.more {
	text-align: center;
}

.btn.feedback{
	position:fixed;
	right:10px;
	bottom:0px;
	margin-bottom:5px;
}
.feedback-form{
	position:fixed;
	right:10px;
	bottom:0px;
}

</style>

<script id="homepage-template" type="text/x-handlebars-template">
<div class="container-fluid homepage">
	<div class="row">
		<div class="col-md-12">
			 <h1 style="text-align:center;">A place for all your gaming moments</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			 <h4 style="color:darkgrey;text-align:center;">Dota2, GTA5, World of Warcraft, Age of Empires...</h4>
		</div>
	</div>
	<div class="row content">
		<div class="col-md-7 featured"></div>
		<div class="col-md-5 posts hidden-sm hidden-xs"></div>
	</div>
</div>
</script>

<script id="homepage-featured" type="text/x-handlebars-template">
{{#each featured}}
	<div class="row post">
		<div class="row">
			<div class="col-md-10 post-title">
				<span><a href="/gaf/{{url_key}}">{{title}}</a><span>
			</div>
			<div class="col-md-2">
				<span data-postid="{{id}}" class="glyphicon glyphicon-arrow-up post-vote {{voted}}"></span>
				<span class="post-points">{{points}}<span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<a href="/gaf/{{url_key}}">
					<video {{#if last}} data-last="true" {{/if}} width="100%" loop>
						<source src="{{webm}}" type="video/webm">
						<source src="{{mp4}}" type="video/mp4">
					</video>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 post-social">
				<a class="btn btn-social-icon btn-s btn-facebook" data-ignore="true" href="https://www.facebook.com/sharer/sharer.php?u={{postLocation}}" target="_blank"><i class="fa fa-facebook"></i></a>
				<a class="btn btn-social-icon btn-s btn-reddit" data-ignore="true" href="//www.reddit.com/submit" onclick="window.location = '//www.reddit.com/submit?url=' + encodeURIComponent('{{postLocation}}'); return false" target="_blank"><i class="fa fa-reddit"></i></a>
				<a href="/gaf/{{url_key}}"<span class="glyphicon glyphicon-comment"></span><span class="comment-count">{{#if comments_count.aggregate}} {{comments_count.aggregate}} {{else}} 0 {{/if}}</span></a>
			</div>
		</div>
	</div>
{{/each}}
<!--<div class="loader"></div>-->
</script>

<script id="homepage-posts" type="text/x-handlebars-template">
{{#each posts}}
<div class="col-md-12 col-xs-12 post-thumb post-{{status}}">
	<span class="title">{{title}}</span>
	<a href="/gaf/{{url_key}}">
		<img width="100%" src="https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg" class="thumb">
	</a>
</div>
{{/each}}
</script>