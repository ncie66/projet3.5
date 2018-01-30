<?php 

require_once 'php/functions.php';
reconnect_cookie();

if(isset($_SESSION['auth'])){
    
    header('Location: profil.php');
    exit();
}

    if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){

        require_once 'php/database.php';

        $req = $pdo->prepare('SELECT * FROM user WHERE (username=:username OR email=:username) AND confirmed_date is NOT NULL');
        $req->execute(['username' => $_POST['username']]);

        $user = $req->fetch();
        
        if( !$user ){
            $_SESSION['flash']['danger'] = "Identifiant incorrect";
        }
        else if(password_verify($_POST['password'], $user->password)){

            $_SESSION['auth'] = $user;

            $_SESSION['flash']['success'] = "Vous êtes bien connecté";

            if(!empty($_POST['remember'])){

                $remember_token = str_random(255);

                $pdo->prepare('UPDATE user SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);

                $reset_token_date = setcookie('remember', $user->id . '//' . $remember_token . sha1($user->id . 'projetncie'), time() + 60  * 60 * 24 * 7);                

                $pdo->prepare('UPDATE user SET reset_token_date = NOW() WHERE id = ?')->execute([$user->id]);
            }

            header('Location: profil.php');

            exit();

        } else {

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
    <div class="form-group">
        <label>Se souvenir de moi</label>
            <input type="checkbox" name="remember" value="1" /> <br><br>
    </div>
    <button type="submit" class="btn btn-dark">Se connecter</button>

</form>

<?php require 'php/footer.php'; ?> 

</body>
</html>