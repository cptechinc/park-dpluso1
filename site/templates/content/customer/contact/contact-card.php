<?php
    $editpage = new \Purl\Url($page->fullURL->getUrl());
    $editpage->path->remove(6);
    $editpage->path->add('edit');
?>
<h2 class="page-header">
    <?= $page->title; ?>
</h2>
<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped table-user-information">
            <tbody>
                <tr>
                    <td>Customer:</td>
                    <td>
                        <a href="<?= $contact->generate_customerURL(); ?>" target="_blank">
                            <?= $contact->custid. ' - '. $contact->name ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
    			<?php if ($contact->has_shipto()) : ?>
                    <tr>
                        <td>Shipto ID:</td>
                        <td><a href="<?= $contact->generate_shiptourl(); ?>" target="_blank"><?= $contact->shiptoid; ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></a></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td>
                        <strong>
                            <?= $contact->addr1; ?><br>
                            <?= (strlen($contact->addr2) > 0) ? $contact->addr2.'<br>' : ''; ?>
                            <?= $contact->city . ', ' . $contact->state . ' ' . $contact->zip; ?>
                        </strong>
                    </td>
                </tr>
                <tr> <td>Name:</td> <td><?= $contact->contact; ?></td> </tr>
                <tr> <td>Title:</td><td><?= $contact->title; ?></td> </tr>
                <tr> <td>Email:</td> <td><a href="mailto:<?php echo $contact->email; ?>"><?php echo $contact->email; ?></a></td></tr>
                <tr>
                    <td>Office Phone:</td>
                    <td>
                        <a href="tel:<?= $contact->phone; ?>"><?= $page->stringerbell->format_phone($contact->phone); ?></a><b> &nbsp;
                        <?php if ($contact->has_extension()) { echo 'Ext. ' . $contact->extension;} ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Cell Phone:</td> <td><a href="tel:<?= $contact->cellphone; ?>"> <?= $page->stringerbell->format_phone($contact->cellphone); ?></a></td>
                </tr>
                <tr> <td>Fax:</td> <td><a href="tel:<?= $contact->cellphone; ?>"> <?= $page->stringerbell->format_phone($contact->faxnbr); ?></a></td> </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table table-striped table-user-information">
            <tbody>
                <tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
        			<td class="control-label">AR Contact</td>
        			<td>
                        <?= array_flip($config->yesnoarray)[$contact->arcontact]; ?>
        			</td>
        		</tr>
                <tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
        			<td class="control-label">Dunning Contact</td>
        			<td>
                        <?= array_flip($config->yesnoarray)[$contact->dunningcontact]; ?>
        			</td>
        		</tr>
                <tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
        			<td class="control-label">Acknowledgement Contact</td>
        			<td>
                        <?= array_flip($config->yesnoarray)[$contact->ackcontact]; ?>
        			</td>
        		</tr>
        		<tr>
        			<td class="control-label">Buying Contact</td>
        			<td>
                        <?= $config->buyertypes[$contact->buyingcontact]; ?>
        			</td>
        		</tr>
        		<tr>
        			<?php if ($config->cptechcustomer == 'stat') : ?>
        				<td class="control-label">End User</td>
        			<?php else : ?>
        				<td class="control-label">Certificate Contact</td>
        			<?php endif; ?>
        			<td>
                        <?= array_flip($config->yesnoarray)[$contact->certcontact]; ?>
        			</td>
        		</tr>
            </tbody>
        </table>
    </div>
</div>
<a href="<?= $editpage->getUrl(); ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit Contact</a>
