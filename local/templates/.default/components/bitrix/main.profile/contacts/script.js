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
        for (let mainFieldCode in this.dependenceList) {
            const mainField = document.querySelector('select#'+mainFieldCode);
            const dependenceFieldCode = this.dependenceList[mainFieldCode];

            mainField.onchange = () => {
                let dataCities = [];
                for (let option of mainField.options) {
                    if (option.selected === true) {
                        let cities = option.getAttribute('data-cities');
                        // Если есть города то фильтруем
                        if (cities) {
                            dataCities = JSON.parse(cities);
                            if (dataCities) _this.filterDependencyValues(dataCities, dependenceFieldCode);
                            break;
                        } else {
                            // если городов нет то блокируем зависимый селект
                            _this.showAllValues(dependenceFieldCode);
                            _this.showDisable(dependenceFieldCode);
                        }
                    }
                }
            }

            // Блокируем зависимый селект при ините библеотеки селектбокс
            let isDependencyFieldDefaultBlocked = false;
            const selectedOption = mainField.querySelector('option[selected]');
            let observer = new MutationObserver(mutationRecords => {
                if (!isDependencyFieldDefaultBlocked) {
                    let cities = JSON.parse(selectedOption.getAttribute('data-cities'));
                    _this.filterDependencyValues(cities, dependenceFieldCode, false);
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

PhoneController.prototype.showDisable = function (dependenceFieldCode)
{
    const dependenceViewSelectContainer = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelector('span.selectbox');
    dependenceViewSelectContainer.style.pointerEvents = 'none';
    dependenceViewSelectContainer.querySelector('div.select').style.background = '#e8e8e8'; // #d5d5d5
}

PhoneController.prototype.hideDisable = function (dependenceFieldCode)
{
    const dependenceViewSelectContainer = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelector('span.selectbox');
    dependenceViewSelectContainer.style.pointerEvents = 'all';
    dependenceViewSelectContainer.querySelector('div.select').style.background = '#fff'; // #d5d5d5
}

PhoneController.prototype.filterDependencyValues = function (cities, dependenceFieldCode, click = true)
{
    const _this = this;
    const dependenceField = document.querySelector('select#'+dependenceFieldCode);
    const dependenceSelectBoxLi = dependenceField.parentNode.querySelectorAll('.selectbox .dropdown li');
    if (dependenceSelectBoxLi) {

        let firstValueClicked = false === click;
        for (const li of dependenceSelectBoxLi) {
            const cityName = li.innerHTML.trim();
            if (cities && cities.includes(cityName)) {
                li.style.display = 'block';
                if (firstValueClicked === false) {
                    li.click();
                    _this.hideDisable(dependenceFieldCode);
                    firstValueClicked = true;
                }
            } else {
                li.style.display = 'none';
            }
        }
    }
}


PhoneController.prototype.showAllValues = function (dependenceFieldCode)
{
    const dependenceField = document.querySelector('select#'+dependenceFieldCode);
    const dependenceSelectBoxLi = dependenceField.parentNode.querySelectorAll('.selectbox .dropdown li');

    if (dependenceSelectBoxLi) {
        let firstValueClicked = false;
        for (const li of dependenceSelectBoxLi) {
            li.style.display = 'block';
            if (firstValueClicked === false) {
                li.click();
                firstValueClicked = true;
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