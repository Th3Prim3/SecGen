<?php
  session_start();
  
  require_once("whoami.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Pwnable Pwnies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <style>
      .container, .navbar-fixed-top .container {
        width: 800px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="/ico/favicon.png">
    <script type="text/javascript" src="js/news.js"></script>
    <link type="text/css" rel="stylesheet" href="css/news.css"/>
    <style>
  /* -------- Custom Site Theme -------- */

  .row img {
    height: 25rem;
  }

  .navbar-inner {
    background-color: #333333;
    background-image: none;
  }

  body {
    background-color: #888888;
    background-image: linear-gradient(#444444, #444444, #444444, #444444, #0bc5a6, #0bc5a6);
    background-repeat: none;
    font-family: Arial, Helvetica, sans-serif;
    height: 100%;
  }

  #news h1, h2, h3, h4, #news p, h5 {
    color: #222222;
  }

  h1, p {
    color: #0bc5a6;
  }
    </style>
  </head>

  <body onload="initialise();">
    <?php include("headnav.php"); ?>
    <div class="container">
        <h1>Pwnable Pwnies</h1>
        <p>Changing the World, One Image at a Time</p>
        <div class="row">
          <img src="/img/pwnyfront.png" class="span5"/>
          <img src="/img/classic.png" class="span5"/>
        </div>
    </div> <!-- /container -->
    <div id="news">
    <h2>News</h2>
      <div id="preview_list">
        <ul>
        </ul>
      </div>
      <div id="story_pane">
        <ul>
        </ul>
      </div>
    </div>
  </body>
</html>
