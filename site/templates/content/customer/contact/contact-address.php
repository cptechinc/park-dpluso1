<address>
	<?= $contact->addr1; ?><br>
    <?= (strlen($contact->addr2) > 0) ? $contact->addr2.'<br>' : ''; ?>
    <?= $contact->city . ', ' . $contact->state . ' ' . $contact->zip; ?>
</address>
