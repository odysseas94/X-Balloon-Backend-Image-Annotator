class Shape extends KonvaShapeF {


    constructor(pos, context) {

        super(pos, context);
        this.shape_name = this.getClassName();


        this.creation = true;
        this.currentLine = null;
        this.labelOffset = 5;
        console.log(this.classificationId);

        this.lockingMechanism = false;
        this.keyListen = false;
        this.mousemoveTouchmove = true;
        this.labelPosition = {};
        this.final_form = false;
        this._initTransformer = true;

    }


    hasTransformer() {
        return true;
    }

    getClassName() {
        return this.constructor.name.toLowerCase();
    }

    bindEvents() {


        this._onDragEnd(() => {
            this.updateModel();
            this.context.onCurrentObjectMoveEvent();
            console.log("on drag end");

        });

    }

    _onTransformShape(callback = () => {
    }) {

        this.updateModel();
        this.context.onCurrentObjectMoveEvent();
        console.log("on transformed");
    }

    init() {


        super.init();
    }


    onEnterPressed() {
        console.log("enter pressed");
    }

    addToLayer(object) {
        if (object)
            this.layer.add(object);
    }

    addToFinalLayer() {




        if (this.final_form) return false;


        if (this.shape)
            this.shape.moveTo(this.finalLayer);
        if (this.transformer)
            this.transformer.moveTo(this.finalLayer);
        if (this.label) {
            this.label.moveTo(this.finalLayer);
        }
        this.layer.batchDraw();
        this.finalLayer.batchDraw();

        this.final_form = true;
        // create model since its last layer and should change on delete, update now
        this.model;

        this.bindEvents();

        return true;

    }

    draw() {

        this.shape.draw();
    }


    drawAllSeparate() {

        if (this.shape)
            this.shape.draw();
        if (this.label)
            this.label.draw();
        if (this.transformer)
            this.transformer.draw();

    }


    endLoop() {

    }

    batchDraw() {
        this.layer.batchDraw();
    }

    movePosition(pos) {
        this.layer.batchDraw();
        this.updateModel();
        this.context.onCurrentObjectMoveEvent();
    }

    get shapePosition() {
        let points = this.shape.getPosition();
        let result = [];
        let scaleX = this.shape.scaleX();
        let scaleY = this.shape.scaleY();
        for (let i = 0; i < points.length; i++) {
            let singleAxis = 0;
            if (i % 2 === 0) {
                singleAxis = this.global_scale * scaleX * points[i];
            } else
                singleAxis = this.global_scale * scaleY * points[i];
            result.push(singleAxis)

        }
        return result;

    }

    delete() {
        if (this.shape)
            this.shape.remove();
        if (this.transformer)
            this.transformer.remove();
        if (this.label)
            this.label.remove();
        this.finalLayer.batchDraw();
    }

    suggestPointForLabel() {

        let points = this.shape.points();
        let pos = {x: 0, y: 0};
        if (points.length > 4) {

            pos = {x: points[0], y: points[1]};
            for (let i = 3; i < points.length; i += 2) {

                let singleAxis = points[i];

                if (singleAxis < pos.y) {
                    pos.y = points[i];
                    pos.x = points[i - 1];
                }

            }
        }


        return pos;

    }


    get shapeId() {
        let models = master.models.shape_types;
        for (let ob in models) {
            let model = models[ob];

            if (this.shape_name === model.name)
                return model.id;
        }
        throw new Error("model not found ");

    }


    set model(model) {
        this._model = model;
    }

    updateModel() {

        if (this.model) {


            this._model.points = this.shapePosition;
            this._model.calculateArea(this.context.aspectRatio)


            if (this._model.id) {


                this._model._updated = true;

            }


        }
        console.log("update model" + this._model)

    }


    onPreload(modelShape) {
        let points = this.points;


        if (this instanceof MultiPolygon || this instanceof Polygon) {


            this.x = null;
            this.y = null;

            this.currentLine.is_preloaded = true;
            this.currentLine.currentColor = this.currentColor;
            this.currentLine.classificationId = this.classificationId;
            this.currentLine.points = points;


            this._model = modelShape;

            this._initTransformer = false;
            this.final_form = true;
            this.create();


            this.endLoop();
            this.bindEvents();

        }

    }


    get model() {


        if (!this._model) {
            return this.createModel();
        }


        return this._model;
    }

    createModel() {


        this._model = new ModelShape({
            id: null,
            points: this.shapePosition,
            shape_type_id: this.shapeId,
            class_id: this.classificationId
        });
        this._model.calculateArea(this.context.aspectRatio);
        return this._model;

    }

    preLoad(modelShape) {


        if (modelShape instanceof ModelShape && modelShape.points instanceof Object) {

            //is multipolygon and polygon

            this.classificationId = modelShape.class_id;
            this.currentColor = modelShape.classification.color;
            this.draggable = false;
            this.points = [];

            if (Array.isArray(modelShape.points)) {

                //data is like [{x,y},{x,y}]


                for (let ob in modelShape.points) {

                    let object = modelShape.points[ob];
                    this.points.push(object.x / this.global_scale, object.y / this.global_scale);


                }


                this.onPreload(modelShape);


            }
            //all other shapes
            else {


                let points = modelShape.points;
                for (let ob in points) {
                    if (this.hasOwnProperty(ob)) {

                        //in order to bring it to the currentScreen;
                        this[ob] = points[ob] / this.global_scale;
                        console.log(ob, this[ob], this.global_scale);
                    }
                }
                this.pos = {
                    x: this.x,
                    y: this.y
                };

                this._initTransformer = false;
                this._model = modelShape;
                this.create();


                this.addToFinalLayer();

            }


        }

        return this;

    }


    updateClassificationId(id) {

        let classification = master.models.classifications[id];
        if (classification) {


            this.classificationId = id;

            if (master.models.classifications[this.classificationId].visible === "true") {
                this.shape.listening(true);
            } else
                this.shape.listening(false);
            this.currentColor = this.fill = classification.color;
            this._model.class_id = id;
            this.shape.fill(this.fill);
            this.updateModel();

            this.context.onCurrentObjectMoveEvent();
            this.finalLayer.batchDraw();

        }
    }


}



