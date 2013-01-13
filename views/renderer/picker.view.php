<script type="text/javascript">
    require(
            [
                'jquery-nos',
                'static/apps/sdrdis_color/plugins/colorpicker/jquery.colorpicker.js',
                'link!static/apps/sdrdis_color/plugins/colorpicker/jquery.colorpicker.css',
                'link!static/apps/sdrdis_color/css/colorpicker.css'
            ],
            function($) {
                require(['static/apps/sdrdis_color/plugins/colorpicker/i18n/jquery.ui.colorpicker-en.js'], function() {
                    $(function() {
                        var $input = $('input#<?= $id ?>');
                        console.log($input.data('colorpicker-options'));
                        $input.colorpicker($input.data('colorpicker-options'));
                    });
                });
            });
</script>
