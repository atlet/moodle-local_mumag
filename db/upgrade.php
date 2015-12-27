<?php

// This file keeps track of upgrades to 
// the booking module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installtion to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_local_saml_site_upgrade($oldversion) {

    global $CFG, $DB;

    $dbman = $DB->get_manager(); /// loads ddl manager and xmldb classes

    if ($oldversion < 2015111901) {

        // Define table local_saml_site_rules to be created.
        $table = new xmldb_table('local_saml_site_rules');

        // Adding fields to table local_saml_site_rules.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('local_saml_site_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rule', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('ruletype', XMLDB_TYPE_INTEGER, '5', null, XMLDB_NOTNULL, null, '1');

        // Adding keys to table local_saml_site_rules.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table local_saml_site_rules.
        $table->add_index('local_saml_site_id', XMLDB_INDEX_NOTUNIQUE, array('local_saml_site_id'));

        // Conditionally launch create table for local_saml_site_rules.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define field rule to be dropped from local_saml_site.
        $table = new xmldb_table('local_saml_site');
        $field = new xmldb_field('rule');

        // Conditionally launch drop field rule.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('ruletype');

        // Conditionally launch drop field ruletype.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Saml_site savepoint reached.
        upgrade_plugin_savepoint(true, 2015111901, 'local', 'saml_site');
    }

    if ($oldversion < 2015122401) {

        // Define field customprofilefield to be added to local_saml_site_rules.
        $table = new xmldb_table('local_saml_site_rules');
        $field = new xmldb_field('customprofilefield', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'ruletype');

        // Conditionally launch add field customprofilefield.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Saml_site savepoint reached.
        upgrade_plugin_savepoint(true, 2015122401, 'local', 'saml_site');
    }

    return true;
}

?>
