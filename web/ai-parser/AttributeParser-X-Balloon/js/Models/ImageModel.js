class ImageModel extends Model {
    constructor({id = 0, name = "", path = "", thumbnail_path = "", testing_id = null, visible = 0, user_fullname = "", date_created = 0, date_updated = 0, image = "", thumbnail = ""}) {

        super("image");

        this.id = id;
        this.name = name;
        this.path = path;
        this.thumbnail_path = thumbnail_path;
        this.visible = visible;
        this.testing_id = testing_id;
        this.date_created = date_created;
        this.date_updated = date_updated;
        this.image = image;
        this.thumbnail = thumbnail;
        this.user_fullname = user_fullname;
    }


    get attributes() {

        return {


            id: this.id,
            name: this.name,
            path: this.path,
            thumbnail_path: this.thumbnail_path,
            visible: this.visible,
            testing_id:this.testing_id,
            date_created: this.date_created,
            date_updated: this.date_updated,
        }
    }
}
