class ClassificationModel extends Model {
    constructor({id, name, pretty_name, date_created, date_updated, visible = "", color = ""}) {
        super("classification");

        this.id = id;
        this.name = name;
        this.pretty_name = pretty_name;
        this.visible = visible;
        this.date_created = date_created;
        this.date_updated = date_updated;
        this.color = color;
        if (id)
            this.toMemory();

    }

    toMemory() {
        master.models.classifications[this.id] = this;
    }


    get attributes() {

        return {


            id: this.id,
            name: this.name,
            pretty_name: this.pretty_name,
            color: this.color,
            visible: this.visible,
            date_created: this.date_created,
            date_updated: this.date_updated,
        }
    }
}
