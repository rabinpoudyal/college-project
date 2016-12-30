(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
        
        function stripslashes (str) {
            return (str + '').replace(/\\(.?)/g, function (s, n1) {
              switch (n1) {
              case '\\':
                return '\\';
              case '0':
                return '\u0000';
              case '':
                return '';
              default:
                return n1;
              }
            });
        }

        $(document).ready(function(){
            $('.datepicker').datepicker({
                //yearRange: dRange,
                dateFormat : 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
            });
            
         $( ".aol_app_form" ).submit(function() {
            var datastring = new FormData(document.getElementById("aol_app_form"));
             $.ajax({
                    url: aol_ajax.ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: datastring,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('#aol_form_status').removeClass();
                        $('#aol_form_status').html('Submitting.....');
                        $("#aol_app_submit_button").attr('disabled','diabled');                            
                    },
                    success:function(response){
                        if(response['success']==true){
                            $('.aol_app_form').slideUp();
                            $('#aol_form_status').removeClass();
                            $('#aol_form_status').addClass('alert alert-success');
                            var submission_message = $('#submission_message').text();
                            $('#aol_form_status').html(submission_message);
                            
                            //Divert to thank you page. 
                            if(response.divert != null){
                                var page = response.divert;
                                window.location.href = stripslashes(page);
                            }
                        }
                        else if(response['success']==false){
                            $('#aol_form_status').removeClass();
                            $('#aol_form_status').addClass('alert alert-danger');
                            $('#aol_form_status').html(response['error']+' Your application could not be processed.');
                            $("#aol_app_submit_button").removeAttr('disabled');
                        }
                    },
                    error: function(){
                        $('#aol_form_status').removeClass();
                        $('#aol_form_status').addClass('alert alert-danger');
                        $('#aol_form_status').html('An unexpected error occured. Check your file and other fields and try again.');
                        $("#aol_app_submit_button").removeAttr('disabled');
                    }
            });
            return false;
          });     
        })

})( jQuery );
