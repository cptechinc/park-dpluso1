<table class="table table-bordered table-condensed table-striped">
    <tr>
        <th>Due</th> <th>Subtype</th> <th>Customer</th> <th>Regarding / Title</th> <th>View / Complete</th>
    </tr>
    <?php if (!$actionpanel->count_actions()) : ?>
        <tr>
            <td colspan="5">No related tasks found</td>
        </tr>
    <?php else: ?>
        <?php foreach ($actionpanel->get_actions() as $task) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($action); ?>">
                <td><?= $task->generate_duedatedisplay('m/d/Y'); ?></td>
                <td><?= ucfirst($task->generate_actionsubtypedescription()); ?></td>
                <td><?= $task->customerlink.' - '.Customer::get_customernamefromid($task->customerlink, '', false); ?></td>
                <td><?= $task->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($task); ?></td>
                <td><?= ($task->is_completed()) ? '' : $actionpanel->generate_completetasklink($task); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
