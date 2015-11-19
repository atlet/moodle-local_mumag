<?php

require_once("../../config.php");
require_once("lib.php");
require_once("addnewrule.class.php");

$cid = required_param('cid', PARAM_INT);
$id = optional_param('id', '', PARAM_INT);
$delete = optional_param('delete', '', PARAM_INT);

if ($cid != '') {
    $url = new moodle_url('/local/saml_site/addnewrule.php', array('cid' => $cid, 'id' => $id));
} else {
    $url = new moodle_url('/local/saml_site/addnewrule.php', array('cid' => $cid));
}

$redirecturl = new moodle_url('/local/saml_site/listpermission.php', array('cid' => $cid));

$PAGE->set_url($url);

$sitecontext = context_system::instance();

$PAGE->set_context($sitecontext);
$PAGE->set_pagelayout('admin');

$PAGE->navbar->add(get_string('addnewcategorypermission', 'local_saml_site'));

if (!has_capability('local/saml_site:addrules', $sitecontext)) {
    print_error('nopermissions', 'error', '', 'edit/delete users');
}

$PAGE->set_pagelayout('admin');

if ($delete == 1) {

    $DB->delete_records("local_saml_site_rules", array("id" => $id));

    redirect($redirecturl, get_string('sucesfulldeleted', 'local_saml_site'), 5);
}

$mform = new local_saml_site_addnewrule_form($url, array('cid' => $cid));

$default_values = new stdClass();
if ($id != '') {
    $default_values = $DB->get_record('local_saml_site_rules', array('id' => $id));
} else {
    $default_values->cid = $cid;
}

$PAGE->set_title(get_string('addnewcategorypermission', 'local_saml_site'));

if ($mform->is_cancelled()) {
    redirect($redirecturl, '', 0);
} else if ($data = $mform->get_data(true)) {
    if ($data->id != '') {
        $DB->update_record("local_saml_site_rules", $data);
    } else {
        $DB->insert_record("local_saml_site_rules", $data);
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