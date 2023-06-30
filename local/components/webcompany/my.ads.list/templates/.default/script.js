const DeactivateItemApp = function () {
    this.settings = {
        'deactivateBtnClass':'.deactivate-btn',
        'rateFormId':'#rate-form',
        'usersLiClass':'.grade-list-person',
        'itemIdAttr':'data-item-id',
        'userIdAttr':'data-user-id',
        'popUpUsersContainerSelector':'.popUp-rate ul.person-list-list',
        'ajaxResAdsContainerClass':'.user-list-ads'
    }

    this.component = {
        'name':'webcompany:my.ads.list',
        'actionGetUsers':'getAdsWantTakeListUsers',
        'actionDeactivate':'setUserRatingAndDeactivate',
        'actionOnlyDeactivate':'deactivate'
    }

    this.loader = {
        'loaderClassName':'lds-heart',
        'blurClass':'blur',
        'blurUserContainerClass':'.person-list-list',
        'elementsClass':'.announcements-content__item',
        'loaderContainerClass':'.person-list-container',
        'loaderItemContainerClass':'.loader-container',
        'elementsContainerClass':'.announcements-content'
    }

    this.errors = {
        'borderErrorClass':'valid-error',
        'errorClass':'error-block',
        'containerInputErrorClass':'error',
        'ratingMessage':'Выставьте оценку!'
    }

    this.$popUp = document.querySelector('#popUp-rate');
    this.$popUpBack = document.querySelector('.substrate');
    this.$usersContainer = document.querySelector(this.settings.popUpUsersContainerSelector);
    this.$rateForm = document.querySelector(this.settings.rateFormId);
    this.init();
}

DeactivateItemApp.prototype.init = function () {
    this.setEventListener();
    this.createLoader();
}

DeactivateItemApp.prototype.setEventListener = function () {
    const _this = this;
    this.$deactivateButns = document.querySelectorAll(this.settings.deactivateBtnClass);

    if (this.$deactivateButns.length > 0) {
        this.$deactivateButns.forEach((btn) => {
            btn.onclick = (e) => {
                e.preventDefault();
                let adsId = btn.getAttribute(_this.settings.itemIdAttr);
                if (adsId && _this.$requestAdsId !== adsId) {
                    _this.$requestAdsId = adsId;
                    _this.setLoader(_this.loader.blurUserContainerClass,_this.loader.loaderContainerClass);
                    let data = {
                        'component': _this.component.name,
                        'action': _this.component.actionGetUsers,
                        'ads_id': adsId,
                    }
                    _this.getUserData(data);
                } else {
                    if (_this.$formShowed === true) {
                        _this.showModal();
                    }
                }
            }
        });
    }

    if (this.$rateForm) {
        this.$rateForm.onsubmit = (e) => {
            e.preventDefault();
            if (_this.checkRatingForm()) {
                let formData = new FormData(_this.$rateForm);
                if (this.$formUserId) {
                    formData.set('user_id',_this.$formUserId);
                    formData.set('ads_id',_this.$requestAdsId);
                    formData.set('component',_this.component.name);
                    formData.set('action',_this.component.actionDeactivate);
                    _this.setLoader(_this.settings.ajaxResAdsContainerClass,_this.loader.loaderItemContainerClass);
                    _this.hideModal();
                    _this.sendData(formData);
                }
            }
        }
    }
}

DeactivateItemApp.prototype.showModal = function () {
    if (this.$popUp && this.$popUpBack){
        this.$popUp.classList.add('active');
        this.$popUpBack.classList.add('active');
    }
}

DeactivateItemApp.prototype.hideModal = function () {
    if (this.$popUp && this.$popUpBack){
        this.$popUp.classList.remove('active');
        this.$popUpBack.classList.remove('active');
    }
}

DeactivateItemApp.prototype.checkRatingForm = function () {
    const chosenUsers = this.$usersContainer.querySelector(this.settings.usersLiClass+'.active');
    const usersContainer = document.querySelector('.person-list-container');
    let formValid = true;
    if (chosenUsers && usersContainer) {
        this.$formUserId = chosenUsers.getAttribute(this.settings.userIdAttr);
        usersContainer.classList.remove(this.errors.borderErrorClass);
    } else {
        formValid = false;
        usersContainer.classList.add(this.errors.borderErrorClass);
    }

    let textarea = this.$rateForm.querySelector('textarea');
    if (!textarea.value) {
        formValid = false;
        textarea.classList.add(this.errors.borderErrorClass);
    } else {
        textarea.classList.remove(this.errors.borderErrorClass);
    }

    if (document.querySelector('input[name="RATING"]')) {
        let allRatingStars = document.querySelectorAll('input[name="RATING"]');
        if (allRatingStars) {
            let oneChecked = false;
            allRatingStars.forEach((starBtn) => {
                if (starBtn.checked) {
                    oneChecked = true;
                }
            });
            if (oneChecked === false) {
                this.createInputErrorMessage(document.querySelector('.form-group-rate'),this.errors.ratingMessage);
                formValid = false;
            } else {
                this.deleteInputErrorMessage(document.querySelector('.form-group-rate'));
            }
        }
    }
    return formValid;
}

