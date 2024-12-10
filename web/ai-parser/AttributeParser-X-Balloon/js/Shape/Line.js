class Line extends KonvaShapeF {
    constructor({
                    x = 0,
                    y = 0
                }, context) {
        super({x: x, y: y}, context);

        this.points = [x, y, x, y];
        this.shape = null;

        this.x = null;
        this.y = null;
        this.width = null;
        this.height = null;

        this.draggable = false;
        this.is_preloaded = false;


        this.done = false;
        this.parentClass = null;


    }

    create() {
        this.init();
        return this;
    }

    addMorePoints(x, y) {
        this.points.push(...[x, y]);

        // console.log(this.points)
    }

    round(number, precision = 100) {
        return Math.round(number * precision) / precision;
    }

    init() {
        super.init();

        this.shape = new Konva.Line(this.konvaConfig);


        this.context.midLayer.add(this.shape);
        this.context.midLayer.batchDraw();

    }


    followCursor(cursor) {

        //console.log("follow cursor",this.points)
        let length = this.points.length;

        this.points[length - 2] = cursor.x;
        this.points[length - 1] = cursor.y;

        this.shape.points(this.format);
        this.context.midLayer.draw();

    }


    get format() {
        return this.points;
    }

    get pointsAxis() {
        let result = [];
        let points = this.shape.points();

        let x = this.shape.getX();
        let y = this.shape.getY();

        for (let i = 0; i <= points.length - 1; i++) {


            if (i % 2 === 0) {


                result.push({
                    x: this.round((points[i] * this.shape.getScaleX() + x) * this.global_scale),
                    y: this.round((points[i + 1] * this.shape.getScaleY() + y) * this.global_scale)
                })
            }
        }
        return result;
    }

    addToFinalLayer() {
        console.error("add to final layer")
        super.addToFinalLayer();
    }

    endLoop() {
        let length = this.points.length;
        if (!this.is_preloaded) {


            this.points.splice(length - 1);
            this.points.splice(length - 2);
        }
        this.removeUnnecessaryPoints();
        this.shape.points(this.format);
        this.shape.setClosed(true);

        this.shape.setDraggable(true);
        this.shape.draw();
        this._initBinding();


    }

    removeUnnecessaryPoints() {

        if (!this.is_preloaded && this.parentClass === MultiPolygon) {
            // let points = [];
            // for (let index = 0; index < this.points.length - 1; index += 2) {
            //     points.push(...[this.points[index], this.points[index + 1]])
            // }
            this.points = this.bestRouting();
            console.log(this.points)
        }

    }


    bestRouting() {
        let result = [];
        result.push(...[this.round(this.points[0], 10), this.round(this.points[1], 10)]);
        let equals = (number1, number2) => {
            let result = Math.abs(number1 - number2);
            let ratio = (this.context.aspectRatio * this.context.zoomedRatio) / 1.70;


            return number1 === number2;


        }


        for (let index = 2; index < this.points.length - 3; index += 2) {

            let point = {x: this.round(this.points[index], 10), y: this.round(this.points[index + 1], 10)};
            let previous_point = {x: this.round(this.points[index - 2], 10), y: this.round(this.points[index - 1], 10)};
            let next_point = {x: this.round(this.points[index + 2], 10), y: this.round(this.points[index + 3], 10)};


            if (equals(point.x, next_point.x) && equals(point.x, previous_point.x))
                if (equals(point.y, next_point.y) && equals(point.y, previous_point.y))
                    continue;
            result.push(...[point.x, point.y]);


        }
        result.push(...[this.round(this.points[this.points.length - 2], 10), this.round(this.points[this.points.length - 1], 10)]);
        return result;

    }


}
