<?php require 'php/header.php'; ?>

<br><br>
<link href="css/stylecontact.css" rel='stylesheet'/>

<div class="formcontact">

  <?php if(array_key_exists('errors', $_SESSION)): ?>

  <div class="alert alert-danger">
    <?= implode('<br>', $_SESSION['errors']); ?>
  </div>
  <?php endif; ?> 

  <?php if(array_key_exists('success', $_SESSION)): ?>

    <div class="alert alert-success">
     Message envoyé avec succés
    </div>
  <?php endif; ?> 

  <form action="addcategorie_contact.php" method="POST">

    <div class="form-group">
      <label for="username">Pseudo :</label>
      <input type="text" id="username" name="username" placeholder="Votre pseudo" value="<?= isset($_SESSION['inputs']['username']) ? $_SESSION['inputs']['username'] : ''; ?> <?= $_SESSION['auth']->username; ?>"> </input>

      <label for="email">Email :</label>
      <input type="text" id="email" name="email" placeholder="Votre adresse email" value="<?= isset($_SESSION['inputs']['email']) ? $_SESSION['inputs']['email'] : ''; ?><?= $_SESSION['auth']->email; ?>">

      <label for="categorie">Categorie :</label>
        <SELECT name="categorie" size="1">
            <OPTION>AUTOMOBLIE
            <OPTION>ASTRONOMIE
            <OPTION>CULTURE
            <OPTION>ELECTRONIQUE
            <OPTION>GASTRONOMIE
            <OPTION>MODE
            <OPTION>SCIENCE
            <OPTION>SPORTS
            <OPTION>VOYAGES
            <OPTION>+18ANS
            <OPTION>JE DEMANDE MA CATEGORIE
        </SELECT>          

      <label for="sujet">Sujet :</label>
      <textarea id="sujet" name="sujet" placeholder="Ecrivez votre problème" style="height:200px"><?= isset($_SESSION['inputs']['sujet']) ? $_SESSION['inputs']['sujet'] : ''; ?></textarea>

      <input type="submit" value="Envoyer">
    </div>

  </form>

</div><br><br>

<?php 
unset($_SESSION['inputs']);
unset($_SESSION['success']);
unset($_SESSION['errors']); 
?>

<?php 

require 'php/footer.php'; ?>
