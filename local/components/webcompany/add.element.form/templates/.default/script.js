const CreateAdsApp = function () {
    this.settings = {
        'dropZoneContentClass':'.dropzone__content',
        'uploadCounterClass':'.dropzone_count__loaded',
        'idInputFile':'#inputFile',
        'imgAttr':'data-edit-img',
        'imgIndexAttr':'data-index',
        'imgFileAttr':'data-file',
        'dropZoneActiveClass':'drop',
        'deleteImgBtnClass':'.preview-remove',
        'imgContainerClass':'.preview-img',
        'addNewPhoneBtnClass':'.add-new-phone',
        'phonesContainerClass':'.form-tel-container',
        'removePhoneClass':'.remove_phone',
        'maxImagesLimit': 10,
    }

    this.dependenceList = {
        'REGION':'CITY'
    };

    this.$dropZone = document.querySelector(".dropzone");
    this.$dropZoneContent = document.querySelector(this.settings.dropZoneContentClass);
    this.$counter = document.querySelector(this.settings.uploadCounterClass);
    this.$inputFile = document.querySelector(this.settings.idInputFile);
    this.$templatePhone = `
             <div class="form-group form-group--tel">
                 <label class="data-user__label data-user__label--tel">Контактный телефон</label>
                 <input type="tel" name="OWNER_PHONE[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel">
                 <span class="remove_phone"><svg><use xlink:href="/local/templates/main/html/assets/img/sprites/sprite.svg#plus"></use></svg></span>
             </div>`;
    this.init();
}

CreateAdsApp.prototype.highlightDropZone = function () {
    this.$dropZone.classList.add("drop")
}

CreateAdsApp.prototype.unHighlightDropZone = function () {
    this.$dropZone.classList.remove("drop")
}

CreateAdsApp.prototype.setMaskPhone = function () {
    $(".dataUserTel").mask("+375 (99) 999-99-99");
}
CreateAdsApp.prototype.getTemplateImg = function (img,name) {
    return `
            <div class="preview-img">
                <img src="${img}" alt="img">
                <span class="preview-remove" data-file="${name}">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.33594 7.71732L9.8652 11.2466L10.0066 11.1052L9.86521 11.2466C10.2473 11.6287 10.8669
                         11.6289 11.2492 11.2466C11.6315 10.8645 11.6315 10.2448 11.2492 9.86258L7.71996 6.33329L11.2492 
                         2.80403C11.2492 2.80402 11.2492 2.80401 11.2492 2.80399C11.6315 2.42184 11.6315 1.80221 
                         11.2492 1.41996C10.8671 1.03765 10.2474 1.03772 9.8652 1.41996L10.0066 1.56138L9.8652 1.41996L6.33594 
                         4.94925L2.80671 1.42C2.42458 1.03766 1.80494 1.0377 1.42268 1.41992L6.33594 7.71732ZM6.33594 
                         7.71732L2.80667 11.2466L2.80663 11.2467C2.42438 11.6287 1.80478 11.6287 1.42265 11.2466L1.42264 
                         11.2466C1.0404 10.8644 1.04033 10.2447 1.42264 9.86258C1.42266 9.86257 1.42267 9.86255 1.42268 
                         9.86254L4.95191 6.33329L1.42264 2.80399C1.0404 2.42175 1.04034 1.80211 1.42264 1.41996L6.33594 
                         7.71732Z"  stroke="#8E8E8E" stroke-width="0.4"/>
                    </svg>
                </span>
            </div>`;
}

CreateAdsApp.prototype.init = function () {
    this.setEventListener();
    this.setMaskPhone();
    this.setDependentLists();
}

CreateAdsApp.prototype.setEventListener = function () {
    this.setInputFileEvent();
    this.setPhoneEvent();
    this.setDeletePhoneEvent();
    this.setDeleteUploadedImgEvent();
    this.setDropzoneEvents();
}

