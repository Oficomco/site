var mst = jQuery.noConflict();
mst(document).ready(function(){

	mst('.top-link-extra').hover(function(){
			mst('.top-link-extra .link-extra-content').show();
		}, 
		function(){
			mst('.top-link-extra .link-extra-content').hide();
		}); 
});