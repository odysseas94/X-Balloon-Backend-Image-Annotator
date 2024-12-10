class ObjectHandlingContext {
    constructor() {
        this._currentObjects = new Map();
        this._currentObject = null;

        this.deletedModels = new Map();
        this.isPreload = false;


        this.collectDataShapes = new CollectDataShapes(this, this.updateModelsIds)


    }


    updateModelsIds(data) {


    }


    clearDeletedModels() {
        this.deletedModels = new Map();
    }


    removeSingleDeletedModel(id) {
        if (this.deletedModels[id]) {
            delete this.deletedModels[id];
            return true;
        }

        return false;
    }

    set currentObject(currentObject) {
        this._currentObject = currentObject

        if (currentObject && currentObject.id) {

            master.tabHandler.regionAttributeTabUi.scrollTo(currentObject.id);
        }

    }


    removeCurrentObject(currentObject) {
        let model = currentObject.model;
        if (model.id) {
            model._deleted = true;
            model.deleted = 1;
            this.deletedModels[model.id] = model;


        }

        this.onCurrentObjectMoveEvent();
        master.tabHandler.regionAttributeTabUi.removeFromList(currentObject)
        delete this._currentObjects[currentObject.id];


    }

    setCurrentObjects(currentObject) {


        this._currentObjects[currentObject.id] = currentObject;
        if (!this.isPreload) {
            master.tabHandler.regionAttributeTabUi.appendToList(currentObject)
            this.onCurrentObjectMoveEvent();
        }


    }

    onCurrentObjectMoveEvent() {

        this.collectDataShapes.checkJob();

    }

    get currentObjects() {
        return this._currentObjects;
    }


    get currentObject() {
        return this._currentObject;
    }


    preRegisteredShapes(models) {
        this.isPreload = true;

        if (models instanceof Array && models.length) {
            for (let ob in models) {
                let modelShape = models[ob];
                if (modelShape instanceof ModelShape) {


                    let instance = new (modelShape.shapeObject)(null, this).preLoad(modelShape);
                    if (instance)
                        this.setCurrentObjects(instance)
                }
            }


        }
        //add to menu region
        master.tabHandler.regionAttributeTabUi.initList(this.currentObjects)

        this.isPreload = false;
    }


}

