const PropSearch = function () {
    this.settings = {
        'idForm':'main-search',
        'nameInputId':'#form-search',
        'regionInputId':'#selectBanner',
        'cityInputId':'#selectBannerNew'
    }

    this.$form = document.getElementById(this.settings.idForm);
    this.$action = this.$form.getAttribute('action');
    this.$searchUrl = location.origin + this.$action +'?q=';
    this.init();
}

PropSearch.prototype.init = function () {
    this.setEventListener();
}

PropSearch.prototype.setEventListener = function () {
    if (this.$form) {
        this.$form.onsubmit = () => {
            event.preventDefault();
            let goodName = this.$form.querySelector(this.settings.nameInputId).value;
            if (goodName) this.$searchUrl += goodName + '+';
            let region = this.$form.querySelector(this.settings.regionInputId).value;
            if (region) this.$searchUrl += region + '+';
            let cityInputId = this.$form.querySelector(this.settings.cityInputId).value;
            if (cityInputId) this.$searchUrl += cityInputId;
            location.href = this.$searchUrl;
        }
    }
}

addEventListener('DOMContentLoaded',() => {
    new PropSearch();
});