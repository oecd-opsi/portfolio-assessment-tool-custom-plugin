<?php
$absPath = dirname(__FILE__);
$realPath = realpath($absPath . '/./');
$fPath = explode("wp-content",$realPath);
define('WP_USE_THEMES', false);
require(''.$fPath[0].'/wp-blog-header.php');

// WP_Query arguments
$args = array(
	'post_type'              => array( 'pat_submission' ),
	'post_status'            => array( 'publish', 'publish_module2' ),
	'nopaging'               => true,
	'posts_per_page'         => '-1',
);

// Useful data to check if the user is allowed to see this content
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
$current_user_roles = $current_user->roles;

if ( isset($_GET['pat_author']) && !empty($_GET['pat_author']) ) {
	$author_id = $args['author'] = $_GET['pat_author'];
	if ( !in_array( 'administrator', $current_user_roles ) && $current_user_id != $author_id ) {
		wp_die('You are not allowed to see this content or your section has expired.');
	}
}

if ( isset($_GET['pat_result_id']) && !empty($_GET['pat_result_id']) ) {
	$post_id = $_GET['pat_result_id'];
	$args['p'] = $post_id;
}

if ( isset($_GET['pat_module']) && !empty($_GET['pat_module']) ) {
	$module = $_GET['pat_module'];
}

if ( isset($_GET['pat_csv_type']) && !empty($_GET['pat_csv_type']) ) {
	$csv_type = $_GET['pat_csv_type'];
}

// The Query
$query = new WP_Query( $args );

// If the current user is not the author or an admin, do not show the content
if ( !is_user_logged_in() ) {
	wp_die('You are not allowed to see this content or your section has expired.');
}

// declare array
$csv_array = array();

