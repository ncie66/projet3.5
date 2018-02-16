class Server {
    constructor() {
        this.users = [];
    }
    addUser(user) {
        this.users.push(user);
        console.log(user.username+' connected');
    }
    removeUser(socketId) {
        for(let user in this.users) {
            if (this.users[user] == socketId) {
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