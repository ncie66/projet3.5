<?php 
if(session_status() == PHP_SESSION_NONE){

  session_start();

}

?> 

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>My hobbie</title>

    <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php">My hobbie</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
          <?php if (isset($_SESSION['auth'])): ?> 
              <li> <a href="logout.php">Se deconnecter</a></li>
            
          </li>
          <li class="nav-item">
          
              <?php else: ?> 
                <li> <a href="register.php">S'inscrire</a></li>
                <li> <a href="login.php">Se connecter</a></li>
              <?php endif; ?>

          </li>
        </ul>
        
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Recherche..." aria-label="Search"/>
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
        </form>
      <div>
    </nav>

    <main role="main" class="container">

        <?php if(isset($_SESSION['flash'])): ?> 

            <?php foreach($_SESSION['flash'] as $type =>$message): ?> 

                <div class="alert alert-<?= $type; ?>">

                      <?= $message; ?> 
                      
                </div>

            <?php 
                endforeach; 
             ?>

            <?php unset($_SESSION['flash']); ?>

          <?php endif ?>