<?php
  session_start();
  
  // get the database connection
  require_once("mysql.php");

  require_once("whoami.php");

  // do we have an id? and is it numeric?
  if(isset($_GET['id']) && !is_numeric($_GET['id'])) {
    header("Location: ./index.php"); // no> then go home
    exit();
  }

  $sql = "SELECT p.* FROM agents p WHERE danger=false";

  // are we looking at anything in particular?
  if(isset($_GET['id'])) {
    // request only the agent
    $sql .= " AND p.id=".mysql_real_escape_string($_GET['id']);
  // are we searching?
  } else if(isset($_GET['filter']) and !empty($_GET['filter'])) {
    // report only those that are similar
    $sql .= " AND p.name LIKE '%%" . $_GET['filter'] . "%%'";
  }

  // get whatever we were looking for
  $result = mysql_query($sql, $db);
  if(!$result)
    die("Query failed: " . mysql_error());

  $agents = array(); // make them into an array
  while($row = mysql_fetch_assoc($result)) {
    $agents[] = $row;
  }

  // clean up
  mysql_close($db);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?php if(!isset($_GET['id'])) { ?>
      <title>Suspected Agents</title>
    <?php } else { ?>
      <title><?php echo($agents[0]['name']); ?></title>
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
      th { text-align: left; }
      <?php if(!$_GET['id']): ?>
      img { max-width: 50px; max-height: 50px; }
      <?php endif; ?>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <style>
      .container, .navbar-fixed-top .container {
        width: 800px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <style>
      body {
        background-color: #222222;
      }
    </style>
    <style>
      thead {
        color: #cccccc;
      }

      table.dataTable tbody tr {
        background-color: #d33219;
      }

      td {
        color: #ffffff;
      }

      td a {
        color: #ffffff;
      }

      .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
        color: #cccccc;
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
  </head>

  <body>
    <?php require_once("./headnav.php"); ?>
    <div class="container">
      <h1 style="color: #44386e">
        <?php if(isset($_GET['id'])) { ?>
          <?php echo(htmlentities($agents[0]['name'])); ?>
        <?php } else { ?>
          Suspected Agents
        <?php } ?>
      </h1>
      <?php if(!isset($_GET['id'])) { ?>
        <p style="margin-bottom: 20px; color: #44386e">They Walk Among You</p>
        <form action="#" method="get" class="form-inline">
          <div class="input-append">
            <span class="add-on">Filter Results:</span>
            <input type="text" id="filter" name="filter" 
              <?php if(isset($_GET['filter'])) echo "value=\"" . htmlentities($_GET['filter']) . "\""; ?>
             />
            <button type="submit" class="btn btn-default" style="background-color: #d33219; color: #ffffff;">Submit</button>
          </div>
        </form>
        <table class="datatable">
          <thead>
            <th></th>
            <th>Name</th>
            <th>Profession</th>
            <th>Age</th>
          </thead>
          <?php if(count($agents) > 0): ?>
            <tbody>
              <?php foreach($agents as $agent): ?>
                <tr>
                  <td><a href="./database.php?id=<?php echo(htmlentities($agent["id"])); ?>"></a></td>
                  <td><a href="./database.php?id=<?php echo(htmlentities($agent['id'])); ?>"><?php echo(htmlentities($agent['name'])); ?></a></td>
                  <td><?php echo(htmlentities($agent['profession'])); ?></td>
                  <td><?php echo($agent['age']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          <?php endif; ?>
        </table>
      <?php } else { ?>
        <br />
        <p class="pull-right"><a href="./database.php"><small>Back to database</small></a></p>
        <br />
        <hr style="clear: both" />
        <h2>Suspected Handle:</h2>
        <p><?php echo(htmlentities($agents[0]['username'])); ?></p>
        <h2>Secret Code Response:</h2>
        <p><?php echo(htmlentities($agents[0]['password'])); ?></p>
        <h2>Last Known Address:</h2>
        <p><?php echo(htmlentities($agents[0]['address'])); ?></p>

      <?php } ?>



    </div> <!-- /container -->

    <script type="text/javascript" charset="utf8" src="/js/jquery-2.1.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(".datatable").dataTable({
          "dom": "tip"
        });
        $("input[name='quantity']").change(function() {
          if($(this).val() < 0) {
            $(this).val(0);
            alert("Quantity must be a positive number.");
          }
        });
      });
    </script>
  </body>
</html>
