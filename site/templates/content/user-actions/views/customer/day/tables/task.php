<table class="table table-bordered table-condensed table-striped">
    <tr>
        <th>Due</th> <th>Subtype</th> <th>Regarding / Title</th> <th colspan="2">View / Complete</th>
    </tr>
    
    <?php if (strtotime($day) == strtotime(date('m/d/y')) && !empty($actionpanel->count_daypriorincompletetasks($day))) : ?>
        <tr>
            <td colspan="5" class="text-center h4">Prior Incomplete Tasks</td>
        </tr>
        <?php foreach ($actionpanel->get_daypriorincompletetasks($day) as $task) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($task); ?>">
                <td><?= $task->generate_duedatedisplay('m/d/Y'); ?></td>
                <td><?= ucfirst($task->generate_actionsubtypedescription()); ?></td>
                <td><?= $task->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($task); ?></td>
                <td><?= ($task->is_completed()) ? '' : $actionpanel->generate_completetasklink($task); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if ($actionpanel->count_daytasks($day)) : ?>
        <?php foreach ($actionpanel->get_daytasks($day) as $task) : ?>
            <tr class="<?= $actionpanel->generate_rowclass($task); ?>">
                <td><?= $task->generate_duedatedisplay('m/d/Y'); ?></td>
                <td><?= ucfirst($task->generate_actionsubtypedescription()); ?></td>
                <td><?= $task->generate_regardingdescription(); ?></td>
                <td><?= $actionpanel->generate_viewactionlink($task); ?></td>
                <td><?= ($task->is_completed()) ? '' : $actionpanel->generate_completetasklink($task); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="6" class="text-center h4">No tasks found for this day</td>
        </tr>
    <?php endif; ?>
</table>
