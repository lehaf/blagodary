const AuthAjax = function () {
    this.setting = {
        'formId':'#auth-form',
        'containerInputErrorClass':'error',
        'errorClass':'error-block',
        'errorArrKey':'ERROR_PROCESSING',
    }

    this.errors = {
       'emptyField':'Обязательное поле!',
       'wrongEmail':'Некоректный email!',
       'smallPass':'Минимум 8 символов!',
       'upperLowerCase':'Пароль должен содержать заглавные и строчные символы!',
       'numbersInPass':'Пароль должен содержать цифры!',
    }

    this.$form = document.querySelector('form' + this.setting.formId);
    this.$formAction = this.$form.getAttribute('action');
    this.$formInputs = this.$form.querySelectorAll('input');

    this.init();
}

AuthAjax.prototype.init = function () {
    this.setupListener();
}

AuthAjax.prototype.setupListener = function () {
    const _this = this;
    if (this.$form) {
        this.$form.onsubmit = () => {
            event.preventDefault();
            let formData = new FormData(this.$form);
            formData.set('AUTH_ACTION', 'Y');
            if (_this.checkFormFields()) {
                _this.sendData(formData);
            }
        }
    }
}

AuthAjax.prototype.checkFormFields = function () {
    const _this = this;
    if (this.$formInputs) {
        let testPassed = true;
        this.$formInputs.forEach((input) => {
            let errors = [];
            switch (input.getAttribute('type')) {
                case 'email':
                    if (!input.value) {
                        errors.push(_this.errors.emptyField)
                    } else {
                        if (!/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(input.value)) {
                            errors.push(_this.errors.wrongEmail)
                        }
                    }
                    break;
                case 'password':
                    if (!input.value) {
                        errors.push(_this.errors.emptyField)
                    }
                    break;
            }
            let errorMessage = errors.join('<br>');
            if (errorMessage) {
                testPassed = false;
                _this.createInputErrorMessage(input,errorMessage);
            }
        });
        return testPassed;
    }
}

AuthAjax.prototype.createInputErrorMessage = function (input,errorMessage) {
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

AuthAjax.prototype.deleteInputErrorMessage = function (input) {
    let inputContainer = input.parentNode;
    if (inputContainer.classList.contains(this.setting.containerInputErrorClass)) {
        inputContainer.classList.remove(this.setting.containerInputErrorClass);
    }

    let errorContainer = inputContainer.querySelector('.'+this.setting.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }
}

AuthAjax.prototype.resetForm = function (input) {
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

AuthAjax.prototype.enterErrors = function (jsonFields) {
    const _this = this;
    if (this.$form) {
        if (this.$formInputs) {
            this.$formInputs.forEach((input) => {
                _this.createInputErrorMessage(input,jsonFields[_this.setting.errorArrKey]);
            });
        }
    }
}

AuthAjax.prototype.sendData = function (data) {
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
            location.reload();
        }

    }).catch(error => {
        console.log(error);
    });
}
addEventListener('DOMContentLoaded', () => {
    new AuthAjax();
});