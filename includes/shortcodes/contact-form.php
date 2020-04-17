<?php
/**
 * Contact Form Shortcode
 *
 * Displays a contact form.
 *
 * @package Cluster Assistant
 * @subpackage Cluster
 */
function cluster_contact_form_sc() {
	$nameError         = __( 'Please enter your name.', 'cluster-assistant' );
	$emailError        = __( 'Please enter your email address.', 'cluster-assistant' );
	$emailInvalidError = __( 'You entered an invalid email address.', 'cluster-assistant' );
	$commentError      = __( 'Please enter a message.', 'cluster-assistant' );

	$errorMessages = array();

	if ( isset( $_POST['submitted'] ) ) {
		if ( '' === trim( $_POST['contactName'] ) ) {
			$errorMessages['nameError'] = $nameError;
			$hasError                   = true;
		} else {
			$name = trim( $_POST['contactName'] );
		}

		if ( '' === trim( $_POST['email'] ) ) {
			$errorMessages['emailError'] = $emailError;
			$hasError                    = true;
		} elseif ( ! is_email( trim( $_POST['email'] ) ) ) {
			$errorMessages['emailInvalidError'] = $emailInvalidError;
			$hasError                           = true;
		} else {
			$email = trim( $_POST['email'] );
		}

		if ( '' === trim( $_POST['comments'] ) ) {
			$errorMessages['commentError'] = $commentError;
			$hasError                      = true;
		} else {
			if ( function_exists( 'stripslashes' ) ) {
				$comments = stripslashes( trim( $_POST['comments'] ) );
			} else {
				$comments = trim( $_POST['comments'] );
			}
		}

		if ( ! isset( $hasError ) ) {
			$emailTo = cluster_get_thememod_value( 'general_contact_email' );
			if ( ! isset( $emailTo ) || ( '' === $emailTo ) ) {
				$emailTo = get_option( 'admin_email' );
			}
			$subject = '[Contact Form] From ' . $name;

			$body  = "Name: $name \n\nEmail: $email \n\nMessage: $comments \n\n";
			$body .= "--\n";
			$body .= 'This mail is sent via contact form on ' . get_bloginfo( 'name' ) . "\n";
			$body .= home_url();

			$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n" . 'Reply-To: ' . $email;

			wp_mail( $emailTo, $subject, $body, $headers );
			$emailSent = true;
		}
	}
	?>

	<h3 id="reply-title"><?php esc_html_e( 'Send a Direct Message', 'cluster-assistant' ); ?><span class="section-description"><?php esc_html_e( 'Please be polite. We appreciate that.', 'cluster-assistant' ); ?></span></h3>

	<?php if ( isset( $emailSent ) && $emailSent == true ) { ?>

	<div class="stag-alert accent-background">
		<p><?php esc_html_e( 'Thanks, your email was sent successfully.', 'cluster-assistant' ); ?></p>
	</div>

<?php } else { ?>

<form action="<?php the_permalink(); ?>" id="contactForm" class="contact-form" method="post">

	<div class="grids">
		<p class="grid-6">
			<label for="contactName"><?php esc_html_e( 'Your Name', 'cluster-assistant' ); ?></label>
			<input type="text" name="contactName" id="contactName" value="
			<?php
			if ( isset( $_POST['contactName'] ) ) {
				echo $_POST['contactName'];}
			?>
			">
			<?php if ( isset( $errorMessages['nameError'] ) ) { ?>
				<span class="error"><?php echo $errorMessages['nameError']; ?></span>
			<?php } ?>
		</p>

		<p class="grid-6">
			<label for="email"><?php esc_html_e( 'Your Email', 'cluster-assistant' ); ?><span>*<?php esc_html_e( 'Will not be published', 'cluster-assistant' ); ?></span></label>
			<input type="text" name="email" id="email" value="
			<?php
			if ( isset( $_POST['email'] ) ) {
				echo $_POST['email'];}
			?>
			">
			<?php if ( isset( $errorMessages['emailError'] ) ) { ?>
				<span class="error"><?php echo $errorMessages['emailError']; ?></span>
			<?php } ?>
			<?php if ( isset( $errorMessages['emailInvalidError'] ) ) { ?>
				<span class="error"><?php echo $errorMessages['emailInvalidError']; ?></span>
			<?php } ?>
		</p>
	</div>

	<p>
		<label for="commentsText"><?php esc_html_e( 'Your Message', 'cluster-assistant' ); ?></label>
		<textarea rows="8" name="comments" id="commentsText" >
		<?php
		if ( isset( $_POST['comments'] ) ) {
			if ( function_exists( 'stripslashes' ) ) {
				echo stripslashes( $_POST['comments'] );
			} else {
				echo $_POST['comments']; }
		}
		?>
		</textarea>
		<?php if ( isset( $errorMessages['commentError'] ) ) { ?>
			<span class="error"><?php echo $errorMessages['commentError']; ?></span>
		<?php } ?>
	</p>

	<p class="buttons">
		<input type="submit" id="submitted" class="accent-background contact-form-button" name="submitted" value="<?php esc_html_e( 'Send Message', 'cluster-assistant' ); ?>">
	</p>

</form>

<?php
}
}
add_shortcode( 'cluster_contact_form', 'cluster_contact_form_sc' );
