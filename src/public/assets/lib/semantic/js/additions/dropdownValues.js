// beta v1.0 created by Erik Furik

$.ajaxPrefilter(function(options, originalOptions, jqXHR) {
    options.async = true;
});

$.fn.extend({
    semanticDropdownGetPostValues: function(maxSelections) {

		var $element = $(this).children("input[name=" + $(this).attr("id") + "]");
		var val = $(this).dropdown("get value");

		var count = val.split(",");
		count = count.length;

		if (maxSelections !== undefined && count > maxSelections) {
			val = val.split(",");
			val = val.splice(0, maxSelections);
		}

		$element.val(val);
    },
    semanticDropdownSetValues: function(value) {
   
    	try {
	        $(this).dropdown('set selected', JSON.parse(value));
	    } catch (e) {
	        return false;
	    }
    }
});
