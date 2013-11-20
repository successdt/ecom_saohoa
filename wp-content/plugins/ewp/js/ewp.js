jQuery.noConflict();
jQuery(document).ready(function(){
    var max = 3;
    var checkboxes = jQuery('input[type="checkbox"]');

    checkboxes.click(function(){
        var $this = jQuery(this);
        var current = checkboxes.filter(':checked').length;
        return current <= max;
    });
});	

