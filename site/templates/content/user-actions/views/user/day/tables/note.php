<table class="table table-bordered table-condensed table-striped">
    <tr>
        <th>Date / Time</th> <th>Subtype</th> <th>Customer</th> <th>Regarding / Title</th> <th>View</th>
    </tr>
    <?php if (!$actionpanel->count_daynotes($day)) : ?>
        <tr>
            <td colspan="6" class="text-center h4">No notes found for this day</td>
        </tr>
    <?php else : ?>
        <?php foreach ($actionpanel->get_daynotes($day) as $note) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($note); ?>">
                <td><?= date('m/d/Y g:i A', strtotime($note->datecreated)); ?></td>
                <td><?= ucfirst($note->generate_actionsubtypedescription()); ?></td>
                <td><?= $note->customerlink.' - '.Customer::get_customernamefromid($note->customerlink, '', false); ?></td>
                <td><?= $note->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($note); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
