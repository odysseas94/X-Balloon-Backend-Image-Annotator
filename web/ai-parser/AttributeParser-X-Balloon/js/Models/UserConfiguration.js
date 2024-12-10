class UserConfiguration extends Model {


    constructor({user_id = 0, language_id = 0, attribute_parser_image_id = null,image_testing_id=null, date_created = 0, date_updated = 0}) {
        super("user_configuration");
        this.user_id = user_id;
        this.language_id = language_id;
        this.attribute_parser_image_id = attribute_parser_image_id;
        this.image_testing_id=image_testing_id;
        this.date_created = date_created;
        this.date_updated = date_updated;
        if (this.user_id) {
            this.toMemory();
        }

    }


    toMemory() {
        master.userConfiguration = this;
    }


    get attributes() {
        return {
            user_id: this.user_id,
            language_id: this.language_id,
            attribute_parser_image_id: this.attribute_parser_image_id,
            image_testing_id: this.image_testing_id,
            date_created: this.date_created,
            date_updated: this.date_updated

        }
    }


}