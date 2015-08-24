jQuery(document).ready(function($){
	
	var shadow_x = $("#shadow-x").val();
	var shadow_y = $("#shadow-y").val();
	var shadow_radius = $("#shadow-radius").val();
	var shadow_opacity = $("#shadow-opacity").val();
	var shadowRgb = hexToRgb($('#shadow-color').val());
	var shadowRgba = 'rgba(' + shadowRgb.r + ', ' + shadowRgb.g + ', ' + shadowRgb.b + ', ' + shadow_opacity + ')';	
	
	// Map area
	$("#no-area").change(function() { $(".area").toggle(); });
    $('#area-color').wpColorPicker({
		change: function(event, ui){
			$(".area").css('background-color', ui.color.toString());
		}
	});
	$('#area-opacity').change(function(){
		$(".area").css('opacity', $(this).val());
	});

	$("#no-border").change(function() { $(".area-border").toggle(); });
	$('#area-border-color').wpColorPicker({
		change: function(event, ui){
			$(".area-border").css('border-color', ui.color.toString());
		}
	});
	$('#area-border-width').change(function(){
		$(".area-border").css({
		'border-width' : $(this).val(),
		'top' : 50 - $(this).val(),
		'left' : 75 - $(this).val()
		});
	});
	$('#area-border-opacity').change(function(){
		$(".area-border").css('opacity', $(this).val());
	});
	
	// Shadow
	$("#no-shadow").change(function() { $(".area-shadow").toggle(); });
	$('#shadow-color').wpColorPicker({
		change: function(event, ui){
			shadowRgb = ui.color.toRgb();
			shadowRgba = 'rgba(' + shadowRgb.r + ', ' + shadowRgb.g + ', ' + shadowRgb.b + ', ' + shadow_opacity + ')';
			$(".area-shadow").css('box-shadow', shadow_x + 'px ' + shadow_y + 'px ' + shadow_radius + 'px ' + shadowRgba);
		}
	});
	$('#shadow-x').change(function(){
		shadow_x = $(this).val();
		$(".area-shadow").css('box-shadow', shadow_x + 'px ' + shadow_y + 'px ' + shadow_radius + 'px ' + shadowRgba);
	});
	$('#shadow-y').change(function(){
		shadow_y = $(this).val();
		$(".area-shadow").css('box-shadow', shadow_x + 'px ' + shadow_y + 'px ' + shadow_radius + 'px ' + shadowRgba);
	});
	$('#shadow-radius').change(function(){
		shadow_radius = $(this).val();
		$(".area-shadow").css('box-shadow', shadow_x + 'px ' + shadow_y + 'px ' + shadow_radius + 'px ' + shadowRgba);
	});
	$('#shadow-opacity').change(function(){
		shadow_opacity = $(this).val();
		shadowRgb = hexToRgb($('#shadow-color').val());
		shadowRgba = 'rgba(' + shadowRgb.r + ', ' + shadowRgb.g + ', ' + shadowRgb.b + ', ' + shadow_opacity + ')';
		$(".area-shadow").css('box-shadow', shadow_x + 'px ' + shadow_y + 'px ' + shadow_radius + 'px ' + shadowRgba);
	});
	
	// Tooltip
	$('#tooltip-padding-vertical').change(function(){
		$(".tooltip").css({ 'padding-top' : $(this).val() + 'px', 'padding-bottom' : $(this).val() + 'px'});
	});
	$('#tooltip-padding-horizontal').change(function(){
		$(".tooltip").css({'padding-left' : $(this).val() + 'px', 'padding-right' : $(this).val() + 'px' });
	});
	$('#tooltip-color').wpColorPicker({
		change: function(event, ui){
			$(".tooltip").css('background', ui.color.toString());
		}
	});
	$('#tooltip-border-color').wpColorPicker({
		change: function(event, ui){
			$(".tooltip").css('border-color', ui.color.toString());
		}
	});
	$('#tooltip-border-width').change(function(){
		$(".tooltip").css('border-width', $(this).val());
	});
	$('#tooltip-text-color').wpColorPicker({
		change: function(event, ui){
			$(".tooltip").css('color', ui.color.toString());
		}
	});
});

function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}