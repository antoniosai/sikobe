var SimpleFileUpload = function() {

    var handleSimpleFileUpload = function() {
        handleEvents(jQuery('#upload-container'));

        jQuery('.add-file').on('click', function(){
            var item = jQuery('#upload-row-example').clone();
            jQuery('#upload-container').append(item.fadeIn());

            handleEvents(item);
            
            delete item;
            return false;
        });
    }

    var handleEvents = function(wrapper) {
        jQuery('.del-file', wrapper).on('click', function () {
            if (jQuery('#upload-container li').length > 2) {
                jQuery(this).parent().parent().remove();
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleSimpleFileUpload();
        }
    };

}();

jQuery(document).ready(function() {
    SimpleFileUpload.init();
});
//# sourceMappingURL=file-upload.js.map
