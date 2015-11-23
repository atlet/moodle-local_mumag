<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once $CFG->libdir . '/formslib.php';

class local_saml_site_addnewpermission_form extends moodleform {

    function definition() {
        global $DB;

        $categories = $DB->get_records_sql('SELECT id, name FROM {course_categories} WHERE depth = 1 AND id NOT IN (SELECT {course_categories_id} FROM mdl_local_saml_site)');

        foreach ($categories as $category) {
            $options[$category->id] = $category->name;
        }

        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('select', 'mdl_course_categories_id', get_string('selectcategory', 'local_saml_site'), $options);
        $mform->setDefault('mdl_course_categories_id', 0);
        $mform->addRule('mdl_course_categories_id', null, 'required', null, 'client');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_RAW);

        $this->add_action_buttons();
    }

}
