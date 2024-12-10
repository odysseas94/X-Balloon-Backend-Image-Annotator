class ClassificationTabUI extends TabUI {


    constructor(props) {
        super(props);

        this.parentNode = ".classification-parent";

        this.currentClass = null;

    }

    static colors() {
        let models = master.models.classifications;
        let colors = {};
        for (let ob in models) {
            let model = models[ob];
            colors[model.name] = model.color;
        }
        return colors;

    }
    get classificationName() {

        let models = master.models.classifications;
        for (let ob in models) {
            if (models[ob].name === this.currentClass)
                return models[ob].pretty_name;
        }
    }


    get classificationId() {

        let models = master.models.classifications;
        for (let ob in models) {
            if (models[ob].name === this.currentClass)
                return models[ob].id;
        }
    }


    get classificationColor() {

        return ClassificationTabUI.colors()[this.currentClass];


    }


    content() {


        let models = Object.values(master.models.classifications);
        models = models.sort(function (a, b) {

            return a.name < b.name && a.name !== "area" ? -1 : 0;
        });

        this.currentClass = models[Object.keys(models)[0]].name;
        let str = "     <select class='selectpicker' title='" + translation.get("classification_names", "choose_title") + "' class=\"form-control\" id=\"classification\" name=\"classification\">\n";
        for (let ob in models) {
            let model = models[ob];

            let selected = this.currentClass === model.name ? "selected" : "";

            str += "<option name='" + model.name + "'  " + selected + " value='" + model.name + "' id='" + model.name + "' data-content=\"<i style='color:" + model.color + "' class='fas fa-circle'></i>  " + translation.get("classification_names", model.pretty_name) + "\"></option>\n";


        }
        str += "</select>";


        return str;

    }

    changeClassification(move_index) {
        let array_options = [];
        let current_index = 0;
        let $select = $(this.parentNode + " #classification");
        let current_val = $select.find(":selected").val();
        $select.find("option").each(function (index) {
                let value = $(this).val();

                array_options.push(value);

                if (current_val === value) {
                    current_index = index;
                }
            }
        );
        let final_index=current_index+ (1* move_index);
        if(final_index>=0 && array_options[final_index]){
            $select.val(array_options[final_index]).trigger("change");
            toast.showSuccess("Classification", "Changed Classification to " + this.classificationName);
        }
    }

    bindEvents() {

        let self = this;
        $(".selectpicker").selectpicker({
            style: 'btn-primary',
            showIcon: false,
        });


        $(this.parentNode + " #classification").change(function (e) {

            self.currentClass = String($(this).val()).toLowerCase();
            e.preventDefault();
        })
    }


}
