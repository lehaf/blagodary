const SwitcherView = function () {
    this.settings = {
        'switcherBtnClass':'.announcements-switch__item',
        'loaderClassName':'lds-heart',
        'loaderContainerClass':'.announcements-content',
        'blurContainerClass':'.announcements-content__item',
        'blurClass':'blur',
        'elementsClass':'.announcements-content__item',
        'elementsContainerClass':'.announcements-content',
    }

    this.$arAllSwitchers = document.querySelectorAll(this.settings.switcherBtnClass);
    this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
    this.init();
}

SwitcherView.prototype.init = function () {
    this.setEventListener();
    this.createLoader();
}

SwitcherView.prototype.setEventListener = function () {
    const _this = this;

    if (this.$arAllSwitchers) {
        this.$arAllSwitchers.forEach((switcherBtn) => {
            switcherBtn.onclick = () => {
                if (!switcherBtn.classList.contains('active')) {
                    let typeOfView = switcherBtn.getAttribute('id');
                    _this.setActiveView(switcherBtn);
                    _this.setLoader();
                    _this.sendData({'isAjax': 'Y', 'typeOfView': typeOfView});
                }
            }
        });
    }
}

SwitcherView.prototype.setActiveView = function (elementDom) {
    elementDom.classList.add('active');

    if (elementDom.nextElementSibling) {
        elementDom.nextElementSibling.classList.remove('active');
    } else {
        elementDom.previousElementSibling.classList.remove('active');
    }
}

SwitcherView.prototype.createLoader = function () {
    const loader = document.createElement('div');
    loader.classList.add(this.settings.loaderClassName);
    const innerDiv = document.createElement('div');
    loader.prepend(innerDiv);
    this.$loader = loader;
}

SwitcherView.prototype.setLoader = function () {
    this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
    if (this.$loader && this.$loaderContainer && this.$blurContainer) {
        this.$blurContainer.classList.add(this.settings.blurClass);
        this.$loaderContainer.prepend(this.$loader);
    }
}

SwitcherView.prototype.deleteLoader = function () {
    if (this.$blurContainer) {
        this.$blurContainer.classList.remove(this.settings.blurClass);
        document.querySelector('.'+this.settings.loaderClassName).remove();
    }
}

SwitcherView.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

SwitcherView.prototype.sendData = function (typeOfView) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(typeOfView)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        let response = _this.getDomElementsFromString(text);
        let newView = response.querySelector(_this.settings.elementsClass);
        let curContainer = document.querySelector(_this.settings.elementsContainerClass);
        setTimeout(() => {
            _this.deleteLoader();
            let curElements = curContainer.querySelector(_this.settings.elementsClass);
            if (curElements) curElements.remove();
            if (newView) curContainer.prepend(newView);
            if (window.FavoriteManager) window.FavoriteManager.init(); // Реинитим избранное
            if (window.ImageDefer) window.ImageDefer.init(); // Реинитим lazyload
        },300);

    }).catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new SwitcherView();
});