/**
 ** @property user User
 ** @property io Socket.io
 */
const domain = "localhost:3001";
let page = "machines";

class AbstractSocket {


    constructor(user) {

        this.socket = null;
        this.user = user;
        this.onConnectErrorExecuted = false;
        this.machines=[];


    }


    init() {
        this.socket = io(domain, {
            query: {
                id: this.user.id,
                token: this.user.token,
                type: "client"
            }
        });

        this._bindEvents();

    }

    _onConnect() {
        this.socket.on("connect", () => {
            this.onConnectErrorExecuted = false;
            this.onConnect();
        })


    }

    _onDisconnect() {
        this.socket.on("disconnect", () => {
            this.onDisconnect();
        });

    }
    _onMachinesReceived(){
        this.socket.on("machines-received", () => {



        });
    }

    onDisconnect() {

    }

    _onConnectError() {

        this.socket.on("connect_error", (error) => {

            if (!this.onConnectErrorExecuted) {
                this.onConnectErrorExecuted = true;

                console.log(error);


                this.onConnectError(error);
            }

        });
        this.socket.on('connect_failed', (error) => {
            console.log(error);
            if (!this.onConnectErrorExecuted) {
                this.onConnectErrorExecuted = true;

                console.log(error);


                this.onConnectError(error);
            }

        })
    }

    onConnectError(error) {

    }


    onConnect() {

    }
    bindEvents(){

    }
    _bindEvents() {
        this._onConnect();
        this._onDisconnect();
        this._onConnectError();
        this.bindEvents();

    }


    setAllMachinesOffline(callback = function () {
    }) {


        $.ajax({


            url: "/index.php?r=socket/set-all-machines-status&name=offline",
            success: (result) => {
                if (result.success) {

                    callback();

                }

            }
        });
    }


    getClassByMachineStatus(status) {

    }


    changeMachineStatus(status) {

    }


}


