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
    var patStepN = k.split('-').slice(-1);
    var splitLabel = steps[k].split(' - ');
    var label = ( splitLabel.length > 1 ) ? splitLabel[1] : steps[k];
    jQuery('#acf_pat_steps').append('<li class="pat-step-nav-' + patStepN + '" data-step="' + patStepN + '"><a href="#' + k + '">' + label + '</a><span class="step-error-signal">!</span></li>');
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

// Handle form submission and save
if (jQuery("#pat-form").length > 0) {

  if ( jQuery( '.updatedalert' ).length > 0 ) {
		setTimeout(function () {
			jQuery( '.updatedalert' ).fadeOut();
		}, 5000);
	}

  // PAT form SUBMIT
  jQuery( '.submitform' ).on( 'click', function(e) {

    e.preventDefault();
    jQuery( '.saveform' ).addClass( 'disabled' );
    jQuery( '.submitform' ).addClass( 'disabled' );
    jQuery( '#csf_action' ).val( 'submit' );
    jQuery ( '.acf-form-submit input.acf-button' ).trigger( 'click' );

    return false;

  });

  // PAT form SAVE as draft
  jQuery( '.saveform' ).on( 'click', function(e) {

    e.preventDefault();
    jQuery( '.saveform' ).addClass( 'disabled' );
    jQuery( '.submitform' ).addClass( 'disabled' );
    jQuery('input').removeAttr( 'required' );
    jQuery('textarea').removeAttr( 'required' );
    jQuery( '#csf_action' ).val( 'save' );
    jQuery ( '.acf-form-submit input.acf-button' ).trigger( 'click' );

    return false;

  });


  acf.add_filter('validation_complete', function( json, $form ){

    setTimeout(function () {
      if( jQuery( '.acf-notice.acf-error-message' ).length > 0 ) {

        jQuery( '.pat-step' ).each( function(index) {

          jQuery( '#acf_pat_steps .pat-step-nav-'+index ).removeClass( 'noerror' );
          jQuery( '#acf_pat_steps .pat-step-nav-'+index ).removeClass( 'haserror' );

          if ( jQuery( '#pat-step-'+index ).find( '.acf-error' ).length > 0 ) {
            jQuery( '#acf_pat_steps .pat-step-nav-'+index ).addClass( 'haserror' );
          } else {
            jQuery( '#acf_pat_steps .pat-step-nav-'+index ).addClass( 'noerror' );
          }

        });

        // get first step to have error
        if ( jQuery( '#acf_pat_steps .haserror' ).length > 0 ) {
          var thefirstgroup = jQuery( '#acf_pat_steps .haserror' ).first().attr( 'data-step' );
          jQuery( '#acf_pat_steps .step_'+thefirstgroup ).trigger( 'click' );
          window.location.hash = '#pat-step-'+thefirstgroup;
        }

      }

    }, 500);


    jQuery( 'a.saveform' ).removeClass( 'disabled' );
    jQuery( 'a.submitform' ).removeClass( 'disabled' );


    // return
    return json;

  });

}

// Handle form pagination
var steps;
// Get all field groups; each group is a step
steps = document.querySelectorAll( '[id^="pat-step-"]' );
stepBtns = document.querySelectorAll( '[href^="#pat-step-"]' );
// Show step function
function showPatStep( newID ) {

  if(steps.length > 0 && stepBtns.length > 0) {

    // remove active class from each steps
    steps.forEach( step => step.classList.remove('active-pat-step') );

    // remove active class from each step buttons
    stepBtns.forEach( stepBtn => stepBtn.classList.remove('active-pat-step-btn') );

    // add active class to current step
    let newStep = document.querySelector( '[id="pat-step-' + newID + '"]' );
    newStep.classList.add( 'active-pat-step' );

    // add active class to step button in side navigation
    let newStepNav = document.querySelector( '[href="#pat-step-' + newID + '"]' );
    newStepNav.classList.add( 'active-pat-step-btn' );

  }

}

// Page to show on load
(function($){
  $(document).ready( function() {

    // add a class to hide each steps
    steps.forEach( step => step.classList.add('hide-pat-step') );

    // get from URL the step to display or display step zero
    currentStepN = window.location.hash.replace( /^\D+/g, '');
    currentStepN ? showPatStep( currentStepN ) : showPatStep( 1 );

  });
})(jQuery);

// listen to URL hash change
window.addEventListener( 'hashchange', function(e){

  // hide all steps
  steps.forEach( step => step.classList.add('hide-pat-step') );

  // display new step
  let newStepN = window.location.hash.replace( /^\D+/g, '');
  showPatStep( newStepN );
  document.documentElement.scrollTop = 0;

});

// PAT results scripts
(function($){
  $(document).ready( function() {

    // check if it PAT results page
    if ( $('.pat-results').length > 0 ) {

      // Fix top nav when Introduction sectione exited
      var introInview = new Waypoint.Inview({
        element: $('#introduction'),
        enter: function(direction) {
          if ( direction == 'up' ) {
            $('.pat-results-top-nav').removeClass('show');
          }
        },
        exited: function(direction) {
          if ( direction == 'down' ) {
            $('.pat-results-top-nav').addClass('show');
          }
        }
      });
      var pmcInview = new Waypoint.Inview({
        element: $('#portfolio-management-capability'),
        exited: function(direction) {
          if ( direction == 'down' ) {
            $('.pat-results-top-nav').removeClass('show');
          }
        },
        enter: function(direction) {
          if ( direction == 'up' ) {
            $('.pat-results-top-nav').addClass('show');
          }
        },
      });

    }

  });
})(jQuery);