if ( $module == 1 ) {
	$csv_array = array(
	array(
		'Submission ID',
		'First Name',
		'Last name',
		'Date submitted',
		'Organisation Explored',
		'Number of people',
		'Sector or topic',
		'Country',
		'Facet Q1',
		'Facet Q1a - Achieving overarching societal goals and solving big problems',
		'Facet Q1b - Achieving efficiency and process improvements',
		'Facet Q1c - Preparing for potential future changes and exploring new scenarios',
		'Facet Q1d - Responding to changes already happening in its external operating environment',
		'Facet Q2',
		'Facet Q2a -  Delivering projects on time and on budget',
		'Facet Q2b -  Maximum impact on high-profile projects',
		'Facet Q2c -  Changing course based on external demands or needs',
		'Facet Q2d -  Being ahead of the curve on things that could impact the organisation in the future',
		'Facet Q3',
		'Facet Q3a - Focusing on precise milestones, deadlines, and outputs',
		'Facet Q3b - Focussing on showing results toward a broad, societal outcome',
		'Facet Q3c - Focussing on iterative and flexible project phases',
		'Facet Q3d - Focussing on alternatives and assumption-testing of new possibilities',
		'Facet Q4',
		'Facet Q4a - The strategy is visible in different units\' goals, which rely on specific performance targets',
		'Facet Q4b - Specific goals and strategies are left up to individual units or teams to decide',
		'Facet Q4c - People are welcome to question the mission or strategy of the organisation',
		'Facet Q4d - People know the overall organsational goals and are focused on delivering them across the organisation',
		'Facet Q5',
		'Facet Q5a - Fundamentally change things that are no longer relevant or suitable but are kept working',
		'Facet Q5b - Changing course on overall strategy when new or contradictory information becomes available',
		'Facet Q5c - Keeping focus on urgent and immediate issues or crises',
		'Facet Q5d - Keeping different parts of the organisation coherent with each other or an overall goal',
		'Facet Q6',
		'Facet Q6a - Negative feedback from stakeholders',
		'Facet Q6b - Our service users disengaging or going elsewhere for solutions',
		'Facet Q6c - Lost confidence in the organisation’s ability to have impact',
		'Facet Q6d - Failing to meet expectations in achieving a big goal',
		'Facet Q6e - Situations where there is an unclear or incalculable return on investment',
		'Facet Q6f - Lack of compliance or disruptions to existing operations',
		'Facet Q7',
		'Facet Q7a - People can work in different ways, even if they go against existing standards',
		'Facet Q7b - People can do anything necessary to achieve a priority goal',
		'Facet Q7c - People can explore different options based on user needs',
		'Facet Q7d - People can make policy or operational adjustments for efficiency or effectiveness',
		'Facet Q8',
		'Facet Q8a - The organisation or its leader fails to deliver on a stated outcome',
		'Facet Q8b - Embarrassing news about money wasted',
		'Facet Q8c - Service delivery failure and user dissatisfaction',
		'Facet Q8d - Failed to anticipate or prepare for a crisis',
		'Facet Q9',
		'Facet Q9a - Missing deadlines or going over budget',
		'Facet Q9b - Not being able to demonstrate the impact expected',
		'Facet Q9c - Partners or service users were left waiting or their needs were not met fast enough',
		'Facet Q9d - Failure to foresee something that created crises or missed opportunities',
		'Facet Q10 - Which innovation initiatives tend to get funded in your organisation?',
		'Facet Q11',
		'Facet Q11a - Waterfall (developing a full list of requirements up front and contracting all at once)',
		'Facet Q11b - Agile (iteratively develop modular pieces as the need arises, with user feedback)',
		'Facet Q11c - Challenge-based (buying solutions based on outcomes rather than product specifications)',
		'Facet Q11d - Sandbox (by funding investigations into unclear needs and supporting different competing alternatives)',
		'Facet Q12',
		'Facet Q12a - 3-6 months, based on how projects and needs emerge',
		'Facet Q12b - Fiscal year - we plan ahead with each budget cycle',
		'Facet Q12c - Outcome based: 2-3 years or based on when we think we may achieve our goal',
		'Facet Q12d - Long-term: the organisation actively thinks 5-10+ years ahead',
		'Facet Q13 - What data does your organisation tend to use?',
		'Facet Q14 - What gets evaluated in your organisation?',
		'Facet Q15 - What kind of tools and methods does your organisation tend to use on a regular basis?',
		'Facet Q16',
		'Facet Q16a - The organisation looks for technology options that could make existing practises more efficient',
		'Facet Q16b - The organisation works together with a couple of big technology vendors in the market',
		'Facet Q16c - The organisation looks for technologies that could deliver on outcomes in new ways',
		'Facet Q16d - The organisations does not have preferred technology partners: solutions are developed or insourced based on specific needs of projects',
		'Facet Q16e - The organisation enables small-scale tests of different technologies based on employees or users recommendations',
		'Facet Q16f - The organisation tends to work together with a multitude of small, agile development teams with user-driven design skills',
		'Facet Q16g - The organisation tries to be at the forefront of technological developments in its sector and has a very good overview of all possible technological opportunities in the field',
		'Facet Q16h - The organisation tends to work with early to the market technology vendors close to universities and other basic research teams',
		'Portfolio Mgmt Q17 - Does your organisation have a clear understanding of innovation and why it is needed?',
		'Portfolio Mgmt Q18',
		'Portfolio Mgmt Q18a - By continuously analysing innovation projects and emerging needs',
		'Portfolio Mgmt Q18b - By allowing new projects to appear on an ad hoc basis',
		'Portfolio Mgmt Q19 - Is there an individual or a team in the organisation that has a continuous overview of different projects and programmes and how they fit together?',
		'Portfolio Mgmt Q20 - Is there an individual or team in the organisation tasked with making recommendations to decision makers about synergies or redundancies between different projects, programmes or activities?',
		'Portfolio Mgmt Q21',
		'Portfolio Mgmt Q21a - My organisation analyses the impact of all innovation projects at the same time and as a whole',
		'Portfolio Mgmt Q22',
		'Portfolio Mgmt Q22a - There is a clear understanding of how different types of innovation* contribute to the organisation as a whole *radical, incremental, bottom-up, impact-oriented etc.',
		'Portfolio Mgmt Q22b - There is an ability to tackle multiple strategic initiatives or aims at the same time',
		'Portfolio Mgmt Q22c - We analyse and work on long-term goals as well as projects that need to be delivered quickly',
		'Portfolio Mgmt Q22d - We comprehensively analyse different aspects of problems and make sense of the environment in which we operate',
		'Portfolio Mgmt Q22e - Units learn from what is happening in other areas and use that knowledge for their own work',
		'Portfolio Mgmt Q23',
		'Portfolio Mgmt Q23a - Funding decisions take into account long-term considerations and investments',
		'Portfolio Mgmt Q23b - Funding is provided in a way that allows for flexibility in how and on what it can be spent',
		'Portfolio Mgmt Q23c - Funding for projects takes into account other projects occurring across the organisation',
		'Portfolio Mgmt Q23d - Funding takes into account value contributed by external actors',
		'Portfolio Mgmt Q24',
		'Portfolio Mgmt Q24a - …there are teams that use different working methods',
		'Portfolio Mgmt Q24b - …there are diverse capabilities and skills',
		'Portfolio Mgmt Q24c - …overall organisational strengths and weaknesses are known by most people',
		'Portfolio Mgmt Q24d - …people are suspicious of other departments',
		'Portfolio Mgmt Q24e - …there is little or no conflict between the departments',
		'Portfolio Mgmt Q24f - …cooperation between the departments is very effective',
		'Portfolio Mgmt Q24g - …there is little or no respect between different departments',
		'Portfolio Mgmt Q24h - …people are unwilling to share information across departments',
		'Portfolio Mgmt Q24i - …it is common to work with external stakeholders towards different goals',
		'Portfolio Mgmt Q24j - …teams often sources ideas from external stakeholders',
		'Portfolio Mgmt Q24k - …teams often co-creates solutions with external stakeholders',
		'Results - Facets Orientation Percentage Score - Mission',
		'Results - Facets Orientation Percentage Score - Enhancement',
		'Results - Facets Orientation Percentage Score - Anticipatory',
		'Results - Facets Orientation Percentage Score - Adaptive',
		'Results - Facets Orientation Percentage Group',
		'Results - Portfolio Management Percentage Score',
		'Results - Portfolio Management Group',
		'Link to Results Page (must be logged on to access)'
	)
);
} elseif ( $module == 2 ) {
	if ( $csv_type == 'solo' ) {
		$csv_array[] = array(
			'Submission ID',
			'First Name',
			'Last Name',
			'Date submitted',
			'Organisation Explored',
			'Number of people',
			'Sector or topic',
			'Country',
			'Project',
			'Project created to',
			'Project pushed forward by',
			'Priority level',
			'Resulting map location'
		);
	} elseif ($csv_type == 'comb' ) {
		$csv_array[] = array(
			'Submission ID',
			'First Name',
			'Last name',
			'Date submitted',
			'Organisation Explored',
			'Number of people',
			'Sector or topic',
			'Country',
			'Facet Q1',
			'Facet Q1a - Achieving overarching societal goals and solving big problems',
			'Facet Q1b - Achieving efficiency and process improvements',
			'Facet Q1c - Preparing for potential future changes and exploring new scenarios',
			'Facet Q1d - Responding to changes already happening in its external operating environment',
			'Facet Q2',
			'Facet Q2a -  Delivering projects on time and on budget',
			'Facet Q2b -  Maximum impact on high-profile projects',
			'Facet Q2c -  Changing course based on external demands or needs',
			'Facet Q2d -  Being ahead of the curve on things that could impact the organisation in the future',
			'Facet Q3',
			'Facet Q3a - Focusing on precise milestones, deadlines, and outputs',
			'Facet Q3b - Focussing on showing results toward a broad, societal outcome',
			'Facet Q3c - Focussing on iterative and flexible project phases',
			'Facet Q3d - Focussing on alternatives and assumption-testing of new possibilities',
			'Facet Q4',
			'Facet Q4a - The strategy is visible in different units\' goals, which rely on specific performance targets',
			'Facet Q4b - Specific goals and strategies are left up to individual units or teams to decide',
			'Facet Q4c - People are welcome to question the mission or strategy of the organisation',
			'Facet Q4d - People know the overall organsational goals and are focused on delivering them across the organisation',
			'Facet Q5',
			'Facet Q5a - Fundamentally change things that are no longer relevant or suitable but are kept working',
			'Facet Q5b - Changing course on overall strategy when new or contradictory information becomes available',
			'Facet Q5c - Keeping focus on urgent and immediate issues or crises',
			'Facet Q5d - Keeping different parts of the organisation coherent with each other or an overall goal',
			'Facet Q6',
			'Facet Q6a - Negative feedback from stakeholders',
			'Facet Q6b - Our service users disengaging or going elsewhere for solutions',
			'Facet Q6c - Lost confidence in the organisation’s ability to have impact',
			'Facet Q6d - Failing to meet expectations in achieving a big goal',
			'Facet Q6e - Situations where there is an unclear or incalculable return on investment',
			'Facet Q6f - Lack of compliance or disruptions to existing operations',
			'Facet Q7',
			'Facet Q7a - People can work in different ways, even if they go against existing standards',
			'Facet Q7b - People can do anything necessary to achieve a priority goal',
			'Facet Q7c - People can explore different options based on user needs',
			'Facet Q7d - People can make policy or operational adjustments for efficiency or effectiveness',
			'Facet Q8',
			'Facet Q8a - The organisation or its leader fails to deliver on a stated outcome',
			'Facet Q8b - Embarrassing news about money wasted',
			'Facet Q8c - Service delivery failure and user dissatisfaction',
			'Facet Q8d - Failed to anticipate or prepare for a crisis',
			'Facet Q9',
			'Facet Q9a - Missing deadlines or going over budget',
			'Facet Q9b - Not being able to demonstrate the impact expected',
			'Facet Q9c - Partners or service users were left waiting or their needs were not met fast enough',
			'Facet Q9d - Failure to foresee something that created crises or missed opportunities',
			'Facet Q10 - Which innovation initiatives tend to get funded in your organisation?',
			'Facet Q11',
			'Facet Q11a - Waterfall (developing a full list of requirements up front and contracting all at once)',
			'Facet Q11b - Agile (iteratively develop modular pieces as the need arises, with user feedback)',
			'Facet Q11c - Challenge-based (buying solutions based on outcomes rather than product specifications)',
			'Facet Q11d - Sandbox (by funding investigations into unclear needs and supporting different competing alternatives)',
			'Facet Q12',
			'Facet Q12a - 3-6 months, based on how projects and needs emerge',
			'Facet Q12b - Fiscal year - we plan ahead with each budget cycle',
			'Facet Q12c - Outcome based: 2-3 years or based on when we think we may achieve our goal',
			'Facet Q12d - Long-term: the organisation actively thinks 5-10+ years ahead',
			'Facet Q13 - What data does your organisation tend to use?',
			'Facet Q14 - What gets evaluated in your organisation?',
			'Facet Q15 - What kind of tools and methods does your organisation tend to use on a regular basis?',
			'Facet Q16',
			'Facet Q16a - The organisation looks for technology options that could make existing practises more efficient',
			'Facet Q16b - The organisation works together with a couple of big technology vendors in the market',
			'Facet Q16c - The organisation looks for technologies that could deliver on outcomes in new ways',
			'Facet Q16d - The organisations does not have preferred technology partners: solutions are developed or insourced based on specific needs of projects',
			'Facet Q16e - The organisation enables small-scale tests of different technologies based on employees or users recommendations',
			'Facet Q16f - The organisation tends to work together with a multitude of small, agile development teams with user-driven design skills',
			'Facet Q16g - The organisation tries to be at the forefront of technological developments in its sector and has a very good overview of all possible technological opportunities in the field',
			'Facet Q16h - The organisation tends to work with early to the market technology vendors close to universities and other basic research teams',
			'Portfolio Mgmt Q17 - Does your organisation have a clear understanding of innovation and why it is needed?',
			'Portfolio Mgmt Q18',
			'Portfolio Mgmt Q18a - By continuously analysing innovation projects and emerging needs',
			'Portfolio Mgmt Q18b - By allowing new projects to appear on an ad hoc basis',
			'Portfolio Mgmt Q19 - Is there an individual or a team in the organisation that has a continuous overview of different projects and programmes and how they fit together?',
			'Portfolio Mgmt Q20 - Is there an individual or team in the organisation tasked with making recommendations to decision makers about synergies or redundancies between different projects, programmes or activities?',
			'Portfolio Mgmt Q21',
			'Portfolio Mgmt Q21a - My organisation analyses the impact of all innovation projects at the same time and as a whole',
			'Portfolio Mgmt Q22',
			'Portfolio Mgmt Q22a - There is a clear understanding of how different types of innovation* contribute to the organisation as a whole *radical, incremental, bottom-up, impact-oriented etc.',
			'Portfolio Mgmt Q22b - There is an ability to tackle multiple strategic initiatives or aims at the same time',
			'Portfolio Mgmt Q22c - We analyse and work on long-term goals as well as projects that need to be delivered quickly',
			'Portfolio Mgmt Q22d - We comprehensively analyse different aspects of problems and make sense of the environment in which we operate',
			'Portfolio Mgmt Q22e - Units learn from what is happening in other areas and use that knowledge for their own work',
			'Portfolio Mgmt Q23',
			'Portfolio Mgmt Q23a - Funding decisions take into account long-term considerations and investments',
			'Portfolio Mgmt Q23b - Funding is provided in a way that allows for flexibility in how and on what it can be spent',
			'Portfolio Mgmt Q23c - Funding for projects takes into account other projects occurring across the organisation',
			'Portfolio Mgmt Q23d - Funding takes into account value contributed by external actors',
			'Portfolio Mgmt Q24',
			'Portfolio Mgmt Q24a - …there are teams that use different working methods',
			'Portfolio Mgmt Q24b - …there are diverse capabilities and skills',
			'Portfolio Mgmt Q24c - …overall organisational strengths and weaknesses are known by most people',
			'Portfolio Mgmt Q24d - …people are suspicious of other departments',
			'Portfolio Mgmt Q24e - …there is little or no conflict between the departments',
			'Portfolio Mgmt Q24f - …cooperation between the departments is very effective',
			'Portfolio Mgmt Q24g - …there is little or no respect between different departments',
			'Portfolio Mgmt Q24h - …people are unwilling to share information across departments',
			'Portfolio Mgmt Q24i - …it is common to work with external stakeholders towards different goals',
			'Portfolio Mgmt Q24j - …teams often sources ideas from external stakeholders',
			'Portfolio Mgmt Q24k - …teams often co-creates solutions with external stakeholders',
			'Results - Facets Orientation Percentage Score - Mission',
			'Results - Facets Orientation Percentage Score - Enhancement',
			'Results - Facets Orientation Percentage Score - Anticipatory',
			'Results - Facets Orientation Percentage Score - Adaptive',
			'Results - Facets Orientation Percentage Group',
			'Results - Portfolio Management Percentage Score',
			'Results - Portfolio Management Group',
			'Mapping - Total projects',
			'Mapping - Enhancement-oriented',
			'Mapping - Mission-oriented',
			'Mapping - Anticipatory',
			'Mapping - Adaptive',
			'Mapping - Sustaining change',
			'Mapping - Transformative change',
			'Mapping - Disruptive change',
			'Mapping - Optimising change',
			'Mapping - Mixed or unclear',
			'Link to Results Page (must be logged on to access)'
		);
	}
}

