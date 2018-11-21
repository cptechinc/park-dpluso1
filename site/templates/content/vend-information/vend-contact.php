<?php
	$contactfile = $config->jsonfilepath.session_id()."-vicontact.json";
	// $contactfile = $config->jsonfilepath."vicontv-vicontact.json";

	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

	if (file_exists($contactfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$contactjson = json_decode(file_get_contents($contactfile), true);
		$contactjson = $contactjson ? $contactjson : array('error' => true, 'errormsg' => 'The Vendor Contacts JSON contains errors. JSON ERROR: '.json_last_error());

		if ($contactjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $contactjson['errormsg']);
		} else {
			$vendorleftcolumns = array_keys($contactjson['columns']['vendor']['vendorleft']);
			$vendorrightcolumns = array_keys($contactjson['columns']['vendor']['vendorright']);
			if (isset($contactjson['columns']['contact'])) {
				$contactcolumns = array_keys($contactjson['columns']['contact']);
			} else {
				$contactcolumns = false;
			}

			if (!empty($contactjson['data']['shipfm'])) {
				$shipfmleftcolumns = array_keys($contactjson['columns']['shipfm']['shipfmleft']);
				$shipfmrightcolumns = array_keys($contactjson['columns']['shipfm']['shipfmright']);
			}

			if (isset($contactjson['columns']['forms']))  {
				$formscolumns = array_keys($contactjson['columns']['forms']);
			}

			if (sizeof($contactjson['data']) > 0) {
				echo '<div class="row">';
					echo '<div class="col-sm-6">';
						$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
						foreach ($vendorleftcolumns as $column) {
							$tb->tr();
							$tb->td('class='.$config->textjustify[$contactjson['columns']['vendor']['vendorleft'][$column]['headingjustify']], $contactjson['columns']['vendor']['vendorleft'][$column]['heading']);
							$tb->td('class='.$config->textjustify[$contactjson['columns']['vendor']['vendorleft'][$column]['datajustify']], $contactjson['data']['vendor']['vendorleft'][$column]);
						}
						echo $tb->close();
					echo '</div>';

					echo '<div class="col-sm-6">';
						$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
						foreach ($vendorrightcolumns as $column) {
							$tb->tr();
							$tb->td('class='.$config->textjustify[$contactjson['columns']['vendor']['vendorright'][$column]['headingjustify']], $contactjson['columns']['vendor']['vendorright'][$column]['heading']);
							$tb->td('class='.$config->textjustify[$contactjson['columns']['vendor']['vendorright'][$column]['headingjustify']], $contactjson['data']['vendor']['vendorright'][$column]);
						}
						echo $tb->close();
					echo '</div>';
				echo '</div>';
				echo '<hr>';

				if (!empty($contactjson['data']['shipfm'])) {
					echo '<h2>Ship-To Contact Info</h2>';
					foreach ($contactjson['data']['shipfm'] as $shipfm) {
						echo '<h4>'.$shipfm['shipfmid'].' - '.$shipfm['shipfmname'].'</h4>';
						foreach ($shipfm['shipfmcontacts'] as $contact) {
							echo '<div class="row">';
								echo '<div class="col-sm-6">';
									$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
									foreach ($shipfmleftcolumns as $column) {
										$tb->tr();
										$tb->td('class='.$config->textjustify[$contactjson['columns']['shipfm']['shipfmleft'][$column]['headingjustify']], $contactjson['columns']['shipfm']['shipfmleft'][$column]['heading']);
										$tb->td('class='.$config->textjustify[$contactjson['columns']['shipfm']['shipfmleft'][$column]['datajustify']], $contact['shipfmleft'][$column]);
									}
									echo $tb->close();
								echo '</div>';

								echo '<div class="col-sm-6">';
									$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
									foreach ($shipfmrightcolumns as $column) {
										$tb->tr();
										$tb->td('class='.$config->textjustify[$contactjson['columns']['shipfm']['shipfmright'][$column]['headingjustify']], $contactjson['columns']['shipfm']['shipfmright'][$column]['heading']);
										$tb->td('class='.$config->textjustify[$contactjson['columns']['shipfm']['shipfmright'][$column]['datajustify']], $contact['shipfmright'][$column]);
									}
									echo $tb->close();
								echo '</div>';
							echo '</div>';
						}
					}
				}

				echo '<h2>Vendor Contact Info</h2>';
				if (isset($contactjson['data']['contact'])) {
					$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
						$tb->tablesection('thead');
						$tb->tr();
							foreach ($contactcolumns as $column) {
								$tb->th('class='.$config->textjustify[$contactjson['columns']['contact'][$column]['headingjustify']], $contactjson['columns']['contact'][$column]['heading']);
							}
						$tb->closetablesection('thead');
						$tb->tablesection('tbody');
							foreach ($contactjson['data']['contact'] as $contact) {
								$tb->tr();
								$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactname']['datajustify']], $contact['contactname']);
								$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactemail']['datajustify']], $contact['contactemail']);
								if (isset($contact['contactnumbers']["1"]['contactnbr'])) {
									$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactnbr']['datajustify']], $contact['contactnumbers']["1"]['contactnbr']);
								} else {
									$tb->td();
								}
								for ($i = 1; $i < sizeof($contact['contactnumbers']) + 1; $i++) {
									if ($i != 1) {
										$tb->tr();
										$tb->td();
										$tb->td();
										$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactnbr']['datajustify']], $contact['contactnumbers']["$i"]['contactnbr']);
									}
								}
							}
						$tb->closetablesection('tbody');
					echo $tb->close();
				} else {
					echo '<p>No Contacts Found</p>';
				}

				if (isset($contactjson['columns']['forms'])) {
					echo '<h2>Forms Information</h2>';
					$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
						$tb->tablesection('thead');
							$tb->tr();
							foreach ($formscolumns as $column) {
								$tb->th('class='.$config->textjustify[$contactjson['columns']['forms'][$column]['headingjustify']], $contactjson['columns']['forms'][$column]['heading']);
							}
						$tb->closetablesection('thead');
						$tb->tablesection('tbody');
							foreach ($contactjson['data']['forms'] as $form) {
								$tb->tr();
								foreach ($formscolumns as $column) {
									$tb->th('class='.$config->textjustify[$contactjson['columns']['forms'][$column]['datajustify']], $form[$column]);
								}
							}
						$tb->closetablesection('tbody');
					echo $tb->close();
				}
			} else {
				echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
			} // END if (sizeof($contactjson['data']) > 0)
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Vendor has no Contacts');
	}
?>