CreateAdsApp.prototype.setDeletePhoneEvent = function () {
    const _this = this;
    let deletePhonesBtn = document.querySelectorAll(this.settings.removePhoneClass);
    if (deletePhonesBtn) {
        deletePhonesBtn.forEach((removeBtn) => {
            removeBtn.onclick = () => {
                removeBtn.parentElement.remove();
            }
        });
    }
}


CreateAdsApp.prototype.setPhoneEvent = function () {
    const _this = this;
    document.querySelector(this.settings.addNewPhoneBtnClass).onclick = () => {
        document.querySelector(_this.settings.phonesContainerClass).insertAdjacentHTML('beforeend',_this.$templatePhone);
        _this.setMaskPhone();
        _this.setDeletePhoneEvent();
    }
}

CreateAdsApp.prototype.setInputFileEvent = function () {
    const _this = this;
    this.$inputFile.onchange = () => {
        let images = _this.$dropZone.querySelectorAll(this.settings.imgContainerClass);
        if (_this.$inputFile.files.length > 0 && images.length > 0) {
            images.forEach((img) => {
                img.remove();
            });
        }
        _this.uploadImgFromBtn();
    }
}

CreateAdsApp.prototype.setDropzoneEvents = function () {
    const _this = this;
    if(this.$dropZone){
        this.$dropZone.ondragover = (e) => {
            e.preventDefault();
            _this.highlightDropZone();
        }
        this.$dropZone.ondragenter= (e) => {
            e.preventDefault();
            _this.highlightDropZone();
        }
        this.$dropZone.ondragleave = (e) => {
            e.preventDefault();
            _this.unHighlightDropZone();
        }
        this.$dropZone.ondrop = (e) => {
            e.preventDefault();
            let newImg = Array.from(e.dataTransfer.files);
            _this.unHighlightDropZone();
            _this.addImgFile(newImg);
        }
    }

    if (this.$dropZoneContent) {
        let json = this.$dropZoneContent.getAttribute(this.settings.imgAttr);
        if (json) {
            let img = JSON.parse(json);
            const dt  = new DataTransfer();
            img.forEach((img) => {
                dt.items.add(new File(['editCollection'], img));
            });
            this.$inputFile.files = dt.files;
        }
    }
}

CreateAdsApp.prototype.setDeleteUploadedImgEvent = function () {
    const _this = this;
    this.$deleteImgBtns = document.querySelectorAll(this.settings.deleteImgBtnClass);
    if (this.$deleteImgBtns.length > 0) {
        this.$deleteImgBtns.forEach((imgDelBtn) => {
            imgDelBtn.onclick = () => {
                let dataName = imgDelBtn.getAttribute(_this.settings.imgFileAttr);
                let fileIndex = imgDelBtn.getAttribute(_this.settings.imgIndexAttr);
                _this.removeFile(dataName);
                imgDelBtn.parentNode.classList.add("remove")
                setTimeout(()=>{
                    imgDelBtn.parentNode.remove();
                },300)
            }
        });
    }
}

CreateAdsApp.prototype.removeFile = function (fileName) {
    const dt  = new DataTransfer();
    for (let i = 0; i < this.$inputFile.files.length; i++) {
        const file = this.$inputFile.files[i];
        if (file.name !== fileName) dt.items.add(file);
    }
    this.$counter.innerHTML = dt.files.length;
    this.$inputFile.files = dt.files
}

CreateAdsApp.prototype.addFile = function (img) {
    const dt  = new DataTransfer();
    for (let i = 0; i < this.$inputFile.files.length; i++) {
        if (i <= this.settings.maxImagesLimit-1) {
            const file = this.$inputFile.files[i];
            dt.items.add(file);
        }
    }

    if (dt.files.length < this.settings.maxImagesLimit) {
        dt.items.add(img);
        this.$inputFile.files = dt.files;
    } else {
        alert(`Превышен лимит картинок! Картинка ${img.name} не загружена!`);
        return false;
    }

    return true;
}

