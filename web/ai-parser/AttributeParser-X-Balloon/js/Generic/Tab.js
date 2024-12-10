class Tab extends ContextEvent {
    constructor() {


        super();


    }

    uploadImageJob() {


        master.jobsToDo.push(UploadImageService, this.currentImage, (res) => {

            if (res){
                this.currentImage.model=new ImageModel({});
                this.currentImage.model.load(res);

            }

        });
    }
}









