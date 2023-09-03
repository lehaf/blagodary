const FavoriteManager = function () {
    this.settings = {
        'link':'/personal/favorites/',
        'favoriteBtnClass':'.favorite-card',
        'itemIdAttrName':'data-item',
        'addFavoriteMethod':'add',
        'deleteFavoriteMethod':'delete',
        'getFavoriteMethod':'get'
    }

    this.init();
    window.FavoriteManager = this;
}

FavoriteManager.prototype.init = function () {
    this.$arAllbtns = document.querySelectorAll(this.settings.favoriteBtnClass);
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
        return response.json()
    }).then(function(json) {
        if (json) {
            _this.setFavoriteGoodsOnPage(json);
        }
    }).catch(error => {
        // console.log(error);
    });
}

FavoriteManager.prototype.setEventListener = function () {
    const _this = this;

    if (this.$arAllbtns) {
        this.$arAllbtns.forEach((favoriteBtn) => {
            let itemId = favoriteBtn.getAttribute(_this.settings.itemIdAttrName);
            favoriteBtn.onclick = (e) => {
                e.preventDefault();
                _this.checkUserAndAddFavorite(favoriteBtn,itemId);
            }
        });
    }
}

FavoriteManager.prototype.checkUserAndAddFavorite = function (favoriteBtn, itemId) {
    const _this = this;
    fetch('/login/user_authorize.php', {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({'user_check':'y'})
        }).then(function(response) {
            return response.json()
        }).then(function(json) {
            if (json['userAuthorize'] === true) {
                favoriteBtn.classList.toggle("active");
                if (favoriteBtn.classList.contains('active')) {
                    _this.sendData({'favorite': 'y', 'method': _this.settings.addFavoriteMethod,'item_id':itemId});
                } else {
                    _this.sendData({'favorite': 'y', 'method': _this.settings.deleteFavoriteMethod,'item_id':itemId});
                }
            } else {
                _this.showLoginPopup();
            }
        }).catch(error => {
            // console.log(error);
        });
}

FavoriteManager.prototype.showLoginPopup = function () {
    document.querySelector('.popUp-login').classList.add("active");
    document.querySelector('.substrate').classList.add("active");
}

// FavoriteManager.prototype.changeDuplicates = function (itemId, method = '') {
//     const _this = this;
//     let duplicates = document.querySelectorAll('span[data-item="'+itemId+'"]');
//     console.log(itemId);
//     duplicates.forEach((favoriteBtn) => {
//        switch (method) {
//            case 'delete':
//                favoriteBtn.classList.remove('active');
//                break;
//            case 'add':
//                favoriteBtn.classList.add('active');
//                break;
//        }
//     });
// }

FavoriteManager.prototype.sendData = function (data) {
    const _this = this;
    fetch(_this.settings.link, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    });
}

FavoriteManager.prototype.setFavoriteGoodsOnPage = function (json) {
    const _this = this;
    this.$arFavorites = json;
    this.$arAllbtns.forEach((favoriteBtn) => {
        let itemId = Number(favoriteBtn.getAttribute(_this.settings.itemIdAttrName));
        if (_this.$arFavorites.includes(itemId)) {
            favoriteBtn.classList.add('active');
        } else {
            favoriteBtn.classList.remove('active');
        }
    });
}

addEventListener('DOMContentLoaded',() => {
    new FavoriteManager();
});