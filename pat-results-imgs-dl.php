<?php
$absPath = dirname(__FILE__);
$realPath = realpath($absPath . '/./');
$fPath = explode("wp-content",$realPath);
define('WP_USE_THEMES', false);
require(''.$fPath[0].'/wp-blog-header.php');

if ( !isset($_GET['module']) && empty($_GET['module']) && !isset($_GET['id']) && empty($_GET['id']) ) {
	wp_die('You are not allowed to see this content or your section has expired.');
}

if ( isset($_GET['module']) && !empty($_GET['module']) ) {
	$module = $_GET['module'];
}

if ( isset($_GET['id']) && !empty($_GET['id']) ) {
	$id = $_GET['id'];
	$post = get_post( $id );
}

if ( isset($_GET['org']) && !empty($_GET['org']) ) {
	$org = $_GET['org'];
}

// If the current user is not the author or an admin, do not show the content
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
$current_user_roles = $current_user->roles;
$author_id = $post->post_author;
if ( !in_array( 'administrator', $current_user_roles ) && $current_user_id != $author_id ) {
	wp_die('You are not allowed to see this content or your section has expired.');
}

$scores = pat_score($id);

// Create images
// Define where to put images
$upload_dir = wp_upload_dir();
$upload_path = $upload_dir['basedir'].'/pat-temp';
if( !file_exists( $upload_path )) {
	$dir = mkdir( $upload_path );
}

