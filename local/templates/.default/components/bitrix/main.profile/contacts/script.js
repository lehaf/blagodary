const PhoneController = function () {

    this.settings = {
        'saveButton': '.data-user button[name="save"]',
        'form': 'form#form-contacts-info',
    }

     this.templatePhone = `
         <div class="form-group form-group--tel">
             <label class="data-user__label data-user__label--tel">Контактный телефон*</label>
             <input type="tel" name="UF_PHONES[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" name="new-number">
             <span class="remove_phone"><svg><use xlink:href="/local/templates/main/html/assets/img/sprites/sprite.svg#cross-popup"></use></svg></span>
         </div>
        `;

    this.dependenceList = {
        'REGION':'CITY'
    };

    this.$form = document.querySelector(this.settings.form);
    this.$saveBtn = document.querySelector(this.settings.saveButton);

    this.init();
}

PhoneController.prototype.init = function ()
{
    this.setupListener();
    this.initPhoneMask();
    this.deletePhone();
    this.setDependentLists();
}

PhoneController.prototype.setupListener = function ()
{
    const _this = this;
    $('.add-new-phone').on('click', function () {
        $('.form-tel-container').append(_this.templatePhone);
        _this.initPhoneMask();
        _this.deletePhone();
    });

    if (this.$saveBtn) {
        this.$saveBtn.onclick = (e) => {
            e.preventDefault();
            let form = new FormData(_this.$form);
            if (!form.has('UF_PHONES')) form.append('UF_PHONES[]', '')
            form.append('save', 'Сохранить');
            _this.sendData(form);
        }
    }
}

PhoneController.prototype.initPhoneMask = function ()
{
    $(".dataUserTel").mask("+375 (99) 999-99-99");
}
PhoneController.prototype.deletePhone = function ()
{
    $(".remove_phone").on("click",function(){
        this.parentElement.remove();
    });
}


PhoneController.prototype.setDependentLists = function ()
{
    const _this = this;
    if (this.dependenceList) {
        for (let mainFiledCode in this.dependenceList) {
            const mainField = document.querySelector('select#'+mainFiledCode);
            const dependenceFieldCode = this.dependenceList[mainFiledCode];
            mainField.onchange = () => {
                _this.filterDependencyValues(mainField, dependenceFieldCode);
            }

            let isDependencyFieldDefaultBlocked = false;
            let dependencySelect = document.querySelector('select#'+dependenceFieldCode);
            const needClick = dependencySelect.options[0].selected !== true;
            let observer = new MutationObserver(mutationRecords => {
                if (!isDependencyFieldDefaultBlocked) {
                    _this.filterDependencyValues(mainField, dependenceFieldCode, needClick);
                    isDependencyFieldDefaultBlocked = true;
                }
            });
            // Контейнер для зависимого select
            let dependencySelectContainer = document.querySelector('select#'+dependenceFieldCode).parentNode;
            // наблюдать за зависимым select
            observer.observe(dependencySelectContainer, {
                childList: true, // наблюдать за непосредственными детьми
                subtree: true // и более глубокими потомками
            });

        }
    }
}

PhoneController.prototype.filterDependencyValues = function (mainField, dependenceFieldCode, skipClick = false)
{
    let dependencyFilter = mainField.querySelector(`option[value="${mainField.value}"]`)
        .getAttribute('data-dependency');

    let dependenceLi = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelectorAll('.jq-selectbox__dropdown li');

    if (dependenceLi) {
        let i = 0;
        for (let li of dependenceLi) {
            if (li.getAttribute('data-dependency') !== dependencyFilter) {
                li.style.display = 'none';
            } else {
                if (i === 0 && !skipClick) {
                    li.click();
                }
                li.style.display = 'block';
                i++;
            }
        }
    }
}

PhoneController.prototype.sendData = function (data) {
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
    new PhoneController();
});