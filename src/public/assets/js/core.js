$.fn.extend({
    Amodal: function(html) {
    	$(this).empty();
    	$(this).append(html);
		$(this).modal('show');
    }
});