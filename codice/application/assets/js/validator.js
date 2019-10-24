class Validator {
    constructor() {
        console.log("[INFO] Loaded validator.js for local validation");
    }

    firstname(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1}([\.]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    lastname(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F0-9 ]{1}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    username(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F0-9 ]{1}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    password(text, lengthMin, lengthMax) {
        if (text.length >= lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F0-9*%&!?$@+#\-_+]{1}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    email(email) {
        var re = /^(([^<>()\[\]\\.,:\s@"]+(\.[^<>()\[\]\\.,:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        var notAccents = /[\u00C0-\u017F]/;
        if (email.length > 0) {
            if (re.test(email)) {
                return !notAccents.test(email);
            }
        }
        return false;
    }

    name(text, lengthMin, lengthMax){
        if (text.length > lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    paese(text, lengthMin, lengthMax){
        if (text.length > lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    via(text, lengthMin, lengthMax){
        if (text.length > lengthMin && text.length <= lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    telefono(number, lengthMin, lengthMax) {
        if (number.length > lengthMin && number.length <= lengthMax) {
            var re = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;
            return re.test(number);
        }
        return false
    }

    nocivico(numeroCivico, lengthMin, lengthMax) {
        var re = /^[a-zA-Z0-9 ]+$/;
        if (numeroCivico.length > lengthMin && numeroCivico.length <= lengthMax) {
            return re.test(numeroCivico);
        }
        return false;
    }

    cap(cap, lengthMin, lengthMax){
        var re = /^[0-9]+$/;
        if(cap.length > lengthMin && cap.length <= lengthMax){
            return re.test(cap);
        }
        return false;
    }
}
