(function ($) {

	$('.select2').select2();
	repeaterInit();

	/**
	 * Init all repeaters instances
	 */
	function repeaterInit() {
		$('.add_repeater_group').click(addRepeaterGroup)
		$('.remove_repeater_group').click(removeRepeaterGroup)
	}

	/**
	 * Add new Repeater Group
	 */
	function addRepeaterGroup() {
		// Get Repeater
		var repeater = $(this).parent()

		// Get Name of Repeater
		var name = repeater.data('name');

		// Get array of indexes from repeater's controller input
		var repeaterCtrl = repeater.find('input.repeater-count');
		var indexes = repeaterCtrl.val().length ? repeaterCtrl.val().split(',') : [];

		// Set the new index as the maximum of the current index + 1
		var index = indexes.length ? Math.max(...indexes) + 1 : 0;

		// List with all repeaters' templates
		var repeaterFields = {
			'more_link': `<div class="repeater-group" id="${name}_${index}" data-index="${index}">
							<button type="button" id="remove_${name}_${index}"
								class="remove_repeater_group">Remove link</button>
							<div class="repeater-input">
								<label for="${name}_${index}_label">Link Label</label>
								<input type="text" id="${name}_${index}_label" name="${name}_${index}_label" required/>
							</div>
							<div class="repeater-input">
								<label for="${name}_${index}_icon">Link Icon</label>
								<input type="text" id="${name}_${index}_icon" name="${name}_${index}_icon" required/>
							</div>
							<div class="repeater-input">
								<label for="${name}_${index}_url">Link Url</label>
								<input type="url" id="${name}_${index}_url" name="${name}_${index}_url" required/>
							</div>
						</div>`
		};

		// Insert new repeater group before button
		$(repeaterFields[name]).insertBefore(this);

		// Update repeater's controller input with new stringified array of indexes
		indexes.push(index);
		repeaterCtrl.val(indexes.join(','));

		//Initialize remove button
		$(`#remove_${name}_${index}`).click(removeRepeaterGroup)
	}

	/**
	 * Remove Repeater Group
	 */
	function removeRepeaterGroup() {
		// Get Repeater Group
		var repeaterGroup = $(this).parent();

		// Get Repeater Group's Index
		var repeaterGroupIndex = repeaterGroup.data('index');

		// Update repeater's controller input with new stringified array of indexes
		var repeaterCtrl = $(this).parent().parent().find('input.repeater-count');
		var indexes = repeaterCtrl.val() ? repeaterCtrl.val().split(',').filter(index => index != repeaterGroupIndex) : [];
		repeaterCtrl.val(indexes.join(','));

		//Remove Repeater Group
		repeaterGroup.remove();
	}

})(jQuery);