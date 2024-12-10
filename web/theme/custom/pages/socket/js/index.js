/**
 ** @property user User
 ** @property io Socket.io
 */


class SocketClient extends AbstractSocket{

    constructor(user) {
        super(user);
    }

    onConnectError(error) {
        this.setAllMachinesOffline(function(){
            console.log("changed");
        });
    }

    bindEvents(){

        $(".machines > .machines .start-training").click(()=>{



        });

    }


}

new SocketClient(user).init();