if( 1 == $module ) {

	$svg = '
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="803" height="445" viewBox="0 0 803 445"><defs><style>.a{fill:none;stroke:#fff;stroke-width:3px;}.b{fill:'. $scores['enh_color'] .';}.c{fill:'. $scores['mis_color'] .';}.d{fill:'. $scores['ada_color'] .';}.e{fill:'. $scores['ant_color'] .';}.f{fill:#605f5f;font-size:12px;}.f,.g{font-family:Roboto-Medium, Roboto, lato, sans-serif;font-weight:500;}.g{fill:#fff;font-size:33px;}.h{filter:url(#i);}.i{filter:url(#g);}.j{filter:url(#e);}.k{filter:url(#c);}.l{filter:url(#a);}.leadtext{font-family:Roboto-Medium,Roboto,lato,sans-serif;font-weight:900;fill:#605f5f;font-size:13px;}</style><filter id="a" x="125.265" y="25.211" width="572.267" height="381.245" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="3" result="b"/><feFlood flood-opacity="0.161"/><feComposite operator="in" in2="b"/><feComposite in="SourceGraphic"/></filter><filter id="c" x="186.614" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="d"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="d"/><feComposite in="SourceGraphic"/></filter><filter id="e" x="305.324" y="71.092" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="f"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="f"/><feComposite in="SourceGraphic"/></filter><filter id="g" x="305.324" y="227.27" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="h"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="h"/><feComposite in="SourceGraphic"/></filter><filter id="i" x="424.927" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="j"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="j"/><feComposite in="SourceGraphic"/></filter></defs><g transform="translate(-490 -1096.295)"><g class="l" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="a" d="M2580.007,3511.292l274.127-178.347L3128.8,3511.292,2854.135,3692.6Z" transform="translate(-2443.01 -3299.95)"/></g><g class="k" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-352.13 -1209.87)"/></g><g transform="translate(799.824 1168.887)"><g class="j" transform="matrix(1, 0, 0, 1, -309.82, -72.59)"><path class="c" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-355.42 -1211.41)"/></g></g><g class="i" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="d" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-355.42 -1208.23)"/></g><g class="h" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="e" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-358.81 -1209.87)"/></g><text class="f" transform="translate(1245 1308.295)"><tspan x="-39.574" y="0">UNCERTAINTY</tspan><tspan x="-47.317" y="14">Exploring/Radical</tspan></text><text class="f" transform="translate(897.224 1524.295)"><tspan x="-35.707" y="0">UNDIRECTED</tspan><tspan x="-62.745" y="14">Responding/Bottom Up</tspan></text><text class="f" transform="translate(907.224 1107.295)"><tspan x="-27.536" y="0">DIRECTED</tspan><tspan x="-53.484" y="14">Shaping / Top Down</tspan></text><text class="f" transform="translate(553 1301.295)"><tspan x="-31.403" y="0">CERTAINTY</tspan><tspan x="-62.396" y="14">Exploiting/ Incremental</tspan></text><text class="g" transform="translate(902.528 1240)"><tspan x="-30.873" y="0">'. $scores['mis_percentage'] .'%</tspan></text><text class="g" transform="translate(902.528 1399)"><tspan x="-30.873" y="0">'. $scores['ada_percentage'] .'%</tspan></text><text class="g" transform="translate(1021.528 1322)"><tspan x="-30.873" y="0">'. $scores['ant_percentage'] .'%</tspan></text><text class="g" transform="translate(783.528 1316)"><tspan x="-30.873" y="0">'. $scores['enh_percentage'] .'%</tspan></text><text class="leadtext" transform="translate(509 1130.295)" fill="black"><tspan x="0" y="0">PORTFOLIO BALANCE OF</tspan><tspan x="0" y="19">'.$org.'</tspan></text></g></svg>
	';

} elseif ( 2 == $module ) {
	$hide_datafacet1 = (count($scores['m2']['1-enh']) == 0 || count($scores['m2']['1-enh']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster1 = (count($scores['m2']['1-enh']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet2 = (count($scores['m2']['2-mis']) == 0 || count($scores['m2']['2-mis']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster2 = (count($scores['m2']['2-mis']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet3 = (count($scores['m2']['3-ant']) == 0 || count($scores['m2']['3-ant']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster3 = (count($scores['m2']['3-ant']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet4 = (count($scores['m2']['4-ada']) == 0 || count($scores['m2']['4-ada']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster4 = (count($scores['m2']['4-ada']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet5 = (count($scores['m2']['5-sus']) == 0 || count($scores['m2']['5-sus']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster5 = (count($scores['m2']['5-sus']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet6 = (count($scores['m2']['6-tra']) == 0 || count($scores['m2']['6-tra']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster6 = (count($scores['m2']['6-tra']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet7 = (count($scores['m2']['7-dis']) == 0 || count($scores['m2']['7-dis']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster7 = (count($scores['m2']['7-dis']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet8 = (count($scores['m2']['8-opt']) == 0 || count($scores['m2']['8-opt']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster8 = (count($scores['m2']['8-opt']) <= 16 ) ? 'svg-hide' : '';
	$hide_datafacet9 = (count($scores['m2']['9-mix']) == 0 || count($scores['m2']['9-mix']) > 16 ) ? 'svg-hide' : '';
	$hide_cluster9 = (count($scores['m2']['9-mix']) <= 16 ) ? 'svg-hide' : '';
	$svg = '
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="590.185" height="373.532" viewBox="0 0 590.185 373.532">
		<defs>
			<style>
				.svg-hide {
					display: none;
				}
				.leadtext{font-family:Roboto-Medium,Roboto,lato,sans-serif;font-weight:900;fill:#605f5f;font-size:13px;}
			</style>
			<filter id="Tracciato_141" x="0" y="0" width="590.185" height="373.532" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Tracciato_144" x="18.946" y="119.027" width="214.801" height="135.775" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="1.5" result="blur-2"/>
				<feFlood flood-opacity="0.349"/>
				<feComposite operator="in" in2="blur-2"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Tracciato_14" x="184.656" y="17.492" width="214.802" height="135.775" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="1.5" result="blur-3"/>
				<feFlood flood-opacity="0.349"/>
				<feComposite operator="in" in2="blur-3"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Tracciato_142" x="184.656" y="221.67" width="214.802" height="135.775" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="1.5" result="blur-4"/>
				<feFlood flood-opacity="0.349"/>
				<feComposite operator="in" in2="blur-4"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Tracciato_143" x="354.259" y="121.027" width="214.801" height="135.775" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="1.5" result="blur-5"/>
				<feFlood flood-opacity="0.349"/>
				<feComposite operator="in" in2="blur-5"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51" x="102.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-6"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-6"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52" x="102.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-7"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-7"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53" x="102.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-8"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-8"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54" x="102.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-9"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-9"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-2" x="119.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-10"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-10"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-2" x="119.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-11"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-11"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-2" x="119.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-12"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-12"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-2" x="119.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-13"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-13"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-3" x="136.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-14"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-14"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-3" x="136.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-15"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-15"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-3" x="136.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-16"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-16"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-3" x="136.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-17"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-17"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-4" x="85.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-18"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-18"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-4" x="85.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-19"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-19"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-4" x="85.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-20"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-20"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-4" x="85.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-21"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-21"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-5" x="100.332" y="161.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-22"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-22"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-5" x="187.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-23"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-23"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-5" x="187.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-24"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-24"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-6" x="187.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-25"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-25"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-5" x="187.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-26"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-26"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-6" x="204.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-27"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-27"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-6" x="204.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-28"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-28"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-7" x="204.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-29"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-29"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-6" x="204.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-30"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-30"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-7" x="221.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-31"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-31"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-7" x="221.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-32"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-32"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-8" x="221.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-33"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-33"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-7" x="221.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-34"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-34"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-8" x="170.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-35"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-35"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-8" x="170.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-36"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-36"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-9" x="170.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-37"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-37"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-8" x="170.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-38"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-38"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-10" x="185.332" y="110.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-39"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-39"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-9" x="268.832" y="44.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-40"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-40"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-9" x="268.832" y="61.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-41"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-41"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-11" x="268.832" y="78.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-42"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-42"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-9" x="268.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-43"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-43"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-10" x="285.832" y="44.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-44"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-44"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-10" x="285.832" y="61.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-45"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-45"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-12" x="285.832" y="78.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-46"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-46"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-10" x="285.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-47"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-47"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-11" x="302.832" y="44.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-48"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-48"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-11" x="302.832" y="61.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-49"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-49"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-13" x="302.832" y="78.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-50"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-50"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-11" x="302.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-51"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-51"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-12" x="251.832" y="44.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-52"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-52"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-12" x="251.832" y="61.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-53"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-53"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-14" x="251.832" y="78.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-54"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-54"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-12" x="251.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-55"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-55"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-15" x="266.332" y="59.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-56"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-56"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-13" x="187.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-57"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-57"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-13" x="187.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-58"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-58"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-16" x="187.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-59"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-59"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-13" x="187.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-60"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-60"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-14" x="204.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-61"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-61"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-14" x="204.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-62"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-62"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-17" x="204.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-63"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-63"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-14" x="204.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-64"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-64"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-15" x="221.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-65"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-65"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-15" x="221.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-66"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-66"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-18" x="221.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-67"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-67"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-15" x="221.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-68"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-68"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-16" x="170.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-69"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-69"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-16" x="170.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-70"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-70"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-19" x="170.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-71"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-71"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-16" x="170.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-72"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-72"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-20" x="185.332" y="216.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-73"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-73"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-17" x="268.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-74"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-74"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-17" x="268.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-75"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-75"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-21" x="268.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-76"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-76"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-17" x="268.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-77"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-77"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-18" x="285.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-78"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-78"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-18" x="285.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-79"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-79"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-22" x="285.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-80"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-80"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-18" x="285.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-81"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-81"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-19" x="302.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-82"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-82"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-19" x="302.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-83"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-83"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-23" x="302.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-84"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-84"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-19" x="302.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-85"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-85"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-20" x="251.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-86"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-86"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-20" x="251.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-87"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-87"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-24" x="251.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-88"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-88"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-20" x="251.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-89"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-89"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-25" x="266.332" y="161.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-90"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-90"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-21" x="268.832" y="248.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-91"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-91"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-21" x="268.832" y="265.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-92"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-92"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-26" x="268.832" y="282.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-93"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-93"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-21" x="268.832" y="299.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-94"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-94"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-22" x="285.832" y="248.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-95"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-95"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-22" x="285.832" y="265.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-96"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-96"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-27" x="285.832" y="282.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-97"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-97"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-22" x="285.832" y="299.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-98"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-98"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-23" x="302.832" y="248.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-99"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-99"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-23" x="302.832" y="265.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-100"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-100"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-28" x="302.832" y="282.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-101"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-101"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-23" x="302.832" y="299.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-102"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-102"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-24" x="251.832" y="248.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-103"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-103"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-24" x="251.832" y="265.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-104"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-104"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-29" x="251.832" y="282.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-105"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-105"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-24" x="251.832" y="299.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-106"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-106"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-30" x="266.332" y="263.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-107"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-107"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-25" x="353.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-108"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-108"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-25" x="353.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-109"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-109"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-31" x="353.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-110"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-110"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-25" x="353.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-111"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-111"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-26" x="370.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-112"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-112"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-26" x="370.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-113"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-113"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-32" x="370.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-114"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-114"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-26" x="370.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-115"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-115"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-27" x="387.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-116"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-116"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-27" x="387.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-117"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-117"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-33" x="387.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-118"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-118"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-27" x="387.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-119"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-119"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-28" x="336.832" y="201.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-120"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-120"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-28" x="336.832" y="218.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-121"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-121"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-34" x="336.832" y="235.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-122"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-122"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-28" x="336.832" y="252.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-123"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-123"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-35" x="351.332" y="216.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-124"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-124"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-29" x="437.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-125"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-125"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-29" x="437.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-126"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-126"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-36" x="437.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-127"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-127"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-29" x="437.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-128"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-128"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-30" x="454.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-129"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-129"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-30" x="454.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-130"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-130"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-37" x="454.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-131"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-131"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-30" x="454.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-132"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-132"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-31" x="471.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-133"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-133"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-31" x="471.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-134"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-134"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-38" x="471.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-135"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-135"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-31" x="471.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-136"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-136"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-32" x="420.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-137"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-137"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-32" x="420.832" y="163.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-138"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-138"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-39" x="420.832" y="180.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-139"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-139"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-32" x="420.832" y="197.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-140"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-140"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-40" x="435.332" y="161.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-141"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-141"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-33" x="353.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-142"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-142"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-33" x="353.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-143"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-143"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-41" x="353.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-144"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-144"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-33" x="353.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-145"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-145"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-34" x="370.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-146"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-146"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-34" x="370.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-147"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-147"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-42" x="370.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-148"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-148"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-34" x="370.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-149"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-149"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-35" x="387.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-150"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-150"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-35" x="387.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-151"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-151"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-43" x="387.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-152"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-152"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-35" x="387.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-153"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-153"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_51-36" x="336.832" y="95.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-154"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-154"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_52-36" x="336.832" y="112.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-155"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-155"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-44" x="336.832" y="129.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-156"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-156"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_54-36" x="336.832" y="146.605" width="30" height="30" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-157"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-157"/>
				<feComposite in="SourceGraphic"/>
			</filter>
			<filter id="Ellisse_53-45" x="351.332" y="110.105" width="52" height="52" filterUnits="userSpaceOnUse">
				<feOffset dy="3" input="SourceAlpha"/>
				<feGaussianBlur stdDeviation="3" result="blur-158"/>
				<feFlood flood-opacity="0.161"/>
				<feComposite operator="in" in2="blur-158"/>
				<feComposite in="SourceGraphic"/>
			</filter>
		</defs>
		<g id="Raggruppa_195" data-name="main-group" transform="translate(-5255.668 -2451.895)">
			<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Tracciato_141)">
				<path id="Tracciato_141-2" data-name="border" d="M2575.507,3513.15l281.833-176.833,284.667,179.333-284.667,172.667Z" transform="translate(-2563.68 -3328.55)" fill="none" stroke="#fff" stroke-width="3"/>
			</g>
			<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Tracciato_144)">
				<path id="Tracciato_144-2" data-name="facet-1" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-519.8 -1240.47)" fill="'. $scores['enh_color'] .'"/>
			</g>
			<g id="Componente_4_15" data-name="Componente 4 – 15" transform="translate(5444.824 2470.887)">
				<g transform="matrix(1, 0, 0, 1, -189.16, -18.99)" filter="url(#Tracciato_14)">
					<path id="Tracciato_14-2" data-name="facet-2" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-476.09 -1265.01)" fill="'. $scores['mis_color'] .'"/>
				</g>
			</g>
			<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Tracciato_142)">
				<path id="Tracciato_142-2" data-name="facet-3" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-476.09 -1213.83)" fill="'. $scores['ada_color'] .'"/>
			</g>
			<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Tracciato_143)">
				<path id="Tracciato_143-2" data-name="facet-4" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-429.48 -1238.47)" fill="'. $scores['ant_color'] .'"/>
			</g>
			<g id="Raggruppa_171" data-name="data-facet-1">
				<g id="Raggruppa_161" class="'. $hide_datafacet1 .'" data-name="data-dots-1">
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_52)">
						<circle id="Ellisse_52-37" data-name="dot-1-1" data-project-title="'. $scores['m2']['1-enh'][0]['title'] .'" cx="'. $scores['m2']['1-enh'][0]['circle'] .'"
						cy="'. $scores['m2']['1-enh'][0]['circle'] .'" r="'. $scores['m2']['1-enh'][0]['circle'] .'" transform="translate(123.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_53-2)">
						<circle id="Ellisse_53-47" data-name="dot-1-2" data-project-title="'. $scores['m2']['1-enh'][1]['title'] .'" cx="'. $scores['m2']['1-enh'][1]['circle'] .'" cy="'. $scores['m2']['1-enh'][1]['circle'] .'"
						r="'. $scores['m2']['1-enh'][1]['circle'] .'" transform="translate(140.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_52-2)">
						<circle id="Ellisse_52-38" data-name="dot-1-3" data-project-title="'. $scores['m2']['1-enh'][2]['title'] .'" cx="'. $scores['m2']['1-enh'][2]['circle'] .'" cy="'. $scores['m2']['1-enh'][2]['circle'] .'"
						r="'. $scores['m2']['1-enh'][2]['circle'] .'" transform="translate(140.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_53)">
						<circle id="Ellisse_53-46" data-name="dot-1-4" data-project-title="'. $scores['m2']['1-enh'][3]['title'] .'" cx="'. $scores['m2']['1-enh'][3]['circle'] .'" cy="'. $scores['m2']['1-enh'][3]['circle'] .'"
						r="'. $scores['m2']['1-enh'][3]['circle'] .'" transform="translate(123.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_51)">
						<circle id="Ellisse_51-37" data-name="dot-1-5" data-project-title="'. $scores['m2']['1-enh'][4]['title'] .'" cx="'. $scores['m2']['1-enh'][4]['circle'] .'" cy="'. $scores['m2']['1-enh'][4]['circle'] .'"
						r="'. $scores['m2']['1-enh'][4]['circle'] .'" transform="translate(123.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_53-3)">
						<circle id="Ellisse_53-48" data-name="dot-1-6" data-project-title="'. $scores['m2']['1-enh'][5]['title'] .'" cx="'. $scores['m2']['1-enh'][5]['circle'] .'" cy="'. $scores['m2']['1-enh'][5]['circle'] .'"
						r="'. $scores['m2']['1-enh'][5]['circle'] .'" transform="translate(157.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_54)">
						<circle id="Ellisse_54-37" data-name="dot-1-7" data-project-title="'. $scores['m2']['1-enh'][6]['title'] .'" cx="'. $scores['m2']['1-enh'][6]['circle'] .'" cy="'. $scores['m2']['1-enh'][6]['circle'] .'"
						r="'. $scores['m2']['1-enh'][6]['circle'] .'" transform="translate(123.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_52-4)">
						<circle id="Ellisse_52-40" data-name="dot-1-8" data-project-title="'. $scores['m2']['1-enh'][7]['title'] .'" cx="'. $scores['m2']['1-enh'][7]['circle'] .'" cy="'. $scores['m2']['1-enh'][7]['circle'] .'"
						r="'. $scores['m2']['1-enh'][7]['circle'] .'" transform="translate(106.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_51-2)">
						<circle id="Ellisse_51-38" data-name="dot-1-9" data-project-title="'. $scores['m2']['1-enh'][8]['title'] .'" cx="'. $scores['m2']['1-enh'][8]['circle'] .'" cy="'. $scores['m2']['1-enh'][8]['circle'] .'"
						r="'. $scores['m2']['1-enh'][8]['circle'] .'" transform="translate(140.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_52-3)">
						<circle id="Ellisse_52-39" data-name="dot-1-10" data-project-title="'. $scores['m2']['1-enh'][9]['title'] .'" cx="'. $scores['m2']['1-enh'][9]['circle'] .'" cy="'. $scores['m2']['1-enh'][9]['circle'] .'"
						r="'. $scores['m2']['1-enh'][9]['circle'] .'" transform="translate(157.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_54-2)">
						<circle id="Ellisse_54-38" data-name="dot-1-11" data-project-title="'. $scores['m2']['1-enh'][10]['title'] .'" cx="'. $scores['m2']['1-enh'][10]['circle'] .'" cy="'. $scores['m2']['1-enh'][10]['circle'] .'"
						r="'. $scores['m2']['1-enh'][10]['circle'] .'" transform="translate(140.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_53-4)">
						<circle id="Ellisse_53-49" data-name="dot-1-12" data-project-title="'. $scores['m2']['1-enh'][11]['title'] .'" cx="'. $scores['m2']['1-enh'][11]['circle'] .'" cy="'. $scores['m2']['1-enh'][11]['circle'] .'"
						r="'. $scores['m2']['1-enh'][11]['circle'] .'" transform="translate(106.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_51-4)">
						<circle id="Ellisse_51-40" data-name="dot-1-13" data-project-title="'. $scores['m2']['1-enh'][12]['title'] .'" cx="'. $scores['m2']['1-enh'][12]['circle'] .'" cy="'. $scores['m2']['1-enh'][12]['circle'] .'"
						r="'. $scores['m2']['1-enh'][12]['circle'] .'" transform="translate(106.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_51-3)">
						<circle id="Ellisse_51-39" data-name="dot-1-14" data-project-title="'. $scores['m2']['1-enh'][13]['title'] .'" cx="'. $scores['m2']['1-enh'][13]['circle'] .'" cy="'. $scores['m2']['1-enh'][13]['circle'] .'"
						r="'. $scores['m2']['1-enh'][13]['circle'] .'" transform="translate(157.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_54-3)">
						<circle id="Ellisse_54-39" data-name="dot-1-15" data-project-title="'. $scores['m2']['1-enh'][14]['title'] .'" cx="'. $scores['m2']['1-enh'][14]['circle'] .'" cy="'. $scores['m2']['1-enh'][14]['circle'] .'"
						r="'. $scores['m2']['1-enh'][14]['circle'] .'" transform="translate(157.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5255.67, 2451.9)" filter="url(#Ellisse_54-4)">
						<circle id="Ellisse_54-40" data-name="dot-1-16" data-project-title="'. $scores['m2']['1-enh'][15]['title'] .'" cx="'. $scores['m2']['1-enh'][15]['circle'] .'" cy="'. $scores['m2']['1-enh'][15]['circle'] .'"
						r="'. $scores['m2']['1-enh'][15]['circle'] .'" transform="translate(106.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170" class="'. $hide_cluster1 .'" data-name="cluster-1" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -109.13, -166.91)" filter="url(#Ellisse_53-5)">
							<circle id="Ellisse_53-50" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(143.33 167.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_01" data-name="01" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['1-enh']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_188" data-name="data-facet-2" transform="translate(166 -102)">
				<g id="Raggruppa_161-3" class="'. $hide_datafacet2 .'" data-name="data-dots-2">
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_52-9)">
						<circle id="Ellisse_52-45" data-name="dot-2-1" data-project-title="'. $scores['m2']['2-mis'][0]['title'] .'" cx="'. $scores['m2']['2-mis'][0]['circle'] .'" cy="'. $scores['m2']['2-mis'][0]['circle'] .'"
						r="'. $scores['m2']['2-mis'][0]['circle'] .'" transform="translate(289.83 67.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_53-12)">
						<circle id="Ellisse_53-57" data-name="dot-2-2" data-project-title="'. $scores['m2']['2-mis'][1]['title'] .'" cx="'. $scores['m2']['2-mis'][1]['circle'] .'" cy="'. $scores['m2']['2-mis'][1]['circle'] .'"
						r="'. $scores['m2']['2-mis'][1]['circle'] .'" transform="translate(306.83 84.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_52-10)">
						<circle id="Ellisse_52-46" data-name="dot-2-3" data-project-title="'. $scores['m2']['2-mis'][2]['title'] .'" cx="'. $scores['m2']['2-mis'][2]['circle'] .'" cy="'. $scores['m2']['2-mis'][2]['circle'] .'"
						r="'. $scores['m2']['2-mis'][2]['circle'] .'" transform="translate(306.83 67.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_53-11)">
						<circle id="Ellisse_53-56" data-name="dot-2-4" data-project-title="'. $scores['m2']['2-mis'][3]['title'] .'" cx="'. $scores['m2']['2-mis'][3]['circle'] .'" cy="'. $scores['m2']['2-mis'][3]['circle'] .'"
						r="'. $scores['m2']['2-mis'][3]['circle'] .'" transform="translate(289.83 84.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_51-9)">
						<circle id="Ellisse_51-45" data-name="dot-2-5" data-project-title="'. $scores['m2']['2-mis'][4]['title'] .'" cx="'. $scores['m2']['2-mis'][4]['circle'] .'" cy="'. $scores['m2']['2-mis'][4]['circle'] .'"
						r="'. $scores['m2']['2-mis'][4]['circle'] .'" transform="translate(289.83 50.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_53-13)">
						<circle id="Ellisse_53-58" data-name="dot-2-6" data-project-title="'. $scores['m2']['2-mis'][5]['title'] .'" cx="'. $scores['m2']['2-mis'][5]['circle'] .'" cy="'. $scores['m2']['2-mis'][5]['circle'] .'"
						r="'. $scores['m2']['2-mis'][5]['circle'] .'" transform="translate(323.83 84.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_54-9)">
						<circle id="Ellisse_54-45" data-name="dot-2-7" data-project-title="'. $scores['m2']['2-mis'][6]['title'] .'" cx="'. $scores['m2']['2-mis'][6]['circle'] .'" cy="'. $scores['m2']['2-mis'][6]['circle'] .'"
						r="'. $scores['m2']['2-mis'][6]['circle'] .'" transform="translate(289.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_52-12)">
						<circle id="Ellisse_52-48" data-name="dot-2-8" data-project-title="'. $scores['m2']['2-mis'][7]['title'] .'" cx="'. $scores['m2']['2-mis'][7]['circle'] .'" cy="'. $scores['m2']['2-mis'][7]['circle'] .'"
						r="'. $scores['m2']['2-mis'][7]['circle'] .'" transform="translate(272.83 67.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_51-10)">
						<circle id="Ellisse_51-46" data-name="dot-2-9" data-project-title="'. $scores['m2']['2-mis'][8]['title'] .'" cx="'. $scores['m2']['2-mis'][8]['circle'] .'" cy="'. $scores['m2']['2-mis'][8]['circle'] .'"
						r="'. $scores['m2']['2-mis'][8]['circle'] .'" transform="translate(306.83 50.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_52-11)">
						<circle id="Ellisse_52-47" data-name="dot-2-10" data-project-title="'. $scores['m2']['2-mis'][9]['title'] .'" cx="'. $scores['m2']['2-mis'][9]['circle'] .'" cy="'. $scores['m2']['2-mis'][9]['circle'] .'"
						r="'. $scores['m2']['2-mis'][9]['circle'] .'" transform="translate(323.83 67.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_54-10)">
						<circle id="Ellisse_54-46" data-name="dot-2-11" data-project-title="'. $scores['m2']['2-mis'][10]['title'] .'" cx="'. $scores['m2']['2-mis'][10]['circle'] .'" cy="'. $scores['m2']['2-mis'][10]['circle'] .'"
						r="'. $scores['m2']['2-mis'][10]['circle'] .'" transform="translate(306.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_53-14)">
						<circle id="Ellisse_53-59" data-name="dot-2-12" data-project-title="'. $scores['m2']['2-mis'][11]['title'] .'" cx="'. $scores['m2']['2-mis'][11]['circle'] .'" cy="'. $scores['m2']['2-mis'][11]['circle'] .'"
						r="'. $scores['m2']['2-mis'][11]['circle'] .'" transform="translate(272.83 84.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_51-12)">
						<circle id="Ellisse_51-48" data-name="dot-2-13" data-project-title="'. $scores['m2']['2-mis'][12]['title'] .'" cx="'. $scores['m2']['2-mis'][12]['circle'] .'" cy="'. $scores['m2']['2-mis'][12]['circle'] .'"
						r="'. $scores['m2']['2-mis'][12]['circle'] .'" transform="translate(272.83 50.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_51-11)">
						<circle id="Ellisse_51-47" data-name="dot-2-14" data-project-title="'. $scores['m2']['2-mis'][13]['title'] .'" cx="'. $scores['m2']['2-mis'][13]['circle'] .'" cy="'. $scores['m2']['2-mis'][13]['circle'] .'"
						r="'. $scores['m2']['2-mis'][13]['circle'] .'" transform="translate(323.83 50.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_54-11)">
						<circle id="Ellisse_54-47" data-name="dot-2-15" data-project-title="'. $scores['m2']['2-mis'][14]['title'] .'" cx="'. $scores['m2']['2-mis'][14]['circle'] .'" cy="'. $scores['m2']['2-mis'][14]['circle'] .'"
						r="'. $scores['m2']['2-mis'][14]['circle'] .'" transform="translate(323.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2553.9)" filter="url(#Ellisse_54-12)">
						<circle id="Ellisse_54-48" data-name="dot-2-16" data-project-title="'. $scores['m2']['2-mis'][15]['title'] .'" cx="'. $scores['m2']['2-mis'][15]['circle'] .'" cy="'. $scores['m2']['2-mis'][15]['circle'] .'"
						r="'. $scores['m2']['2-mis'][15]['circle'] .'" transform="translate(272.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-3" class="'. $hide_cluster2 .'" data-name="cluster-2" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-3" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -275.13, -64.91)" filter="url(#Ellisse_53-15)">
							<circle id="Ellisse_53-60" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(309.33 65.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_02" data-name="02" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['2-mis']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_193" data-name="data-facet-3" transform="translate(335)">
				<g id="Raggruppa_161-8" class="'. $hide_datafacet3 .'" data-name="data-dots-3">
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_52-29)">
						<circle id="Ellisse_52-65" data-name="dot-3-1" data-project-title="'. $scores['m2']['3-ant'][0]['title'] .'" cx="'. $scores['m2']['3-ant'][0]['circle'] .'" cy="'. $scores['m2']['3-ant'][0]['circle'] .'"
						r="'. $scores['m2']['3-ant'][0]['circle'] .'" transform="translate(458.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_53-37)">
						<circle id="Ellisse_53-82" data-name="dot-3-2" data-project-title="'. $scores['m2']['3-ant'][1]['title'] .'" cx="'. $scores['m2']['3-ant'][1]['circle'] .'" cy="'. $scores['m2']['3-ant'][1]['circle'] .'"
						r="'. $scores['m2']['3-ant'][1]['circle'] .'" transform="translate(475.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_52-30)">
						<circle id="Ellisse_52-66" data-name="dot-3-3" data-project-title="'. $scores['m2']['3-ant'][2]['title'] .'" cx="'. $scores['m2']['3-ant'][2]['circle'] .'" cy="'. $scores['m2']['3-ant'][2]['circle'] .'"
						r="'. $scores['m2']['3-ant'][2]['circle'] .'" transform="translate(475.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_53-36)">
						<circle id="Ellisse_53-81" data-name="dot-3-4" data-project-title="'. $scores['m2']['3-ant'][3]['title'] .'" cx="'. $scores['m2']['3-ant'][3]['circle'] .'" cy="'. $scores['m2']['3-ant'][3]['circle'] .'"
						r="'. $scores['m2']['3-ant'][3]['circle'] .'" transform="translate(458.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_51-29)">
						<circle id="Ellisse_51-65" data-name="dot-3-5" data-project-title="'. $scores['m2']['3-ant'][4]['title'] .'" cx="'. $scores['m2']['3-ant'][4]['circle'] .'" cy="'. $scores['m2']['3-ant'][4]['circle'] .'"
						r="'. $scores['m2']['3-ant'][4]['circle'] .'" transform="translate(458.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_53-38)">
						<circle id="Ellisse_53-83" data-name="dot-3-6" data-project-title="'. $scores['m2']['3-ant'][5]['title'] .'" cx="'. $scores['m2']['3-ant'][5]['circle'] .'" cy="'. $scores['m2']['3-ant'][5]['circle'] .'"
						r="'. $scores['m2']['3-ant'][5]['circle'] .'" transform="translate(492.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_54-29)">
						<circle id="Ellisse_54-65" data-name="dot-3-7" data-project-title="'. $scores['m2']['3-ant'][6]['title'] .'" cx="'. $scores['m2']['3-ant'][6]['circle'] .'" cy="'. $scores['m2']['3-ant'][6]['circle'] .'"
						r="'. $scores['m2']['3-ant'][6]['circle'] .'" transform="translate(458.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_52-32)">
						<circle id="Ellisse_52-68" data-name="dot-3-8" data-project-title="'. $scores['m2']['3-ant'][7]['title'] .'" cx="'. $scores['m2']['3-ant'][7]['circle'] .'" cy="'. $scores['m2']['3-ant'][7]['circle'] .'"
						r="'. $scores['m2']['3-ant'][7]['circle'] .'" transform="translate(441.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_51-30)">
						<circle id="Ellisse_51-66" data-name="dot-3-9" data-project-title="'. $scores['m2']['3-ant'][8]['title'] .'" cx="'. $scores['m2']['3-ant'][8]['circle'] .'" cy="'. $scores['m2']['3-ant'][8]['circle'] .'"
						r="'. $scores['m2']['3-ant'][8]['circle'] .'" transform="translate(475.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_52-31)">
						<circle id="Ellisse_52-67" data-name="dot-3-10" data-project-title="'. $scores['m2']['3-ant'][9]['title'] .'" cx="'. $scores['m2']['3-ant'][9]['circle'] .'" cy="'. $scores['m2']['3-ant'][9]['circle'] .'"
						r="'. $scores['m2']['3-ant'][9]['circle'] .'" transform="translate(492.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_54-30)">
						<circle id="Ellisse_54-66" data-name="dot-3-11" data-project-title="'. $scores['m2']['3-ant'][10]['title'] .'" cx="'. $scores['m2']['3-ant'][10]['circle'] .'" cy="'. $scores['m2']['3-ant'][10]['circle'] .'"
						r="'. $scores['m2']['3-ant'][10]['circle'] .'" transform="translate(475.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_53-39)">
						<circle id="Ellisse_53-84" data-name="dot-3-12" data-project-title="'. $scores['m2']['3-ant'][11]['title'] .'" cx="'. $scores['m2']['3-ant'][11]['circle'] .'" cy="'. $scores['m2']['3-ant'][11]['circle'] .'"
						r="'. $scores['m2']['3-ant'][11]['circle'] .'" transform="translate(441.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_51-32)">
						<circle id="Ellisse_51-68" data-name="dot-3-13" data-project-title="'. $scores['m2']['3-ant'][12]['title'] .'" cx="'. $scores['m2']['3-ant'][12]['circle'] .'" cy="'. $scores['m2']['3-ant'][12]['circle'] .'"
						r="'. $scores['m2']['3-ant'][12]['circle'] .'" transform="translate(441.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_51-31)">
						<circle id="Ellisse_51-67" data-name="dot-3-14" data-project-title="'. $scores['m2']['3-ant'][13]['title'] .'" cx="'. $scores['m2']['3-ant'][13]['circle'] .'" cy="'. $scores['m2']['3-ant'][13]['circle'] .'"
						r="'. $scores['m2']['3-ant'][13]['circle'] .'" transform="translate(492.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_54-31)">
						<circle id="Ellisse_54-67" data-name="dot-3-15" data-project-title="'. $scores['m2']['3-ant'][14]['title'] .'" cx="'. $scores['m2']['3-ant'][14]['circle'] .'" cy="'. $scores['m2']['3-ant'][14]['circle'] .'"
						r="'. $scores['m2']['3-ant'][14]['circle'] .'" transform="translate(492.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 4920.67, 2451.9)" filter="url(#Ellisse_54-32)">
						<circle id="Ellisse_54-68" data-name="dot-3-16" data-project-title="'. $scores['m2']['3-ant'][15]['title'] .'" cx="'. $scores['m2']['3-ant'][15]['circle'] .'" cy="'. $scores['m2']['3-ant'][15]['circle'] .'"
						r="'. $scores['m2']['3-ant'][15]['circle'] .'" transform="translate(441.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-8" class="'. $hide_cluster3 .'" data-name="cluster-3" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-8" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -444.13, -166.91)" filter="url(#Ellisse_53-40)">
							<circle id="Ellisse_53-85" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(478.33 167.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_03" data-name="03" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['3-ant']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_191" data-name="data-facet-4" transform="translate(166 102)">
				<g id="Raggruppa_161-6" class="'. $hide_datafacet4 .'" data-name="facet-dots-4">
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_52-21)">
						<circle id="Ellisse_52-57" data-name="dot-4-1" data-project-title="'. $scores['m2']['4-ada'][0]['title'] .'" cx="'. $scores['m2']['4-ada'][0]['circle'] .'" cy="'. $scores['m2']['4-ada'][0]['circle'] .'"
						r="'. $scores['m2']['4-ada'][0]['circle'] .'" transform="translate(289.83 271.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_53-27)">
						<circle id="Ellisse_53-72" data-name="dot-4-2" data-project-title="'. $scores['m2']['4-ada'][1]['title'] .'" cx="'. $scores['m2']['4-ada'][1]['circle'] .'" cy="'. $scores['m2']['4-ada'][1]['circle'] .'"
						r="'. $scores['m2']['4-ada'][1]['circle'] .'" transform="translate(306.83 288.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_52-22)">
						<circle id="Ellisse_52-58" data-name="dot-4-3" data-project-title="'. $scores['m2']['4-ada'][2]['title'] .'" cx="'. $scores['m2']['4-ada'][2]['circle'] .'" cy="'. $scores['m2']['4-ada'][2]['circle'] .'"
						r="'. $scores['m2']['4-ada'][2]['circle'] .'" transform="translate(306.83 271.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_53-26)">
						<circle id="Ellisse_53-71" data-name="dot-4-4" data-project-title="'. $scores['m2']['4-ada'][3]['title'] .'" cx="'. $scores['m2']['4-ada'][3]['circle'] .'" cy="'. $scores['m2']['4-ada'][3]['circle'] .'"
						r="'. $scores['m2']['4-ada'][3]['circle'] .'" transform="translate(289.83 288.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_51-21)">
						<circle id="Ellisse_51-57" data-name="dot-4-5" data-project-title="'. $scores['m2']['4-ada'][4]['title'] .'" cx="'. $scores['m2']['4-ada'][4]['circle'] .'" cy="'. $scores['m2']['4-ada'][4]['circle'] .'"
						r="'. $scores['m2']['4-ada'][4]['circle'] .'" transform="translate(289.83 254.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_53-28)">
						<circle id="Ellisse_53-73" data-name="dot-4-6" data-project-title="'. $scores['m2']['4-ada'][5]['title'] .'" cx="'. $scores['m2']['4-ada'][5]['circle'] .'" cy="'. $scores['m2']['4-ada'][5]['circle'] .'"
						r="'. $scores['m2']['4-ada'][5]['circle'] .'" transform="translate(323.83 288.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_54-21)">
						<circle id="Ellisse_54-57" data-name="dot-4-7" data-project-title="'. $scores['m2']['4-ada'][6]['title'] .'" cx="'. $scores['m2']['4-ada'][6]['circle'] .'" cy="'. $scores['m2']['4-ada'][6]['circle'] .'"
						r="'. $scores['m2']['4-ada'][6]['circle'] .'" transform="translate(289.83 305.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_52-24)">
						<circle id="Ellisse_52-60" data-name="dot-4-8" data-project-title="'. $scores['m2']['4-ada'][7]['title'] .'" cx="'. $scores['m2']['4-ada'][7]['circle'] .'" cy="'. $scores['m2']['4-ada'][7]['circle'] .'"
						r="'. $scores['m2']['4-ada'][7]['circle'] .'" transform="translate(272.83 271.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_51-22)">
						<circle id="Ellisse_51-58" data-name="dot-4-9" data-project-title="'. $scores['m2']['4-ada'][8]['title'] .'" cx="'. $scores['m2']['4-ada'][8]['circle'] .'" cy="'. $scores['m2']['4-ada'][8]['circle'] .'"
						r="'. $scores['m2']['4-ada'][8]['circle'] .'" transform="translate(306.83 254.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_52-23)">
						<circle id="Ellisse_52-59" data-name="dot-4-10" data-project-title="'. $scores['m2']['4-ada'][9]['title'] .'" cx="'. $scores['m2']['4-ada'][9]['circle'] .'" cy="'. $scores['m2']['4-ada'][9]['circle'] .'"
						r="'. $scores['m2']['4-ada'][9]['circle'] .'" transform="translate(323.83 271.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_54-22)">
						<circle id="Ellisse_54-58" data-name="dot-4-11" data-project-title="'. $scores['m2']['4-ada'][10]['title'] .'" cx="'. $scores['m2']['4-ada'][10]['circle'] .'" cy="'. $scores['m2']['4-ada'][10]['circle'] .'"
						r="'. $scores['m2']['4-ada'][10]['circle'] .'" transform="translate(306.83 305.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_53-29)">
						<circle id="Ellisse_53-74" data-name="dot-4-12" data-project-title="'. $scores['m2']['4-ada'][11]['title'] .'" cx="'. $scores['m2']['4-ada'][11]['circle'] .'" cy="'. $scores['m2']['4-ada'][11]['circle'] .'"
						r="'. $scores['m2']['4-ada'][11]['circle'] .'" transform="translate(272.83 288.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_51-24)">
						<circle id="Ellisse_51-60" data-name="dot-4-13" data-project-title="'. $scores['m2']['4-ada'][12]['title'] .'" cx="'. $scores['m2']['4-ada'][12]['circle'] .'" cy="'. $scores['m2']['4-ada'][12]['circle'] .'"
						r="'. $scores['m2']['4-ada'][12]['circle'] .'" transform="translate(272.83 254.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_51-23)">
						<circle id="Ellisse_51-59" data-name="dot-4-14" data-project-title="'. $scores['m2']['4-ada'][13]['title'] .'" cx="'. $scores['m2']['4-ada'][13]['circle'] .'" cy="'. $scores['m2']['4-ada'][13]['circle'] .'"
						r="'. $scores['m2']['4-ada'][13]['circle'] .'" transform="translate(323.83 254.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_54-23)">
						<circle id="Ellisse_54-59" data-name="dot-4-15" data-project-title="'. $scores['m2']['4-ada'][14]['title'] .'" cx="'. $scores['m2']['4-ada'][14]['circle'] .'" cy="'. $scores['m2']['4-ada'][14]['circle'] .'"
						r="'. $scores['m2']['4-ada'][14]['circle'] .'" transform="translate(323.83 305.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2349.9)" filter="url(#Ellisse_54-24)">
						<circle id="Ellisse_54-60" data-name="dot-4-16" data-project-title="'. $scores['m2']['4-ada'][15]['title'] .'" cx="'. $scores['m2']['4-ada'][15]['circle'] .'" cy="'. $scores['m2']['4-ada'][15]['circle'] .'"
						r="'. $scores['m2']['4-ada'][15]['circle'] .'" transform="translate(272.83 305.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-6" class="'. $hide_cluster4 .'" data-name="cluster-4" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-6" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -275.13, -268.91)" filter="url(#Ellisse_53-30)">
							<circle id="Ellisse_53-75" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(309.33 269.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_04" data-name="04" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['4-ada']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_187" data-name="data-facet-5" transform="translate(85 -51)">
				<g id="Raggruppa_161-2" class="'. $hide_datafacet5 .'" data-name="data-dots-5">
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_52-5)">
						<circle id="Ellisse_52-41" data-name="dot-5-1" data-project-title="'. $scores['m2']['5-sus'][0]['title'] .'" cx="'. $scores['m2']['5-sus'][0]['circle'] .'" cy="'. $scores['m2']['5-sus'][0]['circle'] .'"
						r="'. $scores['m2']['5-sus'][0]['circle'] .'" transform="translate(208.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_53-7)">
						<circle id="Ellisse_53-52" data-name="dot-5-2" data-project-title="'. $scores['m2']['5-sus'][1]['title'] .'" cx="'. $scores['m2']['5-sus'][1]['circle'] .'" cy="'. $scores['m2']['5-sus'][1]['circle'] .'"
						r="'. $scores['m2']['5-sus'][1]['circle'] .'" transform="translate(225.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_52-6)">
						<circle id="Ellisse_52-42" data-name="dot-5-3" data-project-title="'. $scores['m2']['5-sus'][2]['title'] .'" cx="'. $scores['m2']['5-sus'][2]['circle'] .'" cy="'. $scores['m2']['5-sus'][2]['circle'] .'"
						r="'. $scores['m2']['5-sus'][2]['circle'] .'" transform="translate(225.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_53-6)">
						<circle id="Ellisse_53-51" data-name="dot-5-4" data-project-title="'. $scores['m2']['5-sus'][3]['title'] .'" cx="'. $scores['m2']['5-sus'][3]['circle'] .'" cy="'. $scores['m2']['5-sus'][3]['circle'] .'"
						r="'. $scores['m2']['5-sus'][3]['circle'] .'" transform="translate(208.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_51-5)">
						<circle id="Ellisse_51-41" data-name="dot-5-5" data-project-title="'. $scores['m2']['5-sus'][4]['title'] .'" cx="'. $scores['m2']['5-sus'][4]['circle'] .'" cy="'. $scores['m2']['5-sus'][4]['circle'] .'"
						r="'. $scores['m2']['5-sus'][4]['circle'] .'" transform="translate(208.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_53-8)">
						<circle id="Ellisse_53-53" data-name="dot-5-6" data-project-title="'. $scores['m2']['5-sus'][5]['title'] .'" cx="'. $scores['m2']['5-sus'][5]['circle'] .'" cy="'. $scores['m2']['5-sus'][5]['circle'] .'"
						r="'. $scores['m2']['5-sus'][5]['circle'] .'" transform="translate(242.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_54-5)">
						<circle id="Ellisse_54-41" data-name="dot-5-7" data-project-title="'. $scores['m2']['5-sus'][6]['title'] .'" cx="'. $scores['m2']['5-sus'][6]['circle'] .'" cy="'. $scores['m2']['5-sus'][6]['circle'] .'"
						r="'. $scores['m2']['5-sus'][6]['circle'] .'" transform="translate(208.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_52-8)">
						<circle id="Ellisse_52-44" data-name="dot-5-8" data-project-title="'. $scores['m2']['5-sus'][7]['title'] .'" cx="'. $scores['m2']['5-sus'][7]['circle'] .'" cy="'. $scores['m2']['5-sus'][7]['circle'] .'"
						r="'. $scores['m2']['5-sus'][7]['circle'] .'" transform="translate(191.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_51-6)">
						<circle id="Ellisse_51-42" data-name="dot-5-9" data-project-title="'. $scores['m2']['5-sus'][8]['title'] .'" cx="'. $scores['m2']['5-sus'][8]['circle'] .'" cy="'. $scores['m2']['5-sus'][8]['circle'] .'"
						r="'. $scores['m2']['5-sus'][8]['circle'] .'" transform="translate(225.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_52-7)">
						<circle id="Ellisse_52-43" data-name="dot-5-10" data-project-title="'. $scores['m2']['5-sus'][9]['title'] .'" cx="'. $scores['m2']['5-sus'][9]['circle'] .'" cy="'. $scores['m2']['5-sus'][9]['circle'] .'"
						r="'. $scores['m2']['5-sus'][9]['circle'] .'" transform="translate(242.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_54-6)">
						<circle id="Ellisse_54-42" data-name="dot-5-11" data-project-title="'. $scores['m2']['5-sus'][10]['title'] .'" cx="'. $scores['m2']['5-sus'][10]['circle'] .'" cy="'. $scores['m2']['5-sus'][10]['circle'] .'"
						r="'. $scores['m2']['5-sus'][10]['circle'] .'" transform="translate(225.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_53-9)">
						<circle id="Ellisse_53-54" data-name="dot-5-12" data-project-title="'. $scores['m2']['5-sus'][11]['title'] .'" cx="'. $scores['m2']['5-sus'][11]['circle'] .'" cy="'. $scores['m2']['5-sus'][11]['circle'] .'"
						r="'. $scores['m2']['5-sus'][11]['circle'] .'" transform="translate(191.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_51-8)">
						<circle id="Ellisse_51-44" data-name="dot-5-13" data-project-title="'. $scores['m2']['5-sus'][12]['title'] .'" cx="'. $scores['m2']['5-sus'][12]['circle'] .'" cy="'. $scores['m2']['5-sus'][12]['circle'] .'"
						r="'. $scores['m2']['5-sus'][12]['circle'] .'" transform="translate(191.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_51-7)">
						<circle id="Ellisse_51-43" data-name="dot-5-14" data-project-title="'. $scores['m2']['5-sus'][13]['title'] .'" cx="'. $scores['m2']['5-sus'][13]['circle'] .'" cy="'. $scores['m2']['5-sus'][13]['circle'] .'"
						r="'. $scores['m2']['5-sus'][13]['circle'] .'" transform="translate(242.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_54-7)">
						<circle id="Ellisse_54-43" data-name="dot-5-15" data-project-title="'. $scores['m2']['5-sus'][14]['title'] .'" cx="'. $scores['m2']['5-sus'][14]['circle'] .'" cy="'. $scores['m2']['5-sus'][14]['circle'] .'"
						r="'. $scores['m2']['5-sus'][14]['circle'] .'" transform="translate(242.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2502.9)" filter="url(#Ellisse_54-8)">
						<circle id="Ellisse_54-44" data-name="dot-5-16" data-project-title="'. $scores['m2']['5-sus'][15]['title'] .'" cx="'. $scores['m2']['5-sus'][15]['circle'] .'" cy="'. $scores['m2']['5-sus'][15]['circle'] .'"
						r="'. $scores['m2']['5-sus'][15]['circle'] .'" transform="translate(191.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-2" class="'. $hide_cluster5 .'" data-name="cluster-5" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-2" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -194.13, -115.91)" filter="url(#Ellisse_53-10)">
							<circle id="Ellisse_53-55" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(228.33 116.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_05" data-name="05" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['5-sus']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_194" data-name="data-facet-6" transform="translate(251 -51)">
				<g id="Raggruppa_161-9" class="'. $hide_datafacet6 .'" data-name="data-dots-6">
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_52-33)">
						<circle id="Ellisse_52-69" data-name="dot-6-1" data-project-title="'. $scores['m2']['6-tra'][0]['title'] .'" cx="'. $scores['m2']['6-tra'][0]['circle'] .'" cy="'. $scores['m2']['6-tra'][0]['circle'] .'"
						r="'. $scores['m2']['6-tra'][0]['circle'] .'" transform="translate(374.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_53-42)">
						<circle id="Ellisse_53-87" data-name="dot-6-2" data-project-title="'. $scores['m2']['6-tra'][1]['title'] .'" cx="'. $scores['m2']['6-tra'][1]['circle'] .'" cy="'. $scores['m2']['6-tra'][1]['circle'] .'"
						r="'. $scores['m2']['6-tra'][1]['circle'] .'" transform="translate(391.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_52-34)">
						<circle id="Ellisse_52-70" data-name="dot-6-3" data-project-title="'. $scores['m2']['6-tra'][2]['title'] .'" cx="'. $scores['m2']['6-tra'][2]['circle'] .'" cy="'. $scores['m2']['6-tra'][2]['circle'] .'"
						r="'. $scores['m2']['6-tra'][2]['circle'] .'" transform="translate(391.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_53-41)">
						<circle id="Ellisse_53-86" data-name="dot-6-4" data-project-title="'. $scores['m2']['6-tra'][3]['title'] .'" cx="'. $scores['m2']['6-tra'][3]['circle'] .'" cy="'. $scores['m2']['6-tra'][3]['circle'] .'"
						r="'. $scores['m2']['6-tra'][3]['circle'] .'" transform="translate(374.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_51-33)">
						<circle id="Ellisse_51-69" data-name="dot-6-5" data-project-title="'. $scores['m2']['6-tra'][4]['title'] .'" cx="'. $scores['m2']['6-tra'][4]['circle'] .'" cy="'. $scores['m2']['6-tra'][4]['circle'] .'"
						r="'. $scores['m2']['6-tra'][4]['circle'] .'" transform="translate(374.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_53-43)">
						<circle id="Ellisse_53-88" data-name="dot-6-6" data-project-title="'. $scores['m2']['6-tra'][5]['title'] .'" cx="'. $scores['m2']['6-tra'][5]['circle'] .'" cy="'. $scores['m2']['6-tra'][5]['circle'] .'"
						r="'. $scores['m2']['6-tra'][5]['circle'] .'" transform="translate(408.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_54-33)">
						<circle id="Ellisse_54-69" data-name="dot-6-7" data-project-title="'. $scores['m2']['6-tra'][6]['title'] .'" cx="'. $scores['m2']['6-tra'][6]['circle'] .'" cy="'. $scores['m2']['6-tra'][6]['circle'] .'"
						r="'. $scores['m2']['6-tra'][6]['circle'] .'" transform="translate(374.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_52-36)">
						<circle id="Ellisse_52-72" data-name="dot-6-8" data-project-title="'. $scores['m2']['6-tra'][7]['title'] .'" cx="'. $scores['m2']['6-tra'][7]['circle'] .'" cy="'. $scores['m2']['6-tra'][7]['circle'] .'"
						r="'. $scores['m2']['6-tra'][7]['circle'] .'" transform="translate(357.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_51-34)">
						<circle id="Ellisse_51-70" data-name="dot-6-9" data-project-title="'. $scores['m2']['6-tra'][8]['title'] .'" cx="'. $scores['m2']['6-tra'][8]['circle'] .'" cy="'. $scores['m2']['6-tra'][8]['circle'] .'"
						r="'. $scores['m2']['6-tra'][8]['circle'] .'" transform="translate(391.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_52-35)">
						<circle id="Ellisse_52-71" data-name="dot-6-10" data-project-title="'. $scores['m2']['6-tra'][9]['title'] .'" cx="'. $scores['m2']['6-tra'][9]['circle'] .'" cy="'. $scores['m2']['6-tra'][9]['circle'] .'"
						r="'. $scores['m2']['6-tra'][9]['circle'] .'" transform="translate(408.83 118.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_54-34)">
						<circle id="Ellisse_54-70" data-name="dot-6-11" data-project-title="'. $scores['m2']['6-tra'][10]['title'] .'" cx="'. $scores['m2']['6-tra'][10]['circle'] .'" cy="'. $scores['m2']['6-tra'][10]['circle'] .'"
						r="'. $scores['m2']['6-tra'][10]['circle'] .'" transform="translate(391.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_53-44)">
						<circle id="Ellisse_53-89" data-name="dot-6-12" data-project-title="'. $scores['m2']['6-tra'][11]['title'] .'" cx="'. $scores['m2']['6-tra'][11]['circle'] .'" cy="'. $scores['m2']['6-tra'][11]['circle'] .'"
						r="'. $scores['m2']['6-tra'][11]['circle'] .'" transform="translate(357.83 135.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_51-36)">
						<circle id="Ellisse_51-72" data-name="dot-6-13" data-project-title="'. $scores['m2']['6-tra'][12]['title'] .'" cx="'. $scores['m2']['6-tra'][12]['circle'] .'" cy="'. $scores['m2']['6-tra'][12]['circle'] .'"
						r="'. $scores['m2']['6-tra'][12]['circle'] .'" transform="translate(357.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_51-35)">
						<circle id="Ellisse_51-71" data-name="dot-6-14" data-project-title="'. $scores['m2']['6-tra'][13]['title'] .'" cx="'. $scores['m2']['6-tra'][13]['circle'] .'" cy="'. $scores['m2']['6-tra'][13]['circle'] .'"
						r="'. $scores['m2']['6-tra'][13]['circle'] .'" transform="translate(408.83 101.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_54-35)">
						<circle id="Ellisse_54-71" data-name="dot-6-15" data-project-title="'. $scores['m2']['6-tra'][14]['title'] .'" cx="'. $scores['m2']['6-tra'][14]['circle'] .'" cy="'. $scores['m2']['6-tra'][14]['circle'] .'"
						r="'. $scores['m2']['6-tra'][14]['circle'] .'" transform="translate(408.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2502.9)" filter="url(#Ellisse_54-36)">
						<circle id="Ellisse_54-72" data-name="dot-6-16" data-project-title="'. $scores['m2']['6-tra'][15]['title'] .'" cx="'. $scores['m2']['6-tra'][15]['circle'] .'" cy="'. $scores['m2']['6-tra'][15]['circle'] .'"
						r="'. $scores['m2']['6-tra'][15]['circle'] .'" transform="translate(357.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-9" class="'. $hide_cluster6 .'" data-name="cluster-6" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-9" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -360.13, -115.91)" filter="url(#Ellisse_53-45)">
							<circle id="Ellisse_53-90" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(394.33 116.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_06" data-name="06" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['6-tra']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_192" data-name="data-facet-7" transform="translate(251 55)">
				<g id="Raggruppa_161-7" class="'. $hide_datafacet7 .'" data-name="data-dots-7">
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_52-25)">
						<circle id="Ellisse_52-61" data-name="dot-7-1" data-project-title="'. $scores['m2']['7-dis'][0]['title'] .'" cx="'. $scores['m2']['7-dis'][0]['circle'] .'" cy="'. $scores['m2']['7-dis'][0]['circle'] .'"
						r="'. $scores['m2']['7-dis'][0]['circle'] .'" transform="translate(374.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_53-32)">
						<circle id="Ellisse_53-77" data-name="dot-7-2" data-project-title="'. $scores['m2']['7-dis'][1]['title'] .'" cx="'. $scores['m2']['7-dis'][1]['circle'] .'" cy="'. $scores['m2']['7-dis'][1]['circle'] .'"
						r="'. $scores['m2']['7-dis'][1]['circle'] .'" transform="translate(391.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_52-26)">
						<circle id="Ellisse_52-62" data-name="dot-7-3" data-project-title="'. $scores['m2']['7-dis'][2]['title'] .'" cx="'. $scores['m2']['7-dis'][2]['circle'] .'" cy="'. $scores['m2']['7-dis'][2]['circle'] .'"
						r="'. $scores['m2']['7-dis'][2]['circle'] .'" transform="translate(391.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_53-31)">
						<circle id="Ellisse_53-76" data-name="dot-7-4" data-project-title="'. $scores['m2']['7-dis'][3]['title'] .'" cx="'. $scores['m2']['7-dis'][3]['circle'] .'" cy="'. $scores['m2']['7-dis'][3]['circle'] .'"
						r="'. $scores['m2']['7-dis'][3]['circle'] .'" transform="translate(374.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_51-25)">
						<circle id="Ellisse_51-61" data-name="dot-7-5" data-project-title="'. $scores['m2']['7-dis'][4]['title'] .'" cx="'. $scores['m2']['7-dis'][4]['circle'] .'" cy="'. $scores['m2']['7-dis'][4]['circle'] .'"
						r="'. $scores['m2']['7-dis'][4]['circle'] .'" transform="translate(374.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_53-33)">
						<circle id="Ellisse_53-78" data-name="dot-7-6" data-project-title="'. $scores['m2']['7-dis'][5]['title'] .'" cx="'. $scores['m2']['7-dis'][5]['circle'] .'" cy="'. $scores['m2']['7-dis'][5]['circle'] .'"
						r="'. $scores['m2']['7-dis'][5]['circle'] .'" transform="translate(408.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_54-25)">
						<circle id="Ellisse_54-61" data-name="dot-7-7" data-project-title="'. $scores['m2']['7-dis'][6]['title'] .'" cx="'. $scores['m2']['7-dis'][6]['circle'] .'" cy="'. $scores['m2']['7-dis'][6]['circle'] .'"
						r="'. $scores['m2']['7-dis'][6]['circle'] .'" transform="translate(374.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_52-28)">
						<circle id="Ellisse_52-64" data-name="dot-7-8" data-project-title="'. $scores['m2']['7-dis'][7]['title'] .'" cx="'. $scores['m2']['7-dis'][7]['circle'] .'" cy="'. $scores['m2']['7-dis'][7]['circle'] .'"
						r="'. $scores['m2']['7-dis'][7]['circle'] .'" transform="translate(357.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_51-26)">
						<circle id="Ellisse_51-62" data-name="dot-7-9" data-project-title="'. $scores['m2']['7-dis'][8]['title'] .'" cx="'. $scores['m2']['7-dis'][8]['circle'] .'" cy="'. $scores['m2']['7-dis'][8]['circle'] .'"
						r="'. $scores['m2']['7-dis'][8]['circle'] .'" transform="translate(391.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_52-27)">
						<circle id="Ellisse_52-63" data-name="dot-7-10" data-project-title="'. $scores['m2']['7-dis'][9]['title'] .'" cx="'. $scores['m2']['7-dis'][9]['circle'] .'" cy="'. $scores['m2']['7-dis'][9]['circle'] .'"
						r="'. $scores['m2']['7-dis'][9]['circle'] .'" transform="translate(408.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_54-26)">
						<circle id="Ellisse_54-62" data-name="dot-7-11" data-project-title="'. $scores['m2']['7-dis'][10]['title'] .'" cx="'. $scores['m2']['7-dis'][10]['circle'] .'" cy="'. $scores['m2']['7-dis'][10]['circle'] .'"
						r="'. $scores['m2']['7-dis'][10]['circle'] .'" transform="translate(391.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_53-34)">
						<circle id="Ellisse_53-79" data-name="dot-7-12" data-project-title="'. $scores['m2']['7-dis'][11]['title'] .'" cx="'. $scores['m2']['7-dis'][11]['circle'] .'" cy="'. $scores['m2']['7-dis'][11]['circle'] .'"
						r="'. $scores['m2']['7-dis'][11]['circle'] .'" transform="translate(357.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_51-28)">
						<circle id="Ellisse_51-64" data-name="dot-7-13" data-project-title="'. $scores['m2']['7-dis'][12]['title'] .'" cx="'. $scores['m2']['7-dis'][12]['circle'] .'" cy="'. $scores['m2']['7-dis'][12]['circle'] .'"
						r="'. $scores['m2']['7-dis'][12]['circle'] .'" transform="translate(357.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_51-27)">
						<circle id="Ellisse_51-63" data-name="dot-7-14" data-project-title="'. $scores['m2']['7-dis'][13]['title'] .'" cx="'. $scores['m2']['7-dis'][13]['circle'] .'" cy="'. $scores['m2']['7-dis'][13]['circle'] .'"
						r="'. $scores['m2']['7-dis'][13]['circle'] .'" transform="translate(408.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_54-27)">
						<circle id="Ellisse_54-63" data-name="dot-7-15" data-project-title="'. $scores['m2']['7-dis'][14]['title'] .'" cx="'. $scores['m2']['7-dis'][14]['circle'] .'" cy="'. $scores['m2']['7-dis'][14]['circle'] .'"
						r="'. $scores['m2']['7-dis'][14]['circle'] .'" transform="translate(408.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5004.67, 2396.9)" filter="url(#Ellisse_54-28)">
						<circle id="Ellisse_54-64" data-name="dot-7-16" data-project-title="'. $scores['m2']['7-dis'][15]['title'] .'" cx="'. $scores['m2']['7-dis'][15]['circle'] .'" cy="'. $scores['m2']['7-dis'][15]['circle'] .'"
						r="'. $scores['m2']['7-dis'][15]['circle'] .'" transform="translate(357.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-7" class="'. $hide_cluster7 .'" data-name="cluster-7" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-7" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -360.13, -221.91)" filter="url(#Ellisse_53-35)">
							<circle id="Ellisse_53-80" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(394.33 222.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_07" data-name="07" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['7-dis']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_189" data-name="data-facet-8" transform="translate(85 55)">
				<g id="Raggruppa_161-4" class="'. $hide_datafacet8 .'" data-name="data-dots-8">
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_52-13)">
						<circle id="Ellisse_52-49" data-name="dot-8-1" data-project-title="'. $scores['m2']['8-opt'][0]['title'] .'" cx="'. $scores['m2']['8-opt'][0]['circle'] .'" cy="'. $scores['m2']['8-opt'][0]['circle'] .'"
						r="'. $scores['m2']['8-opt'][0]['circle'] .'" transform="translate(208.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_53-17)">
						<circle id="Ellisse_53-62" data-name="dot-8-2" data-project-title="'. $scores['m2']['8-opt'][1]['title'] .'" cx="'. $scores['m2']['8-opt'][1]['circle'] .'" cy="'. $scores['m2']['8-opt'][1]['circle'] .'"
						r="'. $scores['m2']['8-opt'][1]['circle'] .'" transform="translate(225.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_52-14)">
						<circle id="Ellisse_52-50" data-name="dot-8-3" data-project-title="'. $scores['m2']['8-opt'][2]['title'] .'" cx="'. $scores['m2']['8-opt'][2]['circle'] .'" cy="'. $scores['m2']['8-opt'][2]['circle'] .'"
						r="'. $scores['m2']['8-opt'][2]['circle'] .'" transform="translate(225.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_53-16)">
						<circle id="Ellisse_53-61" data-name="dot-8-4" data-project-title="'. $scores['m2']['8-opt'][3]['title'] .'" cx="'. $scores['m2']['8-opt'][3]['circle'] .'" cy="'. $scores['m2']['8-opt'][3]['circle'] .'"
						r="'. $scores['m2']['8-opt'][3]['circle'] .'" transform="translate(208.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_51-13)">
						<circle id="Ellisse_51-49" data-name="dot-8-5" data-project-title="'. $scores['m2']['8-opt'][4]['title'] .'" cx="'. $scores['m2']['8-opt'][4]['circle'] .'" cy="'. $scores['m2']['8-opt'][4]['circle'] .'"
						r="'. $scores['m2']['8-opt'][4]['circle'] .'" transform="translate(208.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_53-18)">
						<circle id="Ellisse_53-63" data-name="dot-8-6" data-project-title="'. $scores['m2']['8-opt'][5]['title'] .'" cx="'. $scores['m2']['8-opt'][5]['circle'] .'" cy="'. $scores['m2']['8-opt'][5]['circle'] .'"
						r="'. $scores['m2']['8-opt'][5]['circle'] .'" transform="translate(242.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_54-13)">
						<circle id="Ellisse_54-49" data-name="dot-8-7" data-project-title="'. $scores['m2']['8-opt'][6]['title'] .'" cx="'. $scores['m2']['8-opt'][6]['circle'] .'" cy="'. $scores['m2']['8-opt'][6]['circle'] .'"
						r="'. $scores['m2']['8-opt'][6]['circle'] .'" transform="translate(208.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_52-16)">
						<circle id="Ellisse_52-52" data-name="dot-8-8" data-project-title="'. $scores['m2']['8-opt'][7]['title'] .'" cx="'. $scores['m2']['8-opt'][7]['circle'] .'" cy="'. $scores['m2']['8-opt'][7]['circle'] .'"
						r="'. $scores['m2']['8-opt'][7]['circle'] .'" transform="translate(191.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_51-14)">
						<circle id="Ellisse_51-50" data-name="dot-8-9" data-project-title="'. $scores['m2']['8-opt'][8]['title'] .'" cx="'. $scores['m2']['8-opt'][8]['circle'] .'" cy="'. $scores['m2']['8-opt'][8]['circle'] .'"
						r="'. $scores['m2']['8-opt'][8]['circle'] .'" transform="translate(225.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_52-15)">
						<circle id="Ellisse_52-51" data-name="dot-8-10" data-project-title="'. $scores['m2']['8-opt'][9]['title'] .'" cx="'. $scores['m2']['8-opt'][9]['circle'] .'" cy="'. $scores['m2']['8-opt'][9]['circle'] .'"
						r="'. $scores['m2']['8-opt'][9]['circle'] .'" transform="translate(242.83 224.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_54-14)">
						<circle id="Ellisse_54-50" data-name="dot-8-11" data-project-title="'. $scores['m2']['8-opt'][10]['title'] .'" cx="'. $scores['m2']['8-opt'][10]['circle'] .'" cy="'. $scores['m2']['8-opt'][10]['circle'] .'"
						r="'. $scores['m2']['8-opt'][10]['circle'] .'" transform="translate(225.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_53-19)">
						<circle id="Ellisse_53-64" data-name="dot-8-12" data-project-title="'. $scores['m2']['8-opt'][11]['title'] .'" cx="'. $scores['m2']['8-opt'][11]['circle'] .'" cy="'. $scores['m2']['8-opt'][11]['circle'] .'"
						r="'. $scores['m2']['8-opt'][11]['circle'] .'" transform="translate(191.83 241.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_51-16)">
						<circle id="Ellisse_51-52" data-name="dot-8-13" data-project-title="'. $scores['m2']['8-opt'][12]['title'] .'" cx="'. $scores['m2']['8-opt'][12]['circle'] .'" cy="'. $scores['m2']['8-opt'][12]['circle'] .'"
						r="'. $scores['m2']['8-opt'][12]['circle'] .'" transform="translate(191.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_51-15)">
						<circle id="Ellisse_51-51" data-name="dot-8-14" data-project-title="'. $scores['m2']['8-opt'][13]['title'] .'" cx="'. $scores['m2']['8-opt'][13]['circle'] .'" cy="'. $scores['m2']['8-opt'][13]['circle'] .'"
						r="'. $scores['m2']['8-opt'][13]['circle'] .'" transform="translate(242.83 207.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_54-15)">
						<circle id="Ellisse_54-51" data-name="dot-8-15" data-project-title="'. $scores['m2']['8-opt'][14]['title'] .'" cx="'. $scores['m2']['8-opt'][14]['circle'] .'" cy="'. $scores['m2']['8-opt'][14]['circle'] .'"
						r="'. $scores['m2']['8-opt'][14]['circle'] .'" transform="translate(242.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5170.67, 2396.9)" filter="url(#Ellisse_54-16)">
						<circle id="Ellisse_54-52" data-name="dot-8-16" data-project-title="'. $scores['m2']['8-opt'][15]['title'] .'" cx="'. $scores['m2']['8-opt'][15]['circle'] .'" cy="'. $scores['m2']['8-opt'][15]['circle'] .'"
						r="'. $scores['m2']['8-opt'][15]['circle'] .'" transform="translate(191.83 258.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-4" class="'. $hide_cluster8 .'" data-name="cluster-8" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-4" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -194.13, -221.91)" filter="url(#Ellisse_53-20)">
							<circle id="Ellisse_53-65" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(228.33 222.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_08" data-name="08" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['8-opt']) .'</tspan></text>
				</g>
			</g>
			<g id="Raggruppa_190" data-name="data-facet-9" transform="translate(166)">
				<g id="Raggruppa_161-5" class="'. $hide_datafacet9 .'" data-name="data-dots-9">
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_52-17)">
						<circle id="Ellisse_52-53" data-name="dot-9-1" data-project-title="'. $scores['m2']['9-mix'][0]['title'] .'" cx="'. $scores['m2']['9-mix'][0]['circle'] .'" cy="'. $scores['m2']['9-mix'][0]['circle'] .'"
						r="'. $scores['m2']['9-mix'][0]['circle'] .'" transform="translate(289.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_53-22)">
						<circle id="Ellisse_53-67" data-name="dot-9-2" data-project-title="'. $scores['m2']['9-mix'][1]['title'] .'" cx="'. $scores['m2']['9-mix'][1]['circle'] .'" cy="'. $scores['m2']['9-mix'][1]['circle'] .'"
						r="'. $scores['m2']['9-mix'][1]['circle'] .'" transform="translate(306.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_52-18)">
						<circle id="Ellisse_52-54" data-name="dot-9-3" data-project-title="'. $scores['m2']['9-mix'][2]['title'] .'" cx="'. $scores['m2']['9-mix'][2]['circle'] .'" cy="'. $scores['m2']['9-mix'][2]['circle'] .'"
						r="'. $scores['m2']['9-mix'][2]['circle'] .'" transform="translate(306.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_53-21)">
						<circle id="Ellisse_53-66" data-name="dot-9-4" data-project-title="'. $scores['m2']['9-mix'][3]['title'] .'" cx="'. $scores['m2']['9-mix'][3]['circle'] .'" cy="'. $scores['m2']['9-mix'][3]['circle'] .'"
						r="'. $scores['m2']['9-mix'][3]['circle'] .'" transform="translate(289.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_51-17)">
						<circle id="Ellisse_51-53" data-name="dot-9-5" data-project-title="'. $scores['m2']['9-mix'][4]['title'] .'" cx="'. $scores['m2']['9-mix'][4]['circle'] .'" cy="'. $scores['m2']['9-mix'][4]['circle'] .'"
						r="'. $scores['m2']['9-mix'][4]['circle'] .'" transform="translate(289.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_53-23)">
						<circle id="Ellisse_53-68" data-name="dot-9-6" data-project-title="'. $scores['m2']['9-mix'][5]['title'] .'" cx="'. $scores['m2']['9-mix'][5]['circle'] .'" cy="'. $scores['m2']['9-mix'][5]['circle'] .'"
						r="'. $scores['m2']['9-mix'][5]['circle'] .'" transform="translate(323.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_54-17)">
						<circle id="Ellisse_54-53" data-name="dot-9-7" data-project-title="'. $scores['m2']['9-mix'][6]['title'] .'" cx="'. $scores['m2']['9-mix'][6]['circle'] .'" cy="'. $scores['m2']['9-mix'][6]['circle'] .'"
						r="'. $scores['m2']['9-mix'][6]['circle'] .'" transform="translate(289.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_52-20)">
						<circle id="Ellisse_52-56" data-name="dot-9-8" data-project-title="'. $scores['m2']['9-mix'][7]['title'] .'" cx="'. $scores['m2']['9-mix'][7]['circle'] .'" cy="'. $scores['m2']['9-mix'][7]['circle'] .'"
						r="'. $scores['m2']['9-mix'][7]['circle'] .'" transform="translate(272.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_51-18)">
						<circle id="Ellisse_51-54" data-name="dot-9-9" data-project-title="'. $scores['m2']['9-mix'][8]['title'] .'" cx="'. $scores['m2']['9-mix'][8]['circle'] .'" cy="'. $scores['m2']['9-mix'][8]['circle'] .'"
						r="'. $scores['m2']['9-mix'][8]['circle'] .'" transform="translate(306.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_52-19)">
						<circle id="Ellisse_52-55" data-name="dot-9-10" data-project-title="'. $scores['m2']['9-mix'][9]['title'] .'" cx="'. $scores['m2']['9-mix'][9]['circle'] .'" cy="'. $scores['m2']['9-mix'][9]['circle'] .'"
						r="'. $scores['m2']['9-mix'][9]['circle'] .'" transform="translate(323.83 169.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_54-18)">
						<circle id="Ellisse_54-54" data-name="dot-9-11" data-project-title="'. $scores['m2']['9-mix'][10]['title'] .'" cx="'. $scores['m2']['9-mix'][10]['circle'] .'" cy="'. $scores['m2']['9-mix'][10]['circle'] .'"
						r="'. $scores['m2']['9-mix'][10]['circle'] .'" transform="translate(306.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_53-24)">
						<circle id="Ellisse_53-69" data-name="dot-9-12" data-project-title="'. $scores['m2']['9-mix'][11]['title'] .'" cx="'. $scores['m2']['9-mix'][11]['circle'] .'" cy="'. $scores['m2']['9-mix'][11]['circle'] .'"
						r="'. $scores['m2']['9-mix'][11]['circle'] .'" transform="translate(272.83 186.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_51-20)">
						<circle id="Ellisse_51-56" data-name="dot-9-13" data-project-title="'. $scores['m2']['9-mix'][12]['title'] .'" cx="'. $scores['m2']['9-mix'][12]['circle'] .'" cy="'. $scores['m2']['9-mix'][12]['circle'] .'"
						r="'. $scores['m2']['9-mix'][12]['circle'] .'" transform="translate(272.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_51-19)">
						<circle id="Ellisse_51-55" data-name="dot-9-14" data-project-title="'. $scores['m2']['9-mix'][13]['title'] .'" cx="'. $scores['m2']['9-mix'][13]['circle'] .'" cy="'. $scores['m2']['9-mix'][13]['circle'] .'"
						r="'. $scores['m2']['9-mix'][13]['circle'] .'" transform="translate(323.83 152.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_54-19)">
						<circle id="Ellisse_54-55" data-name="dot-9-15" data-project-title="'. $scores['m2']['9-mix'][14]['title'] .'" cx="'. $scores['m2']['9-mix'][14]['circle'] .'" cy="'. $scores['m2']['9-mix'][14]['circle'] .'"
						r="'. $scores['m2']['9-mix'][14]['circle'] .'" transform="translate(323.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
					<g transform="matrix(1, 0, 0, 1, 5089.67, 2451.9)" filter="url(#Ellisse_54-20)">
						<circle id="Ellisse_54-56" data-name="dot-9-16" data-project-title="'. $scores['m2']['9-mix'][15]['title'] .'" cx="'. $scores['m2']['9-mix'][15]['circle'] .'" cy="'. $scores['m2']['9-mix'][15]['circle'] .'"
						r="'. $scores['m2']['9-mix'][15]['circle'] .'" transform="translate(272.83 203.6) rotate(90)" fill="#ffffff"/>
					</g>
				</g>
				<g id="Raggruppa_170-5" class="'. $hide_cluster9 .'" data-name="cluster-9" transform="translate(-722.2 660.8)">
					<g id="Raggruppa_126-5" data-name="Raggruppa 126" transform="translate(6087 1958)">
						<g transform="matrix(1, 0, 0, 1, -275.13, -166.91)" filter="url(#Ellisse_53-25)">
							<circle id="Ellisse_53-70" data-name="Ellisse 53" cx="17" cy="17" r="17" transform="translate(309.33 167.1) rotate(90)" fill="#fff"/>
						</g>
					</g>
					<text id="_09" data-name="09" transform="translate(6104.516 1982.255)" fill="#605f5f" font-size="20" font-family="Lato, Roboto-Medium, Roboto" font-weight="500"><tspan x="-11.367" y="0">'. count($scores['m2']['9-mix']) .'</tspan></text>
				</g>
			</g>
			<text class="leadtext" transform="matrix(1, 0, 0, 1, 5275, 2480)" fill="black"><tspan x="0" y="0">PORTFOLIO BALANCE OF</tspan><tspan x="0" y="19">'.$org.'</tspan></text>
		</g>
	</svg>
	';
}

$file_input_path = $upload_path.'/graph-'.$module.'-'.$post->ID.'.svg';
$file_output_path = $upload_path.'/graph-'.$module.'-'.$post->ID.'.png';
$handle = file_put_contents( $file_input_path, $svg );
exec("inkscape $file_input_path --export-png $file_output_path");
// $file_output_url = $upload_dir['basedir'].'/pat-temp/graph-'.$module.'-'.$post->ID.'.png';

$fp = fopen($file_output_path, 'rb');

header("Content-Type: image/png");
header("Content-Length: " . filesize($file_output_path));
header('Content-Disposition: attachment; filename="graph-'.$module.'.png";');

fpassthru($fp);
exit;
?>
