const header = document.querySelector(".header")
const fakeHeader = document.querySelector(".fake-header");
let widthWindow = window.innerWidth
fakeHeader.style.height = header.offsetHeight + "px"
const pageContent = document.querySelector(".page-content")
const headerSearch = document.querySelector(".header-search")

function positionSearchResize() {
    let position = pageContent.getBoundingClientRect().left;
    if (position > 0) {
        headerSearch.setAttribute('style', `position:absolute; left: ${position}px`)
    }
}

if (pageContent && widthWindow > 1024) {
    positionSearchResize()
    window.addEventListener("resize", () => {
        positionSearchResize()
    })
}

let listsArr = {
    minsk: ["Любой", "Минская область", "Брестская область", "Гродненская область", "Гомельская область", "Могилевская область", "Витебская область"],
    brest: ["Любой", "Фрунзунский", "Лененский", "Московский"],
    grodno: ["Любой", "Фрунзунский", "Лененский", "Московский"],
    gomel: ["Любой", "Фрунзунский", "Лененский", "Московский"],
    mogilev: ["Любой", "Фрунзунский", "Лененский", "Московский"],
    vit: ["Любой", "Фрунзунский", "Лененский", "Московский"]
};

const listOld = document.querySelectorAll(".custom-old");

window.onload = selectCountry;


function selectAdd() {
    listOld.forEach((el) => {
        el.onchange = selectCountry;
    })
}

selectAdd()

function selectCountry(ev) {
    $('[data-select="new-list"]').empty();
    // let itemSelect = this.value || "minsk", o;
    // for (let i = 0; i < listsArr[itemSelect].length; i++) {
    //     o = new Option(listsArr[itemSelect][i], i, false, false);
    //
    //     $('[data-select="new-list"]').append(o);
    //
    // };
    $('.custom-select').styler();
    $('.new-select').trigger('refresh');
}

if (innerWidth > 1220) {
    const slideCnt = document.querySelectorAll(".viewed-slider__item").length;

    if ($('.viewed-slider').hasClass("viewed-slider--big") && slideCnt > 5) {
        $('.viewed-slider--big').slick({
            infinite: true,
            dots: false,
            speed: 500,
            slidesToShow: 5,
            slidesToScroll: 1,
            appendArrows: '.viewed-slider-arrows',
            prevArrow: '.viewed-slider-prev',
            nextArrow: '.viewed-slider-next',
        });
    } else if(slideCnt > 4) {
        $('.viewed-slider').slick({
            infinite: true,
            dots: false,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            appendArrows: '.viewed-slider-arrows',
            prevArrow: '.viewed-slider-prev',
            nextArrow: '.viewed-slider-next',
        });
    }else{
        $('.viewed-slider').addClass("no-arrow");
    }

}

function favoriteCard(el) {
    el.classList.toggle("active");
}

document.addEventListener("click", () => {
    let target = event.target;
    if (target.classList.contains("favorite-card")) {
        event.preventDefault()
        favoriteCard(target)
    }
})

/*function moreItem(item) {
    $('.' + item).on('click', function () {

        let target = event.target;

        if (target.classList.contains("favorite-card")) {
            event.preventDefault()
            favoriteCard(target)
        }
    });
}
moreItem("viewed-slider__item");
moreItem("announcements-list__item");
moreItem("announcements-card__item");*/

$('.card-slider-main').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    appendArrows: '.card-slider-arrows',
    prevArrow: '.card-slider-prev',
    nextArrow: '.card-slider-next',
    asNavFor: '.card-slider-main-nav'
});
$('.card-slider-main-nav').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: '.card-slider-main',
    arrows: false,
    centerMode: true,
    focusOnSelect: true
});


let heightImgCard = 319 / 233
let heightSliderCard = 800 / 535


function imgResize() {
    $('.viewed-slider__item-img').height($('.viewed-slider__item-img').width() / heightImgCard);
}

