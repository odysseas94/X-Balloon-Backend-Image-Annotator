class ZoomTabUI extends TabUI {


    constructor(props) {
        super(props);

        this.parentNode = ".classification-parent";

    }


    content() {
        let str = "     <select class=\"form-control\" id=\"classification\" name=\"classification\">\n" +
            "                <option name='fat' id='fat'>" + translation.get("classification_names", "fat") + "</option>\n" +
            "                <option name='ballooning' id='ballooning'>" + translation.get("classification_names", "ballooning") + "</option>\n" +
            "                <option name='inflammation' id='inflammation'>" + translation.get("classification_names", "inflammation") + "</option>\n" +
            "            </select>"

        return str;

    }

    bindEvents() {

        let self = this;

        $(this.parentNode + " #classification").change(function (e) {

            e.preventDefault();
        })
    }


}
