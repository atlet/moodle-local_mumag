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
require('../../config.php');
require_once("{$CFG->libdir}/tablelib.php");
require_once("{$CFG->dirroot}/local/saml_site/classes/all_permisions.php");

$sitecontext = context_system::instance();
$site = get_site();

if (!has_capability('local/saml_site:addrules', $sitecontext)) {
    print_error('nopermissions', 'error', '', 'edit/delete users');
}

$url = new moodle_url('/local/saml_site/samlsitepermissions.php');
$PAGE->set_url($url);

$PAGE->set_context($sitecontext);
$PAGE->set_pagelayout('admin');

$PAGE->set_title(get_string('adminmenutitle', 'local_saml_site'));

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('adminmenutitle', 'local_saml_site'), 2);

$message = "<a href=\"addnewpermission.php\">" . get_string('addnewpermission', 'local_saml_site') . "</a>";
echo $OUTPUT->box($message, 'mdl-align');

echo $OUTPUT->box_start('generalbox', 'tag-blogs');

$tableAllPermissions = new all_permisions('all_permisions');
$tableAllPermissions->is_downloading(false, 'all_permisions', 'all_permisions_testing123');

$fields = 's.id, s.rule, s.ruletype, c.name';
$from = '{local_saml_site} AS s LEFT JOIN {course_categories} AS c ON c.id = s.mdl_course_categories_id';
$where = '1 = 1';

$tableAllPermissions->set_sql(
        $fields, $from, $where);

$tableAllPermissions->define_baseurl($url);
$tableAllPermissions->is_downloadable(false);
$tableAllPermissions->show_download_buttons_at(array(TABLE_P_BOTTOM));

$tableAllPermissions->out(25, true);

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
