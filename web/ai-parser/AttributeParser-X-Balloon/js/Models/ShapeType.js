class ShapeType extends Model {
    constructor({id, name, pretty_name, date_created, date_updated}) {
        super("shape_type");

        this.id = id;
        this.name = name;
        this.pretty_name = pretty_name;
        this.date_created = date_created;
        this.date_updated = date_updated;
        if (this.id)
            this.toMemory();

    }

    toMemory() {
        master.models.shape_types[this.id] = this;
    }


    get ShapeObject() {
        let object = null;
        switch (this.name) {

            case "rectangle":
                object = Rectangle;
                break;
            case "ellipse":
                object = Ellipse;
                break;
            case "circle":
                object = Circle;
                break;
            case "polygon":
                object = Polygon;
                break;
            case "multipolygon":
                object = MultiPolygon;
                break;
            default:
                object = Rectangle;

        }

        return object;
    }


}
