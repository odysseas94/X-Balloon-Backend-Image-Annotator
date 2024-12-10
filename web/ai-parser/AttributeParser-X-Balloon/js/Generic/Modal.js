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
        this.parentName = "modal-parent";
        this.parentClass='modal-parent'
        this.$parent = null;
        this.events = typeof bindEvents === "function" ? bindEvents : () => {
        };

    }


    init() {
        this.$parent = $("body> #" + this.parentName);

        let buttonStr = "";
        for (let ob in this.buttons)
            buttonStr += this.buttons[ob];


        if (!this.$parent.length)
            this.$parent = $("body").append("<div id='" + this.parentName + "' class='" + this.parentClass + "'/>");


        let str = '<div id="' + this.id + '" class="modal fade" role="dialog">\n' +
            '  <div class="modal-dialog">\n' +
            '\n' +
            '    <!-- Modal content-->\n' +
            '    <div class="modal-content">\n' +
            '      <div class="modal-header text-center">\n' +
            '      <div class="text-center">  ' +
            '<h5 class="modal-title">' + this.title + '</h5>\n' +
            '        <button type="button" class="close btn btn-default" data-dismiss="modal">&times;</button>\n' +
            '</div>' +

            '      </div>\n' +
            '      <div class="modal-body text-dark">\n' +
            this.body +
            '      </div>';


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

