<?php 

session_start(); 

require 'php/functions.php';
require 'php/database.php';

reconnect_cookie();
logged_only();

if(isset($_FILES['photoprofil']) AND !empty($_FILES['photoprofil']['name'])){
    $taillemax = 4194304;
    $extensionValides = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['photoprofil']['size'] <= $taillemax){
        $extensionUpload = strtolower(substr(strrchr($_FILES['photoprofil']['name'], '.'), 1));
        if(in_array($extensionUpload, $extensionValides)){
            $user_id = $_SESSION['auth']->id;
            $chemin = "membres/photosmembres/".$user_id.".".$extensionUpload;
            $resultat = move_uploaded_file($_FILES['photoprofil']['tmp_name'], $chemin);
            if($resultat){
                $updatephotoprofil = $pdo->prepare('UPDATE user SET photoprofil=:photoprofil WHERE id=:id');
                $updatephotoprofil->execute(array(
                    'photoprofil' => $user_id.".".$extensionUpload,
                    'id' => $user_id
                ));
                $_SESSION['auth']->photoprofil = $user_id.".".$extensionUpload;

                header('Location: profil.php');
            }
            else{
                $_SESSION['flash']['danger'] = "Erreur pendant l'importation de l'image de profil ! Désolé";
            }
        }
        else{
            $_SESSION['flash']['danger'] = "Extension jpg, jpeg, gif, png seulement";
        }
    }
    else{
        $_SESSION['flash']['danger'] = "Extension non valide ou limite de 4mo dépassé";
    }


}

require 'php/header.php'; 

?> 


<center><h1> Salut <?= $_SESSION['auth']->username; ?> </h1> 

<?php 

if(!empty($_SESSION['auth']->photoprofil))
{
?>
<img class="roundedImage" src="membres/photosmembres/<?php echo $_SESSION['auth']->photoprofil; ?>" alt="" width="200px;"/>
<style type="text/css">
.roundedImage{
    
    -webkit-border-radius:50px;
    -moz-border-radius:50px;
    border-radius:50%;
    width:300px;
    height:300px;
    /* transform: rotate(180deg); */
    /* image-orientation: inherit; */
}
</style><br><br>
<?php
}
?>

<form action="" method="POST" enctype="multipart/form-data">

<h3>Editer votre photo</h3>

<div class="form-profil">
   <label></label>
   <input type="file" name="photoprofil">
</div><br>
<button type="submit" class="btn btn-dark">Confirmer</button>

</form><br>

<div> <a href="modificationmdp.php">  modifier votre mot de passe  </div>
<center>

<?php require 'php/footer.php'; ?> 