class ShapeTabUI extends TabUI {
    constructor(props) {
        super(props);

        this.tabsNames = ["rectangle", "circle", "ellipse", "polygon", "multi-polygon"];

        this.parentNode = ".shapes-parent";
        this.current_shape="multi-polygon";
    }

    content() {
        let str = "\n" +
            "            <div class=\" shape \">\n" +
            "\n" +
            "\n" +
            "                <a href=\"#\" class=\"btn btn-default rectangle\" title='" + translation.get("rectangle") + "'>\n" +
            "\n" +
            "                    <svg>\n" +
            "                        <rect width=\"18\" height=\"14\" x=\"3\" y=\"5\" stroke=\"white\" fill=\"none\"></rect>\n" +
            "                        <circle r=\"2\" cx=\"3\" cy=\"10\" stroke=\"white\" fill=\"grey\"></circle>\n" +
            "                        <circle r=\"2\" cx=\"10\" cy=\"19\" stroke=\"white\" fill=\"grey\"></circle>\n" +
            "                        <circle r=\"2\" cx=\"15\" cy=\"5\" stroke=\"white\" fill=\"grey\"></circle>\n" +
            "                        <circle r=\"2\" cx=\"21\" cy=\"14\" stroke=\"white\" fill=\"grey\"></circle>\n" +
            "                    </svg>\n" +
            "                </a>\n" +
            "            </div>\n" +
            "            <div class=\" shape\">\n" +
            "                <a href=\"#\" class=\"btn btn-default circle\" title='" + translation.get("circle") + "'>\n" +
            "                    <svg>\n" +
            "                        <circle r=\"9\" cx=\"12\" cy=\"12\" stroke=\"white\" fill=\"none\"></circle>\n" +
            "                    </svg>\n" +
            "                </a>\n" +
            "            </div>\n" +
            "\n" +
            "            <div class=\" shape\">\n" +
            "                <a href=\"#\" class=\"btn btn-default ellipse\" title='" + translation.get("ellipse") + "'>\n" +
            "                    <svg>\n" +
            "                        <ellipse rx=\"10\" ry=\"8\" cx=\"12\" cy=\"12\" stroke=\"white\" fill=\"none\"></ellipse>\n" +
            "                    </svg>\n" +
            "                </a>\n" +
            "            </div>\n" +
            "\n" +
            "            <div class=\" shape\">\n" +
            "                <a href=\"#\" class=\"btn btn-default polygon\" title='" + translation.get("polygon") + "'>\n" +
            "                    <svg>\n" +
            "                        <path d=\"M 4 12 L 10 2 L 20 6 L 18 16 L 8 20 z\" stroke=\"white\" fill=\"none\"></path>\n" +
            "                    </svg>\n" +
            "                </a>\n" +
            "            </div>\n" +
            "\n" +
            "            <div class=\" shape \">\n" +
            "                <a href=\"#\" class=\"btn btn-default multi-polygon  shape-active\" title='" + translation.get("multi-polygon") + "'>\n" +
            "                    <svg id=\"shape_polyline\">\n" +
            "                        <line x1=\"3\" y1=\"4\" x2=\"8\" y2=\"18\" stroke=\"white\" fill=\"none\"></line>\n" +
            "                        <line x1=\"8\" y1=\"18\" x2=\"14\" y2=\"6\" stroke=\"white\"></line>\n" +
            "                        <line x1=\"14\" y1=\"6\" x2=\"20\" y2=\"14\" stroke=\"white\"></line>\n" +
            "                        <circle r=\"2\" cx=\"3\" cy=\"4\" stroke=\"white\"></circle>\n" +
            "                        <circle r=\"2\" cx=\"8\" cy=\"18\" stroke=\"white\"></circle>\n" +
            "                        <circle r=\"2\" cx=\"14\" cy=\"6\" stroke=\"white\"></circle>\n" +
            "                        <circle r=\"2\" cx=\"20\" cy=\"14\" stroke=\"white\"></circle>\n" +
            "                    </svg>\n" +
            "                </a>\n" +
            "            </div>";

        return str;
    }

    bindEvents() {


        let self = this;
        $(this.parentNode + " .shape    > a ").click(function (e) {
            let name = "";
            for (let ob in self.tabsNames) {
                let tempName = self.tabsNames[ob];
                if ($(this).hasClass(tempName)) {
                    name = tempName;
                    break;
                }
            }

            self.setShapeActive(name);


            e.preventDefault();
        });
    }


    setShapeActive(name) {
        if (master.currentImageTab)
            master.currentImageTab.selectedShape = name;
        this.current_shape=name;

        $(this.parentNode + " .shape    > a.shape-active").removeClass("shape-active");

        $(this.parentNode + " .shape    > a." + name).addClass("shape-active");
    }


}
