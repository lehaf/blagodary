const DeactivateItemApp = function () {
    this.settings = {
        'action':'setUserRating',
        'deactivateBtnClass':'.deactivate-btn',
        'rateFormId':'#rate-form',
        'containerInputErrorClass':'error',
        'errorClass':'error-block',
        'componentName':'webcompany:my.ads.list',
        'componentActionGetUsers':'getAdsWantTakeListUsers',
        'componentActionDeactivate':'setUserRatingAndDeactivate',
        'usersLiClass':'.grade-list-person',
        'itemIdAttr':'data-item-id',
        'userIdAttr':'data-user-id',
        'loaderClassName':'lds-heart',
        'blurClass':'blur',
        'popUpUsersContainerSelector':'.popUp-rate ul.person-list-list',
        'loaderContainerClass':'.person-list-container',
        'blurContainerClass':'.person-list-list',
        'elementsClass':'.announcements-content__item',
        'elementsContainerClass':'.announcements-content'
    }

    this.errors = {
        'borderErrorClass':'valid-error',
        'ratingMessage':'Выставьте оценку!',
    }

    this.$usersContainer = document.querySelector(this.settings.popUpUsersContainerSelector);
    this.$rateForm = document.querySelector(this.settings.rateFormId);
    this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
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
            btn.onclick = () => {
                this.$rateForm.reset();
                this.clearErrors();
                let adsId = btn.getAttribute(this.settings.itemIdAttr);
                if (adsId && this.$requestAdsId != adsId) {
                    this.$requestAdsId = adsId;
                    _this.setLoader();
                    let data = {
                        'component': _this.settings.componentName,
                        'action': _this.settings.componentActionGetUsers,
                        'ads_id': adsId,
                    }
                    _this.getUserData(data);
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
                    formData.set('component',_this.settings.componentName);
                    formData.set('action',_this.settings.componentActionDeactivate);
                    _this.sendData(formData);
                }
            }
        }
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
    errorDiv.classList.add(this.settings.errorClass);
    errorDiv.innerHTML = errorMessage;

    if (!container.classList.contains(this.settings.containerInputErrorClass)) {
        container.classList.add(this.settings.containerInputErrorClass);
    }

    let errorContainer = container.querySelector('.'+this.settings.errorClass);
    if (!errorContainer) {
        container.append(errorDiv);
    } else {
        errorContainer.innerHTML = errorMessage;
    }
}

DeactivateItemApp.prototype.deleteInputErrorMessage = function (container) {

    if (container.classList.contains(this.settings.containerInputErrorClass)) {
        container.classList.remove(this.settings.containerInputErrorClass);
    }

    let errorContainer = container.querySelector('.'+this.settings.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }
}

DeactivateItemApp.prototype.createLoader = function () {
    const loader = document.createElement('div');
    loader.classList.add(this.settings.loaderClassName);
    const innerDiv = document.createElement('div');
    loader.prepend(innerDiv);
    this.$loader = loader;
}

DeactivateItemApp.prototype.setLoader = function () {
    this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
    if (this.$loader && this.$loaderContainer && this.$blurContainer) {
        this.$blurContainer.classList.add(this.settings.blurClass);
        this.$loaderContainer.prepend(this.$loader);
    }
}

DeactivateItemApp.prototype.deleteLoader = function () {
    this.$blurContainer.classList.remove(this.settings.blurClass);
    document.querySelector('.'+this.settings.loaderClassName).remove();
}

DeactivateItemApp.prototype.insertEmptyMessage = function () {
    let message = `<div class="empty-mess">Пользователи еще не интересовались объявлением</div>`;
    this.$usersContainer.insertAdjacentHTML('beforeend',message);
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
        } else {
            _this.insertEmptyMessage();
        }
        setTimeout(() => {
            _this.deleteLoader();
            _this.setEventListener();
        },300);
    }).catch(error => {
        _this.deleteLoader();
        console.log(error);
    });
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
        let nextElementsContainer = response.querySelector(_this.settings.elementsContainerClass);
        let curContainer = document.querySelector(_this.settings.elementsContainerClass);
        setTimeout(() => {
            _this.deleteLoader();
            curContainer.innerHTML = nextElementsContainer.innerHTML;
            _this.setEventListener();
            window.FavoriteManager.init();
        },300);

    }).catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new DeactivateItemApp();
});