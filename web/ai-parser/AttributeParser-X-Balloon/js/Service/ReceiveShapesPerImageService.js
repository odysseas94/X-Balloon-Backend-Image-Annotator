class ReceiveShapesPerImageService extends UrlConnection {


    constructor(image, callback = () => {
    }) {
        super({


            url: "get-shapes-by-image",
            type: "GET"
        });


        if (!(image instanceof ImageModel)) throw new Error("image must be an ImageModel instance");


        this.data = image.attributes;
        this.callback = callback;

        this.type_json = false;


    }


    success(res) {


        let models = [];
        if (res.shapes) {

            const {shapes} = res;
            for (let ob in res.shapes) {

                let shape = shapes[ob];
                let model = new ModelShape({});
                model.load(shape);
                models.push(model);

            }
        }

        this.callback(models);
    }

    error(res) {
        this.callback(false);


    }

}
