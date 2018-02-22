
<link rel="stylesheet" href="chatmyhobbie/public/style.css" />
<div><a href="index.php">Retour au menu</a></div>
<div class="chat" id="logged-out">
    <section id="chat">
      <ul id="messages">
      </ul><ul id="users">
      </ul>
      <form action="">
        <input id="m" autocomplete="off" /><button>Send</button>
      </form>
    </section>
    <section id="login">
      <form action="">
        <label for="u">Username</label>
        <input id="u" autocomplete="off" autofocus />
        <p>
          <button>Login</button>
        </p>
      </form>
    </section>
  </div>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="chatmyhobbie/public/socket.io.js"></script>
    <script src="chatmyhobbie/public/client.js"></script>
