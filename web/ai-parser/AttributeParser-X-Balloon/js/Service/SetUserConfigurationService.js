class SetUserConfigurationService extends UrlConnection {

    constructor(user_configuration, callback = () => {
    }) {
        super(
            {
                type: "POST",
                url: "set-user-configuration",
            });

        if (!(user_configuration instanceof UserConfiguration))
            return callback(false);
        this.callback = callback;
        this.contentType = true;
        this.proccessData = false;
        this.type_json = true;
        this.loading = false;
        this.data = {UserConfig: user_configuration.attributes};


        this.init();
    }


    success(res) {
        if(res.user_config)
             new UserConfiguration({}).load(res.user_config)
        return this.callback(true);

    }

    error(res) {
        console.error(res);
        return this.callback(false)

    }


}