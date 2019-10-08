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

function addGrottoListeners() {
    //Aggiunge evento keydown ai campi
    $("#name").keydown(function() {
        manage(this, "name");
    });
    $("#cap").keydown(function() {
        manage(this, "cap");
    });
    $("#paese").keydown(function() {
        manage(this, "paese");
    });
    $("#via").keydown(function() {
        manage(this, "via");
    });
    $("#no_civico").keydown(function() {
        manage(this, "no_civico");
    });
    $("#telefono").keydown(function() {
        manage(this, "telefono");
    });


    //Aggiunge evento keyup ai campi
    $("#name").keyup(function() {
        manage(this, "name");
    });
    $("#cap").keyup(function() {
        manage(this, "cap");
    });
    $("#paese").keyup(function() {
        manage(this, "paese");
    });
    $("#via").keyup(function() {
        manage(this, "via");
    });
    $("#no_civico").keyup(function() {
        manage(this, "no_civico");
    });
    $("#telefono").keyup(function() {
        manage(this, "telefono");
    });

}
//PARAMS
const global_length_min = 0;
const global_length_max = 50;
const pass_length_min = 8;
const no_civico_length_max = 5;
const telefono_length_max = 20;
const cap_length_max = 5;

function manage(obj, selector) {
    var status = false;

    obj.value = obj.value.replace(/\s\s+/i, ' ');

    obj.value = obj.value.replace(/[;]+/i, '');

    if (selector == "firstname") {
        status = validator.firstname(obj.value, global_length_min, global_length_max);
    }else if (selector == "lastname") {
        status = validator.lastname(obj.value, global_length_min, global_length_max);
    }else if (selector == "username") {
        status = validator.username(obj.value, global_length_min, global_length_max);
    }else if (selector == "email") {
        status = validator.email(obj.value);
    }else if (selector == "password") {
        status = validator.password(obj.value, pass_length_min, global_length_max);
    }else if (selector == "repassword") {
        status = validator.password(obj.value, pass_length_min, global_length_max);
    }else if (selector == "name"){
        status = validator.name(obj.value, global_length_min, global_length_max);
    }else if (selector == "cap"){
        status = validator.cap(obj.value, global_length_min, cap_length_max);
    }else if (selector == "paese"){
        status = validator.paese(obj.value, global_length_min, global_length_max);
    }else if (selector == "via"){
        status = validator.via(obj.value, global_length_min, global_length_max);
    }else if (selector == "no_civico"){
        status = validator.nocivico(obj.value, global_length_min, no_civico_length_max);
    }else if (selector == "telefono"){
        status = validator.telefono(obj.value, global_length_min, telefono_length_max);
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