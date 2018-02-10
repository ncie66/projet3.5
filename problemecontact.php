<?php require 'php/header.php'; ?>
<br><br>
<link href="css/stylecontact.css" rel='stylesheet'/>

<div class="formcontact">

  <form action="form_contact.php" method="POST">

    <div class="form-group">
      <label for="pseudo">Pseudo :</label>
      <input type="text" id="pseudo" name="username" placeholder="Votre pseudo">

      <label>Selectionnez votre problème :</label>
      <select id="probleme" name="probleme">
        <option value="probleme_site" name="probleme_site">Problème du site</option>
        <option value="probleme_chat" name="probleme_chat">Problème du chat</option>
        <option value="probleme_affichage" name="probleme_affichage">Bug d'affichage</option>
      </select>

      <label for="sujet">Sujet :</label>
      <textarea id="sujet" name="sujet" placeholder="Ecrivez votre problème" style="height:200px"></textarea>

      <input type="submit" value="Envoyer">
    </div>

  </form>

</div><br><br>

<?php require 'php/footer.php'; ?>
