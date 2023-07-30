const ReferralProgram = function () {
    this.settings = {
        'referralLinkInputSelector':'input[name="referral_link"]',
        'copyReferralLinkBtn':'#copyReferalLink',
        'inputCalendarSelector':'input.referral-calendar__item',
        'calendarBtnClass':'.referral-calendar-btn',
        'elementsContainerSelector':'.referral-result',
    }

    this.componentName = 'webcompany:referral.program';

    this.$calendarBtn = document.querySelector(this.settings.calendarBtnClass);
    this.$inputsCalendar = document.querySelectorAll(this.settings.inputCalendarSelector);
    this.$referalLinkInput = document.querySelector(this.settings.referralLinkInputSelector);
    this.$referalLinkbtn = document.querySelector(this.settings.copyReferralLinkBtn);

    this.init();

}

ReferralProgram.prototype.init = function () {
    this.setCopyReferralLinkEvent();
    this.setCalendarEvent();
}

ReferralProgram.prototype.setCalendarEvent = function () {
    const _this = this;
    if (this.$calendarBtn && this.$inputsCalendar) {
        this.$calendarBtn.onclick = () => {
            let data = {};
            _this.$inputsCalendar.forEach((dateInput) => {
                let inputName = dateInput.getAttribute('name');
                let inputValue = dateInput.value;
                if (inputName.length > 0 && inputValue.length > 0) {
                    data[inputName] = inputValue;
                }
            });

            if (Object.keys(data).length >0) {
                data['component'] = _this.componentName;
                _this.sendData(data);
            }
        }
    }
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

ReferralProgram.prototype.getDomElementsFromString = function (string) {
    let obDomParser = new DOMParser();
    return obDomParser.parseFromString(string, "text/html");
}

ReferralProgram.prototype.sendData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With':'XMLHttpRequest'
        },
        body: new URLSearchParams(data)
    }).then(function(response) {
        return response.text()
    }).then(function(text) {
        if (text) {
            console.log(text);
            let response = _this.getDomElementsFromString(text);
            let nextElementsContainer = response.querySelector(_this.settings.elementsContainerSelector);
            let curContainer = document.querySelector(_this.settings.elementsContainerSelector);
            curContainer.innerHTML = nextElementsContainer.innerHTML;
        }
    }).catch(error => {
        console.log(error);
    });
}
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