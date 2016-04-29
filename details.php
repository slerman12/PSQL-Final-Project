<?php
// File: list.php
// Purpose: lists
require_once ('./dbsetup.php');

?> <html>
<head>
    <title>Game Library</title>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- BOOTSTRAP Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- BOOTSTRAP Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="gamelibrary-masthead">
    <div class="container">
        <nav class="gamelibrary-nav">
            <a class="gamelibrary-nav-item active" href="./index.php">Game <i style="font-size: 18px;" class="fa fa-gamepad" aria-hidden="true"></i> Library  </a>
            <div class="pull-right">
                <a class="gamelibrary-nav-item" href="./list.php?Sam">Sam's List</a>
                <a class="gamelibrary-nav-item" href="./list.php?Cinthia">Cinthia's List</a>
                <a class="gamelibrary-nav-item" href="./list.php?Rodrigo">Rodrigo's List</a>
                <a class="gamelibrary-nav-item" href="./list.php?Lee">Lee's List</a>
            </div>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 list-main">
            <?php

            function insert_platforms($db)
            {
                $sql = "INSERT INTO platforms( name,
                                                version,
                                                type,
                                                speed,
                                                popularity) VALUES (
                                                :name,
                                                :version,
                                                :type,
                                                :speed,
                                                :popularity)";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
                $stmt->bindParam(':version', $_POST['version'], PDO::PARAM_STR);
                $stmt->bindParam(':type', $_POST['type'], PDO::PARAM_STR);
// use PARAM_STR although a number
                $stmt->bindParam(':speed', $_POST['speed'], PDO::PARAM_STR);
                $stmt->bindParam(':popularity', $_POST['popularity'], PDO::PARAM_STR);

                $stmt->execute();
            }

            function update_platforms($db)
            {
                echo "The insert function is called.";
            }

            // Select table query and display list
            try {
                $who = $_GET['who'];

                if($_POST){
                    $attribute1 = $_POST['name'];
                    $attribute2 = $_POST['version'];

                    if(isset($_POST['insert_platforms'])){
                        insert_platforms($db);
                    }elseif(isset($_GET['update_platform'])){
                        update_platforms($db);
                    }
                }
                else{
                    $attribute1 = $_GET['name'];
                    $attribute2 = $_GET['version'];
                }
                if ($who == 'Sam'){
                    $detailsName = 'Platform Details';

                    $tuple = $db->prepare('SELECT name, version, type, speed, popularity FROM platforms WHERE name=:name AND version=:version');
                    $tuple->bindValue(':name', $attribute1, PDO::PARAM_STR);
                    $tuple->bindValue(':version', $attribute2, PDO::PARAM_STR);
                    $tuple->execute();
                }
                elseif ($who == 'Cinthia'){
                    $tuple = $db->prepare('');
                    $tuple->execute();
                }
                elseif ($who == 'Rodrigo'){
                    $tuple = $db->prepare('');
                    $tuple->execute();
                }
                elseif ($who == 'Lee'){
                    $tuple = $db->prepare('');
                    $tuple->execute();
                }
                else{

                }

            }
            catch (PDOException $e) {
                print "DB Query Error : " . $e->getMessage();
                die();
            }

            echo '<h2>', $detailsName, '</h2><hr>';

            // Show tuple
            try {
                echo    '<div class="table-responsive list-table">',
                '<table class="table table-striped table-hover">',
                '<thead>',
                '<tr>',
                '<th>Key</th>',
                '<th>Value</th>',
                '</tr>',
                '</thead>',
                '<tbody>';
                $row = $tuple->fetch(PDO::FETCH_OBJ);
                foreach($row as $key => $value) {
                    echo        '<tr>',
                    '<td>', $key, '</td>',
                    '<td>', $value, '</td>',
                    '</tr>';
                }

                echo            '</tbody>',
                '</table>',
                '</div>';
            }
            catch (PDOException $e) {
                print "DB Query Error : " . $e->getMessage();
                die();
            }

            ;?>
        </div>

    </div><!-- /.row -->

</div><!-- /.container -->

</div>
</body>
</html>