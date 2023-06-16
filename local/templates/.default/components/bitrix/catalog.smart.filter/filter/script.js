const AjaxFilter = function () {
	this.settings = {
		'formFilterId':'filter',
		'formFilterSubmitId':'filter-submit',
		'formFilterResetId':'filter-reset',
		'elementsContainer':'announcements-content'
	}

	this.$filterForm = document.querySelector('form#'+this.settings.formFilterId);
	this.$filterSubmitBtn = this.$filterForm.querySelector('#'+this.settings.formFilterSubmitId);
	this.$filterResetBtn = this.$filterForm.querySelector('#'+this.settings.formFilterResetId);

	this.init();
}

AjaxFilter.prototype.init = function ()
{
	this.setupListener();
}

AjaxFilter.prototype.setupListener = function ()
{
	const _this = this;
	if (this.$filterForm && this.$filterSubmitBtn) {
		this.$filterSubmitBtn.onclick = () => {
			event.preventDefault();
			let formData = new FormData(this.$filterForm);
			formData.set('set_filter', 'y');
			formData.set('isAjax', 'Y');
			formData.set('ajax', 'y');
			// formData.set('arrFilter_11', '498629140');
			_this.sendData(formData);
		}
	}
}

AjaxFilter.prototype.sendData = function (formData) {
	const _this = this;
	fetch(location.href, {
		method: 'POST',
		cache: 'no-cache',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		body: new URLSearchParams(formData)
	}).then(function(response) {
		return response.text()
	}).then(function(text) {
		console.log(text);
		// let response = _this.getDomElementsFromString(text);
		// let newView = response.querySelector(_this.settings.elementsClass);
		// let curContainer = document.querySelector(_this.settings.elementsContainerClass);
		// setTimeout(() => {
		// 	_this.deleteLoader();
		// 	curContainer.querySelector(_this.settings.elementsClass).remove();
		// 	curContainer.prepend(newView);
		// },300);

	}).catch(error => {
		console.log(error);
	});
}



document.addEventListener('DOMContentLoaded', () => {
	new AjaxFilter();
});