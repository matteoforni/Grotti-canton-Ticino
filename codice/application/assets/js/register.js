var validator = new Validator();

function addListeners() {
    //Aggiunge evento keydown ai campi
    $("#name").keydown(function() {
        manage(this, "name");
    });
    $("#message").keydown(function() {
        manage(this, "message");
    });
    $("#email").keydown(function() {
        manage(this, "email");
    });


    //Aggiunge evento keyup ai campi
    $("#name").keyup(function() {
        manage(this, "name");
    });
    $("#message").keyup(function() {
        manage(this, "message");
    });
    $("#email").keyup(function() {
        manage(this, "email");
    });
}

//PARAMS
const global_length_min = 0;
const name_length_max = 500;
const message_length_max = 500;

function manage(obj, selector) {
    var status = false;

    obj.value = obj.value.replace(/\s\s+/i, ' ');

    obj.value = obj.value.replace(/[;]+/i, '');

    if (selector == "name") {
        status = validator.name(obj.value, global_length_min, name_length_max);
    } else if (selector == "email") {
        status = validator.email(obj.value)
    } else if (selector == "message") {
        status = validator.message(obj.value, global_length_min, global_length_max);
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