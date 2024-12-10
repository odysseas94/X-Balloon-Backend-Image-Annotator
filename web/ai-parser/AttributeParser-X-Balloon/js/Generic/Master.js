let getUrl = window.location.toString();
if (!("localDomain" in window)) {
    window.localDomain = getUrl.substr(0, getUrl.lastIndexOf("/"));
}
if (!("urlConnectionApi") in window) {
    window.urlConnectionApi = null;
}
let translation = new Translation();


class Master {


    constructor() {

        this.translation = translation;

        this.toast = toast;
        this.currentImageTab = null;
        this.user = null;
        this.userConfiguration = null;


        this.models = {
            shape_types: new Map(),
            classifications: new Map()


        };
        this.imageTabs = new Map();
        this.tabHandler = new TabHandlerUI();
        this.jobsToDo = new JobsToDo();
    }

    init(callback = () => {
    }) {
        let self = this;

        new ReceiveAllEssentialsService(() => {


            this.toast.init(() => {

                this.translation.init(() => {

                    this.tabHandler.init(() => {
                        let imageTabUI = this.tabHandler.selectImageTabUI;
                        if (this.userConfiguration && this.user && imageTabUI.images[this.userConfiguration.attribute_parser_image_id]) {
                            let image = this.tabHandler.selectImageTabUI.images[
                            this.userConfiguration.attribute_parser_image_id + (this.userConfiguration.image_testing_id ? "|" + this.userConfiguration.image_testing_id : null)];
                            let testing_appender = "[data-testing='']";
                            let image_id = image.id;
                            if (image.testing_id) {
                                testing_appender = "[data-testing='" + image.testing_id + "']";
                                image_id += "|" + image.testing_id;

                            }

                            let $li = $(imageTabUI.childNode + " ul li:not(.dropdown-header) img[data-id='" + image.id + "']" + testing_appender).parents("li");
                            if ($li.length) {

                                imageTabUI.onChangeImage(image_id, null, $li, null)
                                imageTabUI.setActiveClass($li);
                            }

                        }
                        callback();

                        // });

                    });
                })
            });
        });

        this.bindEvents();

    }

    initStage(height, width, callback = () => {
    }) {


        this.createNewTab();

        this.currentImageTab.init(height, width, callback);
        return this.currentImageTab;

    }

    setCurrentTabActive(tab) {
        this.currentImageTab = tab;
        $(".canvas-parent .canvas-child").addClass("hidden");
        $("#" + this.currentImageTab.container).removeClass("hidden");


    }

    createNewTab() {
        let tab = new Tab();
        $(".canvas-parent").append("<div class='canvas-child' id='" + tab.container + "'></div>")
        this.imageTabs[tab._id] = tab;
        this.setCurrentTabActive(tab);

    }

    bindEvents() {

        //drag on stage
        let self = this;
        let p0 = null;
        let running = false;

        $(".canvas-parent")
            .mousedown(function (e) {


                if (e.button === 2 && master && master.currentImageTab) {
                    master.currentImageTab.setCursorGrab();

                    $(this).on("mousemove", function (e) {
                        let p1 = {x: e.pageX, y: e.pageY};
                        p0 = p0 ? p0 : p1;
                        running = true;

                        if (master && master.currentImageTab) {
                            master.currentImageTab.onRightClickStart(p1.x - p0.x, p1.y - p0.y);
                        }
                        p0 = p1;


                    });

                }
            })
            .mouseup(function (e) {
                p0 = null;

                if (master && master.currentImageTab) {

                    master.currentImageTab.onRightClickEnd(e);
                }
                running = false;
                $(this).off("mousemove");
            });
        $(document).mouseup(function (e) {
            if (running) {
                p0 = null;

                if (master && master.currentImageTab) {

                    master.currentImageTab.onRightClickEnd(e);
                }
                $(".canvas-parent").off("mousemove");
            }
        });


        //on window closes


        $(window).on("beforeunload", function (e) {

            if (self.jobsToDo.jobs.length) {
                master.jobsToDo.initJobs();


                confirm("Do you really want to close?");
                e.preventDefault();
                return false;
            }
        })
        $(window).on("unload", function (e) {
            if (master.jobsToDo.jobs.length) {
                master.jobsToDo.initJobs();
                confirm("Do you really want to close2?");
                e.preventDefault();
                return false;
            }
        });
    }
}

let master = new Master();


$(document).ready(function () {
    $(this).bind("contextmenu", function (e) {
        e.preventDefault();
    });

    master.init(() => {
        console.log("all started");
    })


});