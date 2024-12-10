class CollectDataShapes {
    constructor(tab, callback = () => {
    }) {
        this.callback = callback instanceof Function ? callback : () => {
        };

        this.tab = tab;

        this.job_inited = false;
        this.job_id = new Date().getTime();
        this.deletedModels = new Map();


    }

    callableObject() {
        return {}
    }


    checkJob() {


        let data = this.allData;
        let self = this;
        if (data.length && !this.job_inited) {
            master.jobsToDo.push(SaveShapesService, Object.assign({}, this.attributesParsed), (res) => {
                if (res) {
                    this.job_inited = false;
                    this.updateAllDataToSaved(res, data);
                    if (self.tab.currentImage.model && self.tab.currentImage.model.name) {
                        //toast.showSuccess(translation.get("upload_shape"), translation.get("shape_uploaded") + self.tab.currentImage.model.name);
                    }
                }
            }, this.job_id);
            this.job_inited = true;
        } else if (!data.length && this.job_inited) {

            master.jobsToDo.popJobById(this.job_id);
            this.job_inited = false;
        }
    }

    get allData() {

        let result = [];
        let shapes = this.tab.currentObjects;
        for (let ob in shapes) {
            let shape = shapes[ob];
            if (shape.model.shouldSave) {
                let attributes = shape.model.attributes;
                attributes._shape_id = shape.id;
                result.push(attributes);
            }
        }
        for (let ob in this.tab.deletedModels) {
            let model = this.tab.deletedModels[ob];
            result.push(model.attributes);

        }
        return result;
    }

    get modelMap() {
        let shapes = this.tab.currentObjects;
        let result = new Map();
        for (let ob in shapes) {
            let shape = shapes[ob];
            if (shape.model.shouldSave)
                result[shape.model._id] = shape.model;
        }
        for (let ob in this.tab.deletedModels) {
            let model = this.tab.deletedModels[ob];
            result[model._id] = model;

        }
        return result;
    }


    updateAllDataToSaved(result, data) {
        if (result) {
            for (let ob in data) {
                let model = data[ob];

                if (this.tab.deletedModels[model.id])
                    this.tab.removeSingleDeletedModel(model.id)
                else if (model._shape_id) {
                    for (let ob in result) {
                        let incoming_model = result[ob];
                        if (Number(ob) === model._id) {

                            if(this.tab.currentObjects[model._shape_id]) {
                                let currentModel = this.tab.currentObjects[model._shape_id]._model;
                                currentModel.id = Number(incoming_model.id);
                                currentModel._updated = false;
                                break;
                            }

                        }
                    }
                }
            }
        }
        //if previous job didnt clean them all recursive callback

        if (this.allData.length)
            this.checkJob();


    }

    get attributesParsed() {
        let data = this.allData;
        return {
            image: this.tab.currentImage.model ? this.tab.currentImage.model.attributes : null,
            shapes: data
        }
    }


}
