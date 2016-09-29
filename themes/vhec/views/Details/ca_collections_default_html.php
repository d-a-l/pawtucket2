<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id = $t_item->get('ca_collections.collection_id');
	
	$vs_home = caNavLink($this->request, "Home", '', '', '', '');			
	$vs_title 	= caTruncateStringWithEllipsis($t_item->get('ca_collections.preferred_labels.name'), 60);	
	$vs_archives_link = caNavLink($this->request, 'Archives', '', '', 'Archives', 'Index');
	
	if ($t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true)) != "Fonds / Archival Collection") {
		$va_hierarchy_ids = $t_item->get('ca_collections.hierarchy.collection_id', array('returnAsArray' => true));
		$va_hierarchy_path = array();
		foreach ($va_hierarchy_ids as $va_key => $va_hierarchy_id) {
			$t_collection = new ca_collections($va_hierarchy_id);
			$va_hierarchy_path[] = caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_hierarchy_id); 
		}
		array_pop($va_hierarchy_path);
		$vs_hierarchy = " > ".join(' > ', $va_hierarchy_path);
	}

	if ($t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true)) == "Collection") {
		$breadcrumb_link = $vs_home." > ".$vs_title;
	} else {
		$breadcrumb_link = $vs_home." > ".$vs_archives_link.$vs_hierarchy." > ".$vs_title;
	}	
	
?>
<div class="row">
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="breadcrumb"><?php print $breadcrumb_link; ?></div>
		<div class="container">
			<div class="row">			
				<div class='col-sm-6 col-lg-6'>
				
					{{{representationViewer}}}
<?php
	
					$vs_access_point = "";				
					#Local Subject
					$va_local_subjects = $t_item->get('ca_collections.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
					if (sizeof($va_local_subjects) >= 1) {
						$vn_subject = 1;
						#$vs_access_point.= "<h9>Local Access Points </h9>";
						foreach ($va_local_subjects as $va_key => $va_local_subject) {
							if ($va_local_subject == '-') { continue; }
							if ($vn_subject > 3) {
								$vs_subject_style = "class='subjectHidden'";
							}
							$vs_access_point.= "<div {$vs_subject_style}>".caNavLink($this->request, $va_local_subject, '', '',  'Search', 'objects', array('search' => "ca_objects.local_subject:'".$va_local_subject."'"))."</div>";
						
							if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
								$vs_access_point.= "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
							}
							$vn_subject++;
						}
					}
					if ($vs_access_point != "") {
						print "<div class='subjectBlock'>";
						print "<h8 style='margin-bottom:10px;'>Access Points</h8>";
						print $vs_access_point;
						print "</div>";
					}
					
					$vs_rights = false;
					$vs_rights_text = "";
					if ($vs_conditions_access = $t_item->get('ca_collections.govAccess')) {
						$vs_rights = true;
						$vs_rights_text.= "<h8>Conditions on Access</h8>";
						$vs_rights_text.= "<div>".$vs_conditions_access."</div>";
					}		
					if ($vs_conditions_use = $t_item->get('ca_collections.RAD_useRepro')) {
						$vs_rights = true;
						$vs_rights_text.= "<h8>Conditions on Use</h8>";
						$vs_rights_text.= "<div>".$vs_conditions_use."</div>";
					}
					if ($vs_rights_reproduction = $t_item->get('ca_collections.RAD_usePub')) {
						$vs_rights = true;
						$vs_rights_text.= "<h8>Conditions on Reproduction and Publications </h8>";
						$vs_rights_text.= "<div>".$vs_rights_reproduction."</div>";
					}
					if ($vs_rights_statement = $t_item->get('ca_collections.rights_holder')) {
						$vs_rights = true;
						$vs_rights_text.= "<h8>Rights Holder</h8>";
						$vs_rights_text.= "<div>".$vs_rights_statement."</div>";
					}	
					if ($vs_licensing = caNavLink($this->request, 'Licensing', '', '', 'About', 'licensing')) {
						$vs_rights = true;
						$vs_rights_text.= "<div class='unit'><h8>".$vs_licensing."</h8></div>";
					}
							
					if ($vs_rights == true) {
						print "<div class='rightsBlock'>";
						print "<h8 style='margin-bottom:10px;'><a href='#' onclick='$(\"#rightsText\").toggle(300);return false;'>Rights <i class='fa fa-chevron-down'></i></a></h8>";
						print "<div style='display:none;' id='rightsText'>".$vs_rights_text."</div>";
						print "</div>";
					}					
