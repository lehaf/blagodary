const SendReview = function () {
    this.settings = {
        'addRatingBtnClass':'.ads-ratings-btn',
        'rateFormId':'#popUp-review',
        'itemNameAttr':'data-item-name',
        'userIdAttr':'data-user-id',
        'reviewIdAttr':'data-review-id',
    }

    this.component = {
        'name':'webcompany:my.ads.list',
        'actionSetRating':'setUserRating',
    }

    this.errors = {
        'borderErrorClass':'valid-error',
        'errorClass':'error-block',
        'containerInputErrorClass':'error',
        'ratingMessage':'Выставьте оценку!'
    }

    this.$addRatingButns = document.querySelectorAll(this.settings.addRatingBtnClass);
    this.$rateForm = document.querySelector(this.settings.rateFormId);
    this.init();
}

SendReview.prototype.init = function () {
    this.setEventListener();
}

SendReview.prototype.setEventListener = function () {
    const _this = this;

    if (this.$addRatingButns.length > 0) {
        this.$addRatingButns.forEach((btn) => {
            btn.onclick = (e) => {
                _this.$adsName = btn.getAttribute(_this.settings.itemNameAttr);
                _this.$userId = btn.getAttribute(_this.settings.userIdAttr);
                _this.$reviewId = btn.getAttribute(_this.settings.reviewIdAttr);
            }
        });
    }

    if (this.$rateForm) {
        this.$rateForm.onsubmit = (e) => {
            e.preventDefault();
            if (_this.checkForm(_this.$rateForm)) {
                let formData = new FormData(_this.$rateForm);
                if (_this.$userId && _this.$adsName) {
                    formData.set('user_id',_this.$userId);
                    formData.set('review_id',_this.$reviewId);
                    formData.set('ads_name',_this.$adsName );
                    formData.set('component',_this.component.name);
                    formData.set('action',_this.component.actionSetRating);
                    _this.sendData(formData);
                }
            }
        }
    }
}

SendReview.prototype.checkForm = function (form) {
    let formValid = true;
    let textarea = form.querySelector('textarea');
    if (!textarea.value) {
        formValid = false;
        textarea.classList.add(this.errors.borderErrorClass);
    } else {
        textarea.classList.remove(this.errors.borderErrorClass);
    }

    let allRatingStars = form.querySelectorAll('input[name="RATING"]');
    if (allRatingStars) {
        let oneChecked = false;
        allRatingStars.forEach((starBtn) => {
            if (starBtn.checked) {
                oneChecked = true;
            }
        });
        if (oneChecked === false) {
            this.createInputErrorMessage(form.querySelector('.form-group-rate'),this.errors.ratingMessage);
            formValid = false;
        } else {
            this.deleteInputErrorMessage(form.querySelector('.form-group-rate'));
        }

    }
    return formValid;
}

SendReview.prototype.clearErrors = function () {
    document.querySelector('.person-list-container').classList.remove(this.errors.borderErrorClass);
    this.$rateForm.querySelector('textarea').classList.remove(this.errors.borderErrorClass);
    this.deleteInputErrorMessage(document.querySelector('.form-group-rate'));
}

SendReview.prototype.createInputErrorMessage = function (container,errorMessage) {
    let errorDiv = document.createElement('div');
    errorDiv.classList.add(this.errors.errorClass);
    errorDiv.innerHTML = errorMessage;

    if (!container.classList.contains(this.errors.containerInputErrorClass)) {
        container.classList.add(this.errors.containerInputErrorClass);
    }

    let errorContainer = container.querySelector('.'+this.errors.errorClass);
    if (!errorContainer) {
        container.append(errorDiv);
    } else {
        errorContainer.innerHTML = errorMessage;
    }
}

SendReview.prototype.deleteInputErrorMessage = function (container) {

    if (container.classList.contains(this.errors.containerInputErrorClass)) {
        container.classList.remove(this.errors.containerInputErrorClass);
    }

    let errorContainer = container.querySelector('.'+this.errors.errorClass);
    if (errorContainer) {
        errorContainer.remove();
    }
}

SendReview.prototype.sendData = function (data) {
    const _this = this;
    fetch(location.href, {
        method: 'POST',
        cache: 'no-cache',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    }).then(function(json) {
        location.reload();
    }).catch(error => {
        // console.log(error);
    });
}


addEventListener('DOMContentLoaded',() => {
    new SendReview();
});