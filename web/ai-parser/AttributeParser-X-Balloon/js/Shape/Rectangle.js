class Rectangle extends Shape {
    constructor(pos, context) {
        super(pos, context);
        this.defaultWidth = 30;
        this.defaultHeight = 30;


        if (pos) {
            this.x = pos.x - this.defaultWidth / 2;
            this.y = pos.y - this.defaultHeight / 2;
        }


    }


    _bindTransformerEvents(callback = () => {
    }) {
        let self = this;

        this.transformer.on("transform", (e) => {

            console.log("gonna transform",this);
            let node = e.currentTarget.node();
            self.scaleX = node.attrs.scaleX;
            self.scaleY = node.attrs.scaleY;


            // console.log(this.eucidian);
            callback();
            self.dragmove(e)
            // //  this.layer.draw();

        });
    }

    init() {

        super.init();

        this.shape = new Konva.Rect(this.konvaConfig);
        this.addToLayer(this.shape);

        this._makeLabel({
            x: this.x + this.width / 2,
            y: this.y - this.labelOffset
        }, this.shape._id);
        this.addToLayer(this.label);

        this.id = this.shape._id;
        this.shape.id(this.id);
        if (this._initTransformer)
            this._makeTransformer();

        this.drawAllSeparate();
        return this;

    }


    mousemove(e) {
        console.log(this.creatingObject);

        if (this.creatingObject) {
            this.currentShape.movePosition(this.stage.getPointerPosition());
        }

    }

    mousestart(e) {
        // console.log("mouse start buddy")
        // //  this.removeCurrentInstance();
        // let currentInstance = this.getShape();
        // let newRect = currentInstance.shape;
        // let tr = currentInstance.transformer;
        // this.layer.add(newRect);
        //
        // tr.attachTo(newRect)
        // this.layer.add(tr);
        //
        // this.stage.add(this.layer, this.dragLayer);
    }

    //height
    get shapePosition() {


        return {
            x: this.shape.x() * this.global_scale,
            y: this.shape.y() * this.global_scale,
            width: this.shape.width() * this.global_scale * this.shape.getScaleX(),
            height: this.shape.height() * this.global_scale * this.shape.getScaleY(),
        }
    }

    movePosition(pos) {




        let old_position = this.old_position;

        if (this.shape) {


            let contextPlan = this.context;


            this.shape.attrs.width = pos.x - old_position.x + this.defaultWidth;
            this.shape.attrs.height = pos.y - old_position.y + this.defaultHeight;
            this._makeTransformer();

            this.dragmove(pos)


        }


        super.movePosition(pos);
    }

    moveLabel(pos) {

        this.genericShape._updateLabel({
            x: pos.x,
            y: pos.y
        });

        //this.layer.draw();
    }

    dragmove(e) {


        this._updateLabel({
            x: this.shape.attrs.x + (this.shape.attrs.width * this.shape.attrs.scaleX) / 2,
            y: this.shape.attrs.y - this.labelOffset
        });

        super.dragmove(e);
    }


}
