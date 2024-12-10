//only for children of urlConnection

class JobsToDo {
    constructor(onJobChangeEvent) {

        this.onJobChangeEvent = onJobChangeEvent instanceof Function ? onJobChangeEvent : () => {
        };

        this.jobs = [];

        this.ready = true;
    }

    init(callback) {
        this.initJobs(callback);

    }

    initJobs(callback = () => {
    }) {

        if (this.jobs.length && this.ready) {
            //  console.error(this.ready)


            this.ready = false;
            //  console.log("ready changed", this.ready)
            this.recursiveJob(0, () => {

                this.onJobChangeEvent(this.jobs.length);
                //    console.error("job done");
                this.ready = true;
                callback();
            });
        } else {
            callback();
            //   this.ready = true;
        }


    }

    recursiveJob(index, callback) {
        // console.log(this.jobs[index]);
        if (this.jobs[index]) {
            let job = this.jobs[index];
            let jobInstance = null;


            eval("jobInstance=new " + job.job + " ()");

            if (jobInstance) {
                jobInstance.data = job.data;
                //    console.log(jobInstance.data);
                jobInstance.callback = (res) => {
                    if (res)
                        this.jobs.splice(index, 1);
                    else //keep moving forward;
                        index++;

                    job.callback(res);
                    this.recursiveJob(index, callback);
                };

                return jobInstance.init();
            }
        } else {

            return callback(true);

        }

    }

    popJobById(id) {
        for (let i = 0; i < this.jobs.length; i++) {
            if (this.jobs[i].id === id) {
                this.jobs.splice(i, 1);
                this.onJobChangeEvent(this.jobs.length);
                return true;
            }
        }

        return false;
    }

    /**
     * @param {Function} job function

     * @param data
     * @param callback
     * @param id
     */



    push(job, data, callback, id = new Date().getTime()) {

        if (job instanceof Function && callback instanceof Function) {
            this.jobs.push({
                id: id,
                job: job,
                data: data,
                callback: callback,
            });

            this.onJobChangeEvent(this.jobs.length);

            this.initJobs()

            return this.jobs;
        }
        return false;


    }


    protocolToPush(job) {


        // if its image
        if (job instanceof UploadImageService)
            this.initByItself();
        else {
            if (this.jobs.length > 1) {
                this.initByItself();
            } else {
                console.error("gonna set timeout");
                setTimeout(() => {
                    console.error("timeout ended")
                    this.initByItself();

                    //2s
                }, 1000 * 2);
            }

        }


    }


    initByItself() {
        let self = this;
        this.initJobs(function (res) {
            if (!self.jobs.length)
                console.log("ended all");
            else
                console.error("didnt end well");
        })
    }

}