// Helper function to print checkbox selected options
function checkbox_get_all_options( $field ) {
	$output = array();
	foreach ($field as $option) {
		$output[] = $option['label'];
	}
	return implode( '; ', $output );
}

// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();

    $scores = pat_score(get_the_ID());

		if( $module == 1 || $csv_type == 'comb' || !isset($_GET['pat_author']) ) {
			$general_questions = get_field('general_questions');
			$facet_1 = get_field('facet_orientation_questions_1');
			$facet_2 = get_field('facet_orientation_questions_2');
			$facet_3 = get_field('facet_orientation_questions_3');
			$facet_4 = get_field('facet_orientation_questions_4');
			$pmq_1 = get_field('portfolio_management_questions_1');
			if( $module == 2 ) {
				$projects = get_field('projects');
				$projects_number = count( $projects['projects_list'] );
			}

			$post_array = array (
				get_the_ID(),
				get_the_author_meta('first_name'),
				get_the_author_meta('last_name'),
				get_the_date(),
				$general_questions['organisation'],
				$general_questions['n_people'],
				implode( '; ', $general_questions['in_which_sector_or_topic_does_this_group_of_people_focus_its_work']),
				$general_questions['country']->name,
				'My organisation tends to focus on...',
				$facet_1['my_organisation_tends_to_focus_on']['mis_achieving_overarching_societal_goals_and_solving_big_problems']['label'],
				$facet_1['my_organisation_tends_to_focus_on']['enh_achieving_efficiency_and_process_improvements']['label'],
				$facet_1['my_organisation_tends_to_focus_on']['ant_preparing_for_potential_future_changes_and_exploring_new_scenarios']['label'],
				$facet_1['my_organisation_tends_to_focus_on']['ada_responding_to_changes_already_happening_in_its_external_operating_environment']['label'],
				'What does the leadership of my organisation tend to prefer or promote?',
				$facet_1['what_does_the_leadership_of_my_organisation_tend_to_prefer_or_promote']['enh_delivering_projects_on_time_and_on_budget'],
				$facet_1['what_does_the_leadership_of_my_organisation_tend_to_prefer_or_promote']['mis_maximum_impact_on_high-profile_projects'],
				$facet_1['what_does_the_leadership_of_my_organisation_tend_to_prefer_or_promote']['ant_changing_course_based_on_external_demands_or_needs'],
				$facet_1['what_does_the_leadership_of_my_organisation_tend_to_prefer_or_promote']['ada_being_ahead_of_the_curve_on_things_that_could_impact_the_organisation_in_the_future'],
				'How does your organisation tend to manage projects?',
				$facet_1['how_does_your_organisation_tend_to_manage_projects']['enh_focussing_on_precise_milestones_deadlines_and_outputs']['label'],
				$facet_1['how_does_your_organisation_tend_to_manage_projects']['mis_focussing_on_showing_results_toward_a_broad_societal_outcome']['label'],
				$facet_1['how_does_your_organisation_tend_to_manage_projects']['ada_focussing_on_iterative_and_flexible_project_phases']['label'],
				$facet_1['how_does_your_organisation_tend_to_manage_projects']['ant_focussing_on_alternatives_and_assumption-testing_of_new_possibilities']['label'],
				'In my organisation...',
				$facet_1['in_my_organisation…']['enh_the_strategy_is_visible_in_different_units_goals_which_rely_on_specific_performance_targets']['label'],
				$facet_1['in_my_organisation…']['ada_specific_goals_and_strategies_are_left_up_to_individual_units_or_teams_to_decide']['label'],
				$facet_1['in_my_organisation…']['ant_people_are_welcome_to_question_the_mission_or_strategy_of_the_organisation']['label'],
				$facet_1['in_my_organisation…']['mis_people_know_the_overall_organsational_goals_and_are_focused_on_delivering_them_across_the_organisation']['label'],
				'What is most difficult to get done in your organisation?',
				$facet_2['what_is_most_difficult_to_get_done_in_your_organisation']['enh_fundamentally_change_things_that_are_no_longer_relevant_or_suitable_but_are_kept_working'],
				$facet_2['what_is_most_difficult_to_get_done_in_your_organisation']['mis_changing_course_on_overall_strategy_when_new_or_contradictory_information_becomes_available'],
				$facet_2['what_is_most_difficult_to_get_done_in_your_organisation']['ant_keeping_focus_on_urgent_and_immediate_issues_or_crises'],
				$facet_2['what_is_most_difficult_to_get_done_in_your_organisation']['ada_keeping_different_parts_of_the_organisation_coherent_with_each_other_or_an_overall_goal'],
				'Risks my organisation tends to take most seriously are…',
				$facet_2['risks_my_organisation_tends_to_take_most_seriously_are…']['ada_negative_feedback_from_stakeholders']['label'],
				$facet_2['risks_my_organisation_tends_to_take_most_seriously_are…']['ada_our_service_users_disengaging_or_going_elsewhere_for_solutions']['label'],
				$facet_2['risks_my_organisation_tends_to_take_most_seriously_are…']['mis_lost_confidence_in_the_organisation_s_ability_to_have_impact']['label'],
				$facet_2['risks_my_organisation_tends_to_take_most_seriously_are…']['mis_failing_to_meet_expectations_in_achieving_a_big_goal']['label'],
				$facet_2['risks_my_organisation_tends_to_take_most_seriously_are…']['enh_situations_where_there_is_an_unclear_or_incalculable_return_on_investment']['label'],
				$facet_2['risks_my_organisation_tends_to_take_most_seriously_are…']['enh_lack_of_compliance_or_disruptions_to_existing_operations']['label'],
				'What can people in your organisation do without asking for explicit permission?',
				$facet_2['what_can_people_in_your_organisation_do_without_asking_for_explicit_permission']['ant_people_can_work_in_different_ways,_even_if_they_go_against_existing_standards']['label'],
				$facet_2['what_can_people_in_your_organisation_do_without_asking_for_explicit_permission']['mis_people_can_do_anything_necessary_to_achieve_a_priority_goal']['label'],
				$facet_2['what_can_people_in_your_organisation_do_without_asking_for_explicit_permission']['ada_people_can_explore_different_options_based_on_user_needs']['label'],
				$facet_2['what_can_people_in_your_organisation_do_without_asking_for_explicit_permission']['enh_people_can_make_policy_or_operational_adjustments_for_efficiency_or_effectiveness']['label'],
				'Which negative news, articles or external reports would get the most attention inside the organisation?',
				$facet_2['which_negative_news,_articles_or_external_reports_would_get_the_most_attention_inside_the_organisation']['mis_the_organisation_or_its_leader_fails_to_deliver_on_a_stated outcom'],
				$facet_2['which_negative_news,_articles_or_external_reports_would_get_the_most_attention_inside_the_organisation']['enh_embarrassing_news_about_money_waste'],
				$facet_2['which_negative_news,_articles_or_external_reports_would_get_the_most_attention_inside_the_organisation']['ada_service_delivery_failure_and_user_dissatisfaction'],
				$facet_2['which_negative_news,_articles_or_external_reports_would_get_the_most_attention_inside_the_organisation']['ant_failed_to_anticipate_or_prepare_for_a_crisis'],
				'What gets punished in your organisation?',
				$facet_3['what_gets_punished_in_your_organisation']['enh_missing_deadlines_or_going_over_budget']['label'],
				$facet_3['what_gets_punished_in_your_organisation']['mis_not_being_able_to_demonstrate_the_impact_expected']['label'],
				$facet_3['what_gets_punished_in_your_organisation']['ada_partners_or_service_users_were_left_waiting_or_their_needs_were_not_met_fast_enough']['label'],
				$facet_3['what_gets_punished_in_your_organisation']['ant_failure_to_foresee_something_that_created_crises_or_missed_opportunities']['label'],
				$facet_3['which_innovation_initiatives_tend_to_get_funded_in_your_organisation'][0]['label'],
				'Which procurement options does your organisation tend to use most often to achieve its strategic objectives?',
				$facet_3['which_procurement_options_does_your_organisation_tend_to_use_most_often_to_achieve_its_strategic_objectives']['enh_waterfall']['label'],
				$facet_3['which_procurement_options_does_your_organisation_tend_to_use_most_often_to_achieve_its_strategic_objectives']['ada_agile']['label'],
				$facet_3['which_procurement_options_does_your_organisation_tend_to_use_most_often_to_achieve_its_strategic_objectives']['mis_challenge-based']['label'],
				$facet_3['which_procurement_options_does_your_organisation_tend_to_use_most_often_to_achieve_its_strategic_objectives']['ant_sandbox']['label'],
				'Which time horizons does your organisation tend to work with?',
				$facet_3['which_time_horizons_does_your_organisation_tend_to_work_with']['ada_3-6_months'],
				$facet_3['which_time_horizons_does_your_organisation_tend_to_work_with']['enh_fiscal_year'],
				$facet_3['which_time_horizons_does_your_organisation_tend_to_work_with']['mis_outcome_based'],
				$facet_3['which_time_horizons_does_your_organisation_tend_to_work_with']['ant_long-term'],
				$facet_4['what_data_does_your_organisation_tend_to_use'][0]['label'],
				$facet_4['what_gets_evaluated_in_your_organisation'][0]['label'],
				$facet_4['what_kind_of_tools_and_methods_does_your_organisation_tend_to_use_on_a_regular_basis'][0]['label'],
				'How does your organisation engage with technology?',
				$facet_4['how_does_your_organisation_engage_with_technology']['enh_the_organisations_looks_for_technology_options_that_could_make_existing_practises_more_efficient']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['enh_the_organisation_works_together_with_a_couple_of_big_technology_vendors_in_the_market']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['mis_the_organisation_looks_for_technologies_that_could_deliver_on_outcomes_in_new_ways']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['mis_the_organisations_does_not_have_preferred_technology_partners']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['ada_the_organisation_enables_small-scale_tests_of_different_technologies_based_on_employees_or_usersrecommendation']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['ada_the_organisation_tends_to_work_together_with_a_multitude_of_small_agile_development_teams_with_user-driven_design_skills']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['ant_the_organisation_tries_to_be_at_the_forefront_of_technological_developments']['label'],
				$facet_4['how_does_your_organisation_engage_with_technology']['ant_the_organisation_tends_to_work_with_early_to_the_market_technology_vendors_close_to_universities_and_other_basic_research_teams']['label'],
				$pmq_1['does_your_organisation_have_a_clear_understanding_of_innovation_and_why_it_is_needed']['label'],
				'How does your organisation create space for new things?',
				$pmq_1['how_does_your_organisation_create_space_for_new_things']['by_continuously_analysing_innovation_projects_and_emerging_needs']['label'],
				$pmq_1['how_does_your_organisation_create_space_for_new_things']['by_allowing_new_projects_to_appear_on_an_ad_hoc_basis']['label'],
				$pmq_1['is_there_an_individual_or_a_team_in_the_organisation_that_has_a_continuous_overview_of_different_projects_and_programmes_and_how_they_fit_together']['label'],
				$pmq_1['is_there_an_individual_or_team_in_the_organisation_tasked_with_making_recommendations_to_decision_makers_about_synergies_or_redundancies_between_different_projects_programmes_or_activities']['label'],
				'My organisation analyses the impact of all innovation projects at the same time and as a whole',
				$pmq_1['my _organisation_analyses_the_impact_of_all_innovation_projects_at_the_same_time_and_as_a_whole']['my _organisation_analyses_the_impact_of_all_innovation_projects_at_the_same_time_and_as_a_whole']['label'],
				'In my organisation...',
				$pmq_1['in_my_organisation']['there_is_a_clear understanding_of_how_different_types_of_innovation_contribute_to_the_organisation_as_a_whole_radical_incremental_bottom-up_impact-oriented']['label'],
				$pmq_1['in_my_organisation']['there_is_an_ability_to_tackle_multiple_strategic_initiatives_or_aims_at_the_same_time']['label'],
				$pmq_1['in_my_organisation']['we_analyse_and_work_on_long-term_goals_as_well_as_projects_that_need_to_be_delivered_quickly']['label'],
				$pmq_1['in_my_organisation']['we_comprehensively_analyse_different_aspects_of_problems_and_make_sense_of_the_environment_in_which_we_operate']['label'],
				$pmq_1['in_my_organisation']['units_learn_from_what_is_happening_in_other_areas_and_use_that_knowledge_for_their_own_work']['label'],
				'Do the following describe how projects and initiatives are funded in your organisation?',
				$pmq_1['do_the_following_describe_how_projects_and_initiatives_are_funded_in_your_organisation']['funding_decisions_take_into_account_long-term_considerations_and_investments']['label'],
				$pmq_1['do_the_following_describe_how_projects_and_initiatives_are_funded_in_your_organisation']['funding_is_provided_in_a_way_that_allows_for_flexibility_in_how_and_on_what_it_can_be_spent']['label'],
				$pmq_1['do_the_following_describe_how_projects_and_initiatives_are_funded_in_your_organisation']['funding_for_projects_takes_into_account_other_projects_occurring_across_the_organisation']['label'],
				$pmq_1['do_the_following_describe_how_projects_and_initiatives_are_funded_in_your_organisation']['funding_takes_into_account_value_contributed_by_external_actors']['label'],
				'In my organisation...',
				$pmq_1['in_my_organisation_2']['there_are_teams_that_use_different_working_methods']['label'],
				$pmq_1['in_my_organisation_2']['there_are_diverse_capabilities_and_skills']['label'],
				$pmq_1['in_my_organisation_2']['overall_organisational_strengths_and_weaknesses_are_known_by_most_people']['label'],
				$pmq_1['in_my_organisation_2']['people_are_suspicious_of_other_departments']['label'],
				$pmq_1['in_my_organisation_2']['there_is_little_or_no_conflict_between_the_departments']['label'],
				$pmq_1['in_my_organisation_2']['cooperation_between_the_departments_is_very_effective']['label'],
				$pmq_1['in_my_organisation_2']['there_is_little_or_no_respect_between_different_departments']['label'],
				$pmq_1['in_my_organisation_2']['people_are_unwilling_to_share_information_across_departments']['label'],
				$pmq_1['in_my_organisation_2']['it_is_common_to_work_with_external_stakeholders_towards_different_goals']['label'],
				$pmq_1['in_my_organisation_2']['teams_often_sources_ideas_from_external_stakeholders']['label'],
				$pmq_1['in_my_organisation_2']['teams_often_co-creates_solutions_with_external_stakeholders']['label'],
				$scores['mis_percentage'],
				$scores['enh_percentage'],
				$scores['ant_percentage'],
				$scores['ada_percentage'],
				'Your organisational portfolio tends to '.$scores['portfolio_tendency_statement'],
				$scores['pmq_score'],
				$scores['level'],
			);

			if( $module == 2 ) {
				array_push( $post_array,
					$projects_number,
					count( $scores['m2']['1-enh'] ),
					count( $scores['m2']['2-mis'] ),
					count( $scores['m2']['3-ant'] ),
					count( $scores['m2']['4-ada'] ),
					count( $scores['m2']['5-sus'] ),
			    count( $scores['m2']['6-tra'] ),
					count( $scores['m2']['7-dis'] ),
					count( $scores['m2']['8-opt'] ),
			    count( $scores['m2']['9-mix'] )
			  );
			}

			array_push( $post_array, get_permalink(get_the_ID()) );

			$csv_array[] = $post_array;
		} elseif ( $module == 2 && $csv_type == 'solo' ) {

			$general_questions = get_field('general_questions');
			$projects = get_field('projects');

			if( $projects ) {
				foreach ( $projects['projects_list'] as $project ) {
					// Calculate map location
					$q1 = $project['this_project_was_primarily_created_to:']['value'];
					$q2 = $project['the_project_has_been_mainly_pushed_forward_by:']['value'];
					if( $q1 == '0' ) {
						$map_location = 'Mixed or unclear';
					} elseif ( $q1 == '1' ) {
						if( $q2 == 'a' ) { $map_location = 'Sustaining change'; }
						if( $q2 == 'b' ) { $map_location = 'Enhancement-oriented'; }
						if( $q2 == 'c' ) { $map_location = 'Optimising change'; }
						if( $q2 == 'd' ) { $map_location = 'Mixed or unclear'; }
					} elseif ( $q1 == '2' ) {
						if( $q2 == 'a' ) { $map_location = 'Mission-oriented'; }
						if( $q2 == 'b' ) { $map_location = 'Sustaining change'; }
						if( $q2 == 'c' ) { $map_location = 'Mixed or unclear'; }
						if( $q2 == 'd' ) { $map_location = 'Transformative change'; }
					} elseif ( $q1 == '3' ) {
						if( $q2 == 'a' ) { $map_location = 'Transformative change'; }
						if( $q2 == 'b' ) { $map_location = 'Mixed or unclear'; }
						if( $q2 == 'c' ) { $map_location = 'Disruptive change'; }
						if( $q2 == 'd' ) { $map_location = 'Anticipatory'; }
					} elseif ( $q1 == '4' ) {
						if( $q2 == 'a' ) { $map_location = 'Mixed or unclear'; }
						if( $q2 == 'b' ) { $map_location = 'Optimising change'; }
						if( $q2 == 'c' ) { $map_location = 'Adaptive'; }
						if( $q2 == 'd' ) { $map_location = 'Disruptive change'; }
					}

					$post_array = array (
						get_the_ID(),
						get_the_author_meta('first_name'),
						get_the_author_meta('last_name'),
						get_the_date(),
						$general_questions['organisation'],
						$general_questions['n_people'],
						implode( ' | ', $general_questions['in_which_sector_or_topic_does_this_group_of_people_focus_its_work']),
						$general_questions['country']->name,
						$project['project_title'],
						$project['this_project_was_primarily_created_to:']['label'],
						$project['the_project_has_been_mainly_pushed_forward_by:']['label'],
						$project['what_level_of_priority_would_you_say_this_project_has_in_your_organisation']['label'],
						$map_location
					);

					$csv_array[] = $post_array;
				}
			}

		}
	}
}


// Restore original Post Data
wp_reset_postdata();

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="results.csv";');

// open the "output" stream
// see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
$f = fopen('php://output', 'w');

foreach ($csv_array as $line) {
	fputcsv($f, $line);
}
