const PersonalData = function () {

    this.setting = {
        'saveButton': '.data-user button[name="save"]',
        'form': 'form#form-change-pass',
        'containerInputErrorClass':'error',
        'errorClass':'error-block',
        'additionalField':'REGISTER[EMAIL]',
        'acceptCheckboxId':'#accept-register',
        'modalCrossClass':'.modal-cross',
        'popupClass':'.popUp-success',
        'formBack':'.substrate',
    }

    this.errors = {
        'emptyField':'Обязательное поле!',
        'wrongEmail':'Некоректный email!',
        'smallPass':'Минимум 8 символов!',
        'upperCase':'Пароль должен содержать заглавные символны!',
        'lowerCase':'Пароль должен содержать строчные символны!',
        'numbersInPass':'Пароль должен содержать цифры!',
        'passNotMatch':'Пароли не совпадают!'

    }

    this.$form = document.querySelector(this.setting.form);
    this.$popup = document.querySelector(this.setting.popupClass);
    this.$formBack = document.querySelector(this.setting.formBack);
    this.$formInputs = document.querySelectorAll(this.setting.form + ' input');
    this.$saveBtn = document.querySelector(this.setting.saveButton);

    this.init();
}

PersonalData.prototype.init = function ()
{
    this.setupListener();
}

PersonalData.prototype.setupListener = function ()
{
    const _this = this;
    if (this.$saveBtn) {
        this.$saveBtn.onclick = (e) => {
            e.preventDefault();
            if (_this.checkFormFields()) {
                let form = new FormData(_this.$form);
                form.append('savePassAjax', 'y');
                form.append('save', 'Сохранить');
                _this.sendData(form);
            }
        }
    }
}

PersonalData.prototype.checkFormFields = function () {
    const _this = this;
    if (this.$formInputs) {
        let testPassed = true;
        this.$formInputs.forEach((input) => {
            let errors = [];
            const inputType = input.getAttribute('type');
            if (inputType === 'text' || inputType === 'password') {
                if (input.value.length < 8) {
                    errors.push(_this.errors.smallPass);
                }
                // В пароле присутствует хотя бы одна буква нижнего регистра
                if (!/(?=.*[a-z])/.test(input.value)) {
                    errors.push(_this.errors.lowerCase);
                }
                // В пароле присутствует хотя бы одна буква верхнего регистра
                if (!/(?=.*[A-Z])/.test(input.value)) {
                    errors.push(_this.errors.upperCase);
                }
                // В пароле присутствует хотя бы одна цифра
                if (!/[0-9]/.test(input.value)) {
                    errors.push(_this.errors.numbersInPass);
                }

                let errorMessage = errors.join('<br>');

                if (input.getAttribute('data-validate') === 'n') {
                    if (_this.$form.querySelector('input[name="NEW_PASSWORD"]').value !== input.value) {
                        errorMessage = _this.errors.passNotMatch;
                        _this.createInputErrorMessage(input,errorMessage);
                    }
                } else {
                    _this.createInputErrorMessage(input,errorMessage);
                }


                if (errorMessage) {
                    testPassed = false;
                } else {
                    _this.deleteInputErrorMessage(input);
                }
            }
        });
        return testPassed;
    }
    return false;
}

PersonalData.prototype.createInputErrorMessage = function (input,errorMessage) {
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

PersonalData.prototype.deleteInputErrorMessage = function (input) {
    let inputContainer = input.parentNode;
    if (inputContainer.classList.contains(this.setting.containerInputErrorClass)) {
        inputContainer.classList.remove(this.setting.containerInputErrorClass);
    }

    let errorContainer = inputContainer.querySelector('.'+this.setting.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }

}

PersonalData.prototype.enterErrors = function (message) {
    const _this = this;
    if (this.$form) {
        let input = _this.$form.querySelector("input[name='NEW_PASSWORD']");
        _this.createInputErrorMessage(input,message);
    }
}

PersonalData.prototype.cleanInputs = function () {
    const _this = this;
    if (this.$formInputs) {
        this.$formInputs.forEach((input) => {
            _this.deleteInputErrorMessage(input);
        });
    }
}


PersonalData.prototype.sendData = function (data) {
    const _this = this;
    fetch('', {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.json()
    }).then(function(json) {
        if (json['response']) {
            _this.enterErrors(json['response']);
        } else {
            if (_this.$formBack && _this.$popup) {
                _this.$formBack.classList.add('active');
                _this.$popup.classList.add('active');
                _this.cleanInputs();
                _this.$form.reset();
            }
        }
    }).catch(error => {
        // console.log(error);
    });
}

addEventListener('DOMContentLoaded',() => {
    new PersonalData();
});