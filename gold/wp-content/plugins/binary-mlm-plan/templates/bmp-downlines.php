<?php
class BmpGenealogy
{
    public function view_genealogy()
    {
        do_action('bmp_user_check_validate'); ?>
        <div id="full-container " class="container" style="position: relative;top: 25px;">
            <button class="btn btn-dark" onclick="params.funcs.toggleFullScreen()"><i class="fa fa-expand" aria-hidden="true"></i></button>
            <button class="btn btn-dark" onclick="params.funcs.search()"><i class="fa fa-search" aria-hidden="true"></i></button>
            <button class="btn btn-dark" onclick="params.funcs.showMySelf()"><span class='icon'> <i class="fa fa-user" aria-hidden="true"></i></span></button>
            <button class="btn btn-dark" onclick="params.funcs.expandAll()"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <button class="btn btn-dark" onclick="params.funcs.collapseAll()"><i class="fa fa-minus-circle" aria-hidden="true"></i>
            </button>
            <div class="user-search-box">
                <div class="input-box">
                    <div class="fs-3 ps-2 text-danger">
                        <i onclick="params.funcs.closeSearchBox()" class="fa fa-close" aria-hidden="true"></i>
                    </div>
                    <div class="input-wrapper">
                        <input type="text" class="search-input" placeholder="<?php esc_html_e('Search', 'binary-mlm-plan'); ?>" />
                        <div class="input-bottom-placeholder">
                            <?php esc_html_e('By Username, Sponsor, userkey, position', 'binary-mlm-plan'); ?>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="result-box">
                    <div class="result-header"><?php esc_html_e('RESULTS', 'binary-mlm-plan'); ?> </div>
                    <div class="result-list">
                        <div class="buffer"></div>
                    </div>
                </div>
            </div>
            <div id="svgChart" class="container col-md-12"></div>
        </div>
<?php
    }
}
