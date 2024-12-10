class AllTabsUI extends TabUI {

    constructor() {
        super();

        this.parentNode = ".tabs";


    }


    content() {

        let str = "";
        str += " <div class=\"select-image-parent\">\n" +
            "\n" +
            "        </div>\n" +
            "\n" +
            "        <div class=\"classification-parent\">\n" +
            "\n" +
            "        </div>\n" +
            "\n" +
            "        <div class=\"shapes-parent\">\n" +
            "\n" +
            "\n" +
            "        </div>\n" +
            "\n" +
            "\n" +
            "        <div class=\"attribute-menu-parent text-right float-right\">\n" +
            "\n" +
            "\n" +
            "        </div>\n" +
            "        <div class=\"settings-parent text-right float-right\">\n" +
            "\n" +
            "\n" +
            "        </div>\n" +
            "        <div class=\"zoom-parent  text-right float-right\">\n" +
            "\n" +
            "        </div>\n" +
            "<div class='jobs-parent  text-right float-right'></div>" +
            "\n" +
            "        <div class=\"zoom-parent hidden\">\n" +
            "             <span class=\"zoom-details\">\n" +
            "         1\n" +
            "             </span>\n" +
            "\n" +
            "            <i class=\"fa fa-undo\" aria-hidden=\"true\"></i>\n" +
            "\n" +
            "        </div>";

        return str;
    }

    init(callback = () => {
    }) {

        this.beforeRedirect(() => {


            this.strContent = this.content();

            this.$parentNode = $(this.parentNode).append(this.strContent);
            this.bindEvents();
            callback();
        });

    }

    bindEvents() {


    }
}
