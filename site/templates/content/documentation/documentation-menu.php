
<?php
	$parents = $page->parents;
	$section = $parents[2];
	
		// if there's more than 1 page in this section...
		if($section->hasChildren) {
			
			// output sidebar navigation
			// see _init.php for the renderNavTree function
			renderNavTree($section);
		}

?>
