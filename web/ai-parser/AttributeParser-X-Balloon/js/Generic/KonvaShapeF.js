class KonvaShapeF extends KonvaFEvent {
    constructor(pos = null, context) {
        super(context);

        this.pos = pos;
        this.currentColor = master.tabHandler.classificationTabUI.classificationColor;

        this.classificationId = master.tabHandler.classificationTabUI.classificationId;
        this.anchorSize = 4;
        this.group = null;
        this.scaleY = 1;
        this.scaleX = 1;
        this.radiusX = null;
        //make area not showing


        this.radiusY = null;
        this.points = [];
        this.labelName = "";
        this.genericShape = null;
        this.old_position = pos;
        this.rotateEnabled = false;

        this.defaultHeight = 20;
        this.defaultWidth = 20;
        this.ignoreStroke = true;
        this.shadowBlur = null;

        this.x = 0;
        this.y = 0;
        this.width = this.defaultWidth;
        this.height = this.defaultHeight;
        this.radius = null;
        this.draggable = true;
        this.strokeWidth = 2;
        this.opacity = 0.5;


        this.shadowBlur = 0;
        this.shadowOffset = {
            x: 0,
            y: 0
        };
        this.shadowOpacity = 0;

        this.konvaConfig = null;
        this.id = null;

        this.enabledAnchors = null;
        this.perfectDrawEnabled = false;

        this.positionCreated = null;
        this.currentCounter = 0;
        this.global_scale = this.context.aspectRatio;
        if (this.pos) {
            this.x = this.pos.x;
            this.y = this.pos.y;
        }


    }


    config() {
        this.fill = this.fill ? this.fill : this.currentColor;
        this.stroke = this.stroke ? this.stroke : "black";

        this.shadowColor = this.shadowColor ? this.shadowColor : "black";

        this.konvaConfig = {
            x: this.x,
            y: this.y,
            width: this.defaultWidth === this.width ? this.defaultWidth : this.width,
            height: this.defaultHeight === this.height ? this.defaultHeight : this.height,
            radius: this.radius,
            scaleY: this.scaleY,
            scaleX: this.scaleX,
            radiusX: this.radiusX,
            radiusY: this.radiusY,
            points: this.points,
            draggable: this.draggable,
            fill: this.fill,
            listening: this.listening,
            opacity: this.opacity,
            stroke: this.stroke,
            ignoreStroke: this.ignoreStroke,
            strokeWidth: this.strokeWidth,
            strokeScaleEnabled: false,
            perfectDrawEnabled: this.perfectDrawEnabled,
            shadowForStrokeEnabled: false,

            shadowColor: this.shadowColor,
            shadowBlur: this.shadowBlur,
            shadowOffset: this.shadowOffset,
            shadowOpacity: this.shadowOpacity,

        };

        this.positionCreated = this.pos;
    }

    create() {


        this.init();

        this._initBinding();
        return this;
    }


    createInstances() {

    }

    movePosition(pos) {
        this.pos = pos;
    }

    moveLabel(pos) {

    }

    addToFinalLayer() {

    }

    init() {


        this.layer = this.context.midLayer;
        this.finalLayer = this.context.layer;


        this.currentCounter = this.context.currentCounter;
        this.cachedObjects = this.context.cachedObjects;

        this.listening = master.models.classifications[this.classificationId].visible === "true";

        this.config();

        this.createInstances();


    }


    removeCurrentInstance() {
        if (this.shape) {
            this.shape.remove();
            if (this.transformer)
                this.transformer.remove();
            runtime.contextPlan.layer.draw();

        }
    }


    _makeLabel(pos, name) {
        this.currentCounter = ++this.context.currentCounter;
        name = name.toString();

        let text = this.currentCounter;
        this.labelName = text;
        this.label = new Konva.Label({
            x: pos.x,
            y: pos.y,
            opacity: 0.75,
            name: name,
            scale: this.context.onZoomScaling(),
            strokeScaleEnabled: false,
            listening: false,
        });

        this.label.add(
            new Konva.Tag({
                fill: 'black',
                pointerDirection: 'down',
                pointerWidth: 5,
                pointerHeight: 5,
                lineJoin: 'round',
                shadowColor: 'black',
                shadowBlur: 10,
                shadowOffset: 10,
                shadowOpacity: 0.5,
                strokeScaleEnabled: false,
                listening: false,
            })
        );

        this.label.add(
            new Konva.Text({
                text: text + '',
                fontFamily: 'Calibri',
                fontSize: 16,
                padding: 1,
                fill: 'white',
                strokeScaleEnabled: false,
                listening: false,
            })
        );

        if (!this.cachedObjects.Label) {
            this.label.cache();
            this.cachedObjects.Label = true;
        }

        return this.label;
    }


    _updateLabel(pos) {
        if (this.label)
            this.label.position(pos);


    }

    _makeTransformer(layer = null) {

        if (!layer)
            layer = this.layer;
        if (!this.transformer || !this._findTransformer()) {


            let transformer = new Konva.Transformer({

                ignoreStroke: true,
                anchorSize: this.anchorSize,
                rotateEnabled: this.rotateEnabled,
                enabledAnchors: this.enabledAnchors,

            });


            layer.add(transformer);

            transformer.nodes([this.shape]);


            this.transformer = transformer;


            this._bindTransformerEvents(() => {

                this._onTransformShape()
            });
        } else {

            this.transformer.forceUpdate();
        }
        return this.transformer;
    }


    _findTransformer() {
        let transformers = this.context.stage.find("Transformer");
        if (!this.transformer) return null;
        for (let ob in transformers) {
            let transformer = transformers[ob];
            if (this.transformer._id === transformer._id) {
                return this.transformer;
            }
        }
        return null;
    }


    get shapePosition() {

        return [];
    }


}
