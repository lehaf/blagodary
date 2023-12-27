const AddUserToWantThisList = function () {
    this.settings = {
        'linkToMyAdsListComponentPage':'/personal/my-ads/',
        'btnWantTakeClass':'.btn-pick-up',
        'curAdsId':'data-ads-id',
        'componentName':'webcompany:my.ads.list',
        'componentMethod':'addUserToWantTakeList',
        'checkUserAction':'checkUser',
    }

    this.$wantTakeBtn = document.querySelector(this.settings.btnWantTakeClass);
    this.init();
}

AddUserToWantThisList.prototype.init = function () {
    this.setEventListener();
}

AddUserToWantThisList.prototype.setEventListener = function () {
    const _this = this;
    if (this.$wantTakeBtn) {
        this.$wantTakeBtn.onclick = () => {
            // Если блока с телефонами не существует
            if (!document.querySelector('div.card-info__phone > ul.phone-list')) {
                const data = {
                    'action':_this.settings.checkUserAction
                }
                _this.checkUser(data);
            }
        }
    }
}

AddUserToWantThisList.prototype.showAuthorizeModal = function () {
    document.querySelector('div.substrate').classList.add('active');
    document.querySelector('div.popUp-login').classList.add('active');
}

AddUserToWantThisList.prototype.showCheckUserErrorModal = function (title, description) {
    document.querySelector('div.popUp-check-user .popUp__title').innerHTML = title;
    document.querySelector('div.popUp-check-user .popUp__description').innerHTML = description;
    document.querySelector('div.substrate').classList.add('active');
    document.querySelector('div.popUp-check-user').classList.add('active');
}

AddUserToWantThisList.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

AddUserToWantThisList.prototype.checkUser = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'x-requested-with': 'XMLHttpRequest',
        },
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.json()
    }).then(function(json) {
        // Показываем модалку с ошибкой
        if (json.ERROR_AUTHORIZE) {
            _this.showAuthorizeModal();
        } else if (json.ERROR_TITLE) {
            _this.showCheckUserErrorModal(json.ERROR_TITLE, json.ERROR_DESCRIPTION);
        } else {
            // Показываем телефоны владельца объявления
            if (json.PHONES) {
                const phonesHtml = _this.getDomElementsFromString(json.PHONES).querySelector('body ul');
                document.querySelector('div.card-info__phone').append(phonesHtml);
                $(".phone-list").slideDown("slow");

                // Отправляем пользователя который хочет забрать данное объевление
                const curAdsId = _this.$wantTakeBtn.getAttribute(_this.settings.curAdsId);
                if (curAdsId && !_this.$userAlreadyPostData) {
                    const data = {
                        'ads_id':curAdsId,
                        'component':_this.settings.componentName,
                        'action':_this.settings.componentMethod
                    }
                    _this.sendData(data);
                }
            }
        }
    }).catch(error => {
        // console.log(error);
    });
}

AddUserToWantThisList.prototype.sendData = function (data) {
    const _this = this;
    _this.$userAlreadyPostData = true;
    fetch(_this.settings.linkToMyAdsListComponentPage, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).catch(error => {
        // console.log(error);
    });
}

addEventListener('DOMContentLoaded',() => {
    new AddUserToWantThisList();
});