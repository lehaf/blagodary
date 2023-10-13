const PropSearch = function () {
    this.settings = {
        'idForm':'main-search',
        'nameInputId':'#form-search-main',
        'regionInputId':'#selectRegion',
        'cityInputId':'#selectCity'
    }

    this.dependenceList = {
        'selectRegion':'selectCity'
    };

    this.$form = document.getElementById(this.settings.idForm);
    this.$action = this.$form.getAttribute('action');
    this.$searchUrl = location.origin + this.$action +'?q=';
    this.init();
}

PropSearch.prototype.init = function () {
    this.setEventListener();
    this.setDependentLists();
}

PropSearch.prototype.setEventListener = function () {
    if (this.$form) {
        this.$form.onsubmit = (e) => {
            e.preventDefault();
            let goodName = this.$form.querySelector(this.settings.nameInputId).value;
            let region = this.$form.querySelector(this.settings.regionInputId).value;
            let cityInputId = this.$form.querySelector(this.settings.cityInputId).value;
            let searchParams = '';
            if (goodName.length > 0) searchParams += goodName;
            if (region.length > 0 && searchParams.length > 0) searchParams += '+';
            if (region.length > 0) searchParams += region;
            if (cityInputId.length > 0 && searchParams.length > 0) searchParams += '+';
            if (cityInputId) searchParams+= cityInputId;
            if (searchParams.length > 0) this.$searchUrl += searchParams;
            location.href = this.$searchUrl;
        }
    }
}

PropSearch.prototype.setDependentLists = function ()
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
            const isMainFieldChosen = mainField.options[0].selected !== true;
            let observer = new MutationObserver(mutationRecords => {
                if (!isDependencyFieldDefaultBlocked) {
                    if (!isMainFieldChosen) {
                        _this.showDisable(dependenceFieldCode);
                    } else {
                        const selectedOption = document.querySelector('select#'+dependenceFieldCode+' option[selected]');
                        let cities = selectedOption.getAttribute('data-cities');
                        _this.filterDependencyValues(cities, dependenceFieldCode);
                    }
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

PropSearch.prototype.showDisable = function (dependenceFieldCode)
{
    const dependenceViewSelectContainer = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelector('span.selectbox');
    dependenceViewSelectContainer.style.pointerEvents = 'none';
    dependenceViewSelectContainer.querySelector('div.select').style.background = '#e8e8e8'; // #d5d5d5
}

PropSearch.prototype.hideDisable = function (dependenceFieldCode)
{
    const dependenceViewSelectContainer = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelector('span.selectbox');
    dependenceViewSelectContainer.style.pointerEvents = 'all';
    dependenceViewSelectContainer.querySelector('div.select').style.background = '#fff'; // #d5d5d5
}

PropSearch.prototype.filterDependencyValues = function (cities, dependenceFieldCode)
{
    const _this = this;
    const dependenceField = document.querySelector('select#'+dependenceFieldCode);
    const dependenceSelectBoxLi = dependenceField.parentNode.querySelectorAll('.selectbox .dropdown li');

    if (dependenceSelectBoxLi) {
        let firstValueClicked = false;
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

PropSearch.prototype.showAllValues = function (dependenceFieldCode)
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

addEventListener('DOMContentLoaded',() => {
    new PropSearch();
});