<?php

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function goHome() {
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/devAid-v1.2/index.php');
  exit;
}

function logining() {
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/devAid-v1.2/mypage.php');
  exit;
}

  //complete.phpにリダイレクトする
  function complete() {
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/devAid-v1.2/complete.php');
  exit;
}