CreateAdsApp.prototype.uploadImgFromBtn = function () {
    const _this = this;
    const dt  = new DataTransfer();

    for (let i = 0; i < this.$inputFile.files.length; i++) {
        const file = this.$inputFile.files[i];
        if (i <= 9) {
            dt.items.add(file);
        } else {
            alert(`Превышен лимит картинок! Картинка ${file.name} не загружена!`)
        }
    }
    this.$inputFile.files = dt.files;
    let imgList = Array.from(this.$inputFile.files);
    imgList.forEach((img, index) => {
        let reader = new FileReader();
        reader.readAsDataURL(img);
        reader.onload = function () {
            if (index <= _this.settings.maxImagesLimit-1) {
                _this.$counter.innerHTML = _this.$inputFile.files.length;
                let templateImg = _this.getTemplateImg(reader.result, img.name);
                _this.$dropZoneContent.insertAdjacentHTML('beforeEnd', templateImg);
                _this.setDeleteUploadedImgEvent();
            }
        }
    })
}

CreateAdsApp.prototype.addImgFile = function (newImages, addToFiles = true) {
    const _this = this;
    if (newImages.length > 0) {
        if (_this.$inputFile.files.length <= _this.settings.maxImagesLimit-1) {
            newImages.forEach((img) => {
                let reader = new FileReader();
                reader.readAsDataURL(img);
                reader.onload = function () {
                    if (_this.$inputFile.files.length < _this.settings.maxImagesLimit) {
                        let templateImg = _this.getTemplateImg(reader.result, img.name);
                        _this.$dropZoneContent.insertAdjacentHTML('beforeEnd', templateImg);
                        _this.setDeleteUploadedImgEvent();
                    }
                    if (addToFiles) _this.addFile(img);
                    _this.$counter.innerHTML = _this.$inputFile.files.length;
                }
            })
        } else {
            alert('Вы загрузили максимальное колличество картинок!')
        }
    }
}

CreateAdsApp.prototype.setDependentLists = function ()
{
    const _this = this;
    if (this.dependenceList) {
        for (let mainFiledCode in this.dependenceList) {
            const mainField = document.querySelector('select#'+mainFiledCode);
            const dependenceFieldCode = this.dependenceList[mainFiledCode];
            mainField.onchange = () => {
                _this.filterDependencyValues(mainField, dependenceFieldCode);
            }

            let isDependencyFieldDefaultBlocked = false;
            const firstOptionSelected = dependencySelect.options[0].selected === true;
            let observer = new MutationObserver(mutationRecords => {
                if (!isDependencyFieldDefaultBlocked && !location.search.includes('item=')) {
                    _this.filterDependencyValues(mainField, dependenceFieldCode,firstOptionSelected);
                    isDependencyFieldDefaultBlocked = true;
                }
            });
            // Контейнер для зависимого select
            let dependencySelectContainer = document.querySelector('select#'+dependenceFieldCode).parentNode;
            // наблюдать за зависимым select
            observer.observe(dependencySelectContainer, {
                childList: true, // наблюдать за непосредственными детьми
                subtree: true // и более глубокими потомками
            });

        }
    }
}

CreateAdsApp.prototype.filterDependencyValues = function (mainField, dependenceFieldCode, skipClick = false)
{
    let dependencySelect = document.querySelector('select#'+dependenceFieldCode);
    let dependencyFilter = mainField.querySelector(`option[value="${mainField.value}"]`)
        .getAttribute('data-dependency');

    let dependenceLi = document.querySelector('select#'+dependenceFieldCode)
        .parentNode.querySelectorAll('.jq-selectbox__dropdown li');

    if (dependenceLi) {
        let i = 0;
        for (let li of dependenceLi) {
            if (li.getAttribute('data-dependency') !== dependencyFilter) {
                li.style.display = 'none';
            } else {
                if (i === 0 && !skipClick) {
                    li.click();
                }
                li.style.display = 'block';
                i++;
            }
        }
    }
}

addEventListener('DOMContentLoaded',() => {
    new CreateAdsApp();
});

