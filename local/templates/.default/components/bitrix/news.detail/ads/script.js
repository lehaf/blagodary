const AddUserToWantThisList = function () {
    this.settings = {
        'linkToMyAdsListComponentPage':'/personal/my-ads/',
        'btnWantTakeClass':'.btn-pick-up',
        'curAdsId':'data-ads-id',
        'componentName':'webcompany:my.ads.list',
        'componentMethod':'addUserToWantTakeList',
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
            const curAdsId = this.$wantTakeBtn.getAttribute(this.settings.curAdsId);
            if (curAdsId && !this.$userAlreadyPostData) {
                const data = {
                    'ads_id':curAdsId,
                    'component':_this.settings.componentName,
                    'action':_this.settings.componentMethod
                }
                _this.sendData(data);
            }
        }
    }
}

AddUserToWantThisList.prototype.sendData = function (data) {
    const _this = this;
    this.$userAlreadyPostData = true;
    fetch(_this.settings.linkToMyAdsListComponentPage, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        console.log(text);
    }).catch(error => {
        // console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new AddUserToWantThisList();
});