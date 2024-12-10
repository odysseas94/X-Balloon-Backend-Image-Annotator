class MultiPolygon extends Shape {
    constructor(pos, context) {
        super(pos, context);
        this.defaultWidth = null;
        this.defaultHeight = null;
        this.lines = [];


        this.currentLine = new Line({
            x: this.x,
            y: this.y
        }, context);
        this.currentLine.parentClass = MultiPolygon
        this.lines.push(...this.currentLine.format);

        this.points = this.lines;
        this.lockingMechanism = true;
        this.mousemoveTouchmove = false;

        this.done = false;
        this.isFakeFirstTime = true;
        this.keyListen = true;

        this.x = null;
        this.y = null;
        this.width = null;
        this.height = null;

    }


    init() {

        super.init();
        if (this.currentLine)
            this.currentLine.init();


        this.shape = this.currentLine.shape;

        this.id = this.shape._id;
        return this;

    }


    mousemove(e) {


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


        let pos = this.suggestPointForLabel();

        this._makeLabel({
            x: pos.x,
            y: pos.y,
        }, this.shape._id);

        this.labelPosition = pos;
        if (this.label)
            this.label.moveTo(this.finalLayer);

        if (this._initTransformer)
            this._makeTransformer(this.finalLayer);
        this.drawAllSeparate();

        this.batchDraw();
        this.finalLayer.batchDraw();
        this.lockingMechanism = false;

        this.model.points = this.shapePosition;

        this._initBinding();
    }

    create() {

        this.init();
        return this;
    }


    dragmove(e) {

        this._updateLabel({
            x: this.labelPosition.x * this.shape.getScaleX() + this.shape.getX(),
            y: this.labelPosition.y * this.shape.getScaleY() + this.shape.getY(),
        });

        super.dragmove(e);
    }

    onEnterPressed() {
        //if has 2 or more lines at least

        if (this.currentLine.points.length > 20 && !this.done) {
            this.endLoop();
            return true;
        } else {


            toast.showError(translation.get("error"), translation.get("object_too_small_error"), 1000);

            console.log(this.currentLine.shape);
            this.currentLine.shape.remove();
            this.batchDraw();



            return false;
        }
    }

    mouseMovingFree(e) {
        if (!this.currentLine.done) {
            this.currentLine.followCursor(e);
            this.currentLine.addMorePoints(e.x, e.y)
        }
    }

    hasTransformer() {
        return this.done;
    }

    get shapePosition() {


        return this.currentLine.pointsAxis

    }

    mousestart(e) {


    }

    movePosition(pos) {


        this.currentLine.addMorePoints(pos.x, pos.y)

    }


}