function sliderResize() {
    $('.card-slider-main').height($('.card-slider-main').width() / heightSliderCard);
}


imgResize()
sliderResize()

$(window).resize(function () {
    imgResize()
    sliderResize()
});


// const announcementsSwitch = document.querySelector(".announcements-switch");
//
// if (widthWindow < 457) {
//     $(".announcements-content__item--list").removeClass("active");
//     $(".announcements-content__item--card").addClass("active");
// }
//
// if (announcementsSwitch) {
//     announcementsSwitch.addEventListener("click", () => {
//         let target = event.target;
//         $(".announcements-switch__item").removeClass("active");
//         if (target.closest(".switch-list")) {
//             $(".switch-list").addClass("active");
//             $(".announcements-content__item--card").removeClass("active");
//             $(".announcements-content__item--list").addClass("active");
//         } else if (target.closest(".switch-card")) {
//             $(".switch-card").addClass("active");
//             $(".announcements-content__item--list").removeClass("active");
//             $(".announcements-content__item--card").addClass("active");
//         }
//     })
// }

$("#header-search").on("focus", function () {
    $(".header-search").addClass("active")
})

$("#header-search").on("focusout", function () {
    $(".header-search").removeClass("active")
})

$(".btn-reset").on("click", function () {

    setTimeout(function () {
        $('.custom-old').trigger('refresh');
        $('.new-select').trigger('refresh');
    }, 0);

})

const categoryListItem = document.querySelectorAll(".category-list__item--pop-up");
const categoryBlockList = document.querySelectorAll(".category-content");


function removeActive(arr, active, data, dataName) {
    arr.forEach((el) => {
        let dataContentBlock = el.getAttribute(dataName);
        el.classList.remove(active)
        if (dataContentBlock === data) {
            el.classList.add("is-active")
        }
    })
}

if (categoryListItem) {
    categoryListItem.forEach((el) => {
        el.addEventListener("click", () => {
            event.preventDefault()
            let dataValue = el.getAttribute("data-category")

            removeActive(categoryListItem, "is-active");
            removeActive(categoryBlockList, "is-active", dataValue,"data-category");
            el.classList.add("is-active")


        })
    })
}

const categoryForm = document.querySelectorAll(".category-selection-main .category-list__item");
const categoryFormLvl2 = document.querySelectorAll(".category-selection-subcategory .category-selection-content__item");
const categoryFormLiLvl2 = document.querySelectorAll(".category-selection-subcategory .category-selection-content__item li");
const categoryFormLvl3 = document.querySelectorAll(".category-selection-subcategory-3 .category-selection-content__item");
const categoryFormSelectedContent = document.querySelector(".category-selection-content");
const categoryFormSelectedContentLvl3 = document.querySelector(".category-selection-content-3");
const categorySelectionReady = document.querySelector(".category-selection-ready")
let formCategorySelectedItem = document.querySelector(".category-selection-ready__main")
let inputSectionId = document.querySelector("#section-id-value");

