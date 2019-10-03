var validator = new Validator();

function addRegisterListeners() {
    //Aggiunge evento keydown ai campi
    $("#firstname").keydown(function() {
        manage(this, "firstname");
    });
    $("#lastname").keydown(function() {
        manage(this, "lastname");
    });
    $("#username").keydown(function() {
        manage(this, "username");
    });
    $("#email").keydown(function() {
        manage(this, "email");
    });
    $("#password").keydown(function() {
        manage(this, "password");
    });
    $("#repassword").keydown(function() {
        manage(this, "repassword");
    });

    //Aggiunge evento keyup ai campi
    $("#firstname").keyup(function() {
        manage(this, "firstname");
    });
    $("#lastname").keyup(function() {
        manage(this, "lastname");
    });
    $("#username").keyup(function() {
        manage(this, "email");
    });
    //Aggiunge evento keyup ai campi
    $("#email").keyup(function() {
        manage(this, "username");
    });
    $("#password").keyup(function() {
        manage(this, "password");
    });
    $("#repassword").keyup(function() {
        manage(this, "repassword");
    });
}

function addLoginListeners() {
    //Aggiunge evento keydown ai campi
    $("#email").keydown(function() {
        manage(this, "email");
    });
    $("#password").keydown(function() {
        manage(this, "password");
    });


    //Aggiunge evento keyup ai campi
    $("#email").keyup(function() {
        manage(this, "email");
    });
    $("#password").keyup(function() {
        manage(this, "password");
    });

}

//PARAMS
const global_length_min = 0;
const name_length_max = 50;
const pass_length_min = 8;

function manage(obj, selector) {
    var status = false;

    obj.value = obj.value.replace(/\s\s+/i, ' ');

    obj.value = obj.value.replace(/[;]+/i, '');

    if (selector == "firstname") {
        status = validator.firstname(obj.value, global_length_min, name_length_max);
    } else if (selector == "lastname") {
        status = validator.lastname(obj.value, global_length_min, name_length_max);
    } else if (selector == "username") {
        status = validator.username(obj.value, global_length_min, name_length_max);
    }else if (selector == "email") {
        status = validator.email(obj.value);
    }else if (selector == "password") {
        status = validator.password(obj.value, pass_length_min, name_length_max);
    }else if (selector == "repassword") {
        status = validator.password(obj.value, pass_length_min, name_length_max);
    }

    if (status) {
        obj.style.borderBottom = "1px solid #4CAF50";
        obj.style.boxShadow = "0 1px 0 0 #4CAF50";
    } else {
        obj.style.borderBottom = "1px solid #FF0000";
        obj.style.boxShadow = "0 1px 0 0 #FF0000";
    }
    return status;
}