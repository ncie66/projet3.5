<?php require 'php/header.php'; 

// if(!array_key_exist('username', $_POST) || $_POST['username'] == ''){
//     $errors['username'] = "Vous n'avez pas renseigné votre pseudo";
// }

// if(!array_key_exist('email', $_POST) || $_POST['email'] == ''){
//     $errors['email'] = "Vous n'avez pas renseigné votre adresse mail";
// }

// if(!array_key_exist('sujet', $_POST) || $_POST['sujet'] == ''){
//     $errors['sujet'] = "Message vide";
// }

// if(!empty($errors)){
//     header('Location: index.php');
// }   
// else{
//     $sujet = $_POST['sujet'];
//     $headers = 'FROM: test@gmail.com';
    
//     sendMail($_POST['email'], 'Confirmation de votre compte');
//     sendMail('support@myhobbie.fr', 'Formulaire de contact', $sujet, $headers);
// }

?>

<br><br>
<link href="css/stylecontact.css" rel='stylesheet'/>

<div class="formcontact">

  <form action="" method="POST">

    <div class="form-group">
      <label for="username">Pseudo :</label>
      <input type="text" id="username" name="username" placeholder="Votre pseudo">

      <label for="email">Email :</label>
      <input type="text" id="email" name="email" placeholder="Votre adresse email">

      <label for="sujet">Sujet :</label>
      <textarea id="sujet" name="sujet" placeholder="Ecrivez votre problème" style="height:200px"></textarea>

      <input type="submit" value="Envoyer">
    </div>

  </form>

</div><br><br>

<?php require 'php/footer.php'; ?>
