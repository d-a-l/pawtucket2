<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_occurrences_exhibitions_html.php : 
 * EXHIBITIONS
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_item = 				$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
?>
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
			<div class="row">
<?php
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
?>
				<div class='col-sm-12 col-md-5'>
					<?php print $vs_representationViewer; ?>				
					<div id="detailAnnotations"></div>
<?php				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3"));
?>
				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "5" : "7"; ?>'>
					<div class="stoneBg">				
						<H4>{{{^ca_occurrences.preferred_labels.name}}}
							{{{<ifdef code="ca_occurrences.online_exhibition"><br/><unit delimiter="<br/>"><a href="^ca_occurrences.online_exhibition" class="redLink" target="_blank">View Online Exhibiton <span class="glyphicon glyphicon-new-window"></span></a></unit></ifdef>}}}
						</H4>
						{{{<ifdef code="ca_occurrences.occurrence_dates"><div class="unit">^ca_occurrences.occurrence_dates</div></ifdef>}}}
						
						{{{<ifcount code="ca_entities" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
						{{{<ifcount code="ca_entities" restrictToRelationshipTypes="institution" min="1"><div class="unit"><H6>Originating Institution<ifcount code="ca_entities" restrictToRelationshipTypes="institution" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="institution" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
						{{{<ifcount code="ca_entities" restrictToRelationshipTypes="curator" min="1"><div class="unit"><H6>Curator<ifcount code="ca_entities" restrictToRelationshipTypes="curator" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="curator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
						{{{<ifcount code="ca_objects" restrictToTypes="library" min="1"><div class="unit"><H6>Catalogue<ifcount code="ca_objects" restrictToTypes="library" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="library" delimiter=", "><l>^ca_objects.preferred_labels.name</l></unit></div></ifcount>}}}
						
						{{{<ifcount code="ca_places" min="1"><div class="unit"><H6>Location<ifcount code="ca_places" min="2">s</ifcount></H6><unit relativeTo="ca_places"><l>^ca_places.preferred_labels.name</l></unit></div></ifcount>}}}
						{{{<ifdef code="ca_occurrences.description_new.description_new_txt">
							<div class="unit" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_occurrences.description_new.description_new_source"><h6>Description</h6>
								<span class="trimText">^ca_occurrences.description_new.description_new_txt</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_occurrences.community_input_items.comments_objects">
							<div class='unit' data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_occurrences.community_input_items.comment_reference_objects"><h6>Dialogue</h6>
								<span class="trimText">^ca_occurrences.community_input_items.comments_objects</span>
							</div>
						</ifdef>}}}
					</div><!-- end stoneBg -->
					{{{<ifdef code="ca_occurrences.exhibition_type|ca_occurrences.venue|ca_occurrences.public_notes">
						<div class="collapseBlock">
							<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
							<div class="collapseContent">
								<ifdef code="ca_occurrences.exhibition_type"><div class='unit'><h6>Exhibition Type</h6>^ca_occurrences.exhibition_type</div></ifdef>							
								<ifdef code="ca_occurrences.venue"><div class='unit'><h6>Venue</h6><ifdef code="ca_occurrences.venue.venue_institution">^ca_occurrences.venue.venue_institution<br/></ifdef><ifdef code="ca_occurrences.venue.venue_institution">^ca_occurrences.venue.venue_dates<br/></ifdef><ifdef code="ca_occurrences.venue.venue_institution">^ca_occurrences.venue.venue_description<br/></ifdef></div></ifdef>
								<ifdef code="ca_occurrences.public_notes"><div class='unit'><h6>Notes</h6>^ca_occurrences.public_notes%delimiter=<br/></div></ifdef>
							</div>
						</div>
					</ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "2" : "5"; ?>'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools">';
					if ($this->getVar("resultsLink")) {
						print '<div class="detailTool detailToolInline">'.$this->getVar("resultsLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("previousLink")) {
						print '<div class="detailTool detailToolInline">'.$this->getVar("previousLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("nextLink")) {
						print '<div class="detailTool detailToolInline">'.$this->getVar("nextLink").'</div><!-- end detailTool -->';
					}

					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_occurrences", "row_id" => $t_item->get("occurrence_id")))."</div>";
					print '</div><!-- end detailTools -->';			

						if ($vn_comments_enabled) {
							$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
?>				
							<div class="collapseBlock last discussion">
								<h3>Discussion</H3>
								<div class="collapseContent open">
									<div id='detailDiscussion'>
										Do you have a story or comment to contribute?<br/>
<?php
										
										if($this->request->isLoggedIn()){
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_occurrences", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
										}else{
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment")."</button>";
										}
										if($vn_num_comments){
											print "<br/><br/><a href='#comments'>Read All Comments <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
										}
?>
									</div><!-- end itemComments -->
								</div>
							</div>
<?php				
						}
?>

<?php
					if($vs_map = $this->getVar("map")){
						print "<div class='unit'>".$vs_map."</div>";
					}
?>
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">
<?php
		include("related_tabbed_occ_html.php");
?>
					{{{<ifcount code="ca_objects.related" min="1">
						<div class="relatedBlock">
							<h3>Objects</H3>
							<div class="row" id="browseResultsContainer">
								<unit relativeTo="ca_objects.related" delimiter=" ">
									<div class="bResultItemCol col-xs-12 col-sm-6 col-md-3">
										<div class="bResultItem" onmouseover="jQuery("#bResultItemExpandedInfo^ca_objects.object_id").show();" onmouseout="jQuery("#bResultItemExpandedInfo^ca_objects.object_id").hide();">
											<div class="bResultItemContent"><div class="text-center bResultItemImg"><l>^ca_object_representations.media.medium</l></div>
												<div class="bResultItemText">
													<small><l>^ca_objects.preferred_labels.name</l></small>
												</div><!-- end bResultItemText -->
											</div><!-- end bResultItemContent -->
											<div class="bResultItemExpandedInfo" id="bResultItemExpandedInfo^ca_objects.object_id" style="display: none;">
											</div><!-- bResultItemExpandedInfo -->
										</div><!-- end bResultItem -->
									</div>
								</unit>
							</div>
						</div>
					</ifcount>}}}
<?php
					if($vn_num_comments){
?>
						<a name="comments"></a><div class="block">
							<h3>Discussion</H3>
							<div class="blockContent">
								<div id="detailComments">
<?php
								if(sizeof($va_comments)){
									print "<H2>Comments</H2>";
								}
								print $this->getVar("itemComments");
?>
								</div>
							</div>
						</div>
<?php
					}
?>				
			
					
				</div>
			</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 60
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 18
		});
		$('.trimTextSubjects').readmore({
		  speed: 75,
		  maxHeight: 80,
		  moreLink: '<a href="#" class="moreLess">More</a>',
		  lessLink: '<a href="#" class="moreLess">Less</a>'
		});
		
		$('[data-toggle="popover"]').popover();
		
		$('.collapseBlock h3').click(function() {
  			block = $(this).parent();
  			block.find('.collapseContent').toggle();
  			block.find('.fa').toggleClass("fa-toggle-down");
  			block.find('.fa').toggleClass("fa-toggle-up");
  			
		});
	});
</script>