<?php

require_once(__DIR__ . '/controller/config.php');
require_once(__DIR__ . '/controller/Twitterlogin.php');

$twitterLogin = new MyApp\TwitterLogin();

use Abraham\TwitterOAuth\TwitterOAuth;

if ($twitterLogin->isLoggedIn()) {
  $me = $_SESSION['me'];
  MyApp\Token::create();
}else{
   header('Location: http://' . $_SERVER['HTTP_HOST'].'/devAid-v1.2/index.php');
   exit;
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
    // $my_id_str = $userinfo->id;
    
     if($_SERVER['REQUEST_METHOD'] === 'POST'){
         
           try {
            MyApp\Token::validate('token');
          } catch (Exception $e) {
            echo $e->getMessage();
            exit;
          }
          
          $register = new Myapp\Register();
          $register ->register($user_id,$connection);
          }

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
                <h1 class="logo pull-left"><a href="mypage.php"><span class="logo-title">両思いったー</span></a></h1>
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
                    <div class="navbar-collapse collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a href="mypage.php">マイページ</a>
                            </li>
                            <li class="nav-item">
                                <a href="register_page.php">気になる人を登録</a>
                            </li>
                            <li class="nav-item">
                                <a href="edit.php">気になる人一覧</a>
                            </li>
                            <li class="nav nav-pills" style="float:right;">
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
        <div class="container offset-header">
          <div class="row">  
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            <div class="register panel panel-warning">
            <div class="panel-heading">登録</div>
              <div class="panel-body text-cente">
               <div class="container-fluid">
                <div class="row">
                 <div class="col-sm-2"></div>
                 <div class="col-sm-4"><a href="https://twitter.com/<?php echo h($user_id) ?>/following" target=”_blank”>フォローから探す</a></div>
                 <div class="col-sm-4"><a href="https://twitter.com/<?php echo h($user_id) ?>/followers" target=”_blank”>フォロワーから探す</a></div>
                 <div class="col-sm-2"></div>
                </div>
              </div>
              <br>
              <div class="container col-sm-8 col-sm-offset-2">
                <form action="" method="POST" class="form-horizontal">
                  <div class="form-group">
                    <label class="">twitterIDを入力して下さい</label>
                    <input type="text" name="lover_id" class="form-control">
                  </div>
                  <label class="label-tweet"><input type="checkbox" name='tweet_registered'>気になる人を登録したことをつぶやく（誰を登録したかはつぶやきません）</label>
                  <br>
                  <div class="text-center">
                  <?php if(!empty($error['id'])){
                  echo "<div class='alert alert-danger' style='margin-top : 10px'><button class='close' data-dismiss='alert'>&times;</button>".$error['id']."</div>";
                  } ?>
                  <input type="submit"  class="btn btn-cta-register"value="気になる人を登録する"/>
                  <input type="hidden" class="btn btn-cta-register" name="token" value="<?php echo h($_SESSION['token']); ?>"/>
                  </div>
               </form>
             </div> 
             </div> 
           </div>
          </div>
          <div class="col-sm-2"></div>
         </div>
        </div> 
       
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


	    
