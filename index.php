<?php
error_reporting(E_ALL);
define('__ROOT__', dirname(dirname(__FILE__))."/victr");

require_once(__ROOT__."/library.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>VICTR Git API Project</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="all.css">

    <script type="text/javascript" src="uglipop.js/uglipop.min.js"></script>
    <script type="text/javascript" src="all.js"></script>
  </head>
  <body>
    <section class="container">
        <header class="bg-primary">
            <h1 align="center">Most Starred PHP Projects</h1>
        </header>
        <table id="repositoryTable" class="table table-hover">
          <caption>Click on the table row for more details about that repository.</caption>
          <thead>
            <tr>
              <th>RepositoryID</th>
              <th>Name</th>
              <th>URL</th>
              <th>Created</th>
              <th>Stars</th>
            </tr>
          </thead>

          <tbody>
        <?php
          foreach($git->getRowsByStar(50) as $row){
            echo "<tr>";
            echo "<td class='repoID'>" . $row->RepositoryID . "</td>";
            echo "<td>" . $row->Name . "</td>";
            echo "<td><a href='$row->URL' target='_blank'>" . $row->URL . "</a></td>";
            echo "<td>" . date("m/d/Y g:ia", strtotime($row->CreatedDate)) . "</td>";
            echo "<td class='stars'>" . $row->Stars . "</td>";
            echo "<td class='details'>";
            echo "<h2>Repository Information</h2>";
            echo "<ul class='col-sm-12'>
                  <li><div class='header col-sm-4'>RepositoryID:</div><div class='col-sm-7'>". $row->RepositoryID ."</div><div class='clearfix' /></li>
                  <li><div class='header col-sm-4'>Name:</div><div class='col-sm-7'>". $row->Name ."</div><div class='clearfix' /></li>
                  <li><div class='header col-sm-4'>URL:</div><div class='col-sm-7'><a href='$row->URL' target='_blank'>" . $row->URL . "</a></div><div class='clearfix' /></li>
                  <li><div class='header col-sm-4'>Created On:</div><div class='col-sm-7'>". $row->CreatedDate ."</div><div class='clearfix' /></li>
                  <li><div class='header col-sm-4'>Last Pushed On:</div><div class='col-sm-7'>". $row->LastPushDate ."</div><div class='clearfix' /></li>
                  <li><div class='header col-sm-4'>Description:</div><div class='col-sm-7'>". $row->Description ."</div><div class='clearfix' /></li>
                  <li><div class='header col-sm-4'>Stars / Rating:</div><div class='col-sm-7'>". $row->Stars ."</div><div class='clearfix' /></li>
                  </ul>
                  </td>";
            echo "</tr>";
          }
        ?>
          </tbody
        </table>
    </div>
  </body>
</html>
