$ ->
	if $.cookie('designer')
		$('#designer').attr('checked', true)
	else
		$('#designer').attr('checked', false)

	$('#designer').change ->
		if $(this).is(':checked')
			$.cookie('designer', 'true')
		else
			$.removeCookie('designer')

	$('#delete').submit (event)->
		if confirm('Are you sure to delete?')
			if confirm('Previous test data will also be deleted!')
				return true
		return false
