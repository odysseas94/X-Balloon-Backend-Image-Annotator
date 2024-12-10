class Modal {
    constructor({
                    id = "modal",
                    className = "modal",
                    title = "",
                    body = "",
                    buttons = [],
                    bindEvents = () => {
                    }

                }) {

        this.id = "modal-" + id;
        this.className = className;
        this.title = title;
        this.body = body;
        this.buttons = buttons;
        this.parentName = "kt_content";

        this.parentClass = 'modal-parent'
        this.$parent = null;
        this.events = typeof bindEvents === "function" ? bindEvents : () => {
        };

    }


    init() {
        this.$parent = $("body  #" + this.parentName);
        console.log(this.$parent, "body  #" + this.parentName);

        let buttonStr = "";
        for (let ob in this.buttons)
            buttonStr += this.buttons[ob];


        if (!this.$parent.length)
            this.$parent = $("body").append("<div id='" + this.parentName + "' class='" + this.parentClass + "'/>");

        let str = this.constructBody();
        if (this.buttons.length)
            str += '      <div class="modal-footer">\n' +
                buttonStr +
                '      </div>';

        str += '    </div>\n' +
            '\n' +
            '  </div>\n' +
            '</div>';

        let $modal = $("#" + this.id);
        if ($modal.length)
            $modal.remove();


        this.$parent.append(str);

        this.$modal = $("#" + this.id);

        this.bindEvents();

        return this;


    }

    constructBody() {
        return '<div id="' + this.id + '" class="modal fade" role="dialog">\n' +
            '  <div class="modal-dialog">\n' +
            '\n' +
            '    <!-- Modal content-->\n' +
            '    <div class="modal-content">\n' +
            '      <div class="modal-header text-center">\n' +
            '<h5 class="modal-title">' + this.title + '</h5>\n' +
            '  <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
            '                </button>\n' +

            '      </div>\n' +
            '      <div class="modal-body text-dark">\n' +
            this.body +
            '      </div>';

    }


    bindEvents() {
        this.events();

    }


    show() {
        console.log(this.$modal);
        this.$modal.modal("show");
    }

    hide() {
        this.$modal.modal("hide");
    }

}


class WarningModal extends Modal {
    constructor({actionUrl = "",
                    bindEvents = () => {}}) {
        super({
            id: "modal",
            className: "modal",
            title: "Confirmation",
            body: "Are you sure you want to delete this item?",
            bindEvents,
        });
        this.buttons = [
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>',
            '<a href="' + actionUrl + '" data-method="post" class="btn btn-warning" data-dismiss="modal">OK</a>',
        ]
        this.init();
        this.show();
    }


    constructBody() {
        return '<div id="' + this.id + '" class="modal fade" role="dialog">\n' +
            '  <div class="modal-dialog ">\n' +
            '\n' +
            '    <!-- Modal content-->\n' +
            '    <div class="modal-content">\n' +
            '      <div class="modal-header text-center alert alert-warning">\n' +
            '<h5 class="modal-title">' + this.title + '</h5>\n' +
            '  <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
            '                </button>\n' +

            '      </div>\n' +
            '      <div class="modal-body text-dark">\n' +
            this.body +
            '      </div>';

    }


}
