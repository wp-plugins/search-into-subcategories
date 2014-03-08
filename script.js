jQuery(document).ready(function(){
		LOAD_SIS_HANDLER();
});

function add_SIS_level(level){
	jQuery("#level-"+level).change(function(){
		jQuery("#level-"+(level+1))
			.html("<option>-- SELECT --</option>")
			.nextAll("select").prop("disabled", true);
		if(!data[jQuery("#level-"+level).val()])
			return;
		if(!Object.keys(data[jQuery("#level-"+level).val()]).length)
			return;
		jQuery("#level-"+(level+1)).prop("disabled", false);
		jQuery("#level-"+(level+1)).change(function(){
			jQuery("#category").val(jQuery(this).val());
		});
		jQuery.each(data[jQuery("#level-"+level).val()], function (key, value) {
			jQuery("#level-"+(level+1)).append(
				jQuery("<option></option>")
				  .attr("value", key)
				  .text(value)
			);
		});
	});
} 