<?php get_header();

  global $post;

  $has_sidebar = 0;
	$layout = 'fullpage';

?>


<div class="col-sm-<?php echo 12 - $has_sidebar; ?> <?php echo ($has_sidebar > 0 ? 'col-sm-pull-3' : ''); ?>">

<?php while ( have_posts() ) : the_post();

  $postid = get_the_ID();

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

  //* Scores
  $scores = pat_score( $postid );

  // Navigation menu
  $nav_menu = '
    <ul class="pat-results-nav-menu">
      <li><a href="#introduction">Introduction</a></li>
      <li><a href="#organisational-portfolio-balance">Organisational Portfolio Balance</a></li>
      <li><a href="#portfolio-management-capability">Portfolio Management Capability</a></li>
      <!--<li><a href="#project-based-mapping">Project based Mapping</a></li>-->
      <!--<li><a href="#combined-results">Combined Results</a></li>-->
      <li><a href="#download-and-share">Download and Share Results</a></li>
      <li><a href="#interpretation">Interpretation and Next Steps</a></li>
      <li class="nav-share-item"><a href="#"><span>Share Results</span></a></li>
      <li class="nav-start-again-item"><a href="#">Start again</a></li>
    </ul>
  ';

?>
	<div class="row">
		<div class="col-sm-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class('pat-results'); ?>>

        <div class="entry-content">

          <div class="col-md-12 pat-results-hero">
          	<div class="pat-form-title-wrapper screen-reader-text">
              <h1>Portfolio Exploration Tool Results</h1>
          	</div>
          	<div class="single_img_wrap pat-form-banner">
          		<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/pat-results-hero.jpg" class="attachment-blog size-blog wp-post-image" alt="Portfolio Exploration Results">
          	</div>
          </div>

          <div class="pat-results-top-nav"><?php echo $nav_menu ?></div>

          <div class="col-md-12">

            <main class="pat-results-main-content">

              <aside class="pat-results-side"><?php echo $nav_menu ?></aside>

              <section id="introduction">

                <div class="pat-results-content">

                  <div class="pat-results-main-title">
                    <h2>Innovation portfolio balance of <?php echo $organisation ?></h2>
                    <p class="subtitle">Based on exploration by <?php echo $name ?> on <?php echo $submission_date ?></p>
                  </div>

                  <div class="disclaimer"><?php echo get_field( 'disclaimer_text', 'option' ) ?></div>

                  <!-- Diamond 1 -->
                  <div class="diamond diamond-1">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="803" height="445" viewBox="0 0 803 445"><defs><style>.a{fill:none;stroke:#fff;stroke-width:3px;}.b{fill:<?php echo $scores['enh_color'] ?>;}.c{fill:<?php echo $scores['mis_color'] ?>;}.d{fill:<?php echo $scores['ada_color'] ?>;}.e{fill:<?php echo $scores['ant_color'] ?>;}.f{fill:#605f5f;font-size:12px;}.f,.g{font-family:Roboto-Medium, Roboto, 'lato', sans-serif;font-weight:500;}.g{fill:#fff;font-size:33px;}.h{filter:url(#i);}.i{filter:url(#g);}.j{filter:url(#e);}.k{filter:url(#c);}.l{filter:url(#a);}</style><filter id="a" x="125.265" y="25.211" width="572.267" height="381.245" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="3" result="b"/><feFlood flood-opacity="0.161"/><feComposite operator="in" in2="b"/><feComposite in="SourceGraphic"/></filter><filter id="c" x="186.614" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="d"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="d"/><feComposite in="SourceGraphic"/></filter><filter id="e" x="305.324" y="71.092" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="f"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="f"/><feComposite in="SourceGraphic"/></filter><filter id="g" x="305.324" y="227.27" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="h"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="h"/><feComposite in="SourceGraphic"/></filter><filter id="i" x="424.927" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="j"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="j"/><feComposite in="SourceGraphic"/></filter></defs><g transform="translate(-490 -1096.295)"><g class="l" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="a" d="M2580.007,3511.292l274.127-178.347L3128.8,3511.292,2854.135,3692.6Z" transform="translate(-2443.01 -3299.95)"/></g><g class="k" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-352.13 -1209.87)"/></g><g transform="translate(799.824 1168.887)"><g class="j" transform="matrix(1, 0, 0, 1, -309.82, -72.59)"><path class="c" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-355.42 -1211.41)"/></g></g><g class="i" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="d" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-355.42 -1208.23)"/></g><g class="h" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="e" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-358.81 -1209.87)"/></g><text class="f" transform="translate(1245 1308.295)"><tspan x="-39.574" y="0">UNCERTAINTY</tspan><tspan x="-47.317" y="14">Exploring/Radical</tspan></text><text class="f" transform="translate(897.224 1524.295)"><tspan x="-35.707" y="0">UNDIRECTED</tspan><tspan x="-62.745" y="14">Responding/Bottom Up</tspan></text><text class="f" transform="translate(907.224 1107.295)"><tspan x="-27.536" y="0">DIRECTED</tspan><tspan x="-53.484" y="14">Shaping / Top Down</tspan></text><text class="f" transform="translate(553 1301.295)"><tspan x="-31.403" y="0">CERTAINTY</tspan><tspan x="-62.396" y="14">Exploiting/ Incremental</tspan></text><text class="g" transform="translate(902.528 1240)"><tspan x="-30.873" y="0"><?php echo $scores['mis_percentage'] ?>%</tspan></text><text class="g" transform="translate(902.528 1399)"><tspan x="-30.873" y="0"><?php echo $scores['ada_percentage'] ?>%</tspan></text><text class="g" transform="translate(1021.528 1322)"><tspan x="-30.873" y="0"><?php echo $scores['ant_percentage'] ?>%</tspan></text><text class="g" transform="translate(783.528 1316)"><tspan x="-30.873" y="0"><?php echo $scores['enh_percentage'] ?>%</tspan></text></g></svg>
                  </div>

                  <h3>Your organisational portfolio tends to <?php echo $scores['portfolio_tendency_statement'] ?></h3>

                </div>

              </section>

              <section id="organisational-portfolio-balance" class="pat-results-fullwidth-section">

                <div class="pat-results-row">
                  <div class="pat-results-side"></div>
                  <div class="pat-results-content">

                    <h2 class="section-title">Innovation portfolio balance of <strong><?php echo $organisation ?></strong></h2>

                  </div>
                </div>

                <div class="pat-results-row enh-row">
                  <div class="pat-results-side">
                    <p class="fw-section-side-title">Enhancement-oriented innovation</p>
                    <div class="side-small-diamond-img">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="275" height="172.219" viewBox="0 0 275 172.219"> <defs> <style>.small-enh-a, .small-enh-g{fill: #fff;}.small-enh-b{fill: <?php echo $scores['enh_color'] ?>;}.small-enh-c, .small-enh-e, .small-enh-f{opacity: 0.201;}.small-enh-d{fill: <?php echo $scores['mis_color'] ?>;}.small-enh-e{fill: <?php echo $scores['ada_color'] ?>;}.small-enh-f{fill: <?php echo $scores['ant_color'] ?>;}.small-enh-g{font-size: 10px; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.small-enh-h{filter: url(#small-enh-g);}.small-enh-i{filter: url(#small-enh-e);}.small-enh-j{filter: url(#small-enh-c);}.small-enh-k{filter: url(#small-enh-a);}</style> <filter id="small-enh-a" x="22.617" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-enh-c" x="82.102" y="13.333" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-enh-e" x="82.102" y="91.594" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-enh-g" x="142.035" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-142 -1850.272)"> <path class="small-enh-a" d="M2580.007,3418.344l137.365-85.4,137.635,85.4-137.635,86.819Z" transform="translate(-2438.007 -1482.673)"/> <g class="small-enh-k" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-enh-b" d="M646.369,1392.987l-51.563,31.54-51.564-31.54L594.805,1361Z" transform="translate(-516.13 -1306.81)"/> </g> <g class="small-enh-c" transform="translate(228.602 1865.106)"> <g class="small-enh-j" transform="matrix(1, 0, 0, 1, -86.6, -14.83)"> <path class="small-enh-d" d="M768.369,1315.987l-51.563,31.54-51.564-31.54L716.805,1284Z" transform="translate(-578.64 -1269.17)"/> </g> </g> <g class="small-enh-i" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-enh-e" d="M768.369,1468.987l-51.563,31.54-51.564-31.54L716.805,1437Z" transform="translate(-578.64 -1343.91)"/> </g> <g class="small-enh-h" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-enh-f" d="M891.369,1392.987l-51.564,31.54-51.563-31.54L839.805,1361Z" transform="translate(-641.71 -1306.81)"/> </g><text class="small-enh-g" transform="translate(221 1941.29)"> <tspan x="-36.66" y="0">ENHANCEMENT</tspan> </text><text class="small-enh-g" transform="translate(281 1979.29)"> <tspan x="-23.574" y="0">ADAPTIVE</tspan> </text><text class="small-enh-g" transform="translate(279 1901.29)"> <tspan x="-20.237" y="0">MISSION</tspan> </text><text class="small-enh-g" transform="translate(341 1939.29)"> <tspan x="-34.192" y="0">ANTICIPATORY</tspan> </text> </g></svg>
                    </div>
                  </div>

                  <div class="pat-results-content">

                    <div class="enhancement-inno-section">
                      <!-- diamond with enhancement percentage   -->
                      <div class="facet-diamond enh-diamond">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.enh-a{fill: #e6e8f0;}.enh-b{fill: <?php echo $scores['enh_color'] ?>;}.enh-c, .enh-e, .enh-f{opacity: 0.201;}.enh-d{fill: <?php echo $scores['mis_color'] ?>;}.enh-e{fill: <?php echo $scores['ada_color'] ?>;}.enh-f{fill: <?php echo $scores['ant_color'] ?>;}.enh-g, .enh-h{fill: #fff; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.enh-g{font-size: 20px;}.enh-h{font-size: 33px;}.enh-i{filter: url(#enh-g);}.enh-j{filter: url(#enh-e);}.enh-k{filter: url(#enh-c);}.enh-l{filter: url(#enh-a);}</style> <filter id="enh-a" x="49.614" y="105.65" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="enh-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="enh-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="enh-g" x="287.927" y="105.65" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-627 -1980.272)"> <path class="enh-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(-1953.007 -1352.673)"/> <g class="enh-l" transform="matrix(1, 0, 0, 1, 627, 1980.27)"> <path class="enh-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g class="enh-c" transform="translate(799.824 2008.887)"> <g class="enh-k" transform="matrix(1, 0, 0, 1, -172.82, -28.62)"> <path class="enh-d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="enh-j" transform="matrix(1, 0, 0, 1, 627, 1980.27)"> <path class="enh-e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="enh-i" transform="matrix(1, 0, 0, 1, 627, 1980.27)"> <path class="enh-f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="enh-g" transform="translate(902.528 2080)"> <tspan x="-40.474" y="0">MISSION</tspan> </text><text class="enh-g" transform="translate(898.528 2235)"> <tspan x="-47.148" y="0">ADAPTIVE</tspan> </text><text class="enh-g" transform="translate(1022.528 2155)"> <tspan x="-68.384" y="0">ANTICIPATORY</tspan> </text><text class="enh-h" transform="translate(790 2162)"> <tspan x="-30.873" y="0"><?php echo $scores['enh_percentage'] ?>%</tspan> </text> </g></svg>
                      </div>

                      <?php the_field( 'enhancemnet_oriented_innovation_text', 'option' ); ?>
                    </div>

                  </div>
                </div>

                <div class="pat-results-row mis-row">

                  <div class="pat-results-side">
                    <p class="fw-section-side-title">Mission-oriented innovation</p>
                    <div class="side-small-diamond-img">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="275" height="172.219" viewBox="0 0 275 172.219"> <defs> <style>.small-mis-a, .small-mis-g{fill: #fff;}.small-mis-b{fill: <?php echo $scores['enh_color'] ?>;}.small-mis-e, .small-mis-b, .small-mis-f{opacity: 0.201;}.small-mis-d{fill: <?php echo $scores['mis_color'] ?>;}.small-mis-e{fill: <?php echo $scores['ada_color'] ?>;}.small-mis-f{fill: <?php echo $scores['ant_color'] ?>;}.small-mis-g{font-size: 10px; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.small-mis-h{filter: url(#small-mis-g);}.small-mis-i{filter: url(#small-mis-e);}.small-mis-j{filter: url(#small-mis-c);}.small-mis-k{filter: url(#small-mis-a);}</style> <filter id="small-mis-a" x="22.617" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-mis-c" x="82.102" y="13.333" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-mis-e" x="82.102" y="91.594" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-mis-g" x="142.035" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-142 -1850.272)"> <path class="small-mis-a" d="M2580.007,3418.344l137.365-85.4,137.635,85.4-137.635,86.819Z" transform="translate(-2438.007 -1482.673)"/> <g class="small-mis-k" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-mis-b" d="M646.369,1392.987l-51.563,31.54-51.564-31.54L594.805,1361Z" transform="translate(-516.13 -1306.81)"/> </g> <g class="small-mis-c" transform="translate(228.602 1865.106)"> <g class="small-mis-j" transform="matrix(1, 0, 0, 1, -86.6, -14.83)"> <path class="small-mis-d" d="M768.369,1315.987l-51.563,31.54-51.564-31.54L716.805,1284Z" transform="translate(-578.64 -1269.17)"/> </g> </g> <g class="small-mis-i" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-mis-e" d="M768.369,1468.987l-51.563,31.54-51.564-31.54L716.805,1437Z" transform="translate(-578.64 -1343.91)"/> </g> <g class="small-mis-h" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-mis-f" d="M891.369,1392.987l-51.564,31.54-51.563-31.54L839.805,1361Z" transform="translate(-641.71 -1306.81)"/> </g><text class="small-mis-g" transform="translate(221 1941.29)"> <tspan x="-36.66" y="0">ENHANCEMENT</tspan> </text><text class="small-mis-g" transform="translate(281 1979.29)"> <tspan x="-23.574" y="0">ADAPTIVE</tspan> </text><text class="small-mis-g" transform="translate(279 1901.29)"> <tspan x="-20.237" y="0">MISSION</tspan> </text><text class="small-mis-g" transform="translate(341 1939.29)"> <tspan x="-34.192" y="0">ANTICIPATORY</tspan> </text> </g></svg>
                    </div>
                  </div>

                  <div class="pat-results-content">
                    <div class="mission-inno-section">
                      <div class="facet-diamond mis-diamond">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.mis-a{fill: #e6e8f0;}.mis-b{fill: <?php echo $scores['enh_color'] ?>; opacity: 0.2;}.mis-c{fill: <?php echo $scores['mis_color'] ?>;}.mis-d{fill: <?php echo $scores['ada_color'] ?>;}.mis-d, .mis-e{opacity: 0.201;}.mis-e{fill: <?php echo $scores['ant_color'] ?>;}.mis-f, .mis-g{fill: #fff; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.mis-f{font-size: 20px;}.mis-g{font-size: 33px;}.mis-h{filter: url(#mis-g);}.mis-i{filter: url(#mis-e);}.mis-j{filter: url(#mis-c);}.mis-k{filter: url(#mis-a);}</style> <filter id="mis-a" x="49.614" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="mis-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="mis-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="mis-g" x="287.927" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-5165 -1827.272)"> <path class="mis-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(2584.993 -1505.673)"/> <g class="mis-k" transform="matrix(1, 0, 0, 1, 5165, 1827.27)"> <path class="mis-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g transform="translate(5337.824 1855.887)"> <g class="mis-j" transform="matrix(1, 0, 0, 1, -172.82, -28.62)"> <path class="mis-c" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="mis-i" transform="matrix(1, 0, 0, 1, 5165, 1827.27)"> <path class="mis-d" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="mis-h" transform="matrix(1, 0, 0, 1, 5165, 1827.27)"> <path class="mis-e" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="mis-f" transform="translate(5321.528 2002)"> <tspan x="-73.32" y="0">ENHANCEMENT</tspan> </text><text class="mis-f" transform="translate(5436.528 2082)"> <tspan x="-47.148" y="0">ADAPTIVE</tspan> </text><text class="mis-f" transform="translate(5560.528 2002)"> <tspan x="-68.384" y="0">ANTICIPATORY</tspan> </text><text class="mis-g" transform="translate(5441 1931)"> <tspan x="-30.873" y="0"><?php echo $scores['mis_percentage'] ?>%</tspan> </text> </g></svg>
                      </div>
                      <?php the_field( 'mission_oriented_innovation_text', 'option' ); ?>
                    </div>
                  </div>

                </div>

                <div class="pat-results-row ada-row">

                  <div class="pat-results-side">
                    <p class="fw-section-side-title">Adaptive-oriented innovation</p>
                    <div class="side-small-diamond-img">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="275" height="172.219" viewBox="0 0 275 172.219"> <defs> <style>.small-ada-a, .small-ada-g{fill: #fff;}.small-ada-b{fill: <?php echo $scores['enh_color'] ?>;}.small-ada-c, .small-ada-b, .small-ada-f{opacity: 0.201;}.small-ada-d{fill: <?php echo $scores['mis_color'] ?>;}.small-ada-e{fill: <?php echo $scores['ada_color'] ?>;}.small-ada-f{fill: <?php echo $scores['ant_color'] ?>;}.small-ada-g{font-size: 10px; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.small-ada-h{filter: url(#small-ada-g);}.small-ada-i{filter: url(#small-ada-e);}.small-ada-j{filter: url(#small-ada-c);}.small-ada-k{filter: url(#small-ada-a);}</style> <filter id="small-ada-a" x="22.617" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-ada-c" x="82.102" y="13.333" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-ada-e" x="82.102" y="91.594" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-ada-g" x="142.035" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-142 -1850.272)"> <path class="small-ada-a" d="M2580.007,3418.344l137.365-85.4,137.635,85.4-137.635,86.819Z" transform="translate(-2438.007 -1482.673)"/> <g class="small-ada-k" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-ada-b" d="M646.369,1392.987l-51.563,31.54-51.564-31.54L594.805,1361Z" transform="translate(-516.13 -1306.81)"/> </g> <g class="small-ada-c" transform="translate(228.602 1865.106)"> <g class="small-ada-j" transform="matrix(1, 0, 0, 1, -86.6, -14.83)"> <path class="small-ada-d" d="M768.369,1315.987l-51.563,31.54-51.564-31.54L716.805,1284Z" transform="translate(-578.64 -1269.17)"/> </g> </g> <g class="small-ada-i" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-ada-e" d="M768.369,1468.987l-51.563,31.54-51.564-31.54L716.805,1437Z" transform="translate(-578.64 -1343.91)"/> </g> <g class="small-ada-h" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-ada-f" d="M891.369,1392.987l-51.564,31.54-51.563-31.54L839.805,1361Z" transform="translate(-641.71 -1306.81)"/> </g><text class="small-ada-g" transform="translate(221 1941.29)"> <tspan x="-36.66" y="0">ENHANCEMENT</tspan> </text><text class="small-ada-g" transform="translate(281 1979.29)"> <tspan x="-23.574" y="0">ADAPTIVE</tspan> </text><text class="small-ada-g" transform="translate(279 1901.29)"> <tspan x="-20.237" y="0">MISSION</tspan> </text><text class="small-ada-g" transform="translate(341 1939.29)"> <tspan x="-34.192" y="0">ANTICIPATORY</tspan> </text> </g></svg>
                    </div>
                  </div>

                  <div class="pat-results-content">

                    <div class="adaptive-inno-section">
                      <div class="facet-diamond ada-diamond">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.ada-a{fill: #e6e8f0;}.ada-b{fill: <?php echo $scores['enh_color'] ?>;}.ada-b, .ada-c, .ada-f{opacity: 0.2;}.ada-d{fill: <?php echo $scores['mis_color'] ?>;}.ada-e{fill: <?php echo $scores['ada_color'] ?>;}.ada-f{fill: <?php echo $scores['ant_color'] ?>;}.ada-g, .ada-h{fill: #fff; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.ada-g{font-size: 20px;}.ada-h{font-size: 33px;}.ada-i{filter: url(#ada-g);}.ada-j{filter: url(#ada-e);}.ada-k{filter: url(#ada-c);}.ada-l{filter: url(#ada-a);}</style> <filter id="ada-a" x="49.614" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ada-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ada-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ada-g" x="287.927" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-5165 -2677.272)"> <path class="ada-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(2584.993 -655.673)"/> <g class="ada-l" transform="matrix(1, 0, 0, 1, 5165, 2677.27)"> <path class="ada-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g class="ada-c" transform="translate(5337.824 2705.887)"> <g class="ada-k" transform="matrix(1, 0, 0, 1, -172.82, -28.61)"> <path class="ada-d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="ada-j" transform="matrix(1, 0, 0, 1, 5165, 2677.27)"> <path class="ada-e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="ada-i" transform="matrix(1, 0, 0, 1, 5165, 2677.27)"> <path class="ada-f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="ada-g" transform="translate(5321.528 2852)"> <tspan x="-73.32" y="0">ENHANCEMENT</tspan> </text><text class="ada-g" transform="translate(5560.528 2852)"> <tspan x="-68.384" y="0">ANTICIPATORY</tspan> </text><text class="ada-g" transform="translate(5440.528 2776)"> <tspan x="-40.474" y="0">MISSION</tspan> </text><text class="ada-h" transform="translate(5446 2937)"> <tspan x="-30.873" y="0"><?php echo $scores['ada_percentage'] ?>%</tspan> </text> </g></svg>
                      </div>
                      <?php the_field( 'adaptive_oriented_innovation_text', 'option' ); ?>
                    </div>
                  </div>

                </div>

                <div class="pat-results-row ant-row">

                  <div class="pat-results-side">
                    <p class="fw-section-side-title">Anticipatory-oriented innovation</p>
                    <div class="side-small-diamond-img">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="275" height="172.219" viewBox="0 0 275 172.219"> <defs> <style>.small-ant-a, .small-ant-g{fill: #fff;}.small-ant-b{fill: <?php echo $scores['enh_color'] ?>;}.small-ant-e, .small-ant-b, .small-ant-d{opacity: 0.201;}.small-ant-d{fill: <?php echo $scores['mis_color'] ?>;}.small-ant-e{fill: <?php echo $scores['ada_color'] ?>;}.small-ant-f{fill: <?php echo $scores['ant_color'] ?>;}.small-ant-g{font-size: 10px; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.small-ant-h{filter: url(#small-ant-g);}.small-ant-i{filter: url(#small-ant-e);}.small-ant-j{filter: url(#small-ant-c);}.small-ant-k{filter: url(#small-ant-a);}</style> <filter id="small-ant-a" x="22.617" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-ant-c" x="82.102" y="13.333" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-ant-e" x="82.102" y="91.594" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-ant-g" x="142.035" y="52.687" width="112.127" height="72.527" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-142 -1850.272)"> <path class="small-ant-a" d="M2580.007,3418.344l137.365-85.4,137.635,85.4-137.635,86.819Z" transform="translate(-2438.007 -1482.673)"/> <g class="small-ant-k" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-ant-b" d="M646.369,1392.987l-51.563,31.54-51.564-31.54L594.805,1361Z" transform="translate(-516.13 -1306.81)"/> </g> <g class="small-ant-c" transform="translate(228.602 1865.106)"> <g class="small-ant-j" transform="matrix(1, 0, 0, 1, -86.6, -14.83)"> <path class="small-ant-d" d="M768.369,1315.987l-51.563,31.54-51.564-31.54L716.805,1284Z" transform="translate(-578.64 -1269.17)"/> </g> </g> <g class="small-ant-i" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-ant-e" d="M768.369,1468.987l-51.563,31.54-51.564-31.54L716.805,1437Z" transform="translate(-578.64 -1343.91)"/> </g> <g class="small-ant-h" transform="matrix(1, 0, 0, 1, 142, 1850.27)"> <path class="small-ant-f" d="M891.369,1392.987l-51.564,31.54-51.563-31.54L839.805,1361Z" transform="translate(-641.71 -1306.81)"/> </g><text class="small-ant-g" transform="translate(221 1941.29)"> <tspan x="-36.66" y="0">ENHANCEMENT</tspan> </text><text class="small-ant-g" transform="translate(281 1979.29)"> <tspan x="-23.574" y="0">ADAPTIVE</tspan> </text><text class="small-ant-g" transform="translate(279 1901.29)"> <tspan x="-20.237" y="0">MISSION</tspan> </text><text class="small-ant-g" transform="translate(341 1939.29)"> <tspan x="-34.192" y="0">ANTICIPATORY</tspan> </text> </g></svg>
                    </div>
                  </div>

                  <div class="pat-results-content">

                    <div class="anticipatory-inno-section">
                      <div class="facet-diamond ant-diamond">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"> <defs> <style>.ant-a{fill: #e6e8f0;}.ant-b{fill: <?php echo $scores['enh_color'] ?>;}.ant-b, .ant-c{opacity: 0.2;}.ant-d{fill: <?php echo $scores['mis_color'] ?>;}.ant-e{fill: <?php echo $scores['ada_color'] ?>; opacity: 0.201;}.ant-f{fill: <?php echo $scores['ant_color'] ?>;}.ant-g, .ant-h{fill: #fff; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.ant-g{font-size: 20px;}.ant-h{font-size: 33px;}.ant-i{filter: url(#ant-g);}.ant-j{filter: url(#ant-e);}.ant-k{filter: url(#ant-c);}.ant-l{filter: url(#ant-a);}</style> <filter id="ant-a" x="49.614" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ant-c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ant-e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="ant-g" x="287.927" y="105.65" width="214.801" height="135.775" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-5165 -2256.272)"> <path class="ant-a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(2584.993 -1076.673)"/> <g class="ant-l" transform="matrix(1, 0, 0, 1, 5165, 2256.27)"> <path class="ant-b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/> </g> <g class="ant-c" transform="translate(5337.824 2284.887)"> <g class="ant-k" transform="matrix(1, 0, 0, 1, -172.82, -28.61)"> <path class="ant-d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/> </g> </g> <g class="ant-j" transform="matrix(1, 0, 0, 1, 5165, 2256.27)"> <path class="ant-e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/> </g> <g class="ant-i" transform="matrix(1, 0, 0, 1, 5165, 2256.27)"> <path class="ant-f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/> </g><text class="ant-g" transform="translate(5321.528 2431)"> <tspan x="-73.32" y="0">ENHANCEMENT</tspan> </text><text class="ant-g" transform="translate(5436.528 2511)"> <tspan x="-47.148" y="0">ADAPTIVE</tspan> </text><text class="ant-g" transform="translate(5440.528 2355)"> <tspan x="-40.474" y="0">MISSION</tspan> </text><text class="ant-h" transform="translate(5566 2436)"> <tspan x="-30.873" y="0"><?php echo $scores['ant_percentage'] ?>%</tspan> </text> </g></svg>
                      </div>
                      <?php the_field( 'anticipatory_oriented_innovation_text_', 'option' ); ?>
                    </div>
                  </div>

                </div>

                <div class="pat-results-row tendency-row">

                  <div class="pat-results-side">
                    <p class="fw-section-side-title">Portfolio balance</p>
                    <div class="side-small-diamond-img">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="280.16" height="175.45" viewBox="0 0 280.16 175.45"> <defs> <style>.small-diam-1-a{fill: #e6e8f0;}.small-diam-1-b{fill: <?php echo $scores['enh_color'] ?>;}.small-diam-1-c{fill: <?php echo $scores['mis_color'] ?>;}.small-diam-1-d{fill: <?php echo $scores['ada_color'] ?>;}.small-diam-1-e{fill: <?php echo $scores['ant_color'] ?>;}.small-diam-1-f{fill: #fff; font-size: 14px; font-family: Roboto-Medium, Roboto, 'lato', sans-serif; font-weight: 500;}.small-diam-1-g{filter: url(#small-diam-1-g);}.small-diam-1-h{filter: url(#small-diam-1-e);}.small-diam-1-i{filter: url(#small-diam-1-c);}.small-diam-1-j{filter: url(#small-diam-1-a);}</style> <filter id="small-diam-1-a" x="23.125" y="53.648" width="114.062" height="73.719" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="b"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="b"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-diam-1-c" x="83.727" y="13.556" width="114.062" height="73.719" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="d"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="d"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-diam-1-e" x="83.727" y="93.284" width="114.062" height="73.719" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="f"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="f"/> <feComposite in="SourceGraphic"/> </filter> <filter id="small-diam-1-g" x="144.785" y="53.648" width="114.062" height="73.719" filterUnits="userSpaceOnUse"> <feOffset dy="3" input="SourceAlpha"/> <feGaussianBlur stdDeviation="1.5" result="h"/> <feFlood flood-opacity="0.349"/> <feComposite operator="in" in2="h"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g transform="translate(-168 -2827.272)"> <path class="small-diam-1-a" d="M2580.007,3419.947l139.943-87,140.218,87L2719.95,3508.4Z" transform="translate(-2412.007 -505.673)"/> <g class="small-diam-1-j" transform="matrix(1, 0, 0, 1, 168, 2827.27)"> <path class="small-diam-1-b" d="M648.3,1393.587l-52.531,32.132-52.531-32.132L595.773,1361Z" transform="translate(-515.62 -1305.85)"/> </g> <g transform="translate(256.227 2842.328)"> <g class="small-diam-1-i" transform="matrix(1, 0, 0, 1, -88.23, -15.06)"> <path class="small-diam-1-c" d="M770.3,1316.587l-52.531,32.132-52.531-32.132L717.773,1284Z" transform="translate(-577.01 -1268.94)"/> </g> </g> <g class="small-diam-1-h" transform="matrix(1, 0, 0, 1, 168, 2827.27)"> <path class="small-diam-1-d" d="M770.3,1469.587l-52.531,32.131-52.531-32.131L717.773,1437Z" transform="translate(-577.01 -1342.22)"/> </g> <g class="small-diam-1-g" transform="matrix(1, 0, 0, 1, 168, 2827.27)"> <path class="small-diam-1-e" d="M893.3,1393.587l-52.531,32.132-52.531-32.132L840.773,1361Z" transform="translate(-638.96 -1305.85)"/> </g><text class="small-diam-1-f" transform="translate(307.832 2878.805)"> <tspan x="-13.098" y="0"><?php echo $mis_percentage ?>%</tspan> </text><text class="small-diam-1-f" transform="translate(309.832 2958.975)"> <tspan x="-13.098" y="0"><?php echo $ada_percentage ?>%</tspan> </text><text class="small-diam-1-f" transform="translate(371.582 2919.667)"> <tspan x="-13.098" y="0"><?php echo $ant_percentage ?>%</tspan> </text><text class="small-diam-1-f" transform="translate(248.082 2917.604)"> <tspan x="-13.098" y="0"><?php echo $scores['enh_percentage'] ?>%</tspan> </text> </g></svg>
                    </div>
                  </div>

                  <div class="pat-results-content">

                    <div class="tendency-group">

                      <h2 class="section-title">This organisation’s portfolio tends to <?php echo $scores['portfolio_tendency_statement'] ?>.</h2>

                      <?php echo $scores['portfolio_tendency_group_text'] ?>

                    </div>

                  </div>

                </div>

              </section>

              <section id="portfolio-management-capability" class="pat-results-fullwidth-section">

                <div class="pat-results-row">

                  <div class="pat-results-side">
                    <p class="fw-section-side-title">Portfolio management Capability</p>
                    <div class="side-small-diamond-img">
                      <?php
                      if ( $scores['level'] == 'low' ) {
                        ?>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/balance-low.svg" alt="">
                        <?php
                      } elseif ( $scores['level'] == 'medium' ) {
                        ?>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/balance-mid.svg" alt="">
                        <?php
                      } else {
                        ?>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/balance-high.svg" alt="">
                        <?php
                      }
                      ?>
                    </div>
                  </div>

                  <div class="pat-results-content">

                    <h2 class="section-title">This organisation’s tends to have <?php echo $scores['level'] ?> portfolio management capablity</h2>

                    <div class="balance-graph">
                    <?php
                    if ( $scores['level'] == 'low' ) {
                      ?>
                      <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/balance-low.svg" alt="">
                      <?php
                    } elseif ( $scores['level'] == 'medium' ) {
                      ?>
                      <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/balance-mid.svg" alt="">
                      <?php
                    } else {
                      ?>
                      <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/balance-high.svg" alt="">
                      <?php
                    }
                    ?>
                    </div>

                    <?php the_field( 'portfolio_management_capability_text', 'option' ); ?>

                  </div>

                </div>


              </section>

              <section id="download-and-share">
                <div class="pat-results-content">
                  <h2>Download and share results</h2>
                  <?php the_field( 'download_and_share_results_text', 'option' ) ?>
                  <button class="download-pdf">Download PDF</button>
                  <a href="<?php echo plugin_dir_url( __FILE__ ) ?>pat-results-csv-dl.php" class="download-csv">Download CSV</a>
                </div>
              </section>

              <section id="interpretation">
                <div class="pat-results-content">
                  <h2>How you might use these results</h2>
                  <?php the_field( 'how_you_might_use_these_result_text', 'option' ) ?>
                  <h2>Save, share, and continue to next steps</h2>
                  <?php the_field( 'save_share_and_continue_to_next_steps_text', 'option' ) ?>
                  <?php if(function_exists('mpdf_pdfbutton')) {
                    mpdf_pdfbutton();
                  } else {echo 'nopdfbtn';}
                  ?>
                  <h2>Contact OPSI for help with interpretation</h2>
                  <?php the_field( ' contact_OPSI_for_help_with_interpretation_text', 'option' ) ?>
                </div>
              </section>

            </main>

          </div>

        </div><!-- end entry-content -->

      </article>

		</div>

	</div> <!-- end row -->
	<?php endwhile; ?>

</div> <!-- end col-sm-12 -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
