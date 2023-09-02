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
	};

	this.dependenceList = {
		'REGION':'CITY'
	};

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
	this.setDependentLists();
}

AjaxFilter.prototype.setFilterEvent = function () {
	const _this = this;
	if (this.$filterForm && this.$filterSubmitBtn) {
		this.$filterSubmitBtn.onclick = (e) => {
			e.preventDefault();
			let getParams = _this.getParamsToArray();
			let formData = new FormData(this.$filterForm);
			getParams = _this.fillGetParamsValues(getParams, formData);
			let getParamsStr = _this.createGetString(getParams);
			if (getParamsStr.length > 0 && _this.filterParamsExist(getParams)) {
				_this.setLoader();
				_this.sendData(_this.prepareLinkForAjax(getParamsStr));
			} /*else {
				console.log(_this.filterParamsExist(getParams));
				if (location.href.includes('set_filter') && Object.keys(getParams).length > 1 && _this.filterParamsExist(getParams)) {
					_this.setLoader();
					_this.sendData(_this.prepareLinkForAjax());
				}
			}*/
		}
	}
}

AjaxFilter.prototype.filterParamsExist = function (getParams)
{
	for(let key in getParams) {
		if (key.includes('arrFilter')) return true;
	}
	return false;
}

AjaxFilter.prototype.deleteFilterParams = function (getParams)
{
	for(let key in getParams) {
		if (key.includes('arrFilter')) delete getParams[key];
	}
	delete getParams['set_filter'];
	return this.createGetString(getParams);
}

AjaxFilter.prototype.fillGetParamsValues = function (getParams, formData)
{
	for(let [key, value] of formData.entries()) {
		if (key && value) {
			if (value === 'on') getParams[key] = 'Y';
			getParams[key] = value;
		}
	}
	getParams['set_filter'] = 'y';
	return getParams;
}

AjaxFilter.prototype.createGetString = function (getParams)
{
	let getParamsArray = [];
	for(let key in getParams) {
		if (key && getParams[key]) {
			getParamsArray.push(key+'='+getParams[key]);
		}
	}

	if (getParamsArray.length > 0) {
		return '?'+getParamsArray.join('&');
	} else {
		return '';
	}
}

AjaxFilter.prototype.setDependentLists = function ()
{
	const _this = this;
	if (this.dependenceList) {
		for (let mainFiledCode in this.dependenceList) {
			const mainField = document.querySelector('select#'+mainFiledCode);
			const dependenceFieldCode = this.dependenceList[mainFiledCode];
			mainField.onchange = () => {
				let dependencyFilter = mainField.querySelector(`option[value="${mainField.value}"]`)
					.getAttribute('data-dependency');
				let dependenceLi = document.querySelector('select#'+dependenceFieldCode).parentNode
					.querySelectorAll('.jq-selectbox__dropdown li');

				let blockField = true;
				let defaultAllOption = 'Все';
				if (dependenceLi) {
					for (let li of dependenceLi) {
						if (li.getAttribute('data-dependency') !== dependencyFilter) {
							li.style.display = 'none';
						} else {
							blockField = false;
							li.style.display = 'block';
						}

						if (li.getAttribute('data-dependency') === null) {
							li.style.display = 'block';
							defaultAllOption = li.innerHTML;
						}
					}
				}

				let dependenceClickContainer = document.querySelector('#'+dependenceFieldCode+'-styler');
				let selectVision = dependenceClickContainer.querySelector('.jq-selectbox__select');
				if (!dependencyFilter || blockField) {
					dependenceClickContainer.style.pointerEvents = 'none';
					selectVision.style.background = '#e8e8e8'; // #d5d5d5
					dependenceClickContainer.querySelector('.jq-selectbox__select-text').innerHTML = defaultAllOption;
				} else {
					dependenceClickContainer.style.pointerEvents = 'all';
					selectVision.style.background = '#fff'; // #fff
				}
			}
		}
	}
}



AjaxFilter.prototype.getParamsToArray = function ()
{
	return window
		.location
		.search
		.replace('?','')
		.split('&')
		.reduce(
			function(p,e){
				var a = e.split('=');
				p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
				return p;
			},
			{}
		);
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
				let getParams = _this.getParamsToArray();
				_this.setLoader();
				getParams = _this.deleteFilterParams(getParams);
				_this.sendData(_this.prepareLinkForAjax(getParams));
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

AjaxFilter.prototype.scrollToElement = function (element) {
	// Создаем новый observer (наблюдатель)
	let observer = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting !== true) {
				element.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
			}
		});
	});
	observer.observe(element);
}

AjaxFilter.prototype.prepareLinkForAjax = function (getParamsStr = '') {
	return location.pathname + getParamsStr;
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
		_this.scrollToElement(curContainer);
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