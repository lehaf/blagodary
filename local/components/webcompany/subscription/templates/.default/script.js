const Subscription = function () {
    this.settings = {
        'subscriptionBtnId':'#subscriptionAction',
        'subscriptionBtnAttr':'data-action',
        'paginationLinksSelector':'div.pagination a',
        'elementsContainerSelector':'#target',
        'loaderClassName':'lds-heart',
        'loaderContainerClass':'.loader',
        'blurContainerClass':'.history-subscription-list',
        'blurClass':'blur',
    }

    this.componentName = 'webcompany:subscription';
    this.$subscriptionBtn = document.querySelector(this.settings.subscriptionBtnId);
    this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
    this.init();
}

Subscription.prototype.init = function () {
    this.setSubscriptionEvent();
    this.setPaginationEvent();
    this.createLoader();
}

Subscription.prototype.createLoader = function () {
    const loader = document.createElement('div');
    loader.classList.add(this.settings.loaderClassName);
    const innerDiv = document.createElement('div');
    loader.prepend(innerDiv);
    this.$loader = loader;
}

Subscription.prototype.setLoader = function () {
    this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
    if (this.$loader && this.$loaderContainer && this.$blurContainer) {
        this.$blurContainer.classList.add(this.settings.blurClass);
        this.$loaderContainer.prepend(this.$loader);
    }
}

Subscription.prototype.deleteLoader = function () {
    this.$blurContainer.classList.remove(this.settings.blurClass);
    if (document.querySelector('.'+this.settings.loaderClassName))
        document.querySelector('.'+this.settings.loaderClassName).remove();
}

Subscription.prototype.setSubscriptionEvent = function () {
    const _this = this;
    if (this.$subscriptionBtn) {
        this.$subscriptionBtn.onclick = (e) => {
            e.preventDefault();
            let action = this.$subscriptionBtn.getAttribute(this.settings.subscriptionBtnAttr);
            let data = {
                'component': _this.componentName,
                'action': action,
            }
            _this.sendData(data);
        }
    }
}


Subscription.prototype.setPaginationEvent = function () {
    const _this = this;
    this.$paginationLinks = document.querySelectorAll(this.settings.paginationLinksSelector);
    if (this.$paginationLinks.length > 0) {
        this.$paginationLinks.forEach((pageLink) => {
            pageLink.onclick = (e) => {
                e.preventDefault();
                let pageHref = pageLink.getAttribute('href');
                _this.setLoader();
                _this.sendPaginationPage(pageHref);
            }
        });
    }
}

Subscription.prototype.sendData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With':'XMLHttpRequest',
        },
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.json()
    }).then(function(json) {
        if (json) {
            console.log(json);
            if (json.redirect) location = json.redirect;
            if (json.reload) location.reload();
        }
    }).catch(error => {
        console.log(error);
    });
}

Subscription.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

Subscription.prototype.sendPaginationPage = function (link) {
    const _this = this;
    fetch(link, {
        method: 'GET',
        cache: 'no-cache',
        headers: {
            'Content-Type':'application/x-www-form-urlencoded',
            'X-Requested-With':'XMLHttpRequest',
        },
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        let response = _this.getDomElementsFromString(text);
        let nextElementsContainer = response.querySelector(_this.settings.elementsContainerSelector);
        let curContainer = document.querySelector(_this.settings.elementsContainerSelector);
        curContainer.innerHTML = nextElementsContainer.innerHTML;
        _this.setPaginationEvent();
        window.history.replaceState(null, null, link);
        _this.deleteLoader();
    }).catch(error => {
        console.log(error);
    });
}
document.addEventListener('DOMContentLoaded', () => {
    new Subscription();
});