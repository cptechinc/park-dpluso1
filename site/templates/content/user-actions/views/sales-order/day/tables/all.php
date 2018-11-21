<table class="table table-bordered table-condensed table-striped">
    <tr>
        <th>Due</th> <th>Type</th> <th>Subtype</th> <th>Customer</th> <th>Regarding / Title</th> <th>View</th>
    </tr>

    <?php if (strtotime($day) == strtotime(date('m/d/y')) && !empty($actionpanel->count_daypriorincompletetasks($day))) : ?>
        <tr>
            <td colspan="6" class="text-center h4">Prior Incomplete Tasks</td>
        </tr>
        <?php foreach ($actionpanel->get_daypriorincompletetasks($day) as $action) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($action); ?>">
                <td><?= $action->generate_duedatedisplay('m/d/Y'); ?></td>
                <td><?= $action->actiontype; ?></td>
                <td><?= $action->generate_actionsubtypedescription(); ?></td>
                <td><?= $action->customerlink.' - '.Customer::get_customernamefromid($action->customerlink, '', false); ?></td>
                <td><?= $action->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($action); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($actionpanel->count_dayallactions($day)) : ?>
        <?php foreach ($actionpanel->get_dayallactions($day) as $action) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($action); ?>">
                <td><?= $action->generate_duedatedisplay('m/d/Y'); ?></td>
                <td><?= $action->actiontype; ?></td>
                <td><?= $action->generate_actionsubtypedescription(); ?></td>
                <td><?= $action->customerlink.' - '.Customer::get_customernamefromid($action->customerlink, '', false); ?></td>
                <td><?= $action->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($action); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="6" class="text-center h4">Today's Actions</td>
        </tr>
        <tr>
            <td colspan="6" class="text-center h4">No actions found for this day</td>
        </tr>
    <?php endif; ?>
</table>
