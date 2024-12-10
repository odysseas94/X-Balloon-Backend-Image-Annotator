class TabUI extends UI {


    constructor() {
        super();


    }

    init(callback = () => {
    }) {

        this.beforeRedirect(() => {


            this.strContent = this.content();

            this.$parentNode = $(this.parentNode).html(this.strContent);
            this.bindEvents();
            callback();
        });

    }

    beforeRedirect(callback = () => {
    }) {
        callback();
    }

    bindEvents() {


    }


    content() {

    }


}
