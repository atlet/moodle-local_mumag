<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once $CFG->libdir . '/formslib.php';

class local_saml_site_addnewpermission_form extends moodleform {

    function definition() {
        global $CFG, $DB;
        
        $rulestype = array();
        $rulestype[1] = get_string('usernamedomainname', 'local_saml_site'); 

        $categories = $DB->get_records('course_categories');

        foreach ($categories as $category) {
            $options[$category->id] = $category->name;
        }

        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('select', 'ruletype', get_string('ruletype', 'local_saml_site'), $rulestype);
        $mform->setDefault('ruletype', 1);
        $mform->addRule('ruletype', null, 'required', null, 'client');
        
        $mform->addElement('text', 'rule', get_string('rule', 'local_saml_site'), array('size' => '64'));
        $mform->addRule('rule', null, 'required', null, 'client');
        $mform->setType('rule', PARAM_TEXT);

        $mform->addElement('select', 'mdl_course_categories_id', get_string('selectcategory', 'local_saml_site'), $options);
        $mform->setDefault('mdl_course_categories_id', 0);
        $mform->addRule('mdl_course_categories_id', null, 'required', null, 'client');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_RAW);

        $this->add_action_buttons();
    }

}
