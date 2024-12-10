class RegionAttributesTabUI extends TabUI {

    constructor() {
        super();
        this.parentNode = ".attribute-menu-parent"
        this.regionAttributeParent = ".region-attributes-parent";
        this.shapes = new Map();

    }

    content() {
        console.log("content");
        return "\n" +
            "    <a class=\" btn btn-primary \" data-toggle=\"collapse\" data-target=\"#region-attributes-parent\" aria-controls=\"region-attributes-parent\" aria-expanded=\"false\">\n" +
            "   <i class=\"fas fa-bars\"></i>\n" +
            "    </a>\n" +
            "" +
            "<div id='region-attributes-parent' class='region-attributes-parent collapse'></div>";
    }


    initList(shapes) {

        this.shapes = shapes;
        let str = "<ul class='list-group'>";
        for (let ob in this.shapes) {
            let shape = this.shapes[ob];
            str += this.addOne(shape);


        }
        str += "</ul>";

        $(".region-attributes-parent").html(str);
    }


    addOne(shape) {

        return "<li data-id='" + shape.id + "'" +
            " class='list-group-item'><div class='row'><div class='col-3'><a class='btn btn-primary node'>" + shape.labelName + "</a></div>" +
            " <div class='col-7 '>" + this.getClassificationSimpleUiList(shape) +
            "</div>" +
            "<div class='col-2'><a class='btn btn-primary delete'><i class=\"far fa-trash-alt\"></i></a></div></div></li>";
    }


    getClassificationSimpleUiList(shape) {
        let classifications = master.models.classifications;
        let str = "<select class='classification-select form-control'>";

        for (let ob in classifications) {
            let classification = classifications[ob];
            let active = "";
            if (shape.classificationId === classification.id)
                active = "selected";
            str += "<option value='" + classification.id + "' data-id='" + classification.id + "' " + active + ">" + translation.get("classification_names", classification.pretty_name) + "</option>";
        }
        str += "</select>";
        return str;
    }

    appendToList(shape) {


        if (shape && shape instanceof Shape) {

            this.shapes[shape.id] = shape;


            $(".region-attributes-parent ul").append(this.addOne(shape));

        }


    }

    scrollTo(id) {

        if ($(this.regionAttributeParent).hasClass("show") && this.shapes[id]) {

            let $li = $(".region-attributes-parent ul li[data-id='" + id + "']");
            if ($li.length) {
                $li.get(0).scrollIntoView();
            }
            this.setActive(id);
        } else if (this.shapes[id])
            this.setActive(id);

    }

    setActive(id) {
        $(".region-attributes-parent ul li").removeClass("active");
        $(".region-attributes-parent ul li[data-id='" + id + "']").addClass("active");
    }

    removeFromList(shape) {
        delete this.shapes[shape.id];
        $(".region-attributes-parent ul li[data-id='" + shape.id + "']").remove();
    }

    bindEvents() {
        let self = this;
        $(document).on("click", this.parentNode + " ul li a.node ", function (e) {
            let id = $(this).parents("li").data("id");
            self.shapes[id].shape.fire("click");
            let tab = master.currentImageTab;
            let shape = self.shapes[id];
            tab.currentObject = shape;
            tab.currentObject._makeTransformer(tab.layer);
            tab.removeAllTransformers(null, shape.transformer)


            master.currentImageTab.layer.batchDraw();


        });


        $(document).on("click", this.parentNode + " ul li a.delete", function (e) {


            try {
                let id = $(this).parents("li").data("id");
                self.shapes[id].shape.fire("click");
                let tab = master.currentImageTab;
                let shape = self.shapes[id];
                tab.currentObject = shape;
                tab._removeObject(shape);
                console.log("deleted", shape);

            } catch ($e) {
                console.error($e);
            }


        });
        $(document).on("change", this.parentNode + " ul li .classification-select", function (e) {
            let class_id = Number($(this).val());
            let id = $(this).parents("li").data("id");
            self.shapes[id].shape.fire("click");
            let tab = master.currentImageTab;
            let shape = self.shapes[id];
            tab.currentObject = shape;
            tab.currentObject._makeTransformer(tab.layer);
            tab.removeAllTransformers(null, shape.transformer)
            tab.currentObject.updateClassificationId(class_id);

        });
    }


}