$(function(){
	$('img[dat]').each(function(){
		if (!$(this).attr('daturl')){
			$(this).attr('src', '/mogif/img/'+$(this).attr('dat')+'.html');
			this.onerror = function(){this.src='/static/img/not_found.jpg';};
		}
	});
	$('img[daturl]').each(function(){
		$(this).attr('src', $(this).attr('daturl'));
		this.onerror = function(){
			if ($(this).attr('dat')){
				$(this).attr('src', '/mogif/img/'+$(this).attr('dat')+'.html');
				this.onerror = function(){this.src='/static/img/not_found.jpg';};
			}
		};
	});
	$.get('/momgr/index.html?i='+(window.PAGEID?PAGEID:'unknown')+'&d='+(new Date()).getTime());
});