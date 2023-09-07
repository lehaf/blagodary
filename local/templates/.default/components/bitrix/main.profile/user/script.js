const PersonalData = function () {

    this.settings = {
        'saveButton': '.data-user button[name="save"]',
        'form': 'form#form-personal-data',
    }

    this.$form = document.querySelector(this.settings.form);
    this.$saveBtn = document.querySelector(this.settings.saveButton);

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
            let form = new FormData(_this.$form);
            form.append('save', 'Сохранить');
            _this.sendData(form);
        }
    }
}


PersonalData.prototype.sendData = function (data) {
    fetch('', {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
    }).catch(error => {
        // console.log(error);
    });
}

addEventListener('DOMContentLoaded',() => {
    new PersonalData();
});