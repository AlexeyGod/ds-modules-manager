// Модальные окна
// открыть
function modalOpen(idModal)
{
    $(".ds-modal-fade").show();
    $(idModal).show();
}
// Закрыть
function modalClose()
{
    $(".ds-modal-fade").hide();
    $(".ds-modal").hide();
}
// События
$(document).ready(function(){
    console.log("Система управления DS-CMS разаботна WEB-студией Digital-Solution.Ru");
    // Открытие модальных окон
    $(".ds-modal-open").on('click', function(e){
        e.preventDefault();
        var modalId = $(this).attr('data-modal');
        modalOpen(modalId);

    })
    // Закрытие модальных окон
    $(".ds-modal-close").on('click', function(e){
        e.preventDefault();
       modalClose();

    })
    // Эмуляция кликов по input-icon
    $(".input-icon").on('click', function(){
        console.log('it work!!');
        $(this).prev("input:first").focus();
    });
});