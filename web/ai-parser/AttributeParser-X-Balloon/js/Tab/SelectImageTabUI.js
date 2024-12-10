class SelectImageTabUI extends TabUI {


    constructor(props) {
        super(props);

        this.parentNode = ".select-image-parent";
        this.childNode = ".select-image-modal-content";
        this.images = new Map();

        this.images_array = [];

        this.upload_files = [];


        this.modal = null;


    }

    beforeRedirect(callback = () => {
    }) {

        new ReceiveImagesService(null, (data, images_array) => {


            if (data && data instanceof Map) {
                this.images = data;
                this.images_array = images_array;

            }


            return callback();
        });


    }


    content() {

        let images_str = "";

        for (let ob in this.images_array) {
            let image = this.images_array[ob];
            let testing_str = "data-testing= ''";
            if (image.testing_id) {
                testing_str = "data-testing= '" + image.testing_id + "' ";
            }
            images_str += "<li data-name='" + image.name + "' class=\"btn list-group-item d-flex justify-content-between align-items-center\">\n" +
                "<div class='row image-info align-items-center'>" +
                "   <div class='col-4 user_fullname'>" + image.user_fullname + "</div>  " +
                "           <div class='col-4 text'>" + image.name + "</div> \n" +
                "          <div class=\"image-parent col-4\">\n" +
                "              <img " + testing_str + " data-id='" + image.id + "'  src=\"" + image.thumbnail + "\" class=\"img-fluid thumbnail\" alt=\"lay\"></div> </div>\n" +
                "        </li>\n";
        }


        let str = "\
        <div class='row'>\
             <div class='col-12'>\
        " +
            "  <div class=\"form-group has-search\">\n" +
            "    <span class=\"fa fa-search form-control-feedback\"></span>\n" +
            "    <input type=\"text\" class=\"form-control filter-search\" placeholder='" + translation.get("search") + "'>\n" +
            "  </div>\n" +
            "  " +
            "</div></div>" +
            "<div class='row'>" +
            "<div class='col-12'>" +

            "\n<div class=\"select-image-modal-content p-1\">" +
            "            <ul class='padding-0'>\n" +
            "               <div class='upload-image-parent full-width '>\n" +
            "        <li class=\"d-flex justify-content-between choose-button-parent align-items-center\">" +
            "<input class='hidden' type=\"file\"\n" +
            "                                                                id=\"select-image\" name=\"select-image\"\n" +
            "                                                                accept=\"image/png, image/jpeg\">\n" +
            "                    <a href=\"#\" class='btn btn-primary button-choose-image full-width' title=\"" + translation.get("pick_image") + "\">"
            + translation.get("pick_image") +
            "                    </a>" +
            "\n" +
            "                </li></div>\n" +
            "<div class='new-uploads-parent'>" +
            "</div>\n" +
            "                <li class=\"dropdown-header\">" + translation.get("previous_images") + "</li>\n" +
            "        <div class='previous-images-parent'>" + images_str +
            "            </ul>\n" +
            "        </div></div></div></div>";


        this.modal = new Modal({

            title: translation.get("choose_image"),
            body: str

        }).init();


        return " <button type=\"button\" class=\"btn btn-primary open-modal\"  aria-haspopup=\"true\"\n" +
            "                   aria-expanded=\"false\">\n" +
            "               <span class='text-dropdown'>" + translation.get("choose_image") + "</span>  " +
            "            </button>\n";

    }

    appendNewUploads(file) {

        let id = master.currentImageTab._id;
        if (!this.upload_files.length) {
            $(this.parentNode + " .new-uploads-parent").append("<li class=\"dropdown-header\">" + translation.get("new_images") + "</li>\n");
        }

        this.upload_files.push(file);
        let str = "<li data-container='" + master.currentImageTab.container + "' data-id='" + id + "' data-name='" + file.name + "' class=\"btn list-group-item d-flex justify-content-between align-items-center\">\n" +
            "<div class='row text-left w-100 align-items-center'>"
            + "  <div class='col-4 user_fullname'> " + this.iAppender + master.user.fullname + "</div>" +
            "  <div class='col-4 text'> " + file.name + "</div>" +
            "    <div class=\"image-parent col-4\">\n" +
            "              <img src=\"" + file.src + "\" class=\"img-fluid thumbnail\" alt=\"lay\">" +
            "   </div></div>\n" +
            "        </li>\n";

        console.log(str);

        $(this.childNode + " .new-uploads-parent").append(str);
        let $li = $(this.childNode + " ul li[data-id='" + id + "']");
        this.setActiveClass($li);
        return $li;

    }

    get iAppender() {
        return "<i class=\"far fa-object-ungroup\"></i> ";
    }

    setActiveClass($node) {
        $(this.childNode + " li.active").removeClass("active");
        $(this.parentNode + " .text-dropdown").html($node.find(".text").text());
        $node.addClass("active");
    }


    initOldContextTab($self, model) {
        // first receive shapes then show it canvas.
        let self = this;
        new ReceiveShapesPerImageService(model, (shapesModels) => {


            let imageLoaded = new ImageLoaded(model.image, function (reference) {
                let stageImage = new StageImage(reference, model);
                stageImage.shapes = shapesModels;
                stageImage.init();

                $self.attr("data-container", master.currentImageTab.container).attr("data-id", master.currentImageTab._id);
                $self.find(".image-info .user_fullname").prepend(self.iAppender);
            });
        }).init();
    }

    onChangeImage(image_id, container, $self, container_id) {
        //if its loaded into dom

        let model = this.images[image_id];

        if (container_id && container) {
            master.setCurrentTabActive(master.imageTabs[container_id]);
            master.tabHandler.regionAttributeTabUi.initList(master.currentImageTab.currentObjects)

        } else {
            // if its an not loaded image


            this.initOldContextTab($self, model);
        }

        if (!master.userConfiguration) {
            new UserConfiguration({
                user_id: master.user.id,
                attribute_parser_image_id: model.id,
                image_testing_id: model.testing_id,
                date_created: null,
                date_updated: null,
            });
        } else {
            master.userConfiguration.attribute_parser_image_id = model.id;
            master.userConfiguration.image_testing_id = model.testing_id;
        }
        new SetUserConfigurationService(master.userConfiguration, function (res) {
            console.log(res);
        });

    }

    bindEvents() {

        let self = this;

        $(".button-choose-image").click(function (e) {
            $("#select-image").trigger("click");
        });

        $(document).on("click", this.childNode + " ul li:not(.dropdown-header):not(.choose-button-parent)", function () {
            self.modal.hide();

            self.setActiveClass($(this));

            let $self = $(this);

            let container_id = $(this).data("id");
            let id = $(this).find("img").data("id");
            let testing = $(this).find("img").data("testing");
            if (testing)
                id += "|" + testing;
            let container = $(this).data("container");

            if (container && id)
                //if tab exists

                self.onChangeImage(id, container, $self, container_id);

            else {


                if (id) {

                    self.onChangeImage(id, null, $self);

                }
            }


        });
        $(this.parentNode + " .open-modal").click(function (e) {


            self.modal.show();
            console.log(self.childNode + " ul li.list-group-item")
            let activeNode = $(self.childNode + " ul li.list-group-item.active");

            if (activeNode.length) {
                setTimeout(() => {


                    activeNode.get(0).scrollIntoView();
                    console.log("gonna scroll");
                }, 200);
            }

        });



        //search for filter
        $(".modal .filter-search").on("input", function (e) {

            let value = $(this).val();
            $(self.childNode + " ul li.list-group-item").each(function (index) {
                let $singleLi = $(this);

                if (!$singleLi.text().toLowerCase().includes(value.toLowerCase()))
                    $(this).addClass("hidden");
                else if ($singleLi.hasClass("hidden")) {
                    $singleLi.removeClass("hidden");
                }
            })
        });
        $(this.childNode + " input:file").change(function (e) {

            if (this.files && this.files[0]) {
                let file = this.files[0];


                new ImageLoaded(file, (imageLoaded) => {

                    let $li = self.appendNewUploads(imageLoaded);
                    new StageImage(imageLoaded, null, $li).init();


                });


            }
        })


    }


}

class StageImage {

    constructor(file, model, $li) {
        this.imageLoaded = this.file = file;
        this.new_image = (file.file instanceof File);
        this.src = file.src;
        this.name = name;
        this.shapes = null;
        this.$li = $li;

        this.model = model;
        this.konvaImage = null;


    }


    init() {
        this.konvaImage = new Konva.Image({
            image: this.file.imageInstance,
            x: 0,
            y: 0,
            width: this.file.width,
            height: this.file.height,
            draggable: false,
            rotation: 0
        });


        master.currentImageTab.addImage(this);
        if (this.new_image)
            master.currentImageTab.uploadImageJob();


        if (this.shapes) {
            this.setShapesToContext();
        }


        return this;

    }


    setShapesToContext() {
        master.currentImageTab.preRegisteredShapes(this.shapes);

    }


}

