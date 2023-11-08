const ChangePassRes = function () {

    this.setting = {
        'alertContainer': 'div#alert-changepass',
        'classActivateTimer': 'alert-success',
        'redirectText': "Переадресация произойдет через",
        'timerClock': 10,
        'redirectLink': '/',
    }

    this.$alert = document.querySelector(this.setting.alertContainer);

    this.init();
}

ChangePassRes.prototype.init = function ()
{
    this.setupListener();
}

ChangePassRes.prototype.setupListener = function ()
{
    if (this.$alert) {
        if (this.$alert.classList.contains(this.setting.classActivateTimer)) {
            this.addTimer();
        }
    }
}

ChangePassRes.prototype.addTimer = function ()
{
    let redirectDiv = document.createElement('div');
    redirectDiv.classList.add('timer-message');
    redirectDiv.textContent = this.setting.redirectText+":";
    let timerDiv = document.createElement('div');
    timerDiv.setAttribute('id', "timer");
    timerDiv.innerHTML = String(this.setting.timerClock);
    redirectDiv.append(timerDiv);
    this.$alert.append(redirectDiv);
    this.startTimer(timerDiv);
}

ChangePassRes.prototype.startTimer = function (timerDiv)
{
    const _this = this;
    setInterval(function () {
        let timer = timerDiv.innerHTML;
        let seconds = parseInt(timer);
        if (0 < seconds) {
            timerDiv.textContent = --seconds;
        } else {
            location.href = _this.setting.redirectLink;
        }

    }, 1000);
}


addEventListener('DOMContentLoaded',() => {
    new ChangePassRes();
});
