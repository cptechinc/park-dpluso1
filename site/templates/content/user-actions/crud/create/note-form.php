<?php
	$editactiondisplay = new Dplus\Dpluso\UserActions\EditUserActionsDisplay($page->fullURL);
	$note->set('actiontype', 'note');
?>
<form action="<?= $config->pages->useractions."add/"; ?>" method="POST" id="new-action-form" data-refresh="#actions-panel" data-modal="#ajax-modal">
    <input type="hidden" name="action" value="create-note">
    <input type="hidden" name="customerlink" value="<?= $note->customerlink; ?>">
    <input type="hidden" name="shiptolink" value="<?= $note->shiptolink; ?>">
    <input type="hidden" name="contactlink" value="<?= $note->contactlink; ?>">
    <input type="hidden" name="salesorderlink" value="<?= $note->salesorderlink; ?>">
    <input type="hidden" name="quotelink" value="<?= $note->quotelink; ?>">
    <input type="hidden" name="actionlink" value="<?= $note->id; ?>">
    <div class="response"></div>
    <table class="table table-bordered table-striped">
        <tr>  <td class="control-label">Note Date:</td> <td><?= date('m/d/Y g:i A'); ?></td> </tr>
        <tr>
            <td class="control-label">Assigned To:</td>
            <td>
                <?= $editactiondisplay->generate_selectsalesperson($note->assignedto); ?>
            </td>
        </tr>
        <?php include $config->paths->content."common/show-linked-table-rows.php"; ?>
        <tr>
            <td class="control-label">Note Type <br><small>(Click to choose)</small></td>
            <td>
                <?= $editactiondisplay->generate_selectsubtype($note); ?>
            </td>
        </tr>
        <tr>
            <td class="control-label">Title</td>
            <td>
                <input type="text" name="title" class="form-control">
            </td>
        </tr>
        <tr>
            <td colspan="2" class="control-label">
                <label for="" class="control-label">Notes</label>
                <textarea name="textbody" id="note" cols="30" rows="10" class="form-control note required"> </textarea> <br>
                <button type="submit" class="btn btn-success">Create Note</button>
            </td>
        </tr>
    </table>
</form>
