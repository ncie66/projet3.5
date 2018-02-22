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
    console.log(MServer.users);
    socket.emit('user:list', MServer.users, MServer.messages);
    socket.on('user:connect', function(body){
        let user = {
            id: socket.id,
            username: body.username,
            cat: body.cat
        };
        console.log("test");
        var match = false;
        
        for(let connected_user of MServer.users){
            if(connected_user.username == user.username){
                match = true;
            }
        }
;
        if(match == false){
            loggedUser = user;
            MServer.addUser(user);
            socket.emit('user:etat', true);
            socket.broadcast.emit('user:new', user);    
        }
        else{
            socket.emit('user:etat', false);
        }
        
    });

    socket.on("user:typing", function(etat){
        let user = MServer.getUserBySocketId(socket.id);
        socket.broadcast.emit('user:typing', etat, user);
    });

    socket.on('user:sendMessage', function(message){
        let user = MServer.getUserBySocketId(socket.id);
        let data = {
            username: user.username,
            message: message
        };
        MServer.addMessage( user.username, message );
        socket.broadcast.emit('user:receiveMessage', data);
    });

    // socket.on('', function (etat) {

    //     let user = MServer.getUserBySocketId(socket.id);
    //     socket.broadcast.emit('user:typing', etat, user.username);

    //     // console.log('start-typing')
    //     // // Ajout du user à la liste des utilisateurs en cours de saisie
    //     // if (typingUsers.indexOf(loggedUser) === -1) {
    //     // typingUsers.push(loggedUser);
    //     // }
    //     // io.emit('update-typing', typingUsers);
    // });

    socket.on("disconnect", function() {
        console.log('disconnect');
        let user = MServer.getUserBySocketId(socket.id);
        MServer.removeUser(socket.id);

        if(user){
            socket.broadcast.emit('user:disconnect', user);
        }
    });
    
});