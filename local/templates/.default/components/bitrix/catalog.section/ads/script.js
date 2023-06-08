const SwitcherView = function () {
    this.settings = {
        'switcherBtnClass':'.announcements-switch__item',
    }

    this.$arAllSwitchers = document.querySelectorAll(this.settings.switcherBtnClass);
    this.init();
}

SwitcherView.prototype.init = function () {
    this.setEventListener();
}

SwitcherView.prototype.setEventListener = function () {
    const _this = this;

    if (this.$arAllSwitchers) {
        this.$arAllSwitchers.forEach((switcherBtn) => {
            switcherBtn.onclick = () => {
                let typeOfView = switcherBtn.getAttribute('id');
                _this.sendData({'typeOfView':typeOfView});
            }
        });
    }
}

SwitcherView.prototype.sendData = function (typeOfView) {
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(typeOfView)
    })
    .catch(error => {
        console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new SwitcherView();
});