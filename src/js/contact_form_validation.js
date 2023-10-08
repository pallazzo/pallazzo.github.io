
const constraints = {
    name: {
        presence: { allowEmpty: false, message: "Bitte füllen Sie dieses Feld aus" },
    },
    email: {
        presence: { allowEmpty: false, message: "Bitte geben Sie eine gültige Email-Adresse an." },
        email: {message: "Bitte geben Sie eine gültige Email-Adresse an." }
    },
    message: {
        presence: { allowEmpty: false, message: "Bitte geben Sie eine Nachricht ein." }
    }
};

const form = document.getElementById('contact-form');

form.addEventListener('submit', function (event) {
    const formValues = {
        name: form.elements['grid-name'].value,
        email: form.elements['grid-email'].value,
        message: form.elements['grid-message'].value
    };

    const errors = validate(formValues, constraints, {fullMessages: false});

    if (errors) {
        event.preventDefault();
        const errorMessage = Object
            .values(errors)
            .map(function (fieldValues) { return fieldValues.join(', ') })
            .join("\n");

            console.log(errors);
            
            if(errors.name)
            {
                form.elements['grid-name'].classList.add("border-red-500");
                document.getElementById('grid-name-error').innerHTML  = errors.name[0];
            }

            if(errors.email)
            {
                form.elements['grid-email'].classList.add("border-red-500");
                document.getElementById('grid-email-error').innerHTML  = errors.email[0];
            }

            if(errors.message)
            {
                form.elements['grid-message'].classList.add("border-red-500");
                document.getElementById('grid-message-error').innerHTML  = errors.message[0];
            }
            
    }

}, false);


function onRecaptchaSuccess(){
    document.getElementById('contact-form').submit();
}
