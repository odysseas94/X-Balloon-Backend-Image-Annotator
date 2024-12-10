class ReceiveImageStatisticsService extends UrlConnection {
    constructor(image, callback = () => {
    }) {
        super({url: 'get-image-statistics'});
        if (!(image instanceof ImageModel))
            throw new Error("Image is not a ImageModel instance");


        this.data = image.attributes;
        this.callback = callback instanceof Function ? callback : () => {
        };
        this.type_json = false;
        this.init();


    }

    success(response) {
        let res = response.shapes;

        let array = [];
        for (let ob in res) {
            let shape = new ModelShape(res[ob]);
            array.push(shape);

        }
        return this.callback(array);
    }


    error(res) {
        return this.callback(false);
    }


}