if (categoryForm) {

    categoryForm.forEach((el) => {
        el.addEventListener("click", () => {
            event.preventDefault()
            let dataSectionId = el.getAttribute("data-section-id");
            removeActive(categoryForm, "is-active");
            removeActive(categoryFormLiLvl2, "active");
            removeActive(categoryFormLvl2, "is-active", dataSectionId, "data-parent-id");
            removeActive(categoryFormLvl3, "is-active");
            $(".category-selection-subcategory-3").hide(600)
            el.classList.add("is-active")
        })
    });


    categoryFormLiLvl2.forEach((el) => {
        el.addEventListener("click", () => {
            event.preventDefault()
            let dataSectionId = el.getAttribute("data-section-id")
            removeActive(categoryFormLvl3, "is-active", dataSectionId, "data-parent-id");
            el.classList.add("is-active")
        })
    })

    if(categoryFormSelectedContent){
        categoryFormSelectedContent.addEventListener("click",(event)=>{
            event.preventDefault()
            let target = event.target;

            if(target.closest(".category-selection-list__item")){
                $(".category-selection-list__item").removeClass("active");
                let chosenSection = target.closest(".category-selection-list__item");
                let text = chosenSection.innerText;
                let sectionId = chosenSection.getAttribute("data-section-id");
                target.classList.add("active");
                if (document.querySelector('div[data-parent-id="'+sectionId+'"]')) {
                    $(".category-selection-subcategory-3").show(600)
                    $('html, body').animate({
                        scrollTop: $("#categorySelection").offset().top - 120
                    }, 1000);
                } else {
                    $(".category-selection-subcategory-3").hide(600);
                    $(".category-selection").hide(600)
                    $('html, body').animate({
                        scrollTop: $("#categorySelection").offset().top - 120
                    }, 1000);
                    categorySelectionReady.classList.add("active")
                    formCategorySelectedItem.innerText = text;
                    inputSectionId.value = sectionId;
                }
            }
        });
    }

    if(categoryFormSelectedContentLvl3){
        categoryFormSelectedContentLvl3.addEventListener("click",(event)=>{
            event.preventDefault()
            let target = event.target;

            if(target.closest(".category-selection-list__item")){
                let chosenSection = target.closest(".category-selection-list__item");
                let text = chosenSection.innerText;
                let sectionId = chosenSection.getAttribute("data-section-id");
                $(".category-selection").hide(600)
                $('html, body').animate({
                    scrollTop: $("#categorySelection").offset().top - 120
                }, 1000);
                categorySelectionReady.classList.add("active")
                formCategorySelectedItem.innerText = text;
                inputSectionId.value = sectionId;
                target.classList.add("active");
            }
        });
    }

    $(".category-selection-ready-btn").on("click", (event)=>{
        categorySelectionReady.classList.remove("active")
        $(".category-selection").show(600)
    })
}


const btnCategoryOpen = document.querySelector(".btn-category-open");
const btnCategoryClose = document.querySelector(".btn-category-close");
const categoryPopUp = document.querySelector(".category-pop-up");

if (btnCategoryOpen) {
    btnCategoryOpen.addEventListener("click", () => {
        categoryPopUp.classList.add("active");
    })

    btnCategoryClose.addEventListener("click", () => {
        categoryPopUp.classList.remove("active");
    })
}


const btnOpenFilter = document.querySelector(".btn-filter");
const formFilter = document.querySelector(".aside__item-form");
const popUpOverlay = document.querySelector(".popUp-overlay")
const popUpCross = document.querySelector(".popUp-cross");

if (btnOpenFilter) {
    btnOpenFilter.addEventListener("click", () => {
        formFilter.classList.add("active");
        popUpOverlay.classList.add("active");
    })
}

popUpCross.addEventListener("click", () => {
    formFilter.classList.remove("active");
    popUpOverlay.classList.remove("active");
})

let scrollForm = $('.aside-form'),
    scrollForm_sh = scrollForm.length > 0 ? scrollForm[0].scrollHeight : false,
    scrollForm_h = scrollForm.length > 0 ? scrollForm.height() : false;

const ScrollBlock = document.querySelector('.aside-form');

if (ScrollBlock) {
    const hasVerScroll = ScrollBlock.scrollHeight > ScrollBlock.clientHeight;

    if (hasVerScroll && scrollForm_sh) {

        scrollForm.scroll(function () {
            if ($(this).scrollTop() >= scrollForm_sh - scrollForm_h) {
                $(".btn-reset--scroll").addClass("active");
            } else {
                $(".btn-reset--scroll").removeClass("active");
            }
        });
    } else {
        $(".btn-reset--scroll").addClass("active");
    }

}


/*меню в шапке*/

$(function () {
    $(document).on("click", ".mobile_menu_container .parent", function (e) {
        e.preventDefault();
        let text = event.target.innerText
        const crossTemplate = `
        <span class="popUp-cross mobile_menu__cross">
                             <svg>
                <use xlink:href="assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
                        </span>
        `

        event.target.nextElementSibling.querySelector("a").innerHTML = text + crossTemplate
        $(".mobile_menu_container .activity").removeClass("activity");
        $(this).siblings("ul").addClass("loaded").addClass("activity");
    });
    $(document).on("click", ".mobile_menu_container .back", function (e) {
        e.preventDefault();
        $(".mobile_menu_container .activity").removeClass("activity");
        $(this).parent().parent().removeClass("loaded");
        $(this).parent().parent().parent().parent().addClass("activity");
    });
    $(document).on("click", ".mobile_menu", function (e) {
        e.preventDefault();
        $(".mobile_menu_container").addClass("loaded");
        $(".mobile_menu_overlay").fadeIn();
    });
    $(document).on("click", ".mobile_menu_overlay", function (e) {
        $(".mobile_menu_container").removeClass("loaded");
        $(this).fadeOut(function () {
            $(".mobile_menu_container .loaded").removeClass("loaded");
            $(".mobile_menu_container .activity").removeClass("activity");
        });
    });
    $(document).on("click", ".mobile_menu__cross", function (e) {
        $(".mobile_menu_container").removeClass("loaded");
        $(".mobile_menu_overlay").fadeOut(function () {
            $(".mobile_menu_container .loaded").removeClass("loaded");
            $(".mobile_menu_container .activity").removeClass("activity");
        });
    });

})

$('.menu-subcategory').on('click', function () {
    event.preventDefault()
    let dropdown = $(this).parent();
    $(this).toggleClass("active");
    dropdown.find(".menu-subcategory-content").slideToggle("slow");
});

$('.sign-in--mobile.is-active').on('click', function () {
    $(".menu-authorized").addClass("active");
});

$('.menu-authorized__cross').on('click', function () {
    $(".menu-authorized").removeClass("active");
});

$('.btn-pick-up').on('click', function () {
    $(".phone-list").slideDown("slow")
});


if ($(".card-description-text").length) {
    let innerHeight = $(".card-description-text").height();
    let curHeight = $(".card-description-text").get(0).scrollHeight;
        if(curHeight > innerHeight){
            $(".card-description-text").addClass("scroll");
            $('.card-description-text-btn').on('click', function () {
                if (!this.classList.contains('active')) {
                    $(".card-description-text").animate({height: curHeight}, 1000);
                } else {
                    $(".card-description-text").animate({height: innerHeight}, 1000);
                }
                $(".card-description-text-btn").toggleClass("active");
                $(".card-description-text").toggleClass("active");
            });
        }else{
            $(".card-description-text").addClass("inner");
            $('.card-description-text-btn').remove();
        }
}


$('.total-rating').on('click', function () {
    $('.substrate').addClass("active")
    $('.popUp-grade').addClass("active")
});

$('.complain').on('click', function () {
    $('.substrate').addClass("active")
    $('.popUp-complain').addClass("active")
});

$('.modal-cross').on('click', function () {
    $('.substrate').removeClass("active")
    $('.popUp').removeClass("active")
});

$('.substrate').on('click', function () {
    $('.substrate').removeClass("active")
    $('.popUp').removeClass("active")
});

$('.complain-form').on('submit', function () {
    $('.popUp').removeClass("active")
    $('.popUp-successful').addClass("active")
});

$('.ads-ratings-btn').on('click', function () {
    $('.popUp-review').addClass("active")
    $('.substrate').addClass("active")
});

$('.contact-support').on('click', function () {
    $('.popUp-support').addClass("active")
    $('.substrate').addClass("active")
});

$('.del-ed').on('click', function () {
    event.preventDefault()
    $('.popUp-rate').addClass("active")
    $('.substrate').addClass("active")
});

const subscriptionSwitch = document.querySelector(".subscription-switch")

