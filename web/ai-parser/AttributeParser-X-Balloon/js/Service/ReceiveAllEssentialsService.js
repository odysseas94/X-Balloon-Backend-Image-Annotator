class ReceiveAllEssentialsService extends UrlConnection {


    constructor(callback = () => {
    }) {
        super({url: "get-essentials"});
        this.callback = callback;
        this.loading = false;
        this.type_json = false;
        this.init();

    }


    parseModels(res) {
        let classifications = res.classifications;
        let shapeTypes = res.shape_types;
        for (let ob in classifications)
            new ClassificationModel({}).load(classifications[ob]);
        for (let ob in shapeTypes)
            new ShapeType({}).load(shapeTypes[ob]);

        if (res.user)
            new User({}).load(res.user);
        if (res.user_configuration)
            new UserConfiguration({}).load(res.user_configuration);

    }

    success(res) {
        console.log(res);


        if (res) {


            this.parseModels(res);
            return this.callback(true);
        }
        return this.callback(false);
    }


}
