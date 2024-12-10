class Model {

    constructor(name) {
        this._entityName = name;
        this._inserted = false;
        this._updated = true;
        this._deleted = false;
    }

    get attributes() {
        return {}
    }

    toMemory() {

    }

    load(object = {}) {

        for (let ob in object) {
            if (this.hasOwnProperty(ob))
                this[ob] = object[ob];
        }
        this.toMemory();
        this._inserted = true;
        this._updated = false;
        return this;
    }

    get shouldSave() {
        return this._updated;

    }
}







