const ForgotPass = function () {
    this.setting = {
        'formId':'#forgot-pass',
        'containerInputErrorClass':'error',
        'errorClass':'error-block',
        'errorArrKey':'ERROR_PROCESSING',
        'modalCrossClass':'.modal-cross',
        'popupClass':'.popUp-reset-mail',
        'formBack':'.substrate',
    }

    this.errors = {
        'emptyField':'Обязательное поле!',
        'wrongEmail':'Некоректный email!',
        'smallPass':'Минимум 8 символов!',
        'upperLowerCase':'Пароль должен содержать заглавные и строчные символы!',
        'numbersInPass':'Пароль должен содержать цифры!',
    }

    this.$form = document.querySelector('form' + this.setting.formId);
    this.$popUp = document.querySelector(this.setting.popupClass);
    this.$substrate = document.querySelector(this.setting.formBack);
    this.$formAction = this.$form.getAttribute('action');
    this.$formInputs = this.$form.querySelectorAll('input');
    this.$successContainer = this.$form.parentNode.querySelector('.alert-success');

    this.init();
}

ForgotPass.prototype.init = function () {
    this.setupListener();
}

ForgotPass.prototype.setupListener = function () {
    const _this = this;
    if (this.$form) {
        this.$form.onsubmit = (e) => {
            e.preventDefault();
            let formData = new FormData(this.$form);
            formData.set('AUTH_ACTION', 'Y');
            formData.set('forgot_pass', 'Y');
            if (_this.checkFormFields()) {
                _this.sendData(formData);
            }
        }
    }

    _this.resetFormEvent();
}

ForgotPass.prototype.resetFormEvent = function () {
    const _this = this;
    if (this.$popUp) {
        let crossBtn = this.$popUp.querySelector(_this.setting.modalCrossClass);
        if (crossBtn) {
            crossBtn.onclick = (e) => {
                _this.resetForm();
            }
        }
    }

    if (this.$substrate) {
        this.$substrate.onclick = () => {
            if (!this.$substrate.classList.contains('active')) {
                _this.resetForm();
            }
        }
    }
}

ForgotPass.prototype.checkFormFields = function () {
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
            } else {
                _this.deleteInputErrorMessage(input);
            }
        });
        return testPassed;
    }
}

ForgotPass.prototype.createInputErrorMessage = function (input,errorMessage) {
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

ForgotPass.prototype.deleteInputErrorMessage = function (input) {
    let inputContainer = input.parentNode;
    if (inputContainer.classList.contains(this.setting.containerInputErrorClass)) {
        inputContainer.classList.remove(this.setting.containerInputErrorClass);
    }

    let errorContainer = inputContainer.querySelector('.'+this.setting.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }
}

ForgotPass.prototype.resetForm = function (input) {
    const _this = this;
    if (this.$form) {
        if (this.$formInputs) {
            this.$formInputs.forEach((input) => {
                _this.deleteInputErrorMessage(input);
            });
        }
        _this.$form.reset();
    }

    if (this.$successContainer.style.display === 'block') {
        this.$successContainer.innerHTML = '';
        this.$successContainer.style.display = 'none';
    }
}

ForgotPass.prototype.processJson = function (jsonFields) {
    if (jsonFields['ERROR_PROCESSING']) {
        this.enterErrors(jsonFields);
    } else {
        this.enterSuccess(jsonFields);
    }
}

ForgotPass.prototype.enterErrors = function (jsonFields) {
    const _this = this;
    if (this.$successContainer.style.display === 'block') {
        this.$successContainer.innerHTML = '';
        this.$successContainer.style.display = 'none';
    }

    if (this.$form) {
        if (this.$formInputs) {
            this.$formInputs.forEach((input) => {
                _this.createInputErrorMessage(input,jsonFields[_this.setting.errorArrKey]);
            });
        }
    }
}

ForgotPass.prototype.enterSuccess = function (jsonFields) {
    const _this = this;
    if (this.$form) {
        if (this.$formInputs) {
            this.$formInputs.forEach((input) => {
                _this.deleteInputErrorMessage(input);
            });
        }
        if (jsonFields['SUCCESS'] && this.$successContainer) {
            this.$successContainer.innerHTML = jsonFields['SUCCESS'];
            this.$successContainer.style.display = 'block';
        }
    }
}

ForgotPass.prototype.sendData = function (data) {
    const _this = this;
    fetch(_this.$formAction, {
        method: 'POST',
        cache: 'no-cache',
        body: data,
        headers: {
            'X-Requested-With' : 'XMLHttpRequest'
        }
    }).then(function(response) {
        return response.text()
    }).then(function(jsonResponse) {
        if (jsonResponse) {
            let jsonFields = JSON.parse(jsonResponse);
            _this.processJson(jsonFields);
        }
    }).catch(error => {
        console.log(error);
    });
}
addEventListener('DOMContentLoaded', () => {
    new ForgotPass();
});