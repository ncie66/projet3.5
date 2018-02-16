var http = require('http');

var Server = require('./models/Server'),
    MServer = new Server();


var httpServer = http.createServer();
httpServer.listen(1300, function(){
    console.log('server en écoute sur le port 1300');
});

var io = require('socket.io').listen(httpServer);

var typingUsers = [];
var loggedUser;

io.sockets.on("connection", function( socket ){ 
    socket.emit('user:list', MServer.users);
    socket.on('user:connect', function(username){
        let user = {
            id: socket.id,
            username: username
        };
        loggedUser = user;
        MServer.addUser(user);
        socket.emit('user:etat', true);
        socket.broadcast.emit('user:new', user.username);
    });

    socket.on('user:sendMessage', function(message){
        let user = MServer.getUserBySocketId(socket.id);
        let data = {
            username: user.username,
            message: message.text
        };
        socket.broadcast.emit('user:receiveMessage', data);
    });

    socket.on('', function (etat) {

        let user = MServer.getUserBySocketId(socket.id);
        socket.broadcast.emit('user:typing', etat, user.username);

        // console.log('start-typing')
        // // Ajout du user à la liste des utilisateurs en cours de saisie
        // if (typingUsers.indexOf(loggedUser) === -1) {
        // typingUsers.push(loggedUser);
        // }
        // io.emit('update-typing', typingUsers);
    });
    
    socket.on("disconnect", function() {
        let user = MServer.getUserBySocketId(socket.id);
        MServer.removeUser(socket.id);
        socket.broadcast.emit('user:disconnect', user);
    });
    
});