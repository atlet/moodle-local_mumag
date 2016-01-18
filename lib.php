<?php

// This file is part of the SAML Site plugin for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * @package    local_saml_site
 * @copyright  2015, Andraž Prinčič <atletek@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */
defined('MOODLE_INTERNAL') || die();

function local_saml_site_extend_settings_navigation($settingsnav, $context) {
    global $CFG, $PAGE;

    if (has_capability('local/saml_site:addrules', context_course::instance($PAGE->course->id))) {
        $settingnode = $settingsnav->find('root', navigation_node::TYPE_SITE_ADMIN);
        if ($settingnode) {
            $setMotdMenuLbl = get_string('adminmenutitle', 'local_saml_site');
            $setMotdUrl = new moodle_url('/local/saml_site/samlsitepermissions.php');
            $setMotdnode = navigation_node::create(
                            $setMotdMenuLbl, $setMotdUrl, navigation_node::NODETYPE_LEAF, 'saml_site', 'saml_site',
                            new pix_icon('i/settings', $setMotdMenuLbl));
            if ($PAGE->url->compare($setMotdUrl, URL_MATCH_BASE)) {
                $setMotdnode->make_active();
            }
            $settingnode->add_node($setMotdnode);
        }
    }
}
