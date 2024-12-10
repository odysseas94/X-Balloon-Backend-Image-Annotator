class UploadImageService extends UrlConnection {


    constructor(stageImage, callback = (result) => {
    }) {
        super(
            {
                type: "POST",
                url: "upload-image",
            });

        this.proccessData = false;
        this.type_json = false;
        this.callback = callback;
        this.imageLoaded = null;
        this.stageImage = stageImage;
        this.data = stageImage;

        this.loading = false;

        this.contentType = false;


    }

    collectAll() {


        let data = this.data.imageLoaded;
        this.stageImage=this.data;
        this.imageLoaded = data;

        let formData = new FormData();
        formData.append("Image[image]", data.file);

        this.data = formData;


    }

    success(res) {

        if (this.stageImage.$li && this.stageImage.$li.length) {

            this.stageImage.$li.find("img").data("id", res.id);
        }
        toast.showSuccess(translation.get("upload_image"), this.imageLoaded.name + " : " + translation.get("image_uploaded"));

        this.callback(res);
    }

    error(res) {
        console.log(this.callback)
        toast.showError(translation.get("upload_image"), translation.get("no_upload"));
        this.callback(false);
    }
}
