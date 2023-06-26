const FavoriteManager = function () {
    this.settings = {
        'link':'/personal/favorites/',
        'favoriteBtnClass':'.favorite-card',
        'itemIdAttrName':'data-item',
        'addFavoriteMethod':'add',
        'deleteFavoriteMethod':'delete',
        'getFavoriteMethod':'get'
    }

    this.$arAllbtns = document.querySelectorAll(this.settings.favoriteBtnClass);
    this.init();
    window.FavoriteManager = this;
}

FavoriteManager.prototype.init = function () {
    this.getUserFavoriteGoods();
    this.setEventListener();
}

FavoriteManager.prototype.getUserFavoriteGoods = function () {
    const _this = this;
    fetch(_this.settings.link, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({'favorite': 'y', 'method': this.settings.getFavoriteMethod})
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        if (text) {
            _this.setFavoriteGoodsOnPage(text);
        }
    }).catch(error => {
        console.log(error);
    });
}

FavoriteManager.prototype.setEventListener = function () {
    const _this = this;

    if (this.$arAllbtns) {
        this.$arAllbtns.forEach((favoriteBtn) => {
            let itemId = favoriteBtn.getAttribute(_this.settings.itemIdAttrName);
            favoriteBtn.onclick = () => {
                if (!favoriteBtn.classList.contains('active')) {
                    _this.sendData({'favorite': 'y', 'method': _this.settings.addFavoriteMethod,'item_id':itemId});
                } else {
                    _this.sendData({'favorite': 'y', 'method': _this.settings.deleteFavoriteMethod,'item_id':itemId});
                }
            }
        });
    }
}

FavoriteManager.prototype.sendData = function (data) {
    const _this = this;
    fetch(_this.settings.link, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    });
}

FavoriteManager.prototype.setFavoriteGoodsOnPage = function (text) {
    const _this = this;
    this.$arFavorites = JSON.parse(text);
    this.$arAllbtns.forEach((favoriteBtn) => {
        let itemId = Number(favoriteBtn.getAttribute(_this.settings.itemIdAttrName));
        if (_this.$arFavorites.includes(itemId)) {
            favoriteBtn.classList.add('active');
        }
    });
}

addEventListener('DOMContentLoaded',() => {
    new FavoriteManager();
});