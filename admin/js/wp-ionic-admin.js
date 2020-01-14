(function( $ ) {

	$('.select2').select2();

	$('.add_repeater_group').click(function(e){
		var repeater =  $(this).parent()
		var name = repeater.data('name');
		var repeaterCtrl =  repeater.find('input.repeater-count');
		var index = repeaterCtrl.val() ? parseInt( repeaterCtrl.val() , 10) + 1 : 1;
		var repeaterGroup = 
		`<div class="repeater-group" id="${name}_${index}">
			<button type="button" id="remove_${name}_${index}"
				class="remove_repeater_group">Remove link</button>
			<div class="repeater-input">
				<label for="${name}_${index}_label">Link Label</label>
				<input type="text" name="${name}_${index}_label" required/>
			</div>
			<div class="repeater-input">
				<label for="${name}_${index}_url">Link Url</label>
				<input type="url" name="${name}_${index}_url" required/>
			</div>
			<div class="repeater-input">
				<label for="${name}_${index}_icon">Link Icon</label>
				<input type="text" name="${name}_${index}_icon" required/>
			</div>
		</div>`;
		$(repeaterGroup).insertBefore(this);
		repeaterCtrl.val(index);
		$(`#remove_${name}_${index}`).click(removeRepeaterGroup)
	})

	$('.remove_repeater_group').click(removeRepeaterGroup)

	function removeRepeaterGroup(){
		var repeater =  $(this).parent().parent();
		var repeaterCtrl =  repeater.find('input.repeater-count');
		var index = repeaterCtrl.val() ? parseInt( repeaterCtrl.val() , 10) - 1 : 0;
		repeaterCtrl.val(index);
		$(this).parent().remove();
	}
	

})( jQuery );


