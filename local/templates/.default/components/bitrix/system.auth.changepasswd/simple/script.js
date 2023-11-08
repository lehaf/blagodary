const ChangePassChecker = function () {

    this.setting = {
        'saveButton': 'button#change-pass',
        'form': 'form#changePass',
        'containerInputErrorClass':'error',
        'errorClass':'error-block',
    }

    this.errors = {
        'emptyField':'Обязательное поле!',
        'smallPass':'Минимум 8 символов!',
        'upperCase':'Пароль должен содержать заглавные символны!',
        'lowerCase':'Пароль должен содержать строчные символны!',
        'numbersInPass':'Пароль должен содержать цифры!',
        'passNotMatch':'Пароли не совпадают!'

    }

    this.$form = document.querySelector(this.setting.form);
    this.$formInputs = document.querySelectorAll(this.setting.form + ' input');
    this.$saveBtn = document.querySelector(this.setting.saveButton);

    this.init();
}

ChangePassChecker.prototype.init = function ()
{
    this.setupListener();
}

ChangePassChecker.prototype.setupListener = function ()
{
    const _this = this;
    if (this.$saveBtn) {
        this.$saveBtn.onclick = (e) => {
            if (!_this.checkFormFields())
                e.preventDefault();
        }
    }
}

ChangePassChecker.prototype.checkFormFields = function () {
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
                    if (_this.$form.querySelector('input[name="USER_PASSWORD"]').value !== input.value) {
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

ChangePassChecker.prototype.createInputErrorMessage = function (input,errorMessage) {
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

ChangePassChecker.prototype.deleteInputErrorMessage = function (input) {
    let inputContainer = input.parentNode;
    if (inputContainer.classList.contains(this.setting.containerInputErrorClass)) {
        inputContainer.classList.remove(this.setting.containerInputErrorClass);
    }

    let errorContainer = inputContainer.querySelector('.'+this.setting.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }

}

ChangePassChecker.prototype.enterErrors = function (message) {
    const _this = this;
    if (this.$form) {
        let input = _this.$form.querySelector("input[name='USER_PASSWORD']");
        _this.createInputErrorMessage(input,message);
    }
}

ChangePassChecker.prototype.cleanInputs = function () {
    const _this = this;
    if (this.$formInputs) {
        this.$formInputs.forEach((input) => {
            _this.deleteInputErrorMessage(input);
        });
    }
}


addEventListener('DOMContentLoaded',() => {
    new ChangePassChecker();
});