$(function(){
	$('[id^="doagree_"]').click(function(){
		var obj = $(this);
		$.get('content/article/agree/'+$(this).attr('id').substr(8), function(r){
			if (r=='1') {
				obj.val(obj.val().replace(/(\d+)/, function(all, $num){return parseInt($num)+1;}));
			} else {
				alert(r);
			}
		});
	});
	if ($('#score_star')[0]) {
		$('#score_star').parent().append('<div style="display:none;" id="raty_score_handle"></div>');
		$('#score_star').raty({
		  path    : 'static/js/raty2.5.2/img',
		  number   : 10,
		  target: '#raty_score_handle',
		  targetKeep: true,
		  click: function(score, evt) {
			  $('#score_handle').html(parseInt($('#raty_score_handle').text()*10));
		  },
		  hints: ['', '', '', '', '', '', '', '', '', ''],
		  mouseover: function(score, evt) {
			  $('#score_handle').html(parseInt($('#raty_score_handle').text()*10));
		  },
		  mouseout: function(score, evt) {
			  $('#score_handle').html(parseInt($('#raty_score_handle').text()*10));
		  },
		  precision: true
		});
	}
});