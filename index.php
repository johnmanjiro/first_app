<?php

require_once(__DIR__ . '/controller/config.php');
require_once(__DIR__ . '/controller/Twitterlogin.php');

$twitterLogin = new MyApp\TwitterLogin();

use Abraham\TwitterOAuth\TwitterOAuth;

if ($twitterLogin->isLoggedIn()) {
  $me = $_SESSION['me'];
  MyApp\Token::create();
}

$screen_name = $me->tw_screen_name;

$connection = new TwitterOAuth(
      CONSUMER_KEY,
      CONSUMER_SECRET,
      $me -> tw_access_token,
      $me -> tw_access_token_secret
      );
  // ユーザ名でユーザ情報を取得
  $user_info = $connection->get('users/show', ['screen_name'=> $screen_name]);    
 
    $user_name = $user_info->name;
    $user_id = $user_info->screen_name;
    $user_img = $user_info->profile_image_url_https;
    $user_follows = $user_info->friends_count;
    $user_followers = $user_info->followers_count;

?>
<!DOCTYPE html>
<html lang="en"> 
    <head>
        <title>両思いったー</title>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content=""> 
        <link rel="shortcut icon" href="favicon.ico"> 
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> 
        <!-- Global CSS -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
        <!-- Plugins CSS -->         
        <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="assets/plugins/prism/prism.css">
        <!-- Theme CSS -->         
        <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
        <!--social css-->
        <link href="assets/css/social-buttons.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>     
    <body data-spy="scroll">
        <!---//Facebook button code-->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
        <!-- ******HEADER****** -->         
        <header id="header" class="header"> 
            <div class="container"> 
                <h1 class="logo pull-left"><a href="index.php"><span class="logo-title">両思いったー</span></a></h1>
                <!--//logo-->                 
                <nav id="main-nav" class="main-nav navbar-right" role="navigation">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!--//nav-toggle-->
                    </div>
                    <!--//navbar-header-->                     
                    <li class="navbar-collapse collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php if ($twitterLogin->isLoggedIn()) : ?>
                                <div class="nav nav-pills" style="float:right;">
		                        <li>
			                      <img src="<?= h($user_img); ?>" alt="" style="width:50px;height:50px;" />
		                        </li>
		                        <li class="dropdown">
		                      	 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= h($me->tw_screen_name); ?><b class="caret"></b></a>
			                     <ul class="dropdown-menu">
			                      <li><a href="mypage.php">マイページ</a></li>
				                  <li class="divider">&nbsp;</li>
				                  <li>
				                      <a href="" onclick="document.logout.submit();return false;">ログアウト</a>
				                      <form action="controller/logout.php" method="post" id="logout" name="logout">
                                       <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                                       </form>
                                  </li>
			                    </ul>
		                        </li>
	                            </li>
                            <?php else : ?>
                            <li class="nav-item">
                                <a href="controller/login.php">ログイン</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <!--//nav-->
                    </div>
                    <!--//navabr-collapse-->
                </nav>
                <!--//main-nav-->
            </div>
        </header>
        <!--//header-->
        <!-- ******PROMO****** -->
        <section id="promo" class="promo section offset-header">
            <div class="container text-center">
                <h2 class="title"><span class="highlight"><font color="#fff">両思いったー</font></span></h2>
                <p class="intro" style="color:#FB8DA0;">両思い、始めませんか？</p>
                 <h2>ログイン</h2>
                 <a href="controller/login.php"><button class="btn btn-xlarge btn-twitter"><i class="fa fa-twitter"></i> | Connect with Twitter</button></a>
                 <p>（＊ログインと同時に当アカウントをフォローします）</p>
            </div>
            <!--//container-->
            <!--<div class="social-media">-->
                <div class="social-media-inner container text-center">
                    <ul class="list-inline">
                        <li class="twitter-follow">
                            <a href="https://twitter.com/weatherbot777" class="twitter-follow-button" data-show-count="false">Follow @weatherbot777</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </li>
                        <!--//twitter-follow-->
                        <li class="twitter-tweet">
                            <a href="https://twitter.com/weatherbot777" class="twitter-share-button" data-via="3rdwave_themes" data-hashtags="bootstrap">Tweet</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </li>
                        <!--//twitter-tweet-->
                        <li class="facebook-like">
                            <div class="fb-like" data-href="https://twitter.com/weatherbot777" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                        </li>
                        <!--//facebook-like-->
                        <li>
                            <a href="http://b.hatena.ne.jp/entry/https://twitter.com/weatherbot777" class="hatena-bookmark-button" data-hatena-bookmark-title="両思いったー" data-hatena-bookmark-layout="standard-balloon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
                        </li>
                    </ul>
                </div>
            <!--</div>-->
        </section>
        <!--//promo-->
        <!-- ******ABOUT****** -->         
        <section id="about" class="about section">
            <div class="container">
                <h2 class="title text-center">両思いったーって何？</h2>
                <p class="intro text-center">両思いったーとは、フラれることなく両思いを確認できるサービスです。気になる人のtwitter IDを登録して、相手も自分のことを気に入っていれば、お二人にダイレクトメッセージでおしらせします。</p>
                <div class="row">
                     <div class="col-xs-2 col-md-2"></div>
                     <div class="col-xs-8 col-md-8">
                            <ul style="list-style-type:none;">
                                使用上の注意
                              <li>*あなたが登録したことは相手に知られません。両思いの時のみ二人に通知が届きます。</li>
                              <li>*当アカウントのフォローを外しますと、ダイレクトメッセージが届きません。</li>
                              <li>*気になる人を登録してから２４時間以内は気になる人を変更することはできません。</li>
                            </ul>
                     </div>
                     <div class="col-xs-2 col-md-2"></div>
               </div>
            </div>
            <!--//container-->
        </section>
        <!--//about-->
        <!-- ******FOOTER****** -->         
        <footer class="footer">
            <div class="container text-center">
                <small class="copyright">Copyright © 2016 両思いったー All Rights Reserved.</small>
            </div>
            <!--//container-->
        </footer>
        <!--//footer-->
        <!-- Javascript -->         
        <script type="text/javascript" src="assets/plugins/jquery-1.11.3.min.js"></script>         
        <script type="text/javascript" src="assets/plugins/jquery.easing.1.3.js"></script>         
        <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="assets/plugins/jquery-scrollTo/jquery.scrollTo.min.js"></script>         
        <script type="text/javascript" src="assets/plugins/prism/prism.js"></script>         
        <script type="text/javascript" src="assets/js/main.js"></script>         
    </body>
</html>
