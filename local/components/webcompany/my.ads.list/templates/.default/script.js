const DeactivateItemApp = function () {
    this.settings = {
        'DeactivateItemAppLinkSelector':'.DeactivateItemApp-list .DeactivateItemApp-list__item a',
        'switcherBtnClass':'.announcements-switch__item',
        'loaderClassName':'lds-heart',
        'loaderContainerClass':'.announcements-content',
        'blurContainerClass':'.announcements-content__item',
        'blurClass':'blur',
        'elementsClass':'.announcements-content__item',
        'elementsContainerClass':'.announcements-content',
    }

    this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
    this.init();
}

DeactivateItemApp.prototype.init = function () {
    this.setEventListener();
    this.createLoader();
    this.sendData('',{'isAjax': 'Y',});
}

DeactivateItemApp.prototype.setEventListener = function () {
    const _this = this;
    this.$arAllDeactivateItemAppLinks = document.querySelectorAll(this.settings.DeactivateItemAppLinkSelector);

    if (this.$arAllDeactivateItemAppLinks.length > 0) {
        this.$arAllDeactivateItemAppLinks.forEach((DeactivateItemAppLink) => {
            DeactivateItemAppLink.onclick = () => {
                event.preventDefault();
                if (!DeactivateItemAppLink.parentNode.classList.contains('active')) {
                    let requestLink = DeactivateItemAppLink.getAttribute('href');
                    _this.setLoader();
                    _this.sendData(requestLink,{'ajax': 'y',});
                }
            }
        });
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

DeactivateItemApp.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

DeactivateItemApp.prototype.sendData = function (link,data) {
    const _this = this;
    console.log(123);
    fetch('ajax.php', {
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

        window.history.replaceState(null, null, link);

    }).catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new DeactivateItemApp();
});