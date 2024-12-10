class SettingTabUI extends TabUI {

    constructor() {
        super();
        this.parentNode = ".settings-parent"

        this.shapes = new Map();
        this.modal = null;

    }

    content() {

        return "\n" +
            "    <a class=\" btn btn-primary \" title='" + translation.get("Settings") + "' aria-expanded=\"false\">\n" +
            "   <i class=\"fas fa-cogs\"></i>\n" +
            "    </a>\n" +
            "";

    }


    createModal() {
        this.modal = new Modal({
            id: "settings-modal",
            title: translation.get("Settings"),
            body: this.modalContent(),


        }).init();


        if (this.checkIfAreaExists())
            this.loadImageStatisticsService();
        this.modal.show();
    }


    checkIfAreaExists() {
        for (let ob in master.models.classifications) {
            if (master.models.classifications[ob].visible === "false")
                return true;

        }
        return false;

    }

    modalContent() {
        let str = "";
        if (this.checkIfAreaExists())
            str += "<div class='image-statistics row'><div class=\"cssload-loader\">Loading</div></div>";
        str += "<div class='settings-row row'></div>";

        return str;
    }

    bindEvents() {


        $(this.parentNode + " .btn").click(() => {
            if (master.currentImageTab)
                this.createModal();
        })
    }


    loadImageStatisticsService() {


        new ReceiveImageStatisticsService(master.currentImageTab.currentImage.model, (shapes) => {
            let str = "<div class='col-6 d-flex align-items-center justify-content-center text-right '><h5>" + translation.get("Statistics") + "</h5></div>";
            str += "<div class='col-6 '>";
            for (let ob in shapes) {
                let shape = shapes[ob];

                let classification = master.models.classifications[shape.class_id];

                str += "<div class='single-statistic '>" + translation.get("classification_names", classification.pretty_name) + " : " + shape.area + "%</div>";
            }
            str += "</div>";

            $("#" + this.modal.id + " .image-statistics").html(str);

        });
    }


}