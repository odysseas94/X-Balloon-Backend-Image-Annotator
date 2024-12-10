class SaveShapesService extends UrlConnection {


    constructor(data, callback) {
        super({
            url: "save-shapes",
            type:"POST"
        });
        this.data = data;
        this.contentType=true;
        this.proccessData=false;
        this.type_json=true;
        this.loading=false;

        this.callback = callback instanceof Function ? callback : () => {
        };


    }




    success(res) {

        // toast.showSuccess("shape",JSON.stringify(res),1000);


        this.callback(res)
    }

    error(res) {
        toast.showError("shape",JSON.stringify(res),1000);
        this.callback(false);
    }
}
