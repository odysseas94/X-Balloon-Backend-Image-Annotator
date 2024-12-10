class KonvaFEvent {
    constructor(context = null) {
        this.context = context;
        this.shape = null;
        this.transformer = null;
        this.label = null;
        this.fill = null;
        this.stroke = null;
        this.layer=null;
        this.finalLayer=null;


    }


    _initBinding() {

        this._onHover();

    }


    _onHover() {


        this.shape.on('mouseover',  (e) =>{

          this.shape.fill(Helper.shadeColor(this.fill,-50));
          this.finalLayer.batchDraw();
        });
        this.shape.on('mouseout',  ()=> {
            this.shape.fill(this.fill)
            this.finalLayer.batchDraw();

        });

    }

    _onTransformShape(callback = () => {
    }) {


    }

    _onDragEnd(callback = () => {
    }) {




        if (this.shape) {

            this.shape.on("dragend", callback)


        }


    }


    _bindTransformerEvents(callback = () => {
    }) {
        let self = this;

        if (this.transformer)
            this.transformer.on("transform", (e) => {


                let node = e.currentTarget.node();
                callback();
                self.dragmove(e)
                //  this.layer.draw();

            });

    }


    dragmove(e) {

    }


}