<?php
/**
 * Compliance & Privacy - Show the banner when a html element with class 'cmplz-show-banner' is clicked
 */
function compliance_show_banner_on_click() {
	?>
	<script>
        function addEvent(event, selector, callback, context) {
            document.addEventListener(event, e => {
                if ( e.target.closest(selector) ) {
                    callback(e);
                }
            });
        }
        // For elements with class 'compliance-show-cookie-banner'
        addEvent('click', '.compliance-show-cookie-banner', function(){
            document.querySelectorAll('.cmplz-manage-consent').forEach(obj => {
                obj.click();
            });
        });
		// For elements where we can't set a class. Now based on 'Cookie-instellingen' - handles both <a> and <span>
        addEvent('click', 'footer a, footer span', function(e){
            const element = e.target.closest('a, span');
            if (element?.textContent.trim() === 'Cookie-instellingen') {
                document.querySelectorAll('.cmplz-manage-consent').forEach(obj => {
                    obj.click();
					e.preventDefault();
                });
            }
        });
	</script>
	<?php
}
add_action( 'wp_footer', 'compliance_show_banner_on_click' );