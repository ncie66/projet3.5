<?php 

require_once 'php/functions.php';

if(!empty($_POST)){

    $errors = array();

    require_once'php/database.php';


    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){

        $errors['username'] = "Champs non rempli ou caractère non pris en charge";

    }   else{
            $req = $pdo->prepare('SELECT id FROM user WHERE username = ?');
            $req->execute([$_POST['username']]);
            $user = $req->fetch();
            if($user){
                $errors['username'] = 'Ce pseudo est déjà pris';
        }
    }


    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email non valide";
    }else{
        $req = $pdo->prepare('SELECT id FROM user WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user){
            $errors['email'] = 'Cet email est déjà utilisé';
        }
    }

    if(!empty($errors)):?>
    <div class="alert"> 
        <p> Vous n'avez pas rempli le formulaire correctement </p> 

        <ul> 

            <?php foreach($errors as $error):?>

            <li>
                <?= $error; ?> 
            </li> 

            <?php 
                endforeach; 
            ?> 
            
        </ul> 
    </div>
<?php endif; 

    if(empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']){
        $errors['password'] = "Mot de passe non valide ou different";
    }

    if(empty($_POST['date'])){
        $errors['date'] = "date non valide";
    }

    if(empty($errors)){

        $req = $pdo->prepare("INSERT INTO user SET username=:username, email=:email, password=:password, date=:date, confirmed_token=:token");

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(50);
 
        $req->execute(array(
            'username'=>$_POST['username'],
            'password'=>$password, 
            'email'=>$_POST['email'], 
            'date'=>$_POST['date'],
            'token'=>$token
        ));

        $user_id = $pdo->lastInsertId();

        sendMail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://www.myhobbie.fr/confirm.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = "Un email de confirmation vous a été envoyé pour valider votre compte";
        header('Location: login.php');
        exit();
        alert('Votre inscription a réussi ! Amusez-vous bien sur Myhobbie.fr');
    }
}


require 'php/header.php';

?> 
<link href="css/styleform.css" rel='stylesheet'/>
<div class="container">
        <div class="row centered-form"></div> 
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4"></div> 
        	<div class="panel panel-default"></div> 
        		<div class="panel-heading"></div>
                <div class="panel-body"></div> 

                <h1> S'inscrire </h1> 
                <div class="formcontact">
    <form action="" method="POST">

        <div class="form-group">
            <p id="civilite"><label>Civilité : </label>
                <input type="radio" name="civilite" value="H" checked/>Homme
                <input type="radio" name="civilite" value="F" />Femme
            </p>
        </div>

        <div class="form-group">
            <label>Pseudo : </label><input type="text" name="username" size="30" /> <br><br>
        </div>

        <div class="form-group">
         <label>E-mail : </label><input type="email" name="email" size="30" /> <br><br>
        </div>

        <div class="form-group">
         <label>Mot de passe : </label><input type="password" name="password" size="30" /> <br><br>
        </div>

        <div class="form-group">
         <label>Confirmez votre mot de passe : </label><input type="password" name="confirm_password" size="30" /> <br><br>
        </div>

        <div class="form-group">
         <label>Date de naissance : </label><input type="date" name="date" size="30" /> <br><br>
        </div>

        <button type="submit" class="btn btn-dark">M'inscrire</button>

    </form>
</div> 

</body>

<?php 
require 'php/footer.php';
?> 
