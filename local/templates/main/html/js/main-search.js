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
        for (let mainFiledCode in this.dependenceList) {
            const mainField = document.querySelector('select#'+mainFiledCode);
            const dependenceFieldCode = this.dependenceList[mainFiledCode];
            mainField.onchange = () => {
                let dependencySelect = document.querySelector('select#'+dependenceFieldCode);
                if (!mainField.value) {
                    dependencySelect.options[0].selected = true;
                }
                // Ставим в видимое значение зависимого поля его стандартный option
                dependencySelect.parentNode.querySelector('.jq-selectbox__select-text')
                    .innerHTML = dependencySelect.options[0].innerHTML;
                _this.filterDependencyValues(mainField, dependenceFieldCode);
            }

            let isDependencyFieldDefaultBlocked = false;
            const isMainFieldChosen = mainField.options[0].selected !== true;
            let observer = new MutationObserver(mutationRecords => {
                if (!isDependencyFieldDefaultBlocked) {
                    if (!isMainFieldChosen) {
                        let dependenceClickContainer = document.querySelector('#'+dependenceFieldCode+'-styler');
                        let selectVision = dependenceClickContainer.querySelector('.jq-selectbox__select');
                        dependenceClickContainer.style.pointerEvents = 'none';
                        selectVision.style.background = '#e8e8e8'; // #d5d5d5
                    } else {
                        _this.filterDependencyValues(mainField, dependenceFieldCode);
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

PropSearch.prototype.filterDependencyValues = function (mainField, dependenceFieldCode)
{
    let dependencyFilter = mainField.querySelector(`option[value="${mainField.value}"]`)
        .getAttribute('data-dependency');
    let dependenceLi = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelectorAll('.jq-selectbox__dropdown li');

    let blockField = true;
    let defaultAllOption = 'Любой';
    if (dependenceLi) {
        for (let li of dependenceLi) {
            if (li.getAttribute('data-dependency') !== dependencyFilter) {
                li.style.display = 'none';
            } else {
                blockField = false;
                li.style.display = 'block';
            }

            if (li.getAttribute('data-dependency') === null) {
                li.style.display = 'block';
                defaultAllOption = li.innerHTML;
            }
        }
    }

    let dependenceClickContainer = document.querySelector('#'+dependenceFieldCode+'-styler');
    let selectVision = dependenceClickContainer.querySelector('.jq-selectbox__select');
    if (!dependencyFilter || blockField) {
        dependenceClickContainer.style.pointerEvents = 'none';
        selectVision.style.background = '#e8e8e8'; // #d5d5d5
        dependenceClickContainer.querySelector('.jq-selectbox__select-text').innerHTML = defaultAllOption;
    } else {
        dependenceClickContainer.style.pointerEvents = 'all';
        selectVision.style.background = '#fff'; // #fff
    }
}

addEventListener('DOMContentLoaded',() => {
    new PropSearch();
});