?>				
					<div class='map'>{{{map}}}</div>
<?php


?>									
				</div><!-- end col -->
				<div class='col-sm-6 col-lg-6'>
<?php
					if ($t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => 'true')) == "Fonds / Archival Collection") {
						print caNavLink($this->request, 'Download <i class="fa fa-download"></i>', 'faDownload', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');
					}
?>								
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H5>{{{^ca_collections.type_id}}}</H5>
<?php	
					if ($va_identifier = $t_item->get('ca_collections.collection_identifier')) {
						print "<div class='unit'><h8>Identifier</h8>".$va_identifier."</div>";
					}
					if ($va_extent = $t_item->get('ca_collections.RAD_extent')) {
						print "<div class='unit'><h8>Extent & Medium</h8>".$va_extent."</div>";
					}
					if ($va_date = $t_item->get('ca_collections.displayDate', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h8>Date</h8>".$va_date."</div>";
					}	
					if ($va_creator = $t_item->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('creator'), 'returnAsLink' => true))) {
						print "<div class='unit'><h8>Creator</h8>".$va_creator."</div>";
					}
					if ($va_adminbio = $t_item->get('ca_collections.RAD_admin_hist')) {
						print "<div class='unit trimText'><h8>Administrative/Biographical History</h8>".$va_adminbio."</div>";
					}
					if ($va_scope = $t_item->get('ca_collections.ISADG_scope')) {
						print "<div class='unit trimText'><h8>Scope & Content</h8>".$va_scope."</div>"; 
					}
					if ($va_archival = $t_item->get('ca_collections.RAD_custodial')) {
						print "<div class='unit '><h8>Archival History</h8>".$va_archival."</div>";
					}
					if ($va_source = $t_item->get('ca_collections.ISADG_transfer')) {
						print "<div class='unit trimText'><h8>Immediate Source of Acquisition or Transfer</h8>".$va_source."</div>";
					}
					if ($va_accruals = $t_item->get('ca_collections.RAD_accruals')) {
						print "<div class='unit'><h8>Accruals</h8>".$va_accruals."</div>";
					}
					if ($va_language = $t_item->get('ca_collections.RAD_langMaterial', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h8>Language</h8>".$va_language."</div>";
					}
					if ($va_note = $t_item->get('ca_collections.RAD_generalNote')) {
						print "<div class='unit'><h8>Note</h8>".$va_note."</div>";
					}
					if ($va_arrangement = $t_item->get('ca_collections.RAD_arrangement')) {
						print "<div class='unit'><h8>System of Arrangement</h8>".$va_arrangement."</div>";
					}
					if ($va_physical_access = $t_item->get('ca_collections.MARC_physical_access')) {
						print "<div class='unit'><h8>Physical Access Provisions</h8>".$va_physical_access."</div>";
					}
					if ($va_rights = $t_item->get('ca_collections.dc_rights')) {
						print "<div class='unit'><h8>Rights</h8>".$va_rights."</div>";
					}
					if ($va_license = $t_item->get('ca_collections.dc_license')) {
						print "<div class='unit'><h8>License</h8>".$va_license."</div>";
					}
					if ($va_rules = $t_item->get('ca_collections.ISADG_rules')) {
						print "<div class='unit'><h8>Rules or Conventions</h8>".$va_rules."</div>";
					}
					if ($va_arch_note = $t_item->get('ca_collections.ISADG_archNote')) {
						print "<div class='unit'><h8>Archivist's Note</h8>".$va_arch_note."</div>";
					}
					if ($va_date_desc = $t_item->get('ca_collections.dateDescript')) { 
						print "<div class='unit'><h8>Date of Description</h8>".$va_date_desc."</div>";
					}					
/*																																																				
					if ($va_description = $t_item->get('ca_collections.description')) {
						print "<div class='unit'><h8>Description</h8>".$va_description."</div>";
					}
					if ($va_entities = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Entities</h8>".$va_entities."</div>";
					}
					if ($va_places = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_places"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Places</h8>".$va_places."</div>";
					}
					if ($va_collections = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_collections.related"><l>^ca_collections.preferred_labels</l></unit>')) {
						print "<div class='unit'><h8>Related Collections</h8>".$va_collections."</div>";
					}
					if ($va_events = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Events</h8>".$va_events."</div>";
					}
*/															
?>				
				</div><!-- end col -->
			</div><!-- end row -->
<hr>			
			<div class='row collLevels'>
				<div class='col-sm-12'>
<?php				

					if ($vn_top_level_id = $t_item->getHierarchyRootId()) {
						$vs_buf.= "<h4 style='margin-bottom:10px;'>Collection Contents</h4>";
						$t_top_collection = new ca_collections($vn_top_level_id);
						$qr_series_level = $t_top_collection->get('ca_collections.children.collection_id', array('returnAsSearchResult' => true, 'sort' => 'ca_collections.collection_identifier'));
						(($qr_series_level->numHits() > 0) ? $vs_class = "borderlevel" : $vs_class = "");						
						$vs_buf.= "<div class='colContents {$vs_class}'>";
						
						$vn_i = 0;
					
						( $vn_top_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");
						$vs_buf.= "<div>".(($qr_series_level->numHits() > 0) ? "<a href='#' onclick='$(\".seriesLevel".$vn_top_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i></a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_top_collection->get('ca_collections.preferred_labels')." (".$t_top_collection->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$vn_top_level_id)."</div>".($t_top_collection->get('ca_collections.ISADG_scope') ? "<div style='margin-left:20px;' class='trimText'>".$t_top_collection->get('ca_collections.ISADG_scope')."</div>" : "");
						$vs_buf.= "<div class='seriesLevel".$vn_top_level_id." ' >";
						
						while($qr_series_level->nextHit()) {
							$vn_series_level_id = $qr_series_level->get('ca_collections.collection_id');
							$qr_subseries_level = $qr_series_level->get('ca_collections.children.collection_id', array('returnAsSearchResult' => true, 'sort' => 'ca_collections.collection_identifier'));
							(($vn_series_level_id == $vn_id) ? $vs_highlight = "showme" : $vs_highlight = "");
							$vs_buf.= "<div>".(($qr_subseries_level && $qr_subseries_level->numHits() > 0) ? "&mdash;<a href='#' onclick='$(\".subseriesLevel".$vn_series_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i></a>" : "&mdash;<span class='colspacer'></span>").caNavLink($this->request, $qr_series_level->get('ca_collections.preferred_labels')." (".$qr_series_level->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$vn_series_level_id)."</div>";
							$vs_buf.= "<div class='subseriesLevel{$vn_series_level_id} borderlevel' style='margin-left:40px;'>";
		
							while($qr_subseries_level && $qr_subseries_level->nextHit()) {
								$vn_subseries_level_id = $qr_subseries_level->get('ca_collections.collection_id');
								
								$qr_box_level = $qr_subseries_level->get('ca_collections.children.collection_id', array("returnAsSearchResult" => true, 'sort' => 'ca_collections.collection_identifier'));
								( $vn_subseries_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");

								$vs_buf.= "<div>".($qr_box_level && ($qr_box_level->numHits() > 0) ? "&mdash;<a href='#' onclick='$(\".boxLevel".$vn_subseries_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i></a>" : "&mdash;<span class='colspacer'></span>").caNavLink($this->request, $qr_subseries_level->get('ca_collections.preferred_labels')." (".$qr_subseries_level->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$vn_subseries_level_id)."</div>";
								$vs_buf.= "<div class='boxLevel{$vn_subseries_level_id} borderlevel' style='margin-left:60px;'>";
						
								while($qr_box_level && $qr_box_level->nextHit()) {
									$vn_box_level_id = $qr_box_level->get('ca_collections.collection_id');
									( $vn_box_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");

									$vs_buf.= "<div>&mdash;".caNavLink($this->request, 'xx'.$qr_box_level->get('ca_collections.preferred_labels')." (".$qr_box_level->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$vn_box_level_id)."</div>";
								}
								$vs_buf.= "</div><!-- end boxlevel -->";
							}
							$vs_buf.= "</div><!-- end subseries -->";
						}
						$vs_buf.= "</div><!-- end series -->";
						$vs_buf.= "</div><!-- col Contents-->";
					}
					print $vs_buf;

					// $va_top_level_id = $t_item->getHierarchyRootId();
// 					if ($va_top_level_id) {
// 						$vs_buf.= "<h4 style='margin-bottom:10px;'>Collection Contents</h4>";
// 						$t_top_collection = new ca_collections($va_top_level_id);
// 						$va_series_level = $t_top_collection->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'sort' => 'ca_collections.collection_identifier'));
// 						(sizeof($va_series_level) > 0 ? $vs_class = "borderlevel" : $vs_class = "");						
// 						$vs_buf.= "<div class='colContents {$vs_class}'>";
// 						$vn_i = 0;
// 						#foreach($va_top_level as $vn_i => $va_top_level_id) {
// 							( $va_top_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");
// 							$vs_buf.= "<div>".(sizeof($va_series_level) > 0 ? "<a href='#' onclick='$(\".seriesLevel".$va_top_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i></a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_top_collection->get('ca_collections.preferred_labels')." (".$t_top_collection->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$va_top_level_id)."</div>".($t_top_collection->get('ca_collections.ISADG_scope') ? "<div style='margin-left:20px;' class='trimText'>".$t_top_collection->get('ca_collections.ISADG_scope')."</div>" : "");
// 							$vs_buf.= "<div class='seriesLevel".$va_top_level_id." ' >";
// 			
// 							foreach($va_series_level as $vn_i2 => $va_series_level_id) {
// 								$t_series_level = new ca_collections($va_series_level_id);
// 				
// 								#$va_subseries_level = $t_series_level->get('ca_collections.children.collection_id', array('returnAsArray' => true));
// 								$va_subseries_level = $t_series_level->getHierarchyChildren(null, array("idsOnly" => true, 'sort' => 'ca_collections.collection_identifier'));
// 								( $va_series_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");
// 								$vs_buf.= "<div>".(sizeof($va_subseries_level) > 0 ? "&mdash;<a href='#' onclick='$(\".subseriesLevel".$va_series_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i></a>" : "&mdash;<span class='colspacer'></span>").caNavLink($this->request, $t_series_level->get('ca_collections.preferred_labels')." (".$t_series_level->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$va_series_level_id)."</div>";
// 								$vs_buf.= "<div class='subseriesLevel".$va_series_level_id." borderlevel' style='margin-left:40px;'>";
// 				
// 								foreach($va_subseries_level as $vn_i3 => $va_subseries_level_id) {
// 									$t_subseries_level = new ca_collections($va_subseries_level_id);
// 									$va_box_levels = $t_subseries_level->getHierarchyChildren(null, array("idsOnly" => true, 'sort' => 'ca_collections.collection_identifier'));
// 									( $va_subseries_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");
// 
// 									$vs_buf.= "<div>".(sizeof($va_box_levels) > 0 ? "&mdash;<a href='#' onclick='$(\".boxLevel".$va_subseries_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i></a>" : "&mdash;<span class='colspacer'></span>").caNavLink($this->request, $t_subseries_level->get('ca_collections.preferred_labels')." (".$t_subseries_level->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$va_subseries_level_id)."</div>";
// 									$vs_buf.= "<div class='boxLevel".$va_subseries_level_id." borderlevel' style='margin-left:60px;'>";
// 									foreach ($va_box_levels as $vn_i4 => $va_box_level_id) {
// 										$t_box_level = new ca_collections($va_box_level_id);
// 										( $va_box_level_id == $vn_id ? $vs_highlight = "showme" : $vs_highlight = "");
// 
// 										$vs_buf.= "<div>&mdash;".caNavLink($this->request, $t_box_level->get('ca_collections.preferred_labels')." (".$t_box_level->get('ca_collections.collection_identifier').") ", $vs_highlight, '', 'Detail', 'collections/'.$va_box_level_id)."</div>";
// 									}
// 									$vs_buf.= "</div><!-- end boxlevel -->";
// 								}
// 				
// 								$vs_buf.= "</div><!-- end subseries -->";
// 							}
// 							$vs_buf.= "</div><!-- end series -->";
// 						#}
// 						$vs_buf.= "</div><!-- col Contents-->";
// 					}
// 					print $vs_buf;
?>									
				</div>		
			</div>
			<hr>
			
			
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div class="col-sm-12"><h4 style='font-size:16px;'>Items</h4></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print "Loading..."; ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load(
						"<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>", 
						{'search': 'ca_collection_labels.collection_id/part_of:^ca_collections.collection_id'}, 
					function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print "Loading..."; ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next' 
						});
					});
					
					
				});
			</script>

</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'> 
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					$('.trimText').readmore({
					  speed: 75,
					  maxHeight: 97
					});
				});
			</script>
