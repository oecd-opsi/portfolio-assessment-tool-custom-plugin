// Get form steps to create side menu
// Get all IDs
var stepsID = document.querySelectorAll('[id*="pat-step"]:not(.hidden)');
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
    label = label.replace( 'About your organisation', 'Get started' );
    jQuery('#acf_pat_steps').append('<li class="pat-step-nav-' + patStepN + '" data-step="' + patStepN + '"><a href="#' + k + '">' + label + '</a><span class="step-error-signal">!</span></li>');
  }
}

// Make Ranking fields item sortable
(function($){
  $(document).ready( function() {
    // Ranking fields initial items position
    var rankQuestions = document.querySelectorAll('.pat-sortable-field .acf-input .acf-fields');
    rankQuestions.forEach((rankQuestion, i) => {
      var rankItemObj = [];
      var numFields = rankQuestion.querySelectorAll('.acf-field-number');
      numFields.forEach((field, i) => {
        var dataName = field.getAttribute('data-name');
        var value = field.querySelector('input[type="number"]').getAttribute('value');
        rankItemObj[i] = [dataName, value];
      });
      rankItemObj.sort( function(a,b) {
        if ( a[1] < b[1] ) { return 1; } else { return -1; }
      });
      rankItemObj.forEach((item, i) => {
        rankQuestion.append($('[data-name="'+item[0]+'"]')[0]);
      });
    });
    // Enable sortable widget
    $( ".pat-sortable-field .acf-input .acf-fields" ).sortable({
      update: function(event, ui) {
        var nbElems = $(this).find( "input[type='number']" ).length;
        $(this).find( "input[type='number']" ).each( function(i) {
          if ( i == 0 ) {
            $(this).val( parseInt(nbElems - i) ).attr( 'value', parseInt(nbElems - i) );
          } else {
            $(this).val( parseInt(nbElems - i - 1) ).attr( 'value', parseInt(nbElems - i - 1) );
          }
        });
      }
    });
  });
})(jQuery);

