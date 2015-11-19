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
require_once("{$CFG->dirroot}/local/saml_site/classes/list_permisions.php");

$cid = required_param('cid', PARAM_INT);

$sitecontext = context_system::instance();
$site = get_site();

if (!has_capability('local/saml_site:addrules', $sitecontext)) {
    print_error('nopermissions', 'error', '', 'edit/delete users');
}

$url = new moodle_url('/local/saml_site/listpermission.php', array('cid' => $cid));
$PAGE->set_url($url);

$PAGE->set_context($sitecontext);
$PAGE->set_pagelayout('admin');

$categoryname = $DB->get_record_sql("SELECT c.name FROM {local_saml_site} AS s LEFT JOIN {course_categories} AS c ON c.id = s.mdl_course_categories_id WHERE s.id = :cid", array('cid' => $cid));

$PAGE->set_title(get_string('siterulesfor', 'local_saml_site') . " " . $categoryname->name);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('siterulesfor', 'local_saml_site') . " " . $categoryname->name, 2);

$message = "<a href=\"addnewrule.php?cid={$cid}\">" . get_string('addnewcategorypermission', 'local_saml_site') . "</a>";
$categories = "<a href=\"samlsitepermissions.php\">" . get_string('backtocategories', 'local_saml_site') . "</a>";
echo $OUTPUT->box("{$message} | {$categories}", 'mdl-align');

echo $OUTPUT->box_start('generalbox', 'tag-blogs');

$tableAllPermissions = new list_permisions('list_permisions');
$tableAllPermissions->is_downloading(false, 'list_permisions', 'list_permisions_testing123');

$fields = 'id, rule, ruletype, local_saml_site_id';
$from = '{local_saml_site_rules}';
$where = 'local_saml_site_id = :cid';

$tableAllPermissions->set_sql(
        $fields, $from, $where, array('cid' => $cid));

$tableAllPermissions->define_baseurl($url);
$tableAllPermissions->is_downloadable(false);
$tableAllPermissions->show_download_buttons_at(array(TABLE_P_BOTTOM));

$tableAllPermissions->out(25, true);

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
