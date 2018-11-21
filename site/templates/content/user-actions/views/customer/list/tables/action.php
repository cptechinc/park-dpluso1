<table class="table table-bordered table-condensed table-striped">
    <tr>
        <th>Date / Time</th> <th>Subtype</th> <th>Regarding / Title</th> <th>View</th>
    </tr>
    <?php if (!$actionpanel->count_actions()) : ?>
        <tr>
            <td colspan="5">No related actions found</td>
        </tr>
    <?php else: ?>
        <?php foreach ($actionpanel->get_actions() as $action) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($action); ?>">
                <td><?= date('m/d/Y g:i A', strtotime($action->datecreated)); ?></td>
                <td><?= ucfirst($action->generate_actionsubtypedescription()); ?></td>
                <td><?= $action->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($action); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
