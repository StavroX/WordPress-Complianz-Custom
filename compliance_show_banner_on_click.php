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
        addEvent('click', '.compliance-show-cookie-banner', function(e){
            document.querySelectorAll('.cmplz-manage-consent').forEach(obj => {
                obj.click();
				e.preventDefault();
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

		/*
		* For LeadBooster only
		* This script ensures that when the consent banner is visible, the LeadBooster container is sent to the back (lower z-index) so it doesn't cover the banner. When the banner is hidden, it removes the z-index override to allow LeadBooster to function normally.
		*/
		// Conditionally override Leadbooster z-index only when consent banner is visible
		function updateLeadboosterZIndex() {
			const leadbooster = document.getElementById('LeadboosterContainer');
			const banner = document.querySelector('.cmplz-cookiebanner');
			
			if (leadbooster && banner) {
				const bannerVisible = banner.offsetParent !== null || window.getComputedStyle(banner).display !== 'none';
				if (bannerVisible) {
					// Banner is visible - lower Leadbooster z-index
					leadbooster.style.setProperty('z-index', '10', 'important');
				} else {
					// Banner is hidden - remove our z-index override
					leadbooster.style.zIndex = '';
				}
			}
		}
		// Monitor for banner visibility changes
		const observer = new MutationObserver(() => {
			updateLeadboosterZIndex();
		});
		
		if (document.body) {
			observer.observe(document.body, {
				childList: true,
				subtree: true,
				attributes: true,
				attributeFilter: ['style', 'class']
			});
		}
		
		// Also check when document is ready and periodically
		setTimeout(() => updateLeadboosterZIndex(), 100);
		setInterval(() => updateLeadboosterZIndex(), 500);
		/* End of LeadBooster z-index handling */

	</script>
	<?php
}
add_action( 'wp_footer', 'compliance_show_banner_on_click' );