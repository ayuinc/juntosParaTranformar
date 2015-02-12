'use-strict'
$(document).ready ->
	$progressWizard = $('#progress-wizard')
	$stepCounters = $('ul.step-counters', $progressWizard)
	$stepPanels = $('.step-panels', $progressWizard)
	$stepActions = $('.step-actions', $progressWizard)
	
	# stepPanelzIndex: 30
	# $('.step-panel:first-child', $stepPanels).css({
	# 	zIndex: stepPanelzIndex
	# 	})

	$stepCounters.on('click', 'li', (e)->
		e.preventDefault()
		$stepCounters.find('li').removeClass 'active'
		$(this).addClass 'active'
		$stepPanels.find('.step-panel').removeClass 'active'
		stepRef = $(this).data 'panel-ref'
		# console.log(stepRef)
		$stepPanels.find('#' + stepRef).addClass 'active'
		return
	)

	$stepActions.on('click', '.next', (e)->
		e.preventDefault()
		stepRef = $stepCounters.find('li.active').next().data 'panel-ref'
		console.log($stepCounters.find('li[data-panel-ref="'+stepRef+'"]'))
		$stepCounters.find('li').removeClass 'active'
		$stepCounters.find('li[data-panel-ref="'+stepRef+'"]').addClass('active')
		$stepPanels.find('.step-panel').removeClass 'active'
		$stepPanels.find('#' + stepRef).addClass 'active'
		# console.log($(this))
		return
	)

	$stepActions.on('click', '.prev', (e)->
		e.preventDefault()
		# console.log($(this))
		return
	)

	$stepActions.on('click', '.finish', (e)->
		e.preventDefault()
		$('.step-wizard-instructions').addClass('hidden')
		$stepCounters.addClass('hidden')
		$('.step-wizard-thanks').removeClass('hidden')
		$stepPanels.find('.step-panel').removeClass 'active'
		$('#step-panel-last').addClass('active')
		# console.log($(this))
		return
	)

	# $.each($stepCounters, (index, item)->
	# 	# console.log(index)
	# 	# console.log(item)
	# 	return
	# )

	# console.log($stepCounters)

	return