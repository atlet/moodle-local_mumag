<?php

// This file is part of the Mumag plugin for Moodle - http://moodle.org/
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
 * @package    local_mumag
 * @copyright  2015, Andraž Prinčič <atletek@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */
defined('MOODLE_INTERNAL') || die();

function local_mumag_extends_settings_navigation($settingsnav, $context) {
    global $CFG, $PAGE;

    // Only let users with the appropriate capability see this settings item.
    if (has_capability('local/mumag:addorremoveusers', context_course::instance($PAGE->course->id))) {
        if ($settingnode = $settingsnav->find('courseadmin', navigation_node::TYPE_COURSE)) {
            $url = new moodle_url('/local/mumag/usermanager.php', array('id' => $PAGE->course->id));
            $strfoo = get_string('menuname', 'local_mumag');
            $foonode = navigation_node::create(
                            $strfoo, $url, navigation_node::NODETYPE_LEAF, 'mumag', 'mumag',
                            new pix_icon('i/enrolusers', $strfoo)
            );
            if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                $foonode->make_active();
            }
            $settingnode->add_node($foonode);
        }
    }

    if (has_capability('local/mumag:addrules', context_course::instance($PAGE->course->id))) {
        $settingnode = $settingsnav->find('root', navigation_node::TYPE_SITE_ADMIN);
        if ($settingnode) {
            $setMotdMenuLbl = get_string('adminmenutitle', 'local_mumag');
            $setMotdUrl = new moodle_url('/local/mumag/settings.php');
            $setMotdnode = navigation_node::create(
                            $setMotdMenuLbl, $setMotdUrl, navigation_node::NODETYPE_LEAF, 'mumag', 'mumag',
                            new pix_icon('i/settings', $setMotdMenuLbl));
            if ($PAGE->url->compare($setMotdUrl, URL_MATCH_BASE)) {
                $setMotdnode->make_active();
            }
            $settingnode->add_node($setMotdnode);
        }
    }
}
