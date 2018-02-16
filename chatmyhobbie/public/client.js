/*global io*/
/*jslint browser: true*/
// var socket = io();
var i;
var socket = io.connect( 'http://localhost:1300' );
var loggedUser = socket.loggedUser;
let username = "";
/*** Fonctions utiles ***/

/**
 * Scroll vers le bas de page si l'utilisateur n'est pas remonté pour lire d'anciens messages
 */
function scrollToBottom() {
  if ($(window).scrollTop() + $(window).height() + 2 * $('#messages li').last().outerHeight() >= $(document).height()) {
    $('html, div.chat').animate({ scrollTop: $(document).height() }, 0);
  }
}

/*** Gestion des événements ***/

/**
 * Connexion de l'utilisateur
 * Uniquement si le username n'est pas vide et n'existe pas encore
 */
$('#login form').submit(function (e) {
  e.preventDefault();
  username = $('#login input').val().trim();
  if (username.length > 0) { // Si le champ de connexion n'est pas vide
    socket.emit('user:connect', username);
  }
});

/**
 * Envoi d'un message
 */
$('#chat form').submit(function (e) {
  e.preventDefault();
  var message = {
    text : $('#m').val()
  };
  $('#m').val('');
  if (message.text.trim().length !== 0) { // Gestion message vide
    socket.emit('user:sendMessage', message);
    $('#messages').append($('<li>').html('<span class="username">' + username + '</span> ' + message.text));
  }
  $('#chat input').focus(); // Focus sur le champ du message
});


///////////////////////////
socket.on('user:etat', function(etat){
  if (etat) {
    $('div.chat').removeAttr('id'); // Cache formulaire de connexion
    $('#chat input').focus(); // Focus sur le champ du message
  }
});
socket.on('user:new', function(username){
  // $('#users').append($('<li class="new">'));
  $('#users').append($('<li class="' + username + ' new">').html(username + '<span class="typing">est en train d\'écrire</span>'));
});
socket.on('user:list', function(users){
  let elements = '';
  for(let user of users) {
    elements += '<li class="' + user.username + ' new">'+user.username+' <span class="typing">est en train d\'écrire</span></li>';
    // $('#users').append($('<li class="' + user.username + ' new">').html(user.username));
  }
  $('#users').html(elements);
});
socket.on('user:disconnect', function(user){
  $('#users').children().attr('class', user.username).remove();
  
  // $('#users').append($('<li class="' + user.username + ' new">').html(user.username + '<span class="typing">est en train d\'écrire</span>'));
  //   setTimeout(function () {
  //     $('#users li.new').removeClass('new');
  //   }, 1000);
});
socket.on('user:receiveMessage', function(data) {
  $('#messages').append($('<li>').html('<span class="username">' + data.username + '</span> ' + data.message));
});
socket.on('user:typing', function(etat, username){
  if(etat) {
    $('#users li.' + username + ' span.typing').show();
  } else {
    $('#users li.' + username + ' span.typing').hide();
  }
});
/**
 * Réception d'un message
 */
// socket.on('chatr-messages', function (message) {
//   // console.log(message);
//   $('#messages').append($('<li>').html('<span class="username">' + message.username + '</span> ' + message.text));
//   scrollToBottom();
//     // socket.emit('chat-message', message);
//     // messages.push(message);
//     // if (messages.length > 150) {
//     //   messages.splice(0, 1);
//     // }

// });

/**
 * Réception d'un message de service
 */
// socket.on('service-message', function (message) {
//   $('#messages').append($('<li class="' + message.type + '">').html('<span class="info">information</span> ' + " '" + message.text + "'"));
//   scrollToBottom();
// });

// /**
//  * Connection d'un nouvel utilisateur
//  */
// socket.on('user-login', function (user) {
//     $('#users').append($('<li class="' + user.username + ' new">').html(user.username + '<span class="typing">est en train d\'écrire</span>'));
//     setTimeout(function () {
//       $('#users li.new').removeClass('new');
//     }, 1000);
// });

// socket.on('user:receiveMessage', function(data){
//   console.log(data);
// })

/**
 * Déconnexion d'un utilisateur
 */
// socket.on('user-logout', function (user) {
//   var selector = '#users li.' + user.username;
//   $(selector).remove();
// });

/**
 * Détection saisie utilisateur
 */
var typingTimer;
var isTyping = false;

$('#m').keypress(function () {
  clearTimeout(typingTimer);
  if (isTyping == false) {
    socket.emit('user:typing', true);
    isTyping = true;
  }
});

$('#m').keyup(function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(function () {
    if (isTyping) {
      socket.emit('user:typing', false);
      isTyping = false;
    }
  }, 500);
});

/**
 * Gestion saisie des autres utilisateurs
 */
// socket.on('update-typing', function (typingUsers) {
//   console.log(typingUsers)
//   $('#users li span.typing').hide();
//   for (i = 0; i < typingUsers.length; i++) {
//     console.log("lol", typingUsers);
//     $('#users li.' + typingUsers[i].user + ' span.typing').show();
//   }
// });