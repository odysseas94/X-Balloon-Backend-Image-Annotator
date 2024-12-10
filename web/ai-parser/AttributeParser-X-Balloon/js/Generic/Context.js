class Context extends ObjectHandlingContext {


    constructor() {
        super();
        this._id = new Date().getTime();
        this.container = "container-" + this._id;

        this._stage = null;


        this._layer = null;

        this._midLayer = null;


        this._dragLayer = null;

        this._width = null;
        this._height = null;


        this._selectedShape = null;
        this.zoomedRatio = 1;

        this.selectedShape = master.tabHandler && master.tabHandler.shapeTabUI && master.tabHandler.shapeTabUI.current_shape ? master.tabHandler.shapeTabUI.current_shape : "rectangle";


    }

    get selectedShape() {
        return this._selectedShape;
    }

    set selectedShape(selected) {
        selected = selected.toLowerCase();
        switch (selected) {
            case "circle":
                this._selectedShape = Circle;
                break;
            case "rectangle":
                this._selectedShape = Rectangle;
                break;

            case "ellipse":
                this._selectedShape = Ellipse;
                break;
            case "polygon":
                this._selectedShape = Polygon;
                break;

            case "multi-polygon":
                this._selectedShape = MultiPolygon;
                break;
            default:
                this._selectedShape = Circle;
        }
    }


    init() {
        this._stage = this.stage;
        this._layer = this.layer;
        this._width = this.width;
        this._height = this.height;

        this._imageLayer = this.imageLayer;
        this._imageLayerZindexSet = false;


        this._layer = this.layer;
        this._dragLayer = this.dragLayer;
        this._midLayer = this.midLayer;

        master.tabHandler.regionAttributeTabUi.initList(new Map());


    }


    get imageLayer() {
        if (!this._stage)
            this._stage = this.stage;
        if (!this._imageLayer) {
            this._imageLayer = new Konva.Layer({
                listening: false,
            });


            this._stage.add(this._imageLayer);
        } else {
            if (!this._imageLayerZindexSet) {
                this._imageLayer.setZIndex(0);
                this._imageLayerZindexSet = true;
            }
        }
        return this._imageLayer;
    }

    get midLayer() {
        if (!this._stage)
            this._stage = this.stage;
        if (!this._midLayer) {
            this._midLayer = new Konva.Layer();
            this._stage.add(this._midLayer);
        }
        return this._midLayer;
    }

    get dragLayer() {
        if (!this._stage)
            this._stage = this.stage;
        if (!this._dragLayer) {
            this._dragLayer = new Konva.Layer();
            this._stage.add(this._dragLayer);
        }
        return this._dragLayer;
    }

    get stage() {
        if (!this._stage) {

            this.zoomedRatio = 1.0001;
            this._stage = new Konva.Stage({
                container: this.container,
                width: this.width,
                fill: "red",
                height: this.height,
                position: {x: this.zoomedRatio, y: this.zoomedRatio},
                scale: {x: 1.0001, y: 1.0001}
            });
        }
        return this._stage;
    }

    get width() {
        if (!this._width)
            this._width = window.innerWidth;
        return this._width;
    }

    get height() {
        if (!this._height)
            this._height = window.innerHeight;
        return this._height;
    }

    get layer() {
        if (!this._stage)
            this._stage = this.stage;
        if (!this._layer) {
            this._layer = new Konva.Layer({});


            this._stage.add(this._layer);

        }


        return this._layer;
    }
}
