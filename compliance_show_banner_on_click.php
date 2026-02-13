<?php
/**
 * Compliance & Privacy - Show the banner when a html element with class 'cmplz-show-banner' is clicked
 */
function compliance_show_banner_on_click() {
	?>
	<script>
		(function($) {
			// Use jQuery's document ready for maximum compatibility
			$(document).ready(function() {
				
				// Event delegation - works even if elements don't exist yet
				// For elements with class 'compliance-show-cookie-banner'
				$(document).on('click', '.compliance-show-cookie-banner', function(e){
					e.preventDefault();
					$('.cmplz-manage-consent').first().trigger('click');
				});
				
				// For elements where we can't set a class. Now based on 'Cookie-instellingen' - handles both <a> and <span>
				$(document).on('click', 'footer a, footer span', function(e){
					if ($(this).text().trim() === 'Cookie-instellingen') {
						e.preventDefault();
						$('.cmplz-manage-consent').first().trigger('click');
					}
				});

				/*
				* For LeadBooster only
				* This script ensures that when the consent banner is visible, the LeadBooster container is sent to the back (lower z-index) so it doesn't cover the banner. When the banner is hidden, it removes the z-index override to allow LeadBooster to function normally.
				*/
				
				// Wait for elements to exist before initializing observer
				function waitForElements(callback) {
					var checkInterval = setInterval(function() {
						if ($('#LeadboosterContainer').length || $('.cmplz-cookiebanner').length) {
							clearInterval(checkInterval);
							callback();
						}
					}, 100);
					
					// Stop checking after 10 seconds
					setTimeout(function() {
						clearInterval(checkInterval);
					}, 10000);
				}
				
				// Conditionally override Leadbooster z-index only when consent banner is visible
				function updateLeadboosterZIndex() {
					var $leadbooster = $('#LeadboosterContainer');
					var $banner = $('.cmplz-cookiebanner');
					
					if ($leadbooster.length && $banner.length) {
						var bannerVisible = $banner.is(':visible');
						if (bannerVisible) {
							// Banner is visible - lower Leadbooster z-index
							$leadbooster.css('z-index', '10', 'important');
						} else {
							// Banner is hidden - remove our z-index override
							$leadbooster.css('z-index', '');
						}
					}
				}
				
				// Initialize observer once elements exist
				waitForElements(function() {
					// Monitor for banner visibility changes using MutationObserver
					var observer = new MutationObserver(function() {
						updateLeadboosterZIndex();
					});
					
					observer.observe(document.body, {
						childList: true,
						subtree: true,
						attributes: true,
						attributeFilter: ['style', 'class']
					});
					
					// Initial check and periodic updates
					updateLeadboosterZIndex();
					setTimeout(function() { updateLeadboosterZIndex(); }, 100);
					setInterval(function() { updateLeadboosterZIndex(); }, 500);
				});
				/* End of LeadBooster z-index handling */
				
			});
		})(jQuery);
	</script>
	<?php
}
add_action( 'wp_footer', 'compliance_show_banner_on_click' );