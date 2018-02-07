// $('.category').click(function(){
//     $('.sub-category').hide();
// 	$(this).children('.sub-category').show();
// });

// $('.sub-category').on('click', function( e ){
//     e.stopPropagation();
// 	$(this).hide();
// });

$('.category-auto').click(function(){
    $('.sub-category').hide();
	$(this).children('.sub-category').show();
});

$('.sub-category').on('click', function( e ){
    e.stopPropagation();
	$(this).hide();
});

// $('.categories').click(function(){
//     $('.category-auto').hide();
//     $('.sub-category').hide();
// 	$(this).children('.sub-category').show();
// });

// $('.sub-category').on('click', function( e ){
//     e.stopPropagation();
// 	$(this).hide();
// });