<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "./theme/assets/vendors/custom/datatables/datatables.bundle.css",
        "https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css",
        "https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i",
//        "./theme/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css",
        "./theme/assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css",
        "./theme/assets/vendors/general/tether/dist/css/tether.css",
//        "./theme/assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css",
//        "./theme/assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css",
//        "./theme/assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css",
//        "./theme/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css",
//        "./theme/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css",
//        "./theme/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css",
//        "./theme/assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css",
//        "./theme/assets/vendors/general/select2/dist/css/select2.css",
//        "./theme/assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css",
//        "./theme/assets/vendors/general/nouislider/distribute/nouislider.css",
//        "./theme/assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css",
//        "./theme/assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css",
//        "./theme/assets/vendors/general/dropzone/dist/dropzone.css",
//        "./theme/assets/vendors/general/quill/dist/quill.snow.css",
//        "./theme/assets/vendors/general/@yaireo/tagify/dist/tagify.css",
//        "./theme/assets/vendors/general/summernote/dist/summernote.css",
//        "./theme/assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css",
        "./theme/assets/vendors/general/animate.css/animate.css",
//        "./theme/assets/vendors/general/toastr/build/toastr.css",
//        "./theme/assets/vendors/general/dual-listbox/dist/dual-listbox.css",
        "./theme/assets/vendors/general/morris.js/morris.css",
//        "./theme/assets/vendors/general/sweetalert2/dist/sweetalert2.css",
        "./theme/assets/vendors/general/socicon/css/socicon.css",
        "./theme/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css",
        "./theme/assets/vendors/custom/vendors/flaticon/flaticon.css",
        "./theme/assets/vendors/custom/vendors/flaticon2/flaticon.css",
        "./theme/assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css",
        "./theme/assets/css/demo12/style.bundle.min.css",
        './theme/custom/css/asset.main.css',
        './theme/custom/css/lib.css',
    ];
    public $js = [
        "./theme/custom/js/main.asset.js",

//        "./theme/assets/js/demo12/scripts.bundle.js",
//        "./theme/assets/js/demo12/pages/dashboard.js",
//        "./theme/assets/vendors/general/jquery/dist/jquery.js",
        "./theme/assets/vendors/general/popper.js/dist/umd/popper.js",
//        "./theme/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js",
        "./theme/assets/vendors/general/js-cookie/src/js.cookie.js",
        "./theme/assets/vendors/general/moment/min/moment.min.js",
        "./theme/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js",
        "./theme/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js",
        "./theme/assets/vendors/general/sticky-js/dist/sticky.min.js",
        "./theme/assets/vendors/general/wnumb/wNumb.js",
        "./theme/assets/vendors/general/jquery-form/dist/jquery.form.min.js",
        "./theme/assets/vendors/general/block-ui/jquery.blockUI.js",
//        "./theme/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
//        "./theme/assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js",
//        "./theme/assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js",
//        "./theme/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js",
//        "./theme/assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js",
//        "./theme/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js",
//        "./theme/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js",
//        "./theme/assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js",
//        "./theme/assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js",
//        "./theme/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js",
//        "./theme/assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js",
//        "./theme/assets/vendors/custom/js/vendors/bootstrap-switch.init.js",
//        "./theme/assets/vendors/general/select2/dist/js/select2.full.js",
//        "./theme/assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js",
//        "./theme/assets/vendors/general/typeahead.js/dist/typeahead.bundle.js",
//        "./theme/assets/vendors/general/handlebars/dist/handlebars.js",
//        "./theme/assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js",
//        "./theme/assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js",
//        "./theme/assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js",
//        "./theme/assets/vendors/general/nouislider/distribute/nouislider.js",
//        "./theme/assets/vendors/general/owl.carousel/dist/owl.carousel.js",
//        "./theme/assets/vendors/general/autosize/dist/autosize.js",
//        "./theme/assets/vendors/general/clipboard/dist/clipboard.min.js",
//        "./theme/assets/vendors/general/dropzone/dist/dropzone.js",
//        "./theme/assets/vendors/custom/js/vendors/dropzone.init.js",
//        "./theme/assets/vendors/general/quill/dist/quill.js",
//        "./theme/assets/vendors/general/@yaireo/tagify/dist/tagify.polyfills.min.js",
//        "./theme/assets/vendors/general/@yaireo/tagify/dist/tagify.min.js",
//        "./theme/assets/vendors/general/summernote/dist/summernote.js",
//        "./theme/assets/vendors/general/markdown/lib/markdown.js",
//        "./theme/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js",
//        "./theme/assets/vendors/custom/js/vendors/bootstrap-markdown.init.js",
//        "./theme/assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js",
//        "./theme/assets/vendors/custom/js/vendors/bootstrap-notify.init.js",
//        "./theme/assets/vendors/general/jquery-validation/dist/jquery.validate.js",
//        "./theme/assets/vendors/general/jquery-validation/dist/additional-methods.js",
//        "./theme/assets/vendors/custom/js/vendors/jquery-validation.init.js",
//        "./theme/assets/vendors/general/toastr/build/toastr.min.js",
//        "./theme/assets/vendors/general/dual-listbox/dist/dual-listbox.js",
        "./theme/assets/vendors/general/raphael/raphael.js",
        "./theme/assets/vendors/general/morris.js/morris.js",
        "./theme/assets/vendors/general/chart.js/dist/Chart.bundle.js",
//        "./theme/assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js",
//        "./theme/assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js",
//        "./theme/assets/vendors/general/waypoints/lib/jquery.waypoints.js",
//        "./theme/assets/vendors/general/counterup/jquery.counterup.js",
//        "./theme/assets/vendors/general/es6-promise-polyfill/promise.min.js",
//        "./theme/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js",
//        "./theme/assets/vendors/custom/js/vendors/sweetalert2.init.js",
//        "./theme/assets/vendors/general/jquery.repeater/src/lib.js",
//        "./theme/assets/vendors/general/jquery.repeater/src/jquery.input.js",
//        "./theme/assets/vendors/general/jquery.repeater/src/repeater.js",
//        "./theme/assets/vendors/general/dompurify/dist/purify.js",
        "./theme/assets/js/demo12/scripts.bundle.js",
//        "./theme/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js",
        "./theme/custom/js/Modal.js",
        "./theme/custom/js/global.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];




    function get_current_git_commit($branch = 'master')
    {

        try {


            if ($hash = file_get_contents(sprintf('../.git/refs/heads/%s', $branch))) {
                return trim($hash);
            } else {
                return "1";
            }
        } catch (\Exception $exception) {
            return "1";
        }
    }

    public function init()
    {
        foreach ($this->css as $key => $css)
            $this->css[$key] = $css . "?v=" . $this->get_current_git_commit();
        foreach ($this->js as $key => $js)
            $this->js[$key] = $js . "?v=" . $this->get_current_git_commit();


        parent::init(); // TODO: Change the autogenerated stub
    }


}
