const Subscription = function () {
    this.settings = {
        'subscriptionBtnId':'#subscriptionAction',
        'subscriptionBtnAttr':'data-action',
    }

    this.componentName = 'webcompany:subscription';

    this.$subscriptionBtn = document.querySelector(this.settings.subscriptionBtnId);

    this.init();
}

Subscription.prototype.init = function () {
    this.setEvents();
}

Subscription.prototype.setEvents = function () {
    const _this = this;
    if (this.$subscriptionBtn) {
        this.$subscriptionBtn.onclick = () => {
            let action = this.$subscriptionBtn.getAttribute(this.settings.subscriptionBtnAttr);
            let data = {
                'component': _this.componentName,
                'action': action,
            }
            _this.sendData(data);
        }
    }
}

Subscription.prototype.sendData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.json()
    }).then(function(json) {
        if (json) {
            if (json.redirect) location = json.redirect;
            if (json.reload) location.reload();
        }
    }).catch(error => {
        console.log(error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    new Subscription();
});