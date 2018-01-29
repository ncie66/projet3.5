<?php 
session_start();
    if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){

        require_once 'php/database.php';
        require_once 'php/functions.php';

        $req = $pdo->prepare('SELECT * FROM user WHERE (username=:username OR email=:username) AND confirmed_date is NOT NULL');
        $req->execute(['username' => $_POST['username']]);

        $user = $req->fetch();
        
        if( !$user ){
            $_SESSION['flash']['danger'] = "Identifiant incorrect";
        }
        else if(password_verify($_POST['password'], $user->password)){

            $_SESSION['auth'] = $user;

            $_SESSION['flash']['success'] = "Vous êtes bien connecté";

            header('Location: profil.php');

            exit();
        }else {
            $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrect";
        }
        
    }
    require 'php/header.php';
?>


<h1> Se connecter </h1> 
    
<form class="" id="" action="" method="POST">

    <div class="form-group">
        <label>Pseudo ou email  </label>
            <input type="text" name="username" size="30"/> <br><br>
    </div>
    <div class="form-group">
        <label>Mot de passe <a href="forgetpassword.php">(Mot de passe oublié)</a></label>
            <input type="password" name="password" size="30"/> <br><br>
    </div>
    <button type="submit" class="btn btn-dark">Se connecter</button>

</form>

<?php require 'php/footer.php'; ?> 

</body>
</html>