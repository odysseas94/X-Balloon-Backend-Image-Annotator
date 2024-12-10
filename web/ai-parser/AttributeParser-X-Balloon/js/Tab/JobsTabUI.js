class JobsTabUI extends TabUI {


    constructor(props) {
        super(props);

        this.parentNode = ".jobs-parent";

        this.jobs_length = 0;


    }


    content() {


        let str = "    <button disabled  class='btn btn-update-job disabled btn-primary' title='" + translation.get("upload") + "'><i class=\"fas fa-cloud\"></i></button>";


        return str;

    }


    bindEvents() {
        let $button = $(this.parentNode + " .btn-update-job");
        master.jobsToDo.onJobChangeEvent = jobs_length => {
            this.jobs_length = jobs_length;
            if (this.jobs_length) {
                $button.removeClass("disabled").removeAttr("disabled");
            } else
                $button.addClass("disabled").attr("disabled", "true");
        };

        let self = this;

        $button.click(function (e) {
            let $i = $(this).children("i");
            $i.addClass("rotated");

            master.jobsToDo.initJobs(() => {
                $i.removeClass("rotated");
                console.log("jobs done");
            });
            console.log("clicked");
            e.preventDefault();
        })
    }


}
