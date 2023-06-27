const Favorite = function () {
    this.settings = {
        'loaderClassName':'lds-heart',
        'loaderContainerClass':'.favorites-container',
        'blurContainerClass':'.favorites-list',
        'blurClass':'blur',
        'elementsClass':'.favorites-list',
        'elementsContainerClass':'.favorites-list',
        'favoriteElementClass':'.announcements-list__item',
        'elementDeleteBtn':'.favorite-card',
        'deleteAllBtnClass':'.delete-all',
    }

    this.$deleteAllBtn = document.querySelector(this.settings.deleteAllBtnClass);
    this.$allFavoriteElements = document.querySelectorAll(this.settings.favoriteElementClass);
    this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
    this.init();
}

Favorite.prototype.init = function () {
    this.setEventListener();
    this.createLoader();
}

Favorite.prototype.setEventListener = function () {
    const _this = this;
    if (this.$deleteAllBtn) {
        this.$deleteAllBtn.onclick = () => {
            _this.setLoader();
            _this.sendData('',{'favorite': 'y','method': 'delete_all'});
        }
    }

    if (this.$allFavoriteElements.length > 0 && this.$deleteAllBtn) {
        this.$deleteAllBtn.style.display = 'block';
        // this.$allFavoriteElements.forEach((favoriteElement) => {
        //     let heartBtn = favoriteElement.querySelector(this.settings.elementDeleteBtn);
        //     heartBtn.onclick = () => {
        //         favoriteElement.style.display = 'none';
        //     }
        // });
    }
}

Favorite.prototype.createLoader = function () {
    const loader = document.createElement('div');
    loader.classList.add(this.settings.loaderClassName);
    const innerDiv = document.createElement('div');
    loader.prepend(innerDiv);
    this.$loader = loader;
}

Favorite.prototype.setLoader = function () {
    this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
    if (this.$loader && this.$loaderContainer && this.$blurContainer) {
        this.$blurContainer.classList.add(this.settings.blurClass);
        this.$loaderContainer.prepend(this.$loader);
    }
}

Favorite.prototype.deleteLoader = function () {
    this.$blurContainer.classList.remove(this.settings.blurClass);
    document.querySelector('.'+this.settings.loaderClassName).remove();
}

Favorite.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

Favorite.prototype.sendData = function (link,data) {
    const _this = this;
    fetch(link, {
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
           _this.$deleteAllBtn.style.display = 'none';
        },300);
        window.history.replaceState(null, null, link);
    }).catch(error => {
        console.log(error);
        _this.deleteLoader();
    });
}

addEventListener('DOMContentLoaded',() => {
    new Favorite();
});