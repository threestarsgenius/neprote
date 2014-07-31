function comment_add(post_id,parent_id) {
	if (!post_id) return false;
	if (!parent_id) var parent_id = 0;

	// check if comment not empty
	if ($('#text_' + parent_id).val() == '') return false;
	// turn on spinner
	$('#comment_submit').button('loading');

	$.ajax({
		type: "POST",
		url: '/comments/add',
		data: {
			post_id: post_id,
			parent_id: parent_id,
			text: $('#text_' + parent_id).val()
		},
		success : function(resp) {
			if ($('#empty_comments_notification')) $('#empty_comments_notification').remove()
			resp = JSON.parse(resp);
			var depth = 1;
			var date = new Date(parseInt(resp.created)*1000);
			var data = '<div id="comment_'+resp.id+'" class="media" data-id="'+resp.id+'" data-parent="'+resp.parent_id+'" data-depth="DEPTH_VALUE"><a class="pull-left"><img class="media-object" src="http://placekitten.com/50/50" alt="Generic placeholder image"></a><div class="media-body"><h5 class="media-heading" style="font-weight: bold"><span id="user_from_'+resp.id+'">'+resp.user_from+'</span><small>&nbsp;'+date.getHours()+':'+date.getMinutes()+'</small></h5><span id="comment_text_'+resp.id+'">'+resp.text+'</span><span id="comment_options_'+resp.id+'"><p><a onclick="comment_reply('+resp.post_id+','+resp.id+')">Reply</a> | <a onclick="comment_remove('+resp.id+')">Remove</a></p></span></div></div>';
			if (resp.parent_id == 0) {
				data = data.replace('DEPTH_VALUE', depth);
				$("#comments").append(data);
			} else {
				var parent = $('#comment_'+resp.parent_id+' > .media-body');
				depth = parseInt(parent.parent().attr('data-depth'))+1;
				data = data.replace('DEPTH_VALUE', depth);
				if (depth > 5) {
					parent = parent.parent().parent();
					var find_parent = $('div[data-parent='+resp.parent_id+']');
					if (find_parent.length == 0) {
						$(data).insertAfter($('[data-id = '+resp.parent_id+']'));
					} else {
						$(data).insertAfter(find_parent.last());
					}
				} else {
					parent.append(data);
				}
			}
			if(resp.user_to) $('#user_from_'+resp.id).append(' → <span id="user_to_'+resp.id+'">'+resp.user_to+'</span>');
			// clear comment
			$('#text_' + parent_id).val('');
			// turn off spinner
			$('#comment_submit').button('reset')
			if ($('#comment_reply_form').length >= 1) $('#comment_reply_form').remove();
		}
	});
}

function comment_remove(comment_id) {
	if (!comment_id) return false;
	$.ajax({
		type: "POST",
		url: '/comments/remove',
		data: {
			comment_id: comment_id
		},
		success : function(resp) {
			if (JSON.parse(resp) != 1) return false;
			if ($('#comment_'+comment_id+' .media-body').length > 1
				|| $('div[data-parent='+comment_id+']').length > 0) {
				$('#comment_text_'+comment_id).addClass('comment-deleted');
				$('#comment_remove_' + comment_id).remove();
				$('#comment_text_'+ comment_id).text('This comment was removed');
			} else {
				$('#comment_' + comment_id).remove();
			}
			if ($('#comments').children().length == 0) {
				$('#comments').append('<p id="empty_comments_notification">There are no comments yet</p>');
			}
		}
	});
}

function comment_reply(post_id, comment_id) {
	if (!post_id) return false;
	if (!comment_id) return false;
	if ($('#comment_reply_form').length >= 1) {
		$('#comment_reply_form').remove();
	} else {
		$('#comment_options_' + comment_id).append('<div id="comment_reply_form" class="form-group"><textarea id="text_'+comment_id+'" name="text_'+comment_id+'" class="form-control" size="30" maxlength="255"></textarea><input id="comment_submit" data-loading-text="Loading..." type="button" value="Add" class="btn btn-default" onclick="comment_add('+post_id+','+comment_id+')"></div>');
	}
}
