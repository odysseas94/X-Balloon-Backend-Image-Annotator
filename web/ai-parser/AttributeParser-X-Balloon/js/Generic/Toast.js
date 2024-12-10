class Toast {


    constructor(parentElement) {

        this.parentElement = parentElement;
        this.$parentElement = null;

        this.taosts = [];

    }

    init(callback = () => {
    }) {
        this.$parentElement = $(this.parentElement)
        callback();
    }

    showSuccess(category, message, time = 5000) {

        this._makeToast(category, message, "success", time);
    }

    showError(category, message, time = 20000) {
        this._makeToast(category, message, "error", time);
    }

    _makeToast(category, message, type,time) {
        this.taosts.push(new ToastUi(this.$parentElement, type, category, message,time));
    }
}

class ToastUi {
    constructor($parent, type, category, message, time = 5000) {

        this.$parent = $parent;
        this.type = type;
        this.category = category;
        this.message = message;
        this.str = "";
        this.id = new Date().getTime();
        this.$self = null;
        this.time = time;


        this.init();

    }

    init() {
        if (this.type === "error")
            this.error();
        else
            this.success();
    }

    create(type) {
        this.type = type;

        type = type + "-toast";
        this.str = '<div class="toast ' + type + '"  data-id=' + this.id + ' data-autohide="false">\n' +
            '  <div class="toast-header">\n' +
            '    <strong class="mr-auto text-primary">' + this.category + '      </strong>\n' +
            '    <small class="text-muted">' + moment(this.id).format("HH:mm") + '</small>\n' +
            '    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>\n' +
            '  </div>\n' +
            '  <div class="toast-body">\n' +
            '   ' + this.message +
            '  </div>\n' +
            '</div';
        this.$parent.append(this.str);
        this.$self = $(".toast[data-id=" + this.id + "]");
        this.$self.toast('show');
      


        setTimeout(() => {

            this.hide();
        }, this.time)


    }

    hide() {
        console.log("gonna hide")
        this.$self.toast("hide");
    }

    success() {
        this.create("success");
    }

    error() {
        this.create("error");
    }
}


let toast = new Toast(".global-appender");
