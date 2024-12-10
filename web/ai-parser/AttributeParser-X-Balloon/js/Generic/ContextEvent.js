class ContextEvent extends Context {
    constructor() {
        super();

        this.dragging = false;
        this.resizing = false;
        this.painting = false;
        this.mouseovering = false;
        this.transforming = false;
        this.currentImage = null;

        this.finalLayerRendered = false;
        this.currentImages = new Map();
        this.label = null;
        this.aspectRatio = 1;
        this.currentCounter = 0;
        this.cachedObjects = {
            Circle: false,
            Oval: false,
            Polygon: false,
            Rectangle: false,
            Label: false,
        };

        this.zoomedRatio = 1;
        this.creatingObject = false;


    }

    init(height, width, callback = () => {
    }) {

        this._height = height;
        this._width = width;
        super.init();
        this.bindEvents();
        callback();
    }

    addImage(stageImage) {
        this.currentImage = stageImage;
        this.aspectRatio = stageImage.imageLoaded.aspect;
        this.currentImages[stageImage.imageLoaded.name] = stageImage;
        this.imageLayer.add(stageImage.konvaImage);
        this.imageLayer.draw();

    }


    isReadyToPaint(e) {


        return this.transforming || this.painting || this.dragging || this.resizing || this.mouseovering
            || (this.currentObject && !this.currentObject.lockingMechanism && this.layer.getAllIntersections(e).length > 0);
    }

    findShape(e) {

        let target = e.target;
        if (target.parent && !(target.parent instanceof Konva.Transformer)) {
            return target;
        } else {
            return null;
        }

    }


    findTransformer(e, object) {


        let transformers = this.stage.find("Transformer");

        for (let ob in transformers) {
            let transformer = transformers[ob];

            if (transformer._id && transformer.node()._id === object._id) {

                return transformer;
            }
        }
        return null;

    }


    removeAllTransformers(e, selectedTransformer) {
        if (selectedTransformer) {

            let transformers = this.stage.find('Transformer');

            for (let ob in transformers) {
                let transformer = transformers[ob];


                if (transformer instanceof Konva.Transformer && selectedTransformer._id !== transformer._id) {
                    transformer.destroy();
                }
            }

        } else {


            this.stage.find('Transformer').destroy();

        }


    }

    addTransformer() {

        return this.currentObject._makeTransformer(this.layer);
    }

    setCurrentObjectTransformer(e) {
        let current_object = this.findShape(e);

        let transformer = null;
        if (current_object) {
            transformer = this.findTransformer(e, current_object);
        } else return;


        if (!transformer) {
            this.removeAllTransformers(e);

            if (this.currentObject.hasTransformer()) {
                transformer = this.addTransformer(current_object);
                this.layer.batchDraw();
            }


        }

    }

    bindEvents() {
        let stage = this.stage;
        let layer = this.layer;
        let self = this;
        let container = stage.container();
        container.tabIndex = 1;
        let scaleBy = 1.08;


        //zoom in zoom out
        stage.on('wheel', e => {
            e.evt.preventDefault();
            let oldScale = stage.scaleX();

            let mousePointTo = {
                x: stage.getPointerPosition().x / oldScale - stage.x() / oldScale,
                y: stage.getPointerPosition().y / oldScale - stage.y() / oldScale
            };

            let newScale =
                e.evt.deltaY < 0 ? oldScale * scaleBy : oldScale / scaleBy;
            //prevent from drawing elsewhere where zoom is 1 and position is not 0,0
            // 1/6 =0.16
            if (newScale === 1) {
                newScale = 1.0001
            } else if (newScale < 0.16 && e.evt.deltaY > 0) {

                this.zoomedRatio = 1;
                stage.scale({x: 1, y: 1});
                stage.position({x: 0, y: 0});
                this.onZoom();
                stage.batchDraw();

                return;
            }

            stage.scale({x: newScale, y: newScale});

            let newPos = {
                x:
                    -(mousePointTo.x - stage.getPointerPosition().x / newScale) *
                    newScale,
                y:
                    -(mousePointTo.y - stage.getPointerPosition().y / newScale) *
                    newScale
            };


            this.zoomedRatio = newScale;


            stage.position(newPos);
            this.onZoom();
            stage.batchDraw();
        });
        layer.on("mouseover", function (e) {

            // console.log("mouse over");
            self.mouseovering = true;
        });

        stage.on("mousemove", function (e) {
            //  console.log("mousemove")
            self.mouseMovingFree(e)

        });

        container.addEventListener("keydown", function (e) {
            self.keypressed(e);
        });

        layer.on("mouseout", function (e) {
            //   console.log("mouse out");
            self.mouseovering = false;
        });


        layer.on('dragstart', function (evt) {
            //       console.log("dragging start")
            self.dragging = true;
            self.dragstart(evt);
        });

        stage.on('dragmove', function (evt) {

            self.dragmove(evt);
        });
        //
        stage.on('dragend', function (evt) {
            //  console.log("dragging end")
            self.dragging = false;
            //     self.dragend(evt);
        });


        stage.on('mousedown', function (e) {

            if (e.evt.button === 0) {

                self._paintObject(e)
            }


        });

        stage.on('mouseup touchend', function (e) {


            if (!self.finalLayerRendered)
                self.mouseend(e);
            self.painting = false;

        });


        self.transformPoint = (stage) => {
            const transform = stage.getAbsoluteTransform().copy();
            transform.invert();
            const pos = stage.getPointerPosition();
            return transform.point(pos);
        };

        //and core function - drawing // on mouse pressed( drag and make shape bigger);
        stage.on('mousemove touchmove', function (e) {


            if (self.currentObject && self.currentObject.mousemoveTouchmove && !self.currentObject.lockingMechanism)
                self.mousemove(e)


        });
        stage.on('mousedown touchmove', function (e) {


//left click


        });
        stage.on('mouseup', function (e) {


            if (e.evt.button === 0 && self.currentObject && !self.currentObject.done && self.currentObject instanceof MultiPolygon) {

                self.keypressed(null, {button: 2});
            }

            self.creatingObject = false;

            self.mousetouchend(e);


        });
    }

    _paintObject(e) {


        let position = this.pointerPosition;
        let self = this;


        if (this.currentObject && this.currentObject.lockingMechanism && !this.currentObject.final_form) {
            return this.currentObject.movePosition(position)
        }


        let leftClick = e.evt.button === 0;
        if (!leftClick) return;


        let target = e.target;

        if (target._id && self.currentObjects[target._id]) {

            self.currentObject = self.currentObjects[target._id];
            if (!self.currentObject.shape.getDraggable())
                self.currentObject.shape.draggable(true);


        } else {
            self.currentObject = null;
        }


        if (self.isReadyToPaint(position)) {


            self.creatingObject = false;
            self.setCurrentObjectTransformer(e);

            return false;
        } else
            self.removeAllTransformers(e);

        self.painting = true;
        self.finalLayerRendered = false;
        self.creatingObject = true;


        self.mouseup(e);

    }


    setCursorGrab() {
        document.body.style.cursor = 'grabbing';
    }


    setCursorInitial() {
        document.body.style.cursor = 'initial';
    }


    //right click on hold make it drag
    onRightClickStart(addX, addY) {
        let pos = {
            x: this.stage.getPosition().x + addX,
            y: this.stage.getPosition().y + addY
        };


        if (this.zoomedRatio === 1) {
            this.zoomedRatio = 1.0001;


            this.stage.scale({x: this.zoomedRatio, y: this.zoomedRatio});
        }


        // if (pos.x + this._width > this._width || this._width * this.zoomedRatio + pos.x < this._width)
        //     pos.x = this.stage.getPosition().x;
        // if (pos.y + this._height > this._height || this._height * this.zoomedRatio + pos.y < this._height)
        //     pos.y = this.stage.getPosition().y;


        this.stage.position(pos);


        this.stage.batchDraw();


    }

    onRightClickEnd() {
        this.setCursorInitial();
    }

    onZoom() {


        //resize only label on canvas
        let labels = this.stage.find("Label");
        for (let index = 0; index < labels.length; index++) {

            let label = labels[index];

            label.scale(this.onZoomScaling());
        }
    }

    onZoomScaling() {
        return {x: 1 / this.zoomedRatio, y: 1 / this.zoomedRatio}
    }

    initializeParams() {
        this.currentObject = null;
        this.painting = false;
        this.dragging = false;
        this.resizing = false;
        this.mouseovering = false;
        this.transforming = false;
    }

    mouseup(e, force = false) {


        let pos = this.pointerPosition;

        if (pos.x > this.width || pos.x < 0 || pos.y > this.height || pos.y < 0) {
            return console.log("out of bounds ");
        }


        let shape = new this.selectedShape(pos, this).create();


        if (!shape.lockingMechanism)
            this.setCurrentObjects(shape);


        this.currentObject = shape;


    }

    keypressed(e, clickEvent) {


        if (this.currentObject && this.currentObject.keyListen) {
            //enter=
            if ((e && e.keyCode === 13) || (clickEvent && clickEvent.button === 2)) {

                if (this.currentObject.onEnterPressed()) {
                    this.setCurrentObjects(this.currentObject);
                } else {


                    this.currentObject = null;
                }

            }


        }
        //delete button 46
        //backspace button 8
        if ((e && (e.keyCode === 46 || e.keyCode === 8)) && this.currentObject) {
            console.log(this.currentObject, this.currentObjects[this.currentObject.id])
            this._removeObject();

        } else if ((e) && (e.keyCode === 49 || e.keyCode === 50)) {

            if (master?.tabHandler?.classificationTabUI) {
                if (e.keyCode === 49)
                    master?.tabHandler?.classificationTabUI.changeClassification(-1)
                else
                    master?.tabHandler?.classificationTabUI.changeClassification(+1)
                console.log(e.keyCode);
            }
        }

    }

//delete object
    _removeObject(currentObject) {
        currentObject = currentObject ? currentObject : this.currentObject;
        if (currentObject && this.currentObjects[currentObject.id]) {
            this.removeCurrentObject(currentObject);
            currentObject.delete();
            this.initializeParams();


        }
    }


// on rectange to follow mouse
    mouseMovingFree(e) {

        if (this.currentObject && this.currentObject.lockingMechanism) {
            this.currentObject.mouseMovingFree(this.pointerPosition)
        }
    }

    mousestart(e) {

    }


    //on end of the click
    mouseend(e) {


        if (this.currentObject && !this.currentObject.lockingMechanism) {

            if (this.currentObject.addToFinalLayer())
                this.finalLayerRendered = true;


        }

    }

    mousetouchend(e) {

    }


    //on mouse move ( to paint multipolygon)
    mousemove(e) {

        if (this.currentObject && (this.creatingObject || this.currentObject.lockingMechanism)) {
            this.currentObject.movePosition(this.pointerPosition);
        }
    }

    dragstart(e) {
        this.dragmove(e)
    }

    dragend(e) {
    }


    //to drag the objects
    dragmove(e) {


        if (this.currentObject) {

            this.currentObject.dragmove(this.stage.getPointerPosition());

        }
    }


    transformstart(e) {
    }

    transformend(e) {
    };

    transform(e) {
    }

    get isZoomed() {
        return this.zoomedRatio === 1 ? false : true;
    }

    get pointerPosition() {

        let position = null;
        if (this.isZoomed)
            position = this.transformPoint(this.stage);
        else position = this.stage.getPointerPosition();

        if (position.x > this.width)
            position.x = this._width;
        else if (position.x < 0)
            position.x = 0;

        if (position.y > this._height)
            position.y = this._height;
        else if (position.y < 0)
            position.y = 0;

        return position;


    }
}
