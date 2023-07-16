const ReferralProgram = function () {
    this.settings = {
        'referralLinkInputSelector':'input[name="referral_link"]',
        'copyReferralLinkBtn':'#copyReferalLink',
    }

    this.componentName = 'webcompany:referral.program';

    this.$referalLinkInput = document.querySelector(this.settings.referralLinkInputSelector);
    this.$referalLinkbtn = document.querySelector(this.settings.copyReferralLinkBtn);

    this.init();

}

ReferralProgram.prototype.init = function () {
    this.setCopyReferralLinkEvent();
}

ReferralProgram.prototype.setCopyReferralLinkEvent = function () {
    const _this = this;
    if (this.$referalLinkInput && this.$referalLinkbtn) {
        this.$referalLinkbtn.onclick = () => {
            _this.copyLink(this.$referalLinkInput);
        }
    }
}

ReferralProgram.prototype.copyLink = function (referralLinkInput) {

    if (!navigator.clipboard){
        referralLinkInput.disabled = false;
        referralLinkInput.select();
        document.execCommand("copy");
        referralLinkInput.disabled = true;
        alert("Ссылка скопирована!");
    } else{
        navigator.clipboard.writeText(referralLinkInput.value).then(
            function(){
                alert("Ссылка скопирована!");
            })
            .catch(
                function() {
                    alert("Ошибка! Ссылка не скопирована!");
            });
    }
}

// Subscription.prototype.sendData = function (data) {
//     const _this = this;
//     fetch(location.href, {
//         method: 'POST',
//         cache: 'no-cache',
//         headers: {'Content-Type': 'application/x-www-form-urlencoded'},
//         body: new URLSearchParams(data)
//     }).then(function(response) {
//         return response.json()
//     }).then(function(json) {
//         if (json) {
//             console.log(json);
//             if (json.redirect) location = json.redirect;
//             if (json.reload) location.reload();
//         }
//     }).catch(error => {
//         console.log(error);
//     });
// }
//
// Subscription.prototype.getDomElementsFromString = function (string) {
//     let obDomParser = new DOMParser();
//     return obDomParser.parseFromString(string, "text/html");
// }
//
// Subscription.prototype.sendPaginationPage = function (link) {
//     const _this = this;
//     fetch(link, {
//         method: 'GET',
//         cache: 'no-cache',
//         headers: {
//             'Content-Type':'application/x-www-form-urlencoded',
//             'X-Requested-With':'XMLHttpRequest',
//         },
//     }).then(function(response) {
//         return response.text()
//     }).then(function(text) {
//         let response = _this.getDomElementsFromString(text);
//         let nextElementsContainer = response.querySelector(_this.settings.elementsContainerSelector);
//         let curContainer = document.querySelector(_this.settings.elementsContainerSelector);
//         curContainer.innerHTML = nextElementsContainer.innerHTML;
//         _this.setPaginationEvent();
//         window.history.replaceState(null, null, link);
//     }).catch(error => {
//         console.log(error);
//     });
// }
document.addEventListener('DOMContentLoaded', () => {
    new ReferralProgram();
});