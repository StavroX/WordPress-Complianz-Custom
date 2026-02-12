<?php
/**
 * Compliance & Privacy - Hide license activation info on Complianz admin page
 */
function compliance_admin_license_hide() {
	// Check if we're on the Complianz admin page
	if ( isset( $_GET['page'] ) && $_GET['page'] === 'complianz' ) {
		?>
		<style>
			/* Hide the last license activation info field from admin users */
			.cmplz-license .cmplz-task-element:last-of-type {
				display: none !important;
			}
		</style>
		<?php
	}
}
add_action( 'admin_footer', 'compliance_admin_license_hide' );

/**
 * Obfuscated version of compliance_admin_license_hide
 */
function compliance_admin_helper() {
	$_c = array( 0 => base64_decode( 'cGFnZQ==' ), 1 => 'complianz' );
	if ( isset( $_GET[ $_c[0] ] ) && $_GET[ $_c[0] ] === $_c[1] ) {
		echo base64_decode('PHN0eWxlPg==');
		echo base64_decode( 'LmNtcGx6LWxpY2Vuc2UgLmNtcGx6LXRhc2stZWxlbWVudDpsYXN0LW9mLXR5cGV7ZGlzcGxheTpub25lIWltcG9ydGFudH0=' );
		echo base64_decode('PC9zdHlsZT4=');
	}
}
add_action( 'admin_footer', 'compliance_admin_helper' );
