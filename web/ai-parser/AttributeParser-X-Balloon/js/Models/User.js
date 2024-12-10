class User extends Model {
    constructor({
                    id = 0, firstname = "", lastname = "", username = "", email = "",date_created=0,date_updated=0
                }) {



        super("user")
        this.id=id;
        this.firstname=firstname;
        this.lastname=lastname;
        this.username=username;
        this.email=email;
        this.date_created=date_created;
        this.date_updated=date_updated;
    }

    toMemory() {
        master.user=this;
    }

    get attributes(){
        return {
            id:this.id,
            firstname:this.firstname,
            lastname:this.lastname,
            username:this.username,
            email:this.email,
            date_created:this.date_created,
            date_updated:this.date_updated,
        }
    }

    get fullname(){
        return this.firstname + " " + this.lastname;
    }
}