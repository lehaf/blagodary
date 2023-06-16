const PhoneController = function () {

     this.templatePhone = `
         <div class="form-group form-group--tel">
             <label class="data-user__label data-user__label--tel">Контактный телефон*</label>
             <input type="tel" name="UF_PHONES[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" name="new-number">
             <span class="remove_phone"><svg><use xlink:href="/local/templates/main/html/assets/img/sprites/sprite.svg#plus"></use></svg></span>
         </div>
        `

    this.init();
}

PhoneController.prototype.init = function ()
{
    this.setupListener();
    this.initPhoneMask();
    this.deletePhone();
}

PhoneController.prototype.setupListener = function ()
{
    const _this = this;
    $('.add-new-phone').on('click', function () {
        $('.form-tel-container').append(_this.templatePhone);
        _this.initPhoneMask();
        _this.deletePhone();
    });
}

PhoneController.prototype.initPhoneMask = function ()
{
    $(".dataUserTel").mask("+375 (99) 999-99-99");
}
PhoneController.prototype.deletePhone = function ()
{
    $(".remove_phone").on("click",function(){
        this.parentElement.remove();
    });
}

addEventListener('DOMContentLoaded',() => {
    new PhoneController();
});