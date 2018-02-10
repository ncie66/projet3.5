<?php 

$pdo = new PDO('mysql:dbname=db723669912;host=db723669912.db.1and1.com', 'dbo723669912', 'Loun@66300');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);