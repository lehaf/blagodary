const RegisterAjax = function () {
    this.setting = {
        'formId':'#register',
        'fieldNameAttr':'data-field',
        'containerInputErrorClass':'error',
        'errorClass':'error-block',
        'additionalField':'REGISTER[EMAIL]',
        'acceptCheckboxId':'#accept-register',
    }

    this.$form = document.querySelector('form' + this.setting.formId);
    this.$formAction = this.$form.getAttribute('action');
    this.$formInputs = this.$form.querySelectorAll('input');
    this.$acceptInput = this.$form.querySelector(this.setting.acceptCheckboxId);

    this.init();
}

RegisterAjax.prototype.init = function () {
    this.setupListener();
}

RegisterAjax.prototype.setupListener = function () {
    const _this = this;
    if (this.$form) {
        this.$form.onsubmit = () => {
            event.preventDefault();
            let formData = new FormData(this.$form);
            formData.set('register_submit_button', 'Y');
            formData.set(this.setting.additionalField, formData.get('REGISTER[LOGIN]'));
            if (_this.checkAccept())  _this.sendData(formData);
        }
    }
}

RegisterAjax.prototype.checkAccept = function () {
    if (this.$acceptInput.checked) {
        return this.$acceptInput.checked;
    } else {
        this.errorAccept();
        return this.$acceptInput.checked;
    }
}

RegisterAjax.prototype.errorAccept = function () {
    let acceptSpan = this.$acceptInput.parentNode.querySelector('.user-agreement');
    acceptSpan.classList.add('error');
}


RegisterAjax.prototype.createInputErrorMessage = function (input,errorMessage) {
    let errorDiv = document.createElement('div');
    errorDiv.classList.add(this.setting.errorClass);
    errorDiv.innerHTML = errorMessage;
    let inputContainer = input.parentNode;
    if (!inputContainer.classList.contains(this.setting.containerInputErrorClass)) {
        inputContainer.classList.add(this.setting.containerInputErrorClass);
    }

    let errorContainer = inputContainer.querySelector('.'+this.setting.errorClass);
    if (!errorContainer) {
        inputContainer.append(errorDiv);
    } else {
        errorContainer.innerHTML = errorMessage;
    }
}

RegisterAjax.prototype.deleteInputErrorMessage = function (input) {
    let inputContainer = input.parentNode;
    if (inputContainer.classList.contains(this.setting.containerInputErrorClass)) {
        inputContainer.classList.remove(this.setting.containerInputErrorClass);
    }

    let errorContainer = inputContainer.querySelector('.'+this.setting.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }
}

RegisterAjax.prototype.resetForm = function (input) {
    const _this = this;
    if (this.$form) {
        if (this.$formInputs) {
            this.$formInputs.forEach((input) => {
                _this.deleteInputErrorMessage(input);
            });
        }
        _this.$form.reset();
    }
}

RegisterAjax.prototype.enterErrors = function (jsonFields) {
    const _this = this;
    if (this.$form) {
        if (this.$formInputs) {
            let confidence = 0;
            this.$formInputs.forEach((input) => {
                let fieldName = input.getAttribute(this.setting.fieldNameAttr);
                if (jsonFields[fieldName]) {
                    confidence++;
                    _this.createInputErrorMessage(input,jsonFields[fieldName]);
                } else {
                    _this.deleteInputErrorMessage(input);
                }
            });

            if (confidence === 0) {
                let input = _this.$form.querySelector("input[data-field='PASSWORD']");
                _this.createInputErrorMessage(input,jsonFields[0]);
            }
        }
    }
}

RegisterAjax.prototype.sendData = function (data) {
    const _this = this;
    fetch(_this.$formAction, {
        method: 'POST',
        cache: 'no-cache',
        body: data
    }).then(function(response) {
        return response.text()
    }).then(function(jsonResponse) {
        if (jsonResponse) {
            let jsonFields = JSON.parse(jsonResponse);
            _this.enterErrors(jsonFields);
        } else {
            _this.resetForm();
        }

    }).catch(error => {
        console.log(error);
    });
}
addEventListener('DOMContentLoaded', () => {
    new RegisterAjax();
});