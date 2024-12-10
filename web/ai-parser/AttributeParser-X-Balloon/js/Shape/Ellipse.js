class Ellipse extends Shape {
    constructor(pos, context) {
        super(pos, context);

        this.defaultWidth = 10;
        this.defaultHeight = 15;
        this.rotateEnabled = false;
        this.radiusX = 15;
        this.shape_name = "ellipse";
        this.radiusY = 10;


    }

    _bindTransformerEvents() {
        let self = this;

        this.transformer.on("transform", (e) => {


            let node = e.currentTarget.node();
            self.scaleX = node.attrs.scaleX;
            self.scaleY = node.attrs.scaleY;


            self.dragmove(e)


        });
    }


    get shapePosition() {
        return {
            x: this.shape.x() * this.global_scale,
            y: this.shape.y() * this.global_scale,
            radius_x: this.shape.radiusX() * this.global_scale * this.shape.getScaleX(),
            radius_y: this.shape.radiusY() * this.global_scale * this.shape.getScaleY()
        }
    }

    init() {

        super.init();

        this.shape = new Konva.Ellipse(this.konvaConfig);
        this.addToLayer(this.shape);

        this._makeLabel({
            x: this.pos.x,
            y: this.pos.y - this.radiusY - this.labelOffset
        }, this.shape._id);

        this.addToLayer(this.label);
        if (this._initTransformer)
            this._makeTransformer();

        this.id = this.shape._id;
        this.shape.id(this.id);
        this.drawAllSeparate();
        return this;

    }


    movePosition(pos) {


        let old_position = this.old_position;

        if (this.shape) {


            let contextPlan = this.context;


            let radiusX = pos.x - old_position.x + this.radiusX;
            let radiusY = pos.y - old_position.y + this.radiusY;


            if (this.creation && radiusX >= 0 && radiusY >= 0) {
                this.shape.attrs.radiusX = radiusX;
                this.shape.attrs.radiusY = radiusY;
                this._makeTransformer();

                this.dragmove(pos);
                super.movePosition(pos);
            }


        }


    }

    moveLabel(pos) {

        if (this.label) {
            this.genericShape._updateLabel({
                x: pos.x,
                y: pos.y
            });
        }


    }

    dragmove(e) {


        if (this.label) {
            this._updateLabel({
                x: this.shape.attrs.x,
                y: this.shape.attrs.y - (this.shape.attrs.radiusY * this.shape.attrs.scaleY) - this.labelOffset
            });

            super.dragmove(e);
        }
    }


}
