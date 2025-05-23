<?php defined('ABSPATH') or die('Access denied.'); ?>

<div class="wrap wdt-datatables-admin-wrap">
    <?php do_action('wpdatatables_admin_before_settings'); ?>
    <!-- Preloader -->
    <?php include WDT_TEMPLATE_PATH . 'admin/common/preloader.inc.php'; ?>
    <!-- /Preloader -->
    <!-- .container -->
    <div class="container">

        <!-- .row -->
        <div class="row">

            <div class="card plugin-settings">
                <?php wp_nonce_field('wdtSettingsNonce', 'wdtNonce'); ?>
                <div class="card-header wdt-admin-card-header ch-alt">
                    <img id="wpdt-inline-logo"
                         src="<?php echo WDT_ROOT_URL; ?>assets/img/logo.svg"/>
                    <h2>
                        <span style="display: none">wpDataTables Settings</span>
                        <?php esc_html_e('Settings', 'wpdatatables'); ?>
                    </h2>
                    <ul class="actions p-t-5">
                        <li>
                            <button class="btn wdt-backend-close">
                                <?php esc_html_e('Cancel', 'wpdatatables'); ?>
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-primary btn-lg wdt-apply">
                                <i class="wpdt-icon-save"></i><?php esc_html_e('Save Changes', 'wpdatatables'); ?>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body card-padding p-t-10">
                    <div role="tabpanel">
                        <ul class="tab-nav" role="tablist">
                            <li class="active main-plugin-settings-tab">
                                <a href="#main-plugin-settings" aria-controls="main-plugin-settings" role="tab"
                                   data-toggle="tab"><?php esc_html_e('Main settings', 'wpdatatables'); ?></a>
                            </li>
                            <li class="separate-connection-tab">
                                <a href="#separate-connection" aria-controls="separate-connection"
                                   role="tab"
                                   data-toggle="tab"><?php esc_html_e('Separate DB connection', 'wpdatatables'); ?></a>
                            </li>
                            <li class="color-and-font-settings-tab">
                                <a href="#color-and-font-settings" aria-controls="color-and-font-settings"
                                   role="tab"
                                   data-toggle="tab"><?php esc_html_e('Color and font settings', 'wpdatatables'); ?></a>
                            </li>
                            <li class="custom-js-and-css-tab">
                                <a href="#custom-js-and-css" aria-controls="custom-js-and-css" role="tab"
                                   data-toggle="tab"><?php esc_html_e('Custom JS and CSS', 'wpdatatables'); ?></a>
                            </li>
                            <li class="google_sheet_settings-tab">
                                <a href="#google-sheet-api-settings" aria-controls="google_sheet_settings" role="tab"
                                   data-toggle="tab"><?php esc_html_e('Google Spreadsheet API settings', 'wpdatatables'); ?></a>
                            </li>
                            <li class="cache_settings-tab">
                                <a href="#cache-settings" aria-controls="cache_settings" role="tab"
                                   data-toggle="tab"><?php esc_html_e('Cache settings', 'wpdatatables'); ?></a>
                            </li>
                            <li class="wdt-activation-tab">
                                <a href="#wdt-activation" aria-controls="wdt-activation" role="tab"
                                   data-toggle="tab"><?php esc_html_e('Activation', 'wpdatatables'); ?></a>
                            </li>
                            <li class="wdt-charts-tab">
                                <a href="#wdt-charts" aria-controls="wdt-charts" role="tab"
                                   data-toggle="tab"><?php esc_html_e('Charts', 'wpdatatables'); ?></a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Main plugin settings tab -->
                            <?php include 'tabs/main_plugin_settings.php' ?>
                            <!-- /Main plugin settings tab -->

                            <!-- Color and font settings tab-->
                            <?php include 'tabs/color_and_font_settings.php' ?>
                            <!-- /Color and font settings tab-->

                            <!-- Custom JS and CSS settings tab-->
                            <?php include 'tabs/custom_js_and_css.php' ?>
                            <!-- /Custom JS and CSS settings tab-->

                            <!-- Cache settings tab-->
                            <?php include 'tabs/cache_settings.php' ?>
                            <!-- /Cache settings tab-->

                            <!-- Activation tab-->
                            <?php include 'tabs/activation.php' ?>
                            <!-- /Activation tab-->

                            <!-- Charts tab-->
                            <?php include 'tabs/charts.php' ?>
                            <!-- /Charts tab-->

                            <!-- Custom tab-->
                            <?php do_action('wpdatatables_add_tab_in_main_settings'); ?>
                            <!-- /Custom tab-->
                        </div>
                    </div>

                </div>
                <div class="row m-t-15 m-b-5 p-l-15 p-r-15">
                    <div class="pull-right">
                        <button class="btn btn-primary reset-color-settings" id="reset-color-settings"
                                style="display: none;">
                            <?php esc_html_e('Reset colors and fonts to default', 'wpdatatables'); ?>
                        </button>
                        <button class="btn btn-primary btn-icon-text wdt-apply">
                            <i class="wpdt-icon-save"></i><?php esc_html_e('Save Changes', 'wpdatatables'); ?>
                        </button>
                    </div>
                    <a class="btn btn-default btn-icon-text wdt-documentation"
                       data-doc-page="settings_page">
                        <i class="wpdt-icon-file-thin"></i> <?php esc_html_e(' View Documentation', 'wpdatatables'); ?>
                    </a>
                </div>
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- Modals -->

    <!-- Error message modal -->
    <?php include WDT_TEMPLATE_PATH . 'admin/common/error_modal.inc.php'; ?>
    <!-- /Error message modal -->

    <!-- Close modal -->
    <?php include WDT_TEMPLATE_PATH . 'admin/common/close_modal.inc.php'; ?>
    <!-- /Close modal -->

    <!-- /Modals -->

</div>
<!-- /.wdt-datatables-admin-wrap .wrap -->

