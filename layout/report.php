<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
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
 * Moodle's wc theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package   theme_wc
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

// If there can be a sidepost region on this page and we are editing, always
// show it so blocks can be dragged into it.
if ($PAGE->user_is_editing()) {
    if ($PAGE->blocks->is_known_region('side-pre')) {
        $showsidepre = true;
    }
    if ($PAGE->blocks->is_known_region('side-post')) {
        $showsidepost = true;
    }
}

$haslogo = (!empty($PAGE->theme->settings->logo));

$hasfootnote = (!empty($PAGE->theme->settings->footnote));
$navbar_inverse = '';
if (!empty($PAGE->theme->settings->invert)) {
    $navbar_inverse = 'navbar-inverse';
}
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';

if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

$layout = 'pre-and-post';
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $layout = 'side-pre-only';
    } else {
        $layout = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $layout = 'side-post-only';
    } else {
        $layout = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $layout = 'content-only';
}
$bodyclasses[] = $layout;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar <?php echo $navbar_inverse ?> navbar-static-top">
    <nav role="navigation" class="navbar-inner">
        <div class="container">
            <a class="logo" href="<?php echo $CFG->wwwroot;?>"><img src="<?php echo $OUTPUT->pix_url('logo', 'theme')?>" alt="<?php echo $SITE->shortname; ?>" /></a>
            <a class="btn btn-navbar" data-toggle="workaround-collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
                <?php if ($hascustommenu) {
                    echo $custommenu;
                } ?>
                <ul class="nav pull-right">
                <li><?php echo $PAGE->headingmenu ?></li>
                <li class="navbar-text"><?php echo $OUTPUT->user_menu() ?></li>
                </ul>
            </div>
        </div>
    </nav>
</header>



<?php if ($hasheader) { ?>
<header id="page-header" class="clearfix">
    <div class="container">

        <?php if (!empty($courseheader)) { ?>
            <div id="course-header"><?php echo $courseheader; ?></div>
        <?php } ?>

        <?php if ($hasnavbar) { ?>
                <nav class="breadcrumb-button"><?php echo $PAGE->button; ?></nav>
                <?php echo $OUTPUT->navbar(); ?>
        <?php } ?>
    </div>
</header>
<?php } ?>

<div id="wrap">
    <div id="page" class="container-fluid clear-top">
        <div id="page-content" class="row-fluid">
        <?php if ($layout === 'pre-and-post') { ?>
            <div id="region-bs-main-and-pre" class="span9">
            <div class="row">
            <section id="region-main" class="span6 pull-right">
        <?php } else if ($layout === 'side-post-only') { ?>
            <section id="region-main" class="span9">
        <?php } else if ($layout === 'side-pre-only') { ?>
            <section id="region-main" class="span9 pull-right">
        <?php } else if ($layout === 'content-only') { ?>
            <section id="region-main" class="span12">
        <?php } ?>


            <?php echo $coursecontentheader; ?>
            <?php echo $OUTPUT->main_content() ?>
            <?php echo $coursecontentfooter; ?>
            </section>


        <?php if ($layout !== 'content-only') {
                  if ($layout === 'pre-and-post') { ?>
                    <aside class="span3 desktop-first-column">
            <?php } else if ($layout === 'side-pre-only') { ?>
                    <aside class="span3 desktop-first-column">
            <?php } ?>
                  <div id="region-pre" class="block-region">
                  <div class="region-content">
                  <?php
                        if (!right_to_left()) {
                            echo $OUTPUT->blocks_for_region('side-pre');
                        } else if ($hassidepost) {
                            echo $OUTPUT->blocks_for_region('side-post');
                        }
                  ?>
                  </div>
                  </div>
                  </aside>
            <?php if ($layout === 'pre-and-post') {
                  ?></div></div><?php // Close row and span9.
           }

            if ($layout === 'side-post-only' OR $layout === 'pre-and-post') { ?>
                <aside class="span3">
                <div id="region-post" class="block-region">
                <div class="region-content">
                <?php if (!right_to_left()) {
                          echo $OUTPUT->blocks_for_region('side-post');
                      } else {
                          echo $OUTPUT->blocks_for_region('side-pre');
                      } ?>
                </div>
                </div>
                </aside>
            <?php } ?>
        <?php } ?>
    </div><!-- End of #page -->
</div><!-- End of #wrap -->

<footer id="page-footer">
    <div class="container">
        <div class="row">
            <div class="span8">
                <p><strong>©<?php echo date("Y"); echo " "; ?> Waiuku College</strong></p>
                <?php
                echo $OUTPUT->login_info(); ?>     
                <?php
                    if ($hasfootnote) { ?>
                       <div class="footnote">
                       <?php echo $PAGE->theme->settings->footnote; ?>
                       </div>
                        <?php
                    } ?>
                <?php echo $OUTPUT->standard_footer_html(); ?>
            </div>
            <div class="span4">
                <p class="helplink text-right"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
            </div>
        </div>
        <div id="site-credits"><a href="http://nickwreid.com">Theme crafted by Nick Reid.</a>  |  The CollegeNET platform is powered by <a href="http://moodle.org">Moodle.</a></div>
    </div>
</footer>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>