if (subscriptionSwitch) {
    subscriptionSwitch.addEventListener("click", () => {
        let target = event.target
        if (target.classList.contains("subscription__btn--current")) {
            $('.subscription-switch__btn').removeClass("active");
            $('.history-subscription').removeClass("active");
            $('.subscription__btn--current').addClass("active");
            $('.profile-current-subscription').addClass("active");
        } else if (target.classList.contains("subscription__btn--history")) {
            $('.subscription-switch__btn').removeClass("active");
            $('.profile-current-subscription').removeClass("active");
            $('.subscription__btn--history').addClass("active");
            $('.history-subscription').addClass("active");
        }
    })
}


$('.referral-link-btn').on('click', function () {
    let copyText = document.querySelector(".referral-program__link");
    copyText.value;
    navigator.clipboard.writeText(copyText.value);
    $('.referral-link-btn').addClass("copy");
    setTimeout(()=>{
        $('.referral-link-btn').removeClass("copy")
    }, 1000)
});


let dpMin, dpMax;

dpMin = new AirDatepicker('#AirDatepickerMin', {
    onSelect({date}) {
        dpMax.update({
            minDate: date
        })
    },
    autoClose: true

})

dpMax = new AirDatepicker('#AirDatepickerMax', {
    onSelect({date}) {
        dpMin.update({
            maxDate: date
        })
    },
    autoClose: true,
})

new AirDatepicker('#dataUserBirth', {
    autoClose: true
});

// const maskPhone = () => {
//     $(".dataUserTel").mask("+375 (99) 999-99-99");
// }
//
// maskPhone()
//
//
// const templatePhone = `
//  <div class="form-group form-group--tel">
//      <label class="data-user__label data-user__label--tel">Контактный телефон</label>
//      <input type="tel" name placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" name="new-number">
//      <span class="remove_phone"><svg><use xlink:href="/local/templates/main/html/assets/img/sprites/sprite.svg#plus"></use></svg></span>
//  </div>
// `
//
// $('.add-new-phone').on('click', function () {
//     $('.form-tel-container').append(templatePhone)
//     maskPhone()
//     $(".remove_phone").on("click",function(event){
//         this.parentElement.remove();
//     })
// });

$('.password-control').on('click', function () {
    if ($(this).prev().attr('type') == 'password') {
        $(this).addClass('view');
        $(this).prev().attr('type', 'text');
    } else {
        $(this).removeClass('view');
        $(this).prev().attr('type', 'password');
    }
});



// Загрузка фото в объявлении

let templateImg = (img,name) => {
    return `
            <div class="preview-img">
                <img src="${img}" alt="img">
                <span class="preview-remove" data-file="${name}">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6.33594 7.71732L9.8652 11.2466L10.0066 11.1052L9.86521 11.2466C10.2473 11.6287 10.8669 11.6289 11.2492 11.2466C11.6315 10.8645 11.6315 10.2448 11.2492 9.86258L7.71996 6.33329L11.2492 2.80403C11.2492 2.80402 11.2492 2.80401 11.2492 2.80399C11.6315 2.42184 11.6315 1.80221 11.2492 1.41996C10.8671 1.03765 10.2474 1.03772 9.8652 1.41996L10.0066 1.56138L9.8652 1.41996L6.33594 4.94925L2.80671 1.42C2.42458 1.03766 1.80494 1.0377 1.42268 1.41992L6.33594 7.71732ZM6.33594 7.71732L2.80667 11.2466L2.80663 11.2467C2.42438 11.6287 1.80478 11.6287 1.42265 11.2466L1.42264 11.2466C1.0404 10.8644 1.04033 10.2447 1.42264 9.86258C1.42266 9.86257 1.42267 9.86255 1.42268 9.86254L4.95191 6.33329L1.42264 2.80399C1.0404 2.42175 1.04034 1.80211 1.42264 1.41996L6.33594 7.71732Z"  stroke="#8E8E8E" stroke-width="0.4"/>
</svg></span>
            </div>
            `
}

let fileListImg = [];

