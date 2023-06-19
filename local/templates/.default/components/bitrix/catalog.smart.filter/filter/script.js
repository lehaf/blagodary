const AjaxFilter = function () {
	this.settings = {
		'formFilterId':'filter',
		'formFilterSubmitId':'filter-submit',
		'formFilterResetId':'filter-reset',
		'loaderClassName':'lds-heart',
		'loaderContainerClass':'.announcements-content',
		'blurContainerClass':'.announcements-content__item',
		'blurClass':'blur',
		'elementsContainer':'announcements-content',
		'elementsClass':'.announcements-content',
		'elementsContainerClass':'.announcements-content',
		'paginationLinkSelector':'.pagination-list .pagination-list__item a',
	}

	this.$filterForm = document.querySelector('form#'+this.settings.formFilterId);
	this.$filterSubmitBtn = this.$filterForm.querySelector('#'+this.settings.formFilterSubmitId);
	this.$filterResetBtn = this.$filterForm.querySelector('#'+this.settings.formFilterResetId);
	this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);

	this.init();
}

AjaxFilter.prototype.init = function ()
{
	this.setupListener();
	this.createLoader();
}

AjaxFilter.prototype.setupListener = function ()
{
	this.setFilterEvent();
	this.setResetFilterEvent();
}

AjaxFilter.prototype.setFilterEvent = function () {
	const _this = this;
	if (this.$filterForm && this.$filterSubmitBtn) {
		this.$filterSubmitBtn.onclick = () => {
			event.preventDefault();
			let formData = new FormData(this.$filterForm);
			let getParams = '';
			for(let [key, value] of formData.entries()) {
				if (key && value) {
					if (value === 'on') value = 'Y';
					getParams += key+'='+value+'&';
				}
			}

			if (getParams.length > 0) {
				getParams += 'set_filter=y';
				_this.setLoader();
				_this.sendData(_this.prepareLinkForAjax(getParams));
			} else {
				if (location.href.includes('set_filter')) {
					_this.setLoader();
					_this.sendData(_this.prepareLinkForAjax());
				}
			}
		}
	}
}

AjaxFilter.prototype.clearForm = function (oForm) {
	let elements = oForm.elements;
	oForm.reset();
	for(let i=0; i<elements.length; i++) {
		let field_type = elements[i].type.toLowerCase();
		switch(field_type) {
			case "text":
			case "password":
			case "textarea":
			case "hidden":
				elements[i].value = "";
				break;
			case "radio":
				if (elements[i].checked) {
					elements[i].checked = false;
					elements[i].removeAttribute('checked');
				}
				break;
			case "checkbox":
				if (elements[i].checked) {
					elements[i].checked = false;
					elements[i].removeAttribute('checked');
				}
				break;
			case "select-one":
				for (let [key,option] of Object.entries(elements[i].options)) {
					option.removeAttribute('selected');
				}
				break;
			case "select-multi":
				elements[i].selectedIndex = -1;
				break;
			default:
				break;
		}
	}
}

AjaxFilter.prototype.setResetFilterEvent = function () {
	const _this = this;
	if (this.$filterResetBtn) {
		this.$filterResetBtn.onclick = () => {
			if (location.href.includes('set_filter')) {
				_this.setLoader();
				_this.sendData(_this.prepareLinkForAjax());
				_this.clearForm(_this.$filterForm);
			}
		}
	}
}

AjaxFilter.prototype.setPaginationEvent = function () {
	const _this = this;
	this.$arAllPaginationLinks = document.querySelectorAll(this.settings.paginationLinkSelector);

	if (this.$arAllPaginationLinks.length > 0) {
		this.$arAllPaginationLinks.forEach((paginationLink) => {
			paginationLink.onclick = () => {
				event.preventDefault();
				let requestLink = paginationLink.getAttribute('href');
				_this.setLoader();
				_this.sendData(requestLink);
			}
		});
	}
}

AjaxFilter.prototype.getDomElementsFromString = function (string) {
	let obDomParser = new DOMParser();
	return obDomParser.parseFromString(string, "text/html");
}

AjaxFilter.prototype.createLoader = function () {
	const loader = document.createElement('div');
	loader.classList.add(this.settings.loaderClassName);
	const innerDiv = document.createElement('div');
	loader.prepend(innerDiv);
	this.$loader = loader;
}

AjaxFilter.prototype.setLoader = function () {
	this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
	if (this.$loader && this.$loaderContainer && this.$blurContainer) {
		this.$blurContainer.classList.add(this.settings.blurClass);
		this.$loaderContainer.prepend(this.$loader);
	}
}

AjaxFilter.prototype.deleteLoader = function () {
	if (this.$blurContainer) {
		this.$blurContainer.classList.remove(this.settings.blurClass);
		document.querySelector('.'+this.settings.loaderClassName).remove();
	}
}

AjaxFilter.prototype.prepareLinkForAjax = function (getParams = '') {
	getParams = getParams.length > 0 ? '?' + getParams : getParams;
	return  location.origin + location.pathname + getParams;
}

AjaxFilter.prototype.sendData = function (link = '') {
	const _this = this;
	fetch(link, {
		method: 'GET',
		cache: 'no-cache',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
			'X-Requested-With' : 'XMLHttpRequest'
		}
	}).then(function(response) {
		return response.text()
	}).then(function(text) {
		let response = _this.getDomElementsFromString(text);
		let newElements = response.querySelector(_this.settings.elementsClass);
		let curContainer = document.querySelector(_this.settings.elementsContainerClass);
		setTimeout(() => {
			_this.deleteLoader();
			if (newElements) {
				curContainer.innerHTML = newElements.innerHTML;
				_this.setPaginationEvent();
			} else {
				curContainer.innerHTML = response.querySelector('body').innerHTML;
			}
			history.pushState(null, null, link);
		},300);

	}).catch(error => {
		console.log(error);
	});
}

document.addEventListener('DOMContentLoaded', () => {
	new AjaxFilter();
});