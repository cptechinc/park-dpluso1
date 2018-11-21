<table class="table table-bordered table-condensed table-striped">
    <tr>
        <th>Due</th> <th>Type</th> <th>Subtype</th> <th>Regarding / Title</th> <th>View</th>
    </tr>
    <?php if (!$actionpanel->count_actions()) : ?>
        <tr>
            <td colspan="6">No related actions found</td>
        </tr>
    <?php else: ?>
        <?php foreach ($actionpanel->get_actions() as $action) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($action); ?>">
                <td><?= $action->generate_duedatedisplay('m/d/Y'); ?></td>
                <td><?= $action->actiontype; ?></td>
                <td><?= $action->generate_actionsubtypedescription(); ?></td>
                <td><?= $action->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($action); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
