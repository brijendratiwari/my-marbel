<?php 

include_once 'includes/functions.php';

sec_session_start();
$section = $_GET['section'];
$page = $_GET['page'];

$params = array();
foreach ($_GET as $k => $v) {
  if (strcmp($k, 'page') == 0 || strcmp($k, 'section') == 0) { continue; }
  $params[$k] = $v; 
}
if (!empty($section)) {
  if (!login_check($db) || strcmp($section, $_SESSION['marbel_user']['type']) !== 0) {
    $section = '';
    $redirect = $page;
    $page = 'login';
  }
}
if (empty($page)) {
  if (!isset($_SESSION['marbel_user'])) {
    $redirect = $page;
    $page = 'login';
  } else {
    if (empty($section)) {
      $section = $_SESSION['marbel_user']['type'];
    }
    $page = 'dashboard';
  }
}

if (!empty($redirect) && !empty($params)) {
  foreach ($params as $k => $v) {
    if (!empty($redirect)) { $redirect .= (strcmp($redirect, '?') == 0  ? '&' : '?'); }
    $redirect .= $k.'='.$v;                                                                               
  }
}

if (empty($section) && isset($_SESSION['marbel_user'])) {
  $section = $_SESSION['marbel_user']['type'];
}

$basePath = 'includes/pages/';
if (!empty($section)) { $basePath .= $section.'/'; }
if (file_exists($basePath.'parts/head.php')) { include_once $basePath.'parts/head.php'; }
if (file_exists($basePath.'parts/header.php')) { include_once $basePath.'parts/header.php'; }
if (file_exists($basePath.'parts/nav.php')) { include_once $basePath.'parts/nav.php'; }
if (file_exists($basePath.$page.'.php')) { include_once $basePath.$page.'.php'; }
if (file_exists($basePath.'parts/js/base.php')) { include_once $basePath.'parts/js/base.php'; }
if (file_exists($basePath.'parts/js/'.$page.'.php')) { include_once $basePath.'parts/js/'.$page.'.php'; }
if (file_exists($basePath.'parts/footer.php')) { include_once $basePath.'parts/footer.php'; }
?>