// Handle None of these option in checkbox questions
(function($){
  $(document).ready( function() {
    var patCheckboxes = document.querySelectorAll('#portfolio-assessment-tool-form .acf-field-checkbox');
    patCheckboxes.forEach((patCheckbox, i) => {
      var cbOptions = patCheckbox.querySelectorAll('input[type="checkbox"]');
      cbOptions.forEach((option, i) => {
        option.addEventListener( 'click', function(){
          var label = this.parentNode;
          if( label.textContent == ' None of these' && label.querySelector('input[type="checkbox"]').checked == true ) {
            cbOptions.forEach((item, i) => {
              item.parentNode.classList.remove('selected');
              item.checked = false;
            });
            this.parentNode.classList.add('selected');
            this.checked = true;
          } else {
            cbOptions.forEach((item, i) => {
              if( item.parentNode.textContent == ' None of these' ) {
                item.parentNode.classList.remove('selected');
                item.checked = false;
              }
            });
          }
        });
      });
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
    jQuery( '.acf-spinner').addClass('is-active');

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
    jQuery( '.acf-spinner').addClass('is-active');

    return false;

  });


  acf.add_filter('validation_complete', function( json, $form ){

    setTimeout(function () {
      if( jQuery( '.acf-notice.acf-error-message' ).length > 0 ) {

        jQuery( '.acf-spinner').removeClass('is-active');

        jQuery( '.pat-step' ).each( function(i) {

          var index = i + 1;
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
steps = document.querySelectorAll( '[id^="pat-step-"]:not(.hidden)' );
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
    if( newStep ) {
      newStep.classList.add( 'active-pat-step' );
    }

    // add active class to step button in side navigation
    let newStepNav = document.querySelector( '[href="#pat-step-' + newID + '"]' );
    if( newStepNav ) {
      newStepNav.classList.add( 'active-pat-step-btn' );
    }

  }

}

// Page to show on load
(function($){
  $(document).ready( function() {

    // add a class to hide each steps
    steps.forEach( step => step.classList.add('hide-pat-step') );

    // get from URL the step to display or display step zero
    currentStepN = window.location.hash.replace( /^\D+/g, '');
    // choose which step zero to show, based on submission status (step 1 or 10)
    if( !currentStepN ) {
      if( document.querySelector( '[id="pat-step-1"]:not(.hidden)' ) ) {
        currentStepN = 1;
      } else {
        currentStepN = 10;
      }
    }
    showPatStep( currentStepN );

  });
})(jQuery);

// listen to URL hash change
window.addEventListener( 'hashchange', function(e){

  if ( document.querySelector('.pat-form-main') ) {

    // hide all steps
    steps.forEach( step => step.classList.add('hide-pat-step') );

    // display new step
    let newStepN = window.location.hash.replace( /^\D+/g, '');
    showPatStep( newStepN );
    document.documentElement.scrollTop = 0;

  }

});

// Scroll down a little bit when adding a new project to the form
(function($){
  $('#pat-form a[data-event="add-row"]').on( 'click', function(e){
    $('html, body').animate({ scrollTop:  $(this).offset().top - 100 }, 'slow');
  });
})(jQuery);

// PAT results scripts
(function($){
  $(document).ready( function() {

    // In results page, if coming from module 2 completion, scroll to module 2 section
    if ( $('.pat-results').length ) {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const module2 = urlParams.get('module-2');
      if( module2 ) {
        location.hash = '#module-2';
      }
    }

    var mediaQuery = window.matchMedia("(min-width: 960px)");

    // check if it PAT results page
    if ( $('.pat-results').length > 0 && mediaQuery.matches ) {

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
      var heroInview = new Waypoint.Inview({
        element: $('.pat-results-hero'),
        exited: function(direction) {
          if ( direction == 'down' ) {
            $('.first-side-nav .pat-results-nav-menu').addClass('fixed');
          }
        },
        enter: function(direction) {
          if ( direction == 'up' ) {
            $('.first-side-nav .pat-results-nav-menu').removeClass('fixed');
          }
        },
      });
      var pmcInview = new Waypoint.Inview({
        element: $('#portfolio-management-capability'),
        exited: function(direction) {
          if ( !$('#module-2').length && direction == 'down' ) {
            $('.pat-results-top-nav').removeClass('show');
          }
        },
        enter: function(direction) {
          if ( !$('#module-2').length && direction == 'up' ) {
            $('.pat-results-top-nav').addClass('show');
          }
        },
      });
      var enhRowInview = new Waypoint.Inview({
        element: $('#enh-row'),
        enter: function(direction) {
          $('#enh-row .pat-results-side').addClass('show');
          $('#enh-row .pat-results-content').addClass('show');
        },
        entered: function(direction) {
          $('#enh-row .pat-results-side').addClass('show');
          $('#enh-row .pat-results-content').addClass('show');
        },
        exit: function(direction) {
          $('#enh-row .pat-results-side').removeClass('show');
          $('#enh-row .pat-results-content').removeClass('show');
        },
      });
      var misRowInview = new Waypoint.Inview({
        element: $('#mis-row'),
        enter: function(direction) {
          $('#mis-row .pat-results-side').addClass('show');
          $('#mis-row .pat-results-content').addClass('show');
        },
        entered: function(direction) {
          $('#mis-row .pat-results-side').addClass('show');
          $('#mis-row .pat-results-content').addClass('show');
        },
        exit: function(direction) {
          $('#mis-row .pat-results-side').removeClass('show');
          $('#mis-row .pat-results-content').removeClass('show');
        },
      });
      var adaRowInview = new Waypoint.Inview({
        element: $('#ada-row'),
        enter: function(direction) {
          $('#ada-row .pat-results-side').addClass('show');
          $('#ada-row .pat-results-content').addClass('show');
        },
        entered: function(direction) {
          $('#ada-row .pat-results-side').addClass('show');
          $('#ada-row .pat-results-content').addClass('show');
        },
        exit: function(direction) {
          $('#ada-row .pat-results-side').removeClass('show');
          $('#ada-row .pat-results-content').removeClass('show');
        },
      });
      var antRowInview = new Waypoint.Inview({
        element: $('#ant-row'),
        enter: function(direction) {
          $('#ant-row .pat-results-side').addClass('show');
          $('#ant-row .pat-results-content').addClass('show');
          if( direction == 'up' ) {
            $('#tendency-row .pat-results-side').removeClass('fixed');
          }
        },
        entered: function(direction) {
          $('#ant-row .pat-results-side').addClass('show');
          $('#ant-row .pat-results-content').addClass('show');
        },
        exit: function(direction) {
          $('#ant-row .pat-results-side').removeClass('show');
          $('#ant-row .pat-results-content').removeClass('show');
        },
      });
      var tendencyRowInview = new Waypoint.Inview({
        element: $('#tendency-row'),
        enter: function(direction) {
          $('#tendency-row .pat-results-side').addClass('show');
          $('#tendency-row .pat-results-content').addClass('show');
          if( direction == 'up' ) {
            $('#pmg-row .pat-results-side').removeClass('fixed');
            $('#tendency-row .pat-results-side').addClass('fixed');
          }
        },
        entered: function(direction) {
          $('#tendency-row .pat-results-side').addClass('show');
          $('#tendency-row .pat-results-content').addClass('show');
          if( direction == 'up' ) {
            $('#pmg-row .pat-results-side').removeClass('show');
            $('#pmg-row .pat-results-content').removeClass('show');
          }
        },
        exit: function(direction) {
          if( direction == 'down' ) {
            $('#pmg-row .pat-results-side').addClass('show');
            $('#pmg-row .pat-results-content').addClass('show');
            $('#tendency-row .pat-results-side').addClass('fixed');
          }
        },
        exited: function(direction) {
          $('#tendency-row .pat-results-side').removeClass('show');
          $('#tendency-row .pat-results-content').removeClass('show');
        },
      });
      var pmgRowInview = new Waypoint.Inview({
        element: $('#pmg-row'),
        exit: function(direction) {
          $('#pmg-row .pat-results-side').addClass('show');
          $('#pmg-row .pat-results-content').addClass('show');
          if(direction == 'down') {
            $('#pmg-row .pat-results-side').addClass('fixed');
          }
        },
        enter: function(direction) {
          if( direction == 'up' ) {
            $('#pmg-row .pat-results-side').addClass('fixed');
            $('.second-side-nav .pat-results-nav-menu').removeClass('fixed');
            $('#module-2 .pat-results-side').removeClass('fixed');
          }
        },
        exited: function(direction) {
          if(direction == 'down') {
            $('#pmg-row .pat-results-side').addClass('fixed');
            $('#module-2 .pat-results-side').addClass('fixed');
          }
        }
      });
      var downloadInview = new Waypoint.Inview({
        element: $('#download-and-share'),
        exit: function(direction) {
          if ( direction == 'down' ) {
            $('.second-side-nav .pat-results-nav-menu').addClass('fixed');
            $('#tendency-row .pat-results-side').removeClass('fixed');
            if($('#module-2').length) {
              $('#module-2-combined .pat-results-side').addClass('show');
              $('#module-2-combined .pat-results-content').addClass('show');
            }
          } else if( direction == 'up' ) {
            $('#pmg-row .pat-results-side').addClass('show');
            $('#pmg-row .pat-results-content').addClass('show');
          }
        },
      });
      var interpretationInview = new Waypoint.Inview({
        element: $('#interpretation'),
        enter: function(direction) {
          if ( direction == 'down' ) {
            $('#pmg-row .pat-results-side').removeClass('show');
            $('#pmg-row .pat-results-content').removeClass('show');
            if($('#module-2').length) {
              $('#module-2-combined .pat-results-side').removeClass('show');
              $('#module-2-combined .pat-results-content').removeClass('show');
            }
          }
        },
        exit: function(direction) {
          if( direction == 'up' ) {
            $('#pmg-row .pat-results-side').addClass('show');
            $('#pmg-row .pat-results-content').addClass('show');
            if($('#module-2').length) {
              $('#module-2-combined .pat-results-side').addClass('show');
              $('#module-2-combined .pat-results-content').addClass('show');
            }
          }
        }
      });

      if($('#module-2').length) {

        var pmgRow = new Waypoint({
          element: $('#module-2'),
          handler: function(direction) {
            $('#module-2 .pat-results-side').addClass('show');
            $('#module-2 .pat-results-content').addClass('show');
          },
          offset: '50%',
        });
        var mod2combRow = new Waypoint({
          element: $('#module-2-combined'),
          handler: function(direction) {
            $('#module-2-combined .pat-results-side').addClass('show');
            $('#module-2-combined .pat-results-content').addClass('show');
          },
          offset: '50%',
        });
        var module2Inview = new Waypoint.Inview({
          element: $('#module-2-combined'),
          exited: function(direction) {
            if ( direction == 'down' ) {
              $('.pat-results-top-nav').removeClass('show');
            }
          },
          enter: function(direction) {
            if ( direction == 'up' ) {
              $('.pat-results-top-nav').addClass('show');
              $('.second-side-nav .pat-results-nav-menu').removeClass('fixed');
            }
            if( direction == 'down' ) {
              $('#tendency-row .pat-results-side').removeClass('fixed');
            }
          },
          exit: function(direction) {
            if( direction == 'up' ) {
              $('#module-2 .pat-results-side').addClass('show');
              $('#module-2 .pat-results-content').addClass('show');
            }
          }
        });

        // Module 2 graph tooltip
        $('#module-2').append('<span id="m2-graph-tooltip"></span>');
        $('.module-2-graph-container g[data-name="main-group"] circle').on('mouseenter', function(e){
          var mouseX = e.clientX;
          var mouseY = e.clientY;
          var text = $(this).data('project-title');
          var span = $('#m2-graph-tooltip');
          var spanH = span.outerHeight();
          span.text(text);
          span.addClass('active');
          span.css('left', mouseX);
          span.css('top', mouseY + spanH - 116);
        });
        $('.module-2-graph-container g[data-name="main-group"] circle').on('mouseleave', function(e){
          $('#m2-graph-tooltip').removeClass('active');
        });

      } // end if module-2

    }

  });

  // Menu item progress bar
  $(document).ready( function() {

    // Get all id from menu item
    menuItem = document.querySelectorAll('.first-side-nav li');
    idArray = [];
    menuItem.forEach((item, i) => {
      itemHref = item.querySelector('a').getAttribute('href');
      const regex = /\B#[^\s]+/g;
      if( regex.test(itemHref) ) {
        idArray.push(itemHref);
      }
    });

    // Calculate progression and update progress bar function
    function move( id ) {
      if (i == 0) {
        i = 1;
        var elem = document.getElementById("myBar");
        var width = 1;
        var id = setInterval(frame, 10);
        function frame() {
          if (width >= 100) {
            clearInterval(id);
            i = 0;
          } else {
            width++;
            elem.style.width = width + "%";
          }
        }
      }
    }

    // For each section, calculate progression and update progress bar
    window.addEventListener( 'scroll', function(e){
      idArray.forEach((item, i) => {
        let section = $(item);
        let menuItem = $('[href="'+item+'"]');

        let percent = Math.floor( 100 * ($(document).scrollTop() - section.offset().top ) / section.height() );

        menuItem.each((i, item) => {
          item.setAttribute( 'style', '--scrollPerc:' + percent + '%' );
        });
      });
    });

  });

})(jQuery);
