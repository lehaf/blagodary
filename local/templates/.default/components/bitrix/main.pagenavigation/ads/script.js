const Pagination = function () {
	this.settings = {
		'paginationContainerClass':'.pagination',
		'paginationLinkSelector':'ul.pagination-list a',
		'paginationArrowRightClass':'.pagination-arrow-right',
		'paginationArrowLeftClass':'.pagination-arrow-right',
		'loaderClassName':'lds-heart',
		'loaderContainerClass':'.loader-container',
		'blurContainerClass':'.user-list-ads',
		'blurClass':'blur',
		'elementsClass':'.user-list-ads',
		'elementsContainerClass':'.user-list-ads',
	}

	this.$loaderContainer = document.querySelector(this.settings.loaderContainerClass);
	this.init();
}

Pagination.prototype.init = function () {
	this.setEventListener();
	this.createLoader();
}

Pagination.prototype.setEventListener = function () {
	const _this = this;
	this.$arAllPaginationLinks = document.querySelectorAll(this.settings.paginationLinkSelector);

	if (this.$arAllPaginationLinks.length > 0) {
		this.$arAllPaginationLinks.forEach((paginationLink) => {
			paginationLink.onclick = (e) => {
				e.preventDefault();
				if (!paginationLink.parentNode.classList.contains('active')) {
					let requestLink = paginationLink.getAttribute('href');
					_this.setLoader();
					_this.sendData(requestLink,{'isAjax': 'Y',});
				}
			}
		});
	}
}

Pagination.prototype.createLoader = function () {
	const loader = document.createElement('div');
	loader.classList.add(this.settings.loaderClassName);
	const innerDiv = document.createElement('div');
	loader.prepend(innerDiv);
	this.$loader = loader;
}

Pagination.prototype.setLoader = function () {
	this.$blurContainer = document.querySelector(this.settings.blurContainerClass);
	if (this.$loader && this.$loaderContainer && this.$blurContainer) {
		this.$blurContainer.classList.add(this.settings.blurClass);
		this.$loaderContainer.prepend(this.$loader);
	}
}

Pagination.prototype.deleteLoader = function () {
	this.$blurContainer.classList.remove(this.settings.blurClass);
	document.querySelector('.'+this.settings.loaderClassName).remove();
}

Pagination.prototype.getDomElementsFromString = function (string) {
	let obDomParser = new DOMParser();
	return obDomParser.parseFromString(string, "text/html");
}

Pagination.prototype.sendData = function (link,data) {
	const _this = this;
	fetch(link, {
		method: 'POST',
		cache: 'no-cache',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		body: new URLSearchParams(data)
	}).then(function(response) {
		return response.text()
	}).then(function(text) {
		let response = _this.getDomElementsFromString(text);
		setTimeout(() => {
			_this.deleteLoader();
			document.querySelector(_this.settings.elementsContainerClass).innerHTML = response.querySelector(_this.settings.elementsContainerClass).innerHTML;
			document.querySelector(_this.settings.paginationContainerClass).innerHTML = response.querySelector(_this.settings.paginationContainerClass).innerHTML;
			_this.setEventListener();
			if (window.ImageDefer) window.ImageDefer.init(); // Реинитим lazyload
		},200);

		window.history.replaceState(null, null, link);
	}).catch(error => {
		console.log(error);
	});
}


addEventListener('DOMContentLoaded',() => {
	new Pagination();
});