class ModelShape extends Model {

    constructor({id = 0, points = {}, shape_type_id, class_id, area = 0, date_created = 0, date_updated = 0, deleted = 0}) {
        super("shape");
        this.id = id;
        this._points = points;
        this.shape_type_id = shape_type_id;
        this.class_id = class_id;

        this.area = area;
        this.date_created = date_created;
        this.date_updated = date_updated;

        this.deleted = deleted;

        this._id = Math.floor(Math.random() * new Date().getTime()) + new Date().getTime();


    }

    get points() {
        return this._points;
    }

    load(object = {}) {

        for (let ob in object) {
            if (this.hasOwnProperty(ob))
                this[ob] = object[ob];
            else if (ob === "points")
                this.points = object[ob];
        }
        this.toMemory();
        this._inserted = true;
        this._updated = false;
        return this;
    }

    set points(points) {
        if (typeof (points) === "string")
            this._points = JSON.parse(points);
        else
            this._points = points;

    }


    calculateArea() {
        if (this.shape_type_id)
            switch (this.shapeType.name) {
                case "circle":
                    this.area = this.circleArea();
                    break;
                case "ellipse":
                    this.area = this.ellipseArea();
                    break;
                case "rectangle":
                    this.area = this.rectangleArea();
                    break;
                case "polygon":
                    this.area = this.polygonArea();
                    break;
                case "multipolygon":
                    this.area = this.polygonArea();
                    break;
            }
    }


    circleArea() {

        let area = Math.PI * Math.pow(this.points.radius, 2);
        return area > 0 ? area : -area;
    }

    ellipseArea() {
        let area = Math.PI * this.points.radius_x * this.points.radius_y;
        return area > 0 ? area : -area;
    }

    rectangleArea() {
        let area = this.points.height * this.points.width;
        return area > 0 ? area : -area;
    }


    polygonArea() {

        let polygons = this.points;
        let area = 0;
        let j = 0;
        for (let i = 0; i < polygons.length; i++) {
            j = (i + 1) % polygons.length;

            area += polygons[i].x * polygons[j].y;
            area -= polygons[i].y * polygons[j].x;

        }

        area /= 2;
        return (area < 0 ? -area : area);
    }


    get attributes() {

        let result = {


            points: this.points,
            shape_type_id: this.shape_type_id,
            class_id: this.class_id,
            area: this.area,
            _id: this._id,
            deleted: this.deleted,


        };


        if (this.id)
            result.id = this.id;
        else
            result._id = this._id;


        return result;
    }

    get classification() {
        let models = master.models.classifications;
        for (let ob in models) {
            if (models[ob].id === this.class_id)
                return models[ob];
        }
    }


    get shapeType() {
        let models = master.models.shape_types;

        for (let ob in models) {
            if (models[ob].id === this.shape_type_id)
                return models[ob];
        }
    }

    get shapeObject() {

        let shapeType = this.shapeType;
        if (shapeType)
            return shapeType.ShapeObject;

        console.error("shape object is empty");
        return Rectangle;


    }

}
