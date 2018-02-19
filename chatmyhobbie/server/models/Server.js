class Server {
    constructor() {
        this.users = [];
        this.messages = [];
    }
    addMessage( username, text ){
        this.messages.push({
            username: username,
            text: text
        });
        if( this.messages.length > 150 ){
            this.messages.splice(149, 1);
        }
    }
    addUser(user) {
        this.users.push(user);
        console.log(user.username+' connected');
    }
    removeUser(socketId) {
        for(let user in this.users) {
            if (this.users[user].id == socketId) {
                this.users.splice(user, 1);
            }
        }
    }
    getUserBySocketId(socketId) {
        for(let user of this.users) {
            if (user.id == socketId) {
                return user;
            }
        }
    }
}

module.exports = Server;