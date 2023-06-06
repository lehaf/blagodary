function handleHeightBlock() {
    let scrollForm = $('.card-colors'),
        scrollForm_sh = scrollForm.length > 0 ? scrollForm[0].scrollHeight : false,
        scrollForm_h = scrollForm.length > 0 ? scrollForm.height() : false;

    const ScrollBlock = document.querySelector('.card-colors');

    const hasVerScroll = ScrollBlock.scrollHeight > ScrollBlock.clientHeight;
console.log('ScrollBlock.scrollHeight' ,ScrollBlock.scrollHeight)
    console.log('ScrollBlock.clientHeight' , ScrollBlock.clientHeight)
    console.log('hasVerScroll' ,hasVerScroll)
    if (hasVerScroll && scrollForm_sh) {
        $('.more-card-color').show();
    }
}


