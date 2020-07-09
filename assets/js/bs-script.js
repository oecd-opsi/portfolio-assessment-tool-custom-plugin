// Get form steps to create side menu
// Get all IDs
var stepsID = document.querySelectorAll('[id*="pat-step"]');
// For each step, get the title and add them to an array ID => title
var steps = [];
stepsID.forEach( item => {
  var title = item.querySelector('.acf-label label').textContent;
  steps[item.id] = title;
});
// For each item in the steps array, add a link to the menu
for (var k in steps){
  if (typeof steps[k] !== 'function') {
   jQuery('#acf_pat_steps').append('<li><a href="#' + k + '">' + steps[k] + '</a></li>');
  }
}

// Make Ranking fields item sortable
(function($){
  $(document).ready( function() {
    $( ".pat-sortable-field .acf-input .acf-fields" ).sortable({
      stop: function() {
        var nbElems = $(this).find( "input[type='number']" ).length;
        $(this).find( "input[type='number']" ).each( function(i) {
          if ( i == 0 ) {
            $(this).val( nbElems - i );
          } else {
            $(this).val( nbElems - i - 1 );
          }
        });
      }
    });
  });
})(jQuery);

// Manage form submission and save
if (jQuery("#pat-form").length > 0) {

  // PAT form SUBMIT
  jQuery( 'a.submitform' ).on( 'click', function(e) {

    e.preventDefault();
    jQuery( 'a.saveform' ).addClass( 'disabled' );
    jQuery( 'a.submitform' ).addClass( 'disabled' );
    jQuery( '#csf_action' ).val( 'submit' );
    jQuery ( '.acf-form-submit input.acf-button' ).trigger( 'click' );

    return false;

  });

  // PAT form SAVE as draft
  jQuery( 'a.saveform' ).on( 'click', function(e) {

    e.preventDefault();
    jQuery( 'a.saveform' ).addClass( 'disabled' );
    jQuery( 'a.submitform' ).addClass( 'disabled' );
    jQuery('input').removeAttr( 'required' );
    jQuery('textarea').removeAttr( 'required' );
    jQuery( '#csf_action' ).val( 'save' );
    jQuery ( '.acf-form-submit input.acf-button' ).trigger( 'click' );

    return false;

  });


  acf.add_filter('validation_complete', function( json, $form ){

    // if errors?
    // if( json.errors ) {

      setTimeout(function () {
        if( jQuery( '.acf-notice.acf-error-message' ).length > 0 ) {


          if (jQuery( '.stepform .formbuttons .acf-spinner' ).length > 0) {
            jQuery( '.stepform .formbuttons .acf-spinner' ).removeClass( 'is-active' );
          }


          jQuery( '.stepgroup' ).each( function(index) {

            console.log(jQuery( '.stepgroup.step-'+index ).find( '.acf-error' ).text());

            jQuery( '.form-step.step_'+index ).removeClass( 'noerror' );
            jQuery( '.form-step.step_'+index ).removeClass( 'haserror' );

            if ( jQuery( '.stepgroup.step-'+index ).find( '.acf-error' ).length > 0 ) {
              jQuery( '.form-step.step_'+index ).addClass( 'haserror' );
            } else {
              jQuery( '.form-step.step_'+index ).addClass( 'noerror' );
            }

          });

          // get first step to have error
          if ( jQuery( '.form-step.haserror' ).length > 0 ) {
            var thefirstgroup = jQuery( '.form-step.haserror' ).first().attr( 'data-step' );
            jQuery( '.form-step.step_'+thefirstgroup ).trigger( 'click' );
            window.location.hash = '#step-'+thefirstgroup;
          }

        }

      }, 500);


      jQuery( 'a.saveform' ).removeClass( 'disabled' );
      jQuery( 'a.submitform' ).removeClass( 'disabled' );


      // return
      return json;

    });

    // Sticky sidebar for form page
    var sidebar = new StickySidebar('#pat-form-sidebar', {topSpacing: 20});

}
