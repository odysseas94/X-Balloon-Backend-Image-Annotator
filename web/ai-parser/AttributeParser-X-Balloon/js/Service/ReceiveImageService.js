class ReceiveImagesService extends UrlConnection {


    constructor(data, callback) {
        super({
            url: "receive-images",
        });
        this.data = data;
        this.callback = callback instanceof Function ? callback : () => {
        };
        this.type_json = false;

        this.init();
    }


    success(res) {
        let models = new Map();
        let array = [];
        if (res.images)
            for (let ob in res.images) {
                let image = res.images[ob];
                let model = new ImageModel({}).load(image);
                if (!model.testing_id)
                    models[model.id] = model;
                else
                    models[model.id + "|" + model.testing_id] = model;
                array.push(model);


            }


        this.callback(models, array)
    }

    error(res) {
        this.callback(false);
    }

}


