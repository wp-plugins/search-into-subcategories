for(var i=SIS_levels-1;i>=0;i--){
	add_SIS_level(i);
}

function add_SIS_level(level){
	jQuery("#level-"+level).change(function(){
		jQuery("#level-"+(level+1))
			.html("<option>-- SELECT --</option>")
			.nextAll("select").prop("disabled", true);
		if(!SIS_data[jQuery("#level-"+level).val()])
			return;
		if(!Object.keys(SIS_data[jQuery("#level-"+level).val()]).length)
			return;
		jQuery("#level-"+(level+1)).prop("disabled", false);
		jQuery("#level-"+(level+1)).change(function(){
			jQuery("#category").val(jQuery(this).val());
		});
		jQuery.each(SIS_data[jQuery("#level-"+level).val()], function (key, value) {
			jQuery("#level-"+(level+1)).append(
				jQuery("<option></option>")
				  .attr("value", key)
				  .text(value)
			);
		});
	});
}