<?php 

global $kayako;


if(array_key_exists('kayako_url', $_POST)) {
	
	
	if($kayako->saveSettings($_POST)) {
		?><div class="updated"><p><strong><?php _e('Options saved successfully'); ?></strong></p></div><?php
		
		$kayako->createTicket();
	}
	else {
		?><div class="updated"><p><strong><?php _e('Could not save'); ?></strong></p></div><?php
	}
}

$kayako_url    = '';
$kayako_key    = '';
$kayako_secret = '';

$settings = $kayako->getSettings();

if($settings) {
	$kayako_url		= $settings['kayako_url'];
	$kayako_key		= $settings['kayako_key'];
	$kayako_secret  = $settings['kayako_secret'];
}

?>

<div class="wrap">
	<div id="kayako-icon32" class="icon32"><br></div>
	<h2><?php _e( 'Kayako for Wordpress Settings', 'setup' ) ?></h2>

	<div class="tool-box">
		<h3 class="title">Access Settings</h3>
		<p>This is just some dummy text to fill up the area</p>
		<form name="kayako_access_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<?php    echo "<h4>" . __( 'Your kayako URL' ) . "</h4>"; ?> <input type="text" name="kayako_url" id="kayako_url" value="<?php echo $kayako_url?>"/>
			<?php    echo "<h4>" . __( 'API Key' ) . "</h4>"; ?> <input type="text" name="kayako_key" id="kayako_key" value="<?php echo $kayako_key?>"/>
			<?php    echo "<h4>" . __( 'API Secret' ) . "</h4>"; ?> <input type="text" name="kayako_secret" id="kayako_secret" value="<?php echo $kayako_secret?>"/>
			<br/><br/><input type="submit" name="Submit" value="<?php _e('Save', 'save' ) ?>" class="button-primary"/>
			</p>
		</form>
	</div>
</div>