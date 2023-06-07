const PagerApp = function (settings) {
	this._settings = {
		preloaderContainer: '.ajax_container',
		defaultOffsetSelector: '.breadcrumb',
		paginationItemClass: '.paginations__link',
	}
	for (let propName in settings) {
		if (settings.hasOwnProperty(propName)) {
			this._settings[propName] = settings[propName];
		}
	}
	this._$preloaderContainer = document.querySelector(this._settings.preloaderContainer);
	this._init();
}
PagerApp.prototype._init = function () {
	this._setupListener.call(this);
}
PagerApp.prototype._setupListener = function () {
	const _this = this,
		paginationItemSelector = _this._settings.paginationItemClass,
		paginationItemClass = paginationItemSelector.substring(paginationItemSelector.indexOf('.') + 1);

	_this._$preloaderContainer?.addEventListener('click', (e) => {
		if (e.target.classList.contains(paginationItemClass) || e.target.closest('.' + paginationItemClass) !== null) {
			e.preventDefault();
			let link = e.target.getAttribute('href');
			if (!link) {
				link = e.target.closest('.' + paginationItemClass).getAttribute('href')
			}
			_this._send({ reload_ajax: 'y' }, link, link);
		}
	});
}
PagerApp.prototype._send = function (data = {}, link = window.location.href, changeLink = '', scroll = true) {
	const _this = this;
	if (data.length === 0 || link === '#' || !link) return;

	_this._displayLoading();
	if (scroll) {
		let $topOffset = (document.querySelector(this._settings.defaultOffsetSelector)
			.getBoundingClientRect().top - 300 + document.body.scrollTop);

		window.scrollBy({
			top: $topOffset,
			behavior: 'smooth'
		});
	}

	fetch(link, {
		method: 'POST',
		cache: 'no-cache',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: new URLSearchParams(data)
	}).then(function (response) {
		return response.text()
	}).then(function (text) {
		let template = document.createElement('div');
		template.innerHTML = text;

		setTimeout(() => {
			if (template.querySelector(_this._settings.preloaderContainer))
			{
				_this._$preloaderContainer.innerHTML = template.querySelector(_this._settings.preloaderContainer).innerHTML;
				if (changeLink !== '') {
					history.pushState(null, null, changeLink);
				}
			}

			window.dispatchEvent(new CustomEvent("ajax-finished", {
				detail: {}
			}));

			_this._hideLoading();

		}, 100);
	})
		.catch(error => {
			console.log(error);
		});
}
PagerApp.prototype._displayLoading = function () {
	this._$preloaderContainer.classList.add('preloader');
	setTimeout(() => {
		this._hideLoading();
	}, 8000);
}
PagerApp.prototype._hideLoading = function () {
	this._$preloaderContainer.classList.remove('preloader')
}

window.addEventListener('DOMContentLoaded', () => {
	new PagerApp({
		preloaderContainer: '.ajax_container',
		defaultOffsetSelector: '.breadcrumb',
		paginationItemClass: '.paginations__link',
	});
})
