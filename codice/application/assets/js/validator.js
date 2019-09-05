class Validator {
    constructor() {
        console.log("[INFO] Loaded validator.js for local validation");
    }

    name(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length < lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    message(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length < lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F0-9 ]{1,}([\.,]|[-']|))*$/i;
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
}