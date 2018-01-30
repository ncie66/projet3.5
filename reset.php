<?php 

session_start();
    if(isset($_GET['id']) && isset($_GET['token'])){
        require 'php/database.php';
        require 'php/functions.php';

        $req = $pdo->prepare('SELECT * FROM user WHERE id = ? AND reset_password_token IS NOT NULL AND reset_password_token = ?  AND reset_token_date > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
        $req->execute([$_GET['id'], $_GET['token']]);
        $user = $req->fetch();

        if($user){
            if(!empty($_POST)){
                if(!empty($_POST['password']) && $_POST['password'] == $_POST['confirmed_password']){
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    $pdo->prepare('UPDATE user SET password = ?, reset_token_date = NULL, reset_password_token = NULL')->execute([$password]);

                    $_SESSION['flash']['success'] = "Mot de passe modifié avec success";

                    $_SESSION['auth'] = $user;

                    header('Location: profil.php');

                    exit();
                }
            }
        }
    }
    else{
        $_SESSION['flash']['error'] = "Cette clé n'est plus valide";
        header('Location: login.php');
        exit();
    }
   require 'php/header.php';
?>

<h1> Reinitialisation de votre mot de passe </h1> 

<form action="" method="POST">

    <div class="form-group">
        <label>Mot de passe  </label>
            <input type="password" name="password" size="30"/> <br><br>
    </div>
    <div class="form-group">
        <label>Confirmation de mot de passe </a></label>
            <input type="password" name="confirmed_password" size="30"/> <br><br>
    </div>
    <button type="submit" class="btn btn-dark">Confirmer votre mot de passe</button>

</form>

<?php require 'php/footer.php'; ?> 

</body>
</html>