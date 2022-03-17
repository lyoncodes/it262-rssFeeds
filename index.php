<?php
namespace NewsAggregator;

include_once 'src/sessionStatus.php';
include_once 'src/validateUserSession.php';

use function NewsAggregator\helpers\check_session_status;
use function NewsAggregator\helpers\validateUserSession;

include 'config.php';

// check_session_status();
if(namespace\helpers\check_session_status() !== PHP_SESSION_ACTIVE) session_start();

// INCLUDES FOR DEPLOYMENT ==============

// require '../inc_0700/config_inc.php';
// get_header();

//check user login
(namespace\helpers\validateUserSession()) ? header('Location:./views/categories_view.php') : header('Location:login.php');


