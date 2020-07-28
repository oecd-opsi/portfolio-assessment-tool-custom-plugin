<?php
	//Standard Plan Template

	global $post;
	global $pdf_output;
	global $pdf_header;
	global $pdf_footer;

	global $pdf_template_pdfpage;
	global $pdf_template_pdfpage_page;
	global $pdf_template_pdfdoc;

	global $pdf_html_header;
	global $pdf_html_footer;

	//Set a pdf template. if both are set the pdfdoc is used. (You didn't need a pdf template)
	$pdf_template_pdfpage 		= ''; //The filename off the pdf file (you need this for a page template)
	$pdf_template_pdfpage_page 	= 1;  //The page off this page (you need this for a page template)

	$pdf_template_pdfdoc  		= ''; //The filename off the complete pdf document (you need only this for a document template)

	$pdf_html_header 			= false; //If this is ture you can write instead of the array a html string on the var $pdf_header
	$pdf_html_footer 			= false; //If this is ture you can write instead of the array a html string on the var $pdf_footer

	//Set the Footer and the Header
	$pdf_header = array (
  		'odd' =>
  			array (
    			'R' =>
   					array (
						'content' => '{PAGENO}',
						'font-size' => 8,
						'font-style' => 'B',
						'font-family' => 'DejaVuSansCondensed',
    				),
    				'line' => 1,
  				),
  		'even' =>
  			array (
    			'R' =>
    				array (
						'content' => '{PAGENO}',
						'font-size' => 8,
						'font-style' => 'B',
						'font-family' => 'DejaVuSansCondensed',
    				),
    				'line' => 1,
  			),
	);
	$pdf_footer = array (
	  	'odd' =>
	 	 	array (
	    		'R' =>
	    			array (
						'content' => '{DATE d.m.Y}',
					    'font-size' => 8,
					    'font-style' => 'BI',
					    'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'C' =>
	    			array (
	      				'content' => '- {PAGENO} / {nb} -',
	      				'font-size' => 8,
	      				'font-style' => '',
	      				'font-family' => '',
	    			),
	    		'L' =>
	    			array (
	      				'content' => get_bloginfo('name'),
	      				'font-size' => 8,
	      				'font-style' => 'BI',
	      				'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'line' => 1,
	  		),
	  	'even' =>
			array (
	    		'R' =>
	    			array (
						'content' => '{DATE d.m.Y}',
					    'font-size' => 8,
					    'font-style' => 'BI',
					    'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'C' =>
	    			array (
	      				'content' => '- {PAGENO} / {nb} -',
	      				'font-size' => 8,
	      				'font-style' => '',
	      				'font-family' => '',
	    			),
	    		'L' =>
	    			array (
	      				'content' => get_bloginfo('name'),
	      				'font-size' => 8,
	      				'font-style' => 'BI',
	      				'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'line' => 1,
	  		),
	);


	$pdf_output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
		<html xml:lang="en">

		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Portfolio Exploration Results</title>
		</head>
		<body xml:lang="en">
			<bookmark content="'.htmlspecialchars(get_bloginfo('name'), ENT_QUOTES).'" level="0" /><tocentry content="'.htmlspecialchars(get_bloginfo('name'), ENT_QUOTES).'" level="0" />
			<div id="header"><div id="headerimg">
				<h1><a href="' . get_option('home') . '/">' .  get_bloginfo('name') . '</a></h1>
				<div class="description">' .  get_bloginfo('description') . '</div>
			</div>
			</div>
			<div id="content" class="widecolumn">';

			if(have_posts()) :

  			while (have_posts()) : the_post();

        //*** Get all needed data ***//
        // echo '<pre>'.print_r(get_field_objects( $postid ), true).'</pre>';
        $fields = get_field_objects( $postid );

        //* Organisation
        $general_questions = get_field('general_questions');
        $organisation = $general_questions['organisation'];

        //* Name
        $name = get_the_author_meta( 'display_name' );

        //* Date
        $submission_date = get_field( 'submission_date' );

        //* Calculate Facet orientation questions score
        // Declare a variable for each facets to store the score
        $enh = 0;
        $mis = 0;
        $ant = 0;
        $ada = 0;
        $max = 64;

        // Get all sub-fields/questions and manage each one based on the type
        // If the question is of type radio or input number,
        // the value is numeric and the facet reference is in the first part of the key.
        // If the question is of type checkbox, the value contain the facet reference and the value.
        // The type of the field can be deduced from the value: if the splitted value length is greater than zero, the field is a checkbox.
        foreach ( $fields['facet_orientation_questions_1']['value'] as $answers ) {
          foreach ( $answers as $key => $value ) {
            if ( is_array($value) ) {
              // checkbox or radio
              $splitted_value = explode( '-', $value['value'] );
              if ( count($splitted_value) > 1 ) {
                // here we have a checkbox
                $facets_ref = $splitted_value[0];
                $value = $splitted_value[1];
                $$facets_ref += (float)$value['value'];
              } else {
                // here we have a radio input
                $facets_ref = explode( '_', $key )[0];
                $$facets_ref += (float)$value['value'];
              }

            } else {
              // here we have an number input (ranking field)
              // here we have a radio input
              $facets_ref = explode( '_', $key )[0];
              $$facets_ref += (float)$value;
            }
          }
        }
        foreach ( $fields['facet_orientation_questions_2']['value'] as $answers ) {
          foreach ( $answers as $key => $value ) {
            if ( is_array($value) ) {
              // checkbox or radio
              $splitted_value = explode( '-', $value['value'] );
              if ( count($splitted_value) > 1 ) {
                // here we have a checkbox
                $facets_ref = $splitted_value[0];
                $value = $splitted_value[1];
                $$facets_ref += (float)$value['value'];
              } else {
                // here we have a radio input
                $facets_ref = explode( '_', $key )[0];
                $$facets_ref += (float)$value['value'];
              }

            } else {
              // here we have an number input (ranking field)
              // here we have a radio input
              $facets_ref = explode( '_', $key )[0];
              $$facets_ref += (float)$value;
            }
          }
        }
        foreach ( $fields['facet_orientation_questions_3']['value'] as $answers ) {
          foreach ( $answers as $key => $value ) {
            if ( is_array($value) ) {
              // checkbox or radio
              $splitted_value = explode( '-', $value['value'] );
              if ( count($splitted_value) > 1 ) {
                // here we have a checkbox
                $facets_ref = $splitted_value[0];
                $value = $splitted_value[1];
                $$facets_ref += (float)$value['value'];
              } else {
                // here we have a radio input
                $facets_ref = explode( '_', $key )[0];
                $$facets_ref += (float)$value['value'];
              }

            } else {
              // here we have an number input (ranking field)
              // here we have a radio input
              $facets_ref = explode( '_', $key )[0];
              $$facets_ref += (float)$value;
            }
          }
        }
        foreach ( $fields['facet_orientation_questions_4']['value'] as $answers ) {
          foreach ( $answers as $key => $value ) {
            if ( is_array($value) ) {
              // checkbox or radio
              $splitted_value = explode( '-', $value['value'] );
              if ( count($splitted_value) > 1 ) {
                // here we have a checkbox
                $facets_ref = $splitted_value[0];
                $value = $splitted_value[1];
                $$facets_ref += (float)$value['value'];
              } else {
                // here we have a radio input
                $facets_ref = explode( '_', $key )[0];
                $$facets_ref += (float)$value['value'];
              }

            } else {
              // here we have an number input (ranking field)
              // here we have a radio input
              $facets_ref = explode( '_', $key )[0];
              $$facets_ref += (float)$value;
            }
          }
        }
        // Calculate facets percentage
        $enh_percentage = round( $enh / $max * 100 );
        $mis_percentage = round( $mis / $max * 100 );
        $ant_percentage = round( $ant / $max * 100 );
        $ada_percentage = round( $ada / $max * 100 );

        // Transform percentage into color
        $enh_color = ColorHSLToRGB( 288, 75, $enh_percentage );
        $mis_color = ColorHSLToRGB( 288, 75, $mis_percentage );
        $ant_color = ColorHSLToRGB( 288, 75, $ant_percentage );
        $ada_color = ColorHSLToRGB( 288, 75, $ada_percentage );

        //* Portfolio Tendency Group
        $portfolio_tendency_group = '';
        $portfolio_tendency_group_text = '';
        if ($enh_percentage >= 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage >= 50 ) {
              $portfolio_tendency_group = 'Adaptive/Anticipatory/Enhancement/Mission';
              $portfolio_tendency_group_text = get_field( 'adaptiveanticipatoryenhancementmission_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage < 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Primarily Anticipatory';
              $portfolio_tendency_group_text = get_field( 'primarily_anticipatory_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage < 50 &&
            $ant_percentage < 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Primarily Enhancement';
              $portfolio_tendency_group_text = get_field( 'primarily_enhancement_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage < 50 &&
            $ant_percentage < 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Primarily Adaptive';
              $portfolio_tendency_group_text = get_field( 'primarily_adaptive_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage < 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Primarily Mission';
              $portfolio_tendency_group_text = get_field( 'primarily_mission_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage < 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Anticipatory - Enhancement';
              $portfolio_tendency_group_text = get_field( 'anticipatory_enhancement_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage < 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Adaptive - Mission';
              $portfolio_tendency_group_text = get_field( 'adaptive_mission_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage < 50 &&
            $ant_percentage < 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Adaptive - Enhancement';
              $portfolio_tendency_group_text = get_field( 'adaptive_enhancement_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Anticipatory - Mission';
              $portfolio_tendency_group_text = get_field( 'anticipatory_mission_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage < 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Adaptive - Anticipatory';
              $portfolio_tendency_group_text = get_field( 'adaptive_anticipatory_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage < 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Enhancement - Mission';
              $portfolio_tendency_group_text = get_field( 'enhancement_mission_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Adaptive - Anticipatory - Mission';
              $portfolio_tendency_group_text = get_field( 'adaptive_anticipatory_mission_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage < 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Adaptive - Anticipatory - Enhancement';
              $portfolio_tendency_group_text = get_field( 'adaptive_anticipatory_enhancement_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage < 50 &&
            $ada_percentage >= 50) {
              $portfolio_tendency_group = 'Adaptive - Enhancement - Mission';
              $portfolio_tendency_group_text = get_field( 'adaptive_enhancement_mission_content', 'option' );
            }
        elseif
           ($enh_percentage >= 50 &&
            $mis_percentage >= 50 &&
            $ant_percentage >= 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Anticipatory - Mission - Enhancement';
              $portfolio_tendency_group_text = get_field( 'anticipatory_mission_enhancement_content', 'option' );
            }
        elseif
           ($enh_percentage < 50 &&
            $mis_percentage < 50 &&
            $ant_percentage < 50 &&
            $ada_percentage < 50) {
              $portfolio_tendency_group = 'Weak in all facets';
              $portfolio_tendency_group_text = get_field( 'weak_in_all_facets_content', 'option' );
            }
        else {
          $portfolio_tendency_group = 'The VOID';
          $portfolio_tendency_group_text = get_field( 'the_VOID_content', 'option' );
        }

        //* Calculate Portfolio Management questions score
        $pmq_score = 16; // Automatic 16 points added to all scores to account to avoid negative score
        $pmw_max = 108;
        foreach ( $fields['portfolio_management_questions_1']['value'] as $key => $value ) {
          if ( is_array($value) ) {
            foreach ( $value as $subkey => $subvalue ) {
              $pmq_score += (float)$subvalue;
            }
          } else {
            $split_value = explode( '-', $value );
            $pmq_score += $value[0];
          }
        }
        foreach ( $fields['portfolio_management_questions_2']['value'] as $key => $value ) {
          if ( is_array($value) ) {
            foreach ( $value as $subkey => $subvalue ) {
              $pmq_score += (float)$subvalue;
            }
          } else {
            $split_value = explode( '-', $value );
            $pmq_score += $value[0];
          }
        }

        $level = '';
        if ( $pmq_score < 36  ) {
          $level = 'low';
        } elseif ( $pmq_score >= 72 ) {
          $level = 'high';
        } else {
          $level = 'medium';
        }


        $pdf_output .= '<div class="row">
          <div class="col-sm-12">
            <article class="pat-results" >

              <div class="entry-content">

                <div class="col-md-12 pat-results-hero">
                  <div class="pat-form-title-wrapper screen-reader-text">
                    <h1>Portfolio Exploration Tool Results</h1>
                  </div>
                  <div class="single_img_wrap pat-form-banner">
                    <img src="'. get_site_url() .'/wp-content/plugins/portfolio-assessment-tool-custom-plugin/assets/images/pat-results-hero.jpg" class="attachment-blog size-blog wp-post-image" alt="Portfolio Exploration Results">
                  </div>
                </div>

                <div class="col-md-12">

                  <main class="pat-results-main-content">

                    <section id="introduction">

                      <div class="pat-results-content">

                        <div class="pat-results-main-title">
                          <h2>Innovation portfolio balance of '. $organisation .'</h2>
                          <p class="subtitle">Based on exploration by '. $name .' on '. $submission_date .'</p>
                        </div>

                        <div class="disclaimer">'. get_field( 'disclaimer_text', 'option' ) .'</div>

                        <!-- Diamond 1 -->
                        <div class="diamond diamond-1">
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="803" height="445" viewBox="0 0 803 445"><defs><style>.a{fill:none;stroke:#fff;stroke-width:3px;}.b{fill:'. $enh_color .';}.c{fill:'. $mis_color .';}.d{fill:'. $ada_color .';}.e{fill:'. $ant_color .';}.f{fill:#605f5f;font-size:12px;}.f,.g{font-family:Roboto-Medium, Roboto;font-weight:500;}.g{fill:#fff;font-size:33px;}.h{filter:url(#i);}.i{filter:url(#g);}.j{filter:url(#e);}.k{filter:url(#c);}.l{filter:url(#a);}</style><filter id="a" x="125.265" y="25.211" width="572.267" height="381.245" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="3" result="b"/><feFlood flood-opacity="0.161"/><feComposite operator="in" in2="b"/><feComposite in="SourceGraphic"/></filter><filter id="c" x="186.614" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="d"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="d"/><feComposite in="SourceGraphic"/></filter><filter id="e" x="305.324" y="71.092" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="f"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="f"/><feComposite in="SourceGraphic"/></filter><filter id="g" x="305.324" y="227.27" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="h"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="h"/><feComposite in="SourceGraphic"/></filter><filter id="i" x="424.927" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="j"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="j"/><feComposite in="SourceGraphic"/></filter></defs><g transform="translate(-490 -1096.295)"><g class="l" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="a" d="M2580.007,3511.292l274.127-178.347L3128.8,3511.292,2854.135,3692.6Z" transform="translate(-2443.01 -3299.95)"/></g><g class="k" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-352.13 -1209.87)"/></g><g transform="translate(799.824 1168.887)"><g class="j" transform="matrix(1, 0, 0, 1, -309.82, -72.59)"><path class="c" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-355.42 -1211.41)"/></g></g><g class="i" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="d" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-355.42 -1208.23)"/></g><g class="h" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="e" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-358.81 -1209.87)"/></g><text class="f" transform="translate(1245 1308.295)"><tspan x="-39.574" y="0">UNCERTAINTY</tspan><tspan x="-47.317" y="14">Exploring/Radical</tspan></text><text class="f" transform="translate(897.224 1524.295)"><tspan x="-35.707" y="0">UNDIRECTED</tspan><tspan x="-62.745" y="14">Responding/Bottom Up</tspan></text><text class="f" transform="translate(907.224 1107.295)"><tspan x="-27.536" y="0">DIRECTED</tspan><tspan x="-53.484" y="14">Shaping / Top Down</tspan></text><text class="f" transform="translate(553 1301.295)"><tspan x="-31.403" y="0">CERTAINTY</tspan><tspan x="-62.396" y="14">Exploiting/ Incremental</tspan></text><text class="g" transform="translate(902.528 1240)"><tspan x="-30.873" y="0">'. $mis_percentage .'%</tspan></text><text class="g" transform="translate(902.528 1399)"><tspan x="-30.873" y="0">'. $ada_percentage .'%</tspan></text><text class="g" transform="translate(1021.528 1322)"><tspan x="-30.873" y="0">'. $ant_percentage .'%</tspan></text><text class="g" transform="translate(783.528 1316)"><tspan x="-30.873" y="0">'. $enh_percentage .'%</tspan></text></g></svg>
                        </div>

                        <h3>Your organisational portfolio tends to '. $portfolio_tendency_group .' innovation</h3>

                      </div>

                    </section>

                    <section id="organisational-portfolio-balance" class="pat-results-fullwidth-section">

                      <div class="pat-results-row">
                        <div class="pat-results-side"></div>
                        <div class="pat-results-content">

                          <h2 class="section-title">Innovation portfolio balance of <strong>'. $organisation .'</strong></h2>

                        </div>
                      </div>

                      <div class="pat-results-row enh-row">

                        <div class="pat-results-content">

                          <div class="enhancement-inno-section">
                            <!-- diamond with enhancement percentage   -->
                            <div class="facet-diamond enh-diamond">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.enh-a{fill: #e6e8f0;}.enh-b{fill: '. $enh_color .';}.enh-c, .enh-e, .enh-f{opacity: 0.201;}.enh-d{fill: '. $mis_color .';}.enh-e{fill: '. $ada_color .';}.enh-f{fill: '. $ant_color .';}.enh-g, .enh-h{fill: #fff; font-family: Roboto-Medium, Roboto; font-weight: 500;}.enh-g{font-size: 20px;}.enh-h{font-size: 33px;}.enh-i{filter: url(#enh-g);}.enh-j{filter: url(#enh-e);}.enh-k{filter: url(#enh-c);}.enh-l{filter: url(#enh-a);}</style> <filter id="enh-a" x="49.614" y="105.65" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="enh-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="enh-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="enh-g" x="287.927" y="105.65" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-627 -1980.272)"> <path class="enh-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(-1953.007 -1352.673)"/> <g class="enh-l" transform="matrix(1, 0, 0, 1, 627, 1980.27)"> <path class="enh-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g class="enh-c" transform="translate(799.824 2008.887)"> <g class="enh-k" transform="matrix(1, 0, 0, 1, -172.82, -28.62)"> <path class="enh-d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="enh-j" transform="matrix(1, 0, 0, 1, 627, 1980.27)"> <path class="enh-e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="enh-i" transform="matrix(1, 0, 0, 1, 627, 1980.27)"> <path class="enh-f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="enh-g" transform="translate(902.528 2080)"> <tspan x="-40.474" y="0">MISSION</tspan> </text><text class="enh-g" transform="translate(898.528 2235)"> <tspan x="-47.148" y="0">ADAPTIVE</tspan> </text><text class="enh-g" transform="translate(1022.528 2155)"> <tspan x="-68.384" y="0">ANTICIPATORY</tspan> </text><text class="enh-h" transform="translate(790 2162)"> <tspan x="-30.873" y="0">'. $enh_percentage .'%</tspan> </text> </g></svg>
                            </div>

                            '. get_field( 'enhancemnet_oriented_innovation_text', 'option' ) .'
                          </div>

                        </div>
                      </div>

                      <div class="pat-results-row mis-row">

                        <div class="pat-results-content">
                          <div class="mission-inno-section">
                            <div class="facet-diamond mis-diamond">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.mis-a{fill: #e6e8f0;}.mis-b{fill: '. $enh_color .'; opacity: 0.2;}.mis-c{fill: '.$mis_color .';}.mis-d{fill: '. $ada_color .';}.mis-d, .mis-e{opacity: 0.201;}.mis-e{fill: '. $ant_color .';}.mis-f, .mis-g{fill: #fff; font-family: Roboto-Medium, Roboto; font-weight: 500;}.mis-f{font-size: 20px;}.mis-g{font-size: 33px;}.mis-h{filter: url(#mis-g);}.mis-i{filter: url(#mis-e);}.mis-j{filter: url(#mis-c);}.mis-k{filter: url(#mis-a);}</style> <filter id="mis-a" x="49.614" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="mis-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="mis-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="mis-g" x="287.927" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-5165 -1827.272)"> <path class="mis-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(2584.993 -1505.673)"/> <g class="mis-k" transform="matrix(1, 0, 0, 1, 5165, 1827.27)"> <path class="mis-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g transform="translate(5337.824 1855.887)"> <g class="mis-j" transform="matrix(1, 0, 0, 1, -172.82, -28.62)"> <path class="mis-c" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="mis-i" transform="matrix(1, 0, 0, 1, 5165, 1827.27)"> <path class="mis-d" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="mis-h" transform="matrix(1, 0, 0, 1, 5165, 1827.27)"> <path class="mis-e" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="mis-f" transform="translate(5321.528 2002)"> <tspan x="-73.32" y="0">ENHANCEMENT</tspan> </text><text class="mis-f" transform="translate(5436.528 2082)"> <tspan x="-47.148" y="0">ADAPTIVE</tspan> </text><text class="mis-f" transform="translate(5560.528 2002)"> <tspan x="-68.384" y="0">ANTICIPATORY</tspan> </text><text class="mis-g" transform="translate(5441 1931)"> <tspan x="-30.873" y="0">'. $mis_percentage .'%</tspan> </text> </g></svg>
                            </div>
                            '. get_field( 'mission_oriented_innovation_text', 'option' ) .'
                          </div>
                        </div>

                      </div>

                      <div class="pat-results-row ada-row">

                        <div class="pat-results-content">

                          <div class="adaptive-inno-section">
                            <div class="facet-diamond ada-diamond">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.ada-a{fill: #e6e8f0;}.ada-b{fill: '. $enh_color .';}.ada-b, .ada-c, .ada-f{opacity: 0.2;}.ada-d{fill: '. $mis_color .';}.ada-e{fill: '. $ada_color .';}.ada-f{fill: '. $ant_color .';}.ada-g, .ada-h{fill: #fff; font-family: Roboto-Medium, Roboto; font-weight: 500;}.ada-g{font-size: 20px;}.ada-h{font-size: 33px;}.ada-i{filter: url(#ada-g);}.ada-j{filter: url(#ada-e);}.ada-k{filter: url(#ada-c);}.ada-l{filter: url(#ada-a);}</style> <filter id="ada-a" x="49.614" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ada-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ada-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ada-g" x="287.927" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-5165 -2677.272)"> <path class="ada-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(2584.993 -655.673)"/> <g class="ada-l" transform="matrix(1, 0, 0, 1, 5165, 2677.27)"> <path class="ada-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g class="ada-c" transform="translate(5337.824 2705.887)"> <g class="ada-k" transform="matrix(1, 0, 0, 1, -172.82, -28.61)"> <path class="ada-d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="ada-j" transform="matrix(1, 0, 0, 1, 5165, 2677.27)"> <path class="ada-e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="ada-i" transform="matrix(1, 0, 0, 1, 5165, 2677.27)"> <path class="ada-f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="ada-g" transform="translate(5321.528 2852)"> <tspan x="-73.32" y="0">ENHANCEMENT</tspan> </text><text class="ada-g" transform="translate(5560.528 2852)"> <tspan x="-68.384" y="0">ANTICIPATORY</tspan> </text><text class="ada-g" transform="translate(5440.528 2776)"> <tspan x="-40.474" y="0">MISSION</tspan> </text><text class="ada-h" transform="translate(5446 2937)"> <tspan x="-30.873" y="0">'. $ada_percentage .'%</tspan> </text> </g></svg>
                            </div>
                            '. get_field( 'adaptive_oriented_innovation_text', 'option' ) .'
                          </div>
                        </div>

                      </div>

                      <div class="pat-results-row ant-row">

                        <div class="pat-results-content">

                          <div class="anticipatory-inno-section">
                            <div class="facet-diamond ant-diamond">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.ant-a{fill: #e6e8f0;}.ant-b{fill: '. $enh_color .';}.ant-b, .ant-c{opacity: 0.2;}.ant-d{fill: '. $mis_color .';}.ant-e{fill: '. $ada_color .'; opacity: 0.201;}.ant-f{fill: '. $ant_color .';}.ant-g, .ant-h{fill: #fff; font-family: Roboto-Medium, Roboto; font-weight: 500;}.ant-g{font-size: 20px;}.ant-h{font-size: 33px;}.ant-i{filter: url(#ant-g);}.ant-j{filter: url(#ant-e);}.ant-k{filter: url(#ant-c);}.ant-l{filter: url(#ant-a);}</style> <filter id="ant-a" x="49.614" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ant-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ant-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ant-g" x="287.927" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-5165 -2256.272)"> <path class="ant-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(2584.993 -1076.673)"/> <g class="ant-l" transform="matrix(1, 0, 0, 1, 5165, 2256.27)"> <path class="ant-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g class="ant-c" transform="translate(5337.824 2284.887)"> <g class="ant-k" transform="matrix(1, 0, 0, 1, -172.82, -28.61)"> <path class="ant-d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="ant-j" transform="matrix(1, 0, 0, 1, 5165, 2256.27)"> <path class="ant-e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="ant-i" transform="matrix(1, 0, 0, 1, 5165, 2256.27)"> <path class="ant-f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="ant-g" transform="translate(5321.528 2431)"> <tspan x="-73.32" y="0">ENHANCEMENT</tspan> </text><text class="ant-g" transform="translate(5436.528 2511)"> <tspan x="-47.148" y="0">ADAPTIVE</tspan> </text><text class="ant-g" transform="translate(5440.528 2355)"> <tspan x="-40.474" y="0">MISSION</tspan> </text><text class="ant-h" transform="translate(5566 2436)"> <tspan x="-30.873" y="0">'. $ant_percentage .'%</tspan> </text> </g></svg>
                            </div>
                            '. get_field( 'anticipatory_oriented_innovation_text_', 'option' ) .'
                          </div>
                        </div>

                      </div>

                      <div class="pat-results-row tendency-row">

                        <div class="pat-results-content">

                          <div class="tendency-group">

                            <h2 class="section-title">This organisation’s portfolio tends to be strong in '. $portfolio_tendency_group .'-oriented innovation.</h2>

                            '. $portfolio_tendency_group_text .'

                          </div>

                        </div>

                      </div>

                    </section>

                    <section id="portfolio-management-capability" class="pat-results-fullwidth-section">

                      <div class="pat-results-row">

                        <div class="pat-results-content">

                          <h2 class="section-title">This organisation’s tends to have '. $level .' portfolio management capablity</h2>

                          <div class="balance-graph">
                          ';
                          if ( $level == 'low' ) {
                            $pdf_output .= '
                            <img src="'. get_site_url() .'/wp-content/plugins/portfolio-assessment-tool-custom-plugin/assets/images/balance-low.svg" alt="">
                            ';
                          } elseif ( $level == 'medium' ) {
                            $pdf_output .= '
                            <img src="'. get_site_url() .'/wp-content/plugins/portfolio-assessment-tool-custom-plugin/assets/images/balance-mid.svg" alt="">
                            ';
                          } else {
                            $pdf_output .= '
                            <img src="'. get_site_url() .'/wp-content/plugins/portfolio-assessment-tool-custom-plugin/assets/images/balance-high.svg" alt="">
                            ';
                          }
                          $pdf_output .= '
                          </div>

                          '. get_field( 'portfolio_management_capability_text', 'option' ) .'

                        </div>

                      </div>


                    </section>

                  </main>

                </div>

              </div><!-- end entry-content -->

            </article>

          </div>

        </div> <!-- end row -->';

  			endwhile;

		  else :
  			$pdf_output .= '<h2 class="center">Not Found</h2>
  				<p class="center">Sorry, but you are looking for something that isn\'t here.</p>';
  		endif;

		$pdf_output .= '</div> <!--content-->';


	$pdf_output .= '
		</body>
		</html>';
?>
