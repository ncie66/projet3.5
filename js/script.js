$('.category-auto').click(function(){
    $('.sub-category').hide();
    // $(this).children('.sub-category').show();
    $(this).children('.sub-category').css('display', 'flex');
});

$('.sub-category').on('click', function( e ){
    if(!$(e.target).hasClass('s-cat')) {
        e.stopPropagation();
	    $(this).hide();
    }
});

$('.s-cat').click(function(){
    $(this).children('.s-cat-container').css('display', 'flex');
});
$('.s-cat-container').on('click', function( e ){
    e.stopPropagation();
	$(this).hide();
});

