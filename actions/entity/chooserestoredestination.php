<?php
/**
 * Action for choosing destination to restore a post to. For now, just redirect to the stub page for selecting target group
 *
 * Try 1: Redirect to temporary bin
 * Try 2: Redirect to target group selection stub
 *
 *
 */

// TODO: Inside the action, only sets the relationship changes (see reportedcontent for example). The below code is bullshit for now.

/**
 * ACTIONS WILL RECEIVE THE VARIABLES FORWARDED BY FORM, USING THE 'name' OF THE FIELD
 */

// Does not do anything yet, only redirects
$destination_container_id = (int) get_input('destination_container_id');

$site_url = elgg_get_site_url();
$forward_url = '';
$message = 'Test redirecting worked, destination container is: ' . $destination_container_id;

// $guid = (int) get_input('guid');

/**
// Spits out the form to choose groups
elgg_register_ajax_view('forms/entity/chooserestoredestination');

**/



return elgg_ok_response('', $message, REFERRER);
