const maskPhone = () => {
    $(".dataUserTel").mask("+375 (99) 999-99-99");
}

maskPhone()

const templatePhone = `
 <div class="form-group form-group--tel">
     <label class="data-user__label data-user__label--tel">Контактный телефон</label>
     <input type="tel" name="OWNER_PHONE[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel">
     <span class="remove_phone"><svg><use xlink:href="/local/templates/main/html/assets/img/sprites/sprite.svg#plus"></use></svg></span>
 </div>
`
$('.add-new-phone').on('click', function () {
    $('.form-tel-container').append(templatePhone);
    maskPhone();
    $(".remove_phone").on("click",function(event){
        this.parentElement.remove();
    });
});