<div class="docs">
    <h2>Documents</h2>
    <table class="table table-striped">
        <thead>
            <tr> <th>ItemID</th> <th>Document</th> <th>Date</th> <th>Time</th> </tr>
        </thead>
        <tbody>
        	<?php $documents = get_allorderdocs(session_id(), $ordn); ?>
            <?php foreach ($documents as $document) : ?>
				<tr>
					<td><?php echo $document['itemnbr']; ?></td>
	            	<td><a href="<?= $config->documentstorage.$document['pathname']; ?>" target="_blank"><?php echo $document['title']; ?></a></td>
	            	<td><?php echo $document['createdate']; ?></td>
	            	<td><?= $document['time']; ?></td>
				</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
