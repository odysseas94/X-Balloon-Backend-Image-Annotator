class ImageLoaded {


    constructor(file, callback = (res) => {
    }) {
        this.height = 0;
        this.width = 0;
        this.aspect = 1;
        this.size = 0;
        this.callback = callback;

        this.MAX_WIDTH = window.innerWidth;
        this.MAX_HEIGHT = window.innerHeight;
        if (file instanceof File) {

            this.name = name;
            this.src = null;
            this.type = "";
            this.imageInstance = null;


            this.file = file;
            this.init();

        } else if (typeof file === "string") {
            this.src = file;
            this.file = null;

            this.initForSrc();
        } else {
            throw new Error("Not An Image");

        }


    }

     toBase64(file) {
        return new Promise(function (resolve, reject) {
            let reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function () {
                return resolve(reader.result);
            };

            reader.onerror = function (error) {
                return reject(error);
            };
        });
    };

//when file is only the src of the image;
    initForSrc() {
        this.loadImage((image) => {

            this.name = this.src.replace(/^.*[\\\/]/, '');

            master.initStage(this.height, this.width, () => {
                this.callback(this);

            });

        });
    }

    loadImage(callback = () => {
    }) {

        let self = this;

        let image = new Image();
        image.onload = function () {
            console.log(this);
            self.imageInstance = this;
            self.optimizeSize(this.width, this.height);
            callback(this);


        };

        image.src = this.src;


    }

    optimizeSize(width, height) {
        let aspect = 1;
        this.width = width;
        if (width > this.MAX_WIDTH) {

            aspect = width / (this.MAX_WIDTH);
            this.width = this.MAX_WIDTH;

            this.height = height / aspect;
        } else if (height > this.MAX_HEIGHT * 5) {
            aspect = height / (this.MAX_HEIGHT);
            this.height = this.MAX_HEIGHT;

            this.width = width / aspect;
        } else {
            aspect = width / (this.MAX_WIDTH);
            this.width = this.MAX_WIDTH;

            this.height = height / aspect;
        }

        this.aspect = aspect;
    }


    init() {
        this.name = this.file.name;
        this.size = this.file.size;
        this.toBase64(this.file).then((base64) => {
            this.src = base64;
            this.loadImage(() => {
                console.log("gonna init tab", this.height, this.width)
                master.initStage(this.height, this.width, function () {
                    console.log("inited");

                });

                this.callback(this);


            });


        });
    }

}
