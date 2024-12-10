class TabHandlerUI {
    constructor() {

        this.allTabsUI = new AllTabsUI();
        this.shapeTabUI = new ShapeTabUI();
        this.classificationTabUI = new ClassificationTabUI();
        this.selectImageTabUI = new SelectImageTabUI();
        this.jobsTabUi = new JobsTabUI();
        this.regionAttributeTabUi = new RegionAttributesTabUI();
        this.settingsTabUI = new SettingTabUI();

    }

    init(callback = () => {
    }) {
        this.allTabsUI.init(() => {


            this.shapeTabUI.init(() => {
                this.classificationTabUI.init(() => {
                    this.selectImageTabUI.init(() => {
                        this.jobsTabUi.init(() => {
                            this.settingsTabUI.init(() => {
                                this.regionAttributeTabUi.init(() => {
                                    callback();


                                });
                            });
                        });
                    });
                });
            });
        });


    }

}
