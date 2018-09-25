<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
		#print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row tileLinks">
		<div class="col-sm-4">
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, 'paper_1958_Frankenthaler_Untitled_copy0.jpg'), "", "", "Browse", "artworks");
			print "<br/>".caNavLink($this->request, "Artworks", "", "", "Browse", "artworks");
?>
		</div><!--end col-sm-4-->
		<div class="col-sm-4">
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, 'frankenthaler_archival.jpg'), "", "", "Browse", "archival");
			print "<br/>".caNavLink($this->request, "Archival Items", "", "", "Browse", "archival");
?>
		</div> <!--end col-sm-4-->
		<div class="col-sm-4">
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, '1969_Kongresshalle_Berlin.jpg'), "", "", "Browse", "exhibitions");
			print "<br/>".caNavLink($this->request, "Exhibitions", "", "", "Browse", "exhibitions");
?>			
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
	<div class="row tileLinks">
		<div class="col-sm-12">
			<H1>{{{home_page_tagline}}}</H1>
		</div>
	</div>
<?php
		print $this->render("Front/gallery_slideshow_html.php");
?>