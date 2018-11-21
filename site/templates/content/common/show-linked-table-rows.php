<?php if (!empty($custID)) : ?>
    <tr> <td>Customer:</td> <td><?= Customer::get_customernamefromid($custID)." ($custID)"; ?></td> </tr>
<?php endif; ?>

<?php if (!empty($shipID)) : ?>
    <tr> <td>Ship-to:</td> <td><?= Customer::get_customernamefromid($custID, $shipID). " ($shipID)"; ?></td>  </tr>
<?php endif; ?>

<?php if (!empty($contactID)) : ?>
    <tr> <td>Contact:</td> <td><?= $contactID; ?></td>  </tr>
<?php endif; ?>

<?php if (!empty($ordn)) : ?>
    <tr> <td>Sales Order #:</td> <td><?= $ordn; ?></td>  </tr>
<?php endif; ?>

<?php if (!empty($qnbr)) : ?>
    <tr> <td>Quote #:</td> <td><?= $qnbr; ?></td>  </tr>
<?php endif; ?>
