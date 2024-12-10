class UI {


    constructor() {
        this.strContent = "";
        this.parentNode = "";
        this.$parentNode = "";

    }

    init(callback = () => {
    }) {
        this.content();
        this.bindEvents();

        callback();
    }

    content() {


        return '';
    }

    bindEvents() {


    }


}
