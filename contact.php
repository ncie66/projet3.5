<?php require 'php/header.php'; ?>
<br><br>
<link href="css/stylecontact.css" rel='stylesheet'/>

<div class="formcontact">
<form action="" method="POST">

    <label>Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" placeholder="Votre pseudo">

    <label>Selectionnez votre problème :</label>
    <select id="country" name="country">
      <option value="site">Problème du site</option>
      <option value="chat">Problème du chat</option>
      <option value="affichage">Bug d'affichage</option>
    </select>

    <label for="subject">Sujet :</label>
    <textarea id="sujet" name="sujet" placeholder="Ecrivez votre problème" style="height:200px"></textarea>

    <input type="submit" value="Envoyer">

  </form>
</div><br><br>


<?php require 'php/footer.php'; ?>
