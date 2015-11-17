<?php

require_once("../../config.php");
require_once("lib.php");
require_once("addnewpermission.class.php");

$cid = optional_param('cid', '', PARAM_INT);
$delete = optional_param('delete', '', PARAM_INT);

if ($cid != '') {
    $url = new moodle_url('/local/saml_site/addnewpermission.php', array('cid' => $cid));
} else {
    $url = new moodle_url('/local/saml_site/addnewpermission.php');
}

$redirecturl = new moodle_url('/local/saml_site/samlsitepermissions.php');

$PAGE->set_url($url);

$sitecontext = context_system::instance();

$PAGE->set_context($sitecontext);
$PAGE->set_pagelayout('admin');

$PAGE->navbar->add(get_string('addnewpermission', 'local_saml_site'));

if (!has_capability('local/saml_site:addrules', $sitecontext)) {
    print_error('nopermissions', 'error', '', 'edit/delete users');
}

$PAGE->set_pagelayout('admin');

if ($delete == 1) {

    $DB->delete_records("local_saml_site", array("id" => $cid));

    redirect($redirecturl, get_string('sucesfulldeleted', 'local_saml_site'), 5);
}

$mform = new local_saml_site_addnewpermission_form(null, array('cidd' => $cid));

$default_values = new stdClass();
if ($cid != '') {
    $default_values = $DB->get_record('local_saml_site', array('id' => $cid));
}

$PAGE->set_title(get_string('addnewpermission', 'local_saml_site'));

if ($mform->is_cancelled()) {
    redirect($redirecturl, '', 0);
} else if ($data = $mform->get_data(true)) {
    if ($data->id != '') {
        $DB->update_record("local_saml_site", $data);
    } else {
        $DB->insert_record("local_saml_site", $data);
    }
    redirect($redirecturl, '', 0);
}

$PAGE->set_heading(get_string('addnewpermission', 'local_saml_site'));
echo $OUTPUT->header();
// this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
// or on the first display of the form.

$mform->set_data($default_values);
$mform->display();

echo $OUTPUT->footer();
?>