DeactivateItemApp.prototype.clearErrors = function () {
    document.querySelector('.person-list-container').classList.remove(this.errors.borderErrorClass);
    this.$rateForm.querySelector('textarea').classList.remove(this.errors.borderErrorClass);
    this.deleteInputErrorMessage(document.querySelector('.form-group-rate'));
}

DeactivateItemApp.prototype.addUsers = function (json) {
    const _this = this;
    json.forEach((user) => {
        const userTemplate = _this.createUser(user);
        this.$usersContainer.insertAdjacentHTML('beforeend',userTemplate);
    });
    this.activeChosenUser();
}

DeactivateItemApp.prototype.activeChosenUser = function () {
    const usersLi = this.$usersContainer.querySelectorAll(this.settings.usersLiClass);
    if (usersLi) {
        usersLi.forEach((li) => {
            li.onclick = () => {
                usersLi.forEach((liTag) => {
                    liTag.classList.remove('active');
                });
                li.classList.add('active');
            };
        });
    }
}

DeactivateItemApp.prototype.createUser = function (user) {
    let userTemplate = `<li data-user-id="${user['ID']}" class="grade-list-person"><div class="grade-list-person__name">${user['NAME']}</div>`;
    if (user['UF_PHONES']) {
        user['UF_PHONES'].forEach((phone) => {
            const phoneTemplate = `<div class="grade-list-person__phone">${phone}</div>`;
            userTemplate += phoneTemplate;
        });
    }
    userTemplate += `</li>`;
    return userTemplate;
}

DeactivateItemApp.prototype.createInputErrorMessage = function (container,errorMessage) {
    let errorDiv = document.createElement('div');
    errorDiv.classList.add(this.errors.errorClass);
    errorDiv.innerHTML = errorMessage;

    if (!container.classList.contains(this.errors.containerInputErrorClass)) {
        container.classList.add(this.errors.containerInputErrorClass);
    }

    let errorContainer = container.querySelector('.'+this.errors.errorClass);
    if (!errorContainer) {
        container.append(errorDiv);
    } else {
        errorContainer.innerHTML = errorMessage;
    }
}

DeactivateItemApp.prototype.deleteInputErrorMessage = function (container) {

    if (container.classList.contains(this.errors.containerInputErrorClass)) {
        container.classList.remove(this.errors.containerInputErrorClass);
    }

    let errorContainer = container.querySelector('.'+this.errors.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }
}

DeactivateItemApp.prototype.createLoader = function () {
    const loader = document.createElement('div');
    loader.classList.add(this.loader.loaderClassName);
    const innerDiv = document.createElement('div');
    loader.prepend(innerDiv);
    this.$loader = loader;
}

DeactivateItemApp.prototype.setLoader = function (blurContainer, loaderContainer) {
    if (this.$blurContainer) {
        this.deleteLoader();
    }
    this.$blurContainer = document.querySelector(blurContainer);
    this.$loaderContainer = document.querySelector(loaderContainer);
    if (this.$loader && this.$loaderContainer && this.$blurContainer) {
        this.$blurContainer.classList.add(this.loader.blurClass);
        this.$loaderContainer.prepend(this.$loader);
    }
}

DeactivateItemApp.prototype.deleteLoader = function () {
    if (this.$blurContainer) {
        this.$blurContainer.classList.remove(this.loader.blurClass);
        let loader = document.querySelector('.'+this.loader.loaderClassName);
        if (loader) loader.remove();
    }
}

DeactivateItemApp.prototype.onlyDeactivateItem = function () {
    if (this.$requestAdsId) {
        let data = {
            'component': this.component.name,
            'action': this.component.actionOnlyDeactivate,
            'ads_id': this.$requestAdsId,
        }
        this.sendData(data);
    }
}

DeactivateItemApp.prototype.getUserData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.json()
    }).then(function(json) {
        _this.$usersContainer.innerHTML = '';
        if (json.length > 0) {
            _this.addUsers(json);
            _this.$rateForm.reset();
            _this.clearErrors();
            _this.showModal();
            _this.$formShowed = true;
            setTimeout(() => {
                _this.deleteLoader();
                _this.setEventListener();
            },300);
        } else {
            _this.setLoader(_this.settings.ajaxResAdsContainerClass,_this.loader.loaderItemContainerClass);
            _this.onlyDeactivateItem();
            _this.$formShowed = false;
        }
    }).catch(error => {
        _this.deleteLoader();
        console.log(error);
    });
}

DeactivateItemApp.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

DeactivateItemApp.prototype.sendData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        let response = _this.getDomElementsFromString(text);
        let nextElementsContainer = response.querySelector(_this.settings.ajaxResAdsContainerClass);
        let curContainer = document.querySelector(_this.settings.ajaxResAdsContainerClass);
        setTimeout(() => {
            if (!nextElementsContainer) {
                let emptyItemsDiv = response.querySelector('.no-ads');
                curContainer.parentNode.append(emptyItemsDiv);
                curContainer.remove();
            } else {
                curContainer.innerHTML = nextElementsContainer.innerHTML;
            }
            _this.deleteLoader();
            _this.setEventListener();
        },300);

    }).catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new DeactivateItemApp();
});