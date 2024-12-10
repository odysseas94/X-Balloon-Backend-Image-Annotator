class Translation {
    constructor() {
        this.loadFile = "English";
        this.language = "en";
        this.translationObject = {};
    }

    init(callback = function () {

    }) {


        if (runtime.current_user && runtime.current_user.language) {

            this.language = runtime.current_user.language;
        } else
            this.language = "en";

        if (this.language === "el_GR") {
            this.loadFile = "Greek";
            moment.locale("el-GR");
        } else if (this.language === "en") {
            moment.locale("en");
        }
        let self = this;

        this.getLanguageFile(function (res) {
            ;

            self.translationObject = res;
            callback();
        });

    }

    get(string_incoming, secondary_incoming) {
        let string = string_incoming;
        let secondary = secondary_incoming ? secondary_incoming : null;

        if (secondary && typeof this.translationObject[string][secondary] == "string") {
            return this.translationObject[string][secondary];
        } else if (typeof this.translationObject[string] == "string") {

            return this.translationObject[string];
        } else {

            if (secondary) return secondary_incoming;
            return string_incoming;
        }

    }


    getLanguageFile(callback = function () {
    }) {

        $.getJSON(window.localDomain + "/js/Translation/" + this.loadFile + ".json", function (res) {
            callback(res);
        })
    }

}
