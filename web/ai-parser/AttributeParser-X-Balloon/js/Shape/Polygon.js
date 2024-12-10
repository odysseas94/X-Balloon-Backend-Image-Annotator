class Polygon extends Shape {
    constructor(pos, context) {
        super(pos, context);
        this.lines = [];
        this.currentLine = new Line({
            x: this.x,
            y: this.y
        }, context);
        this.lines.push(...this.currentLine.format);

        this.points = this.lines;
        this.lockingMechanism = true;
        this.mousemoveTouchmove = false;

        this.done = false;
        this.isFakeFirstTime = true;
        this.keyListen = true;


    }

    _bindTransformerEvents() {
        let self = this;

        this.transformer.on("transform", (e) => {


            let node = e.currentTarget.node();
            self.scaleX = node.attrs.scaleX;
            self.scaleY = node.attrs.scaleY;


            // console.log(this.eucidian);
            self.dragmove(e)
            // //  this.layer.draw();

        });
    }

    init() {

        super.init();

        if (this.currentLine)
            this.currentLine.init();
        this.shape = this.currentLine.shape;

        this.id = this.shape._id;
        return this;

    }

    create() {

        this.init();
        return this;
    }

    mousemove(e) {


        console.log("mouse move")

        if (this.creatingObject) {
            this.currentShape.movePosition(this.stage.getPointerPosition());
        }

    }

    //finalize the polygon
    endLoop() {

        //end the line
        this.currentLine.endLoop();

        //move to primary  layer


        this.shape.moveTo(this.finalLayer);


        //end transaction
        this.done = true;

        if (this._initTransformer)
            this._makeTransformer(this.finalLayer);


        let pos = this.suggestPointForLabel();

        this._makeLabel({
            x: pos.x,
            y: pos.y,
        }, this.shape._id);

        this.labelPosition = pos;
        if (this.label)
            this.label.moveTo(this.finalLayer);
        this.drawAllSeparate();
        this.batchDraw();
        this.finalLayer.batchDraw();
        this.lockingMechanism = false;


        this.model.points = this.shapePosition;

        this._initBinding();


    }


    onEnterPressed() {
        //if has 2 or more lines at least


        if (this.currentLine.points.length > 6 && !this.done) {
            this.endLoop();
            return true;
        } else {

            console.log("needs at least 2 points");

            return false;
        }
    }

    mouseMovingFree(e) {
        if (!this.currentLine.done) {
            this.currentLine.followCursor(e);
        }
    }

    hasTransformer() {
        return this.done;
    }

    get shapePosition() {
        return this.currentLine.pointsAxis

    }

    movePosition(pos) {


        this.currentLine.addMorePoints(pos.x, pos.y)

    }

    moveLabel(pos) {

        this.genericShape._updateLabel({
            x: pos.x,
            y: pos.y
        });


    }

    dragmove(e) {


        this._updateLabel({
            x: this.labelPosition.x * this.shape.getScaleX() + this.shape.getX(),
            y: this.labelPosition.y * this.shape.getScaleY() + this.shape.getY(),
        });

        super.dragmove(e);
    }


}