let loadedImg = ()=>{
    $(".dropzone_count__loaded").text(fileListImg.length)
}

function readerImgFile(imgList){

    if (imgList.length !== 0) {
        imgList.forEach((file)=>{

            let reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function () {
                if(fileListImg.length < 9){
                    $(".dropzone__content").append(templateImg(reader.result, file.name))
                    fileListImg.push(file);
                    loadedImg()
                }else{
                    alert("Больше нельзя добавлять")
                }
            }

        })
    }

}

$("#inputFile").on("change", function () {
    let imgList = Array.from(this.files);
    readerImgFile(imgList);
})


$(".dropzone__content").on("click", ()=>{
    let target = event.target
    if(target.closest(".preview-remove")){
        let dataName = target.closest(".preview-remove").getAttribute("data-file")

        let removeItemImg = fileListImg.find(file => file.name === dataName)

        fileListImg = fileListImg.filter(file => file !== removeItemImg)

        const itemPreview = document.querySelector(`[data-file="${dataName}"]`).closest(".preview-img")
        itemPreview.classList.add("remove")

        setTimeout(()=>{
            itemPreview.remove()
        },300)

    }else{
        return false
    }
    loadedImg()
})

function highlightDropZone(event){
    event.preventDefault()
    this.classList.add("drop")
}

function unHighlightDropZone(event){
    event.preventDefault()
    this.classList.remove("drop")
}

const dropzone = document.querySelector(".dropzone")

if(dropzone){

    dropzone.addEventListener("dragover", highlightDropZone)
    dropzone.addEventListener("dragenter", highlightDropZone)
    dropzone.addEventListener("dragleave", unHighlightDropZone)
    dropzone.addEventListener("drop", (event)=>{
        let dt = event.dataTransfer.files[0]
        let dtListImg = Array.from(event.dataTransfer.files)

        unHighlightDropZone.call(dropzone, event)
        readerImgFile(dtListImg)
    })
}
// enf loaded photo


$("#announcementTextarea").on("input", function () {
    $(".result-text-value").text(this.value.length);
})



$(".btn--no-name-error").on("click", function (event) {
    event.preventDefault()
    $(".popUp-error").addClass("active")
    $('.substrate').addClass("active")
})


$(".popUp-error__btn").on("click", function () {
    $(".popUp-error").removeClass("active")
    $('.substrate').removeClass("active")
})

const questionItemBtnList = document.querySelectorAll('.question-block__item');
const questionsList = document.querySelectorAll(".questions-item-header");
const questionsContentList = document.querySelectorAll(".question-content__item");

if(questionItemBtnList){
    questionItemBtnList.forEach((item)=>{
        item.addEventListener("click", function (){
            $(".question-block__item").removeClass("active")
            this.classList.add("active")
            questionsContentList.forEach((el)=>{
                el.classList.remove("active")
                let valueItem = el.getAttribute("data-question");
                if(valueItem === this.getAttribute("data-question")){
                    el.classList.add("active")
                }
            })
        })
    })
}

if(questionsList !== null){
    questionsList.forEach((el)=>{
        el.addEventListener("click",function (){
            el.classList.toggle("active");

            $(this).siblings().slideToggle( "slow" );
        })
    })
}

$(".sign-in").on("click", function () {
    $(".popUp-login").addClass("active");
    $('.substrate').addClass("active");
})

$(".login-btn-list__item").on("click", function () {
    $(".login-btn-list__item").removeClass("active")
    if($(this).hasClass("login-btn")){
        $(".registration-content").removeClass("active")
        $(".login-content").addClass("active")
    }else{
        $(".login-content").removeClass("active")
        $(".registration-content").addClass("active")
    }
    $(this).addClass("active")
})

$("#reset-password").on("click", function () {
    $(".popUp-login").removeClass("active")
    $('.popUp-reset-mail').addClass("active")
})

$(".data-user-btn").on("click", function () {
    $(".popUp-success").addClass("active");
    $('.substrate').addClass("active");
})

