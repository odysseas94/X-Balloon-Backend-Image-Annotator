class Circle extends Shape {
    constructor(pos, context) {
        super(pos, context);


        this.eucidian = 10;
        this.radius = this.eucidian;

        this.enabledAnchors = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];


    }

    _bindTransformerEvents() {
        let self = this;

        this.transformer.on("transform", (e) => {

            let node = e.currentTarget.node();
            self.scaleX = node.attrs.scaleX;
            self.scaleY = node.attrs.scaleY;
            self.eucidian = node.attrs.radius * node.attrs.scaleY;
            self.dragmove({
                x: node.attrs.x,
                y: node.attrs.y
            });


        });
    }

    init() {

        super.init();

        this.shape = new Konva.Circle(this.konvaConfig);
        this.addToLayer(this.shape);

        this._makeLabel({
            x: this.pos.x,
            y: this.pos.y - this.eucidian - this.labelOffset
        }, this.shape._id);
        this.addToLayer(this.label);
        if (this._initTransformer)
            this._makeTransformer();
        this.id = this.shape._id;
        this.shape.id(this.id);
        this.drawAllSeparate();
        return this;

    }

    get shapePosition() {
        return {
            x: this.shape.x() * this.global_scale,
            y: this.shape.y() * this.global_scale,
            radius: this.shape.radius() * this.global_scale * this.shape.getScaleX()
        }
    }


    mouseup(e) {

        let currentInstance = this.getShape(e.evt);


        this._makeTransformer();


    }

    initObjectCreation() {

    }

    movePosition(pos) {


        let old_position = this.old_position;

        if (this.shape) {


            let contextPlan = this.context;


            let eucidian = this.eucidian = Math.sqrt(Math.pow(pos.x - old_position.x, 2) + Math.pow(pos.y - old_position.y, 2)) + 10;
            this.eucidian = eucidian;
            this.shape.attrs.radius = eucidian;
            this.shape.attrs.height = pos.y - old_position.y;
            this._makeTransformer();

            this._updateLabel({
                x: old_position.x,
                y: old_position.y - eucidian - this.labelOffset
            });


        }


        super.movePosition(pos);
    }

    moveLabel(pos) {

        this.genericShape._updateLabel({
            x: pos.x,
            y: pos.y - this.eucidian
        });


    }

    dragmove(e) {

        let old_position = e;

        this._updateLabel({
            x: this.shape.attrs.x,
            y: this.shape.attrs.y - this.eucidian - this.labelOffset
        });

        super.dragmove(e);
    }


}
