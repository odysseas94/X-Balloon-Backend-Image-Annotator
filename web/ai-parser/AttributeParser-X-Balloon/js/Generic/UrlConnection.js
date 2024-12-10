class UrlConnection {

    constructor(params = {url: "", type: "GET", data: {}, same_domain: true}) {
        this.domain = urlConnectionApi ? urlConnectionApi : "https://callbuddy.eu/kidney/web/index.php?r=api/v1/workbench/";
        this.domain = window.urlConnectionApi ? window.urlConnectionApi : "https://callbuddy.eu/kidney/web/index.php?r=api/v1/workbench/";
        if (params.same_domain === undefined || params.same_domain === "true") {
            this.url = this.domain + params.url;
            this.same_domain = true;
        } else {
            this.url = params.url;
            this.same_domain = false;
        }
        // this.user = user;
        this.type = params.type ? params.type : "GET";
        this.data = params.data ? params.data : {};
        this.userMessage = translation.get("downloading");

        this.proccessData = true;


        this.callback = () => {
        };
        this.loading = true;
        this.type_json = true;
        this.contentType = true;

    }

    init() {
        let self = this;


        this.collectAll();


        if (this.loading)
            this.showLoader();


        $.ajax({
            url: self.url,
            type: self.type,
            data: this.type_json ? JSON.stringify({data: this.data}) : this.data,
            timeout: 60000,
            contentType: this.contentType ? (this.type_json ? "application/json; charset=utf-8" : "application/x-www-form-urlencoded; charset=UTF-8") : false,
            dataType: "json",
            processData: this.proccessData,


            success: function (res) {
                // console.log(JSON.stringify(res));


                if (self.loading)
                    self.hideLoader();
                if (self.same_domain)
                    if (res.success) {
                        self.success(res.success);
                    } else {
                        self.error(res.error);
                    }
                else {
                    self.done(res);
                }
            },
            fail: function (xhr, textStatus, m) {
                console.log(JSON.stringify(xhr) + JSON.stringify(textStatus) + JSON.stringify(m));
                if (self.loading)
                    self.hideLoader();
                self.failure(xhr, textStatus);
            },
            error: function (xhr, textStatus, m) {
                console.log(xhr);
                if (self.loading)
                    self.hideLoader();
                if (xhr && xhr.responseJSON && xhr.responseJSON.name === "Unauthorized")
                    self.error("Unauthorized")
            }
        });


    }

    collectAll() {

    }

    showLoader() {

        if (!$("body > .loading").length) {
            $("body").append("<div class='loading'></div>");
        }
    }


    hideLoader() {
        $("body .loading").remove();
    }

    error(res) {
        toast.showError("error", "Failed due to :" + res);
    }

    success(res) {

    }

    failure(jqXHR, textStatus) {

        if (textStatus !== "timeout")

            toast.showError("error", "Failed due to :" + textStatus);
        if (this.callback) {
            this.callback(false);
        }
    }

    noInternet() {

        toast.showError("error", "You have no internet connection");
        if (this.callback) {
            this.callback(false);
        }
    }
}
