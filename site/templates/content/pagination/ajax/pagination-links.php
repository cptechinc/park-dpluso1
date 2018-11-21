<nav class="text-center">
    <ul class="pagination">
        <?php if ($input->pageNum == 1) : ?>
            <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        <?php else : ?>
            <li>
                <a href="<?php echo paginate($ajax->link, ($input->pageNum - 1), $ajax->insertafter, '');  ?>" aria-label="Previous" class="load-link" <?php echo $ajax->data; ?>>
                	<span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = ($input->pageNum - 3); $i < ($input->pageNum + 4); $i++) : ?>
            <?php if ($i > 0) : ?> 
				<?php if ($input->pageNum == $i) : ?>
					<li class="active">
						<a href="<?php echo paginate($ajax->link, $i, $ajax->insertafter, '');  ?>" class="load-link" <?php echo $ajax->data; ?>><?php echo $i; ?></a>
					</li>
				<?php elseif ($i > $totalpages) : ?>

				<?php else : ?>
					<li><a href="<?php echo paginate($ajax->link, $i, $ajax->insertafter, '');  ?>" class="load-link" <?php echo $ajax->data; ?>><?php echo $i; ?></a></li>
				<?php endif; ?>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($input->pageNum == $totalpages) : ?>
            <li class="disabled"> <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
        <?php else : ?>
            <li>
            	<a href="<?php echo paginate($ajax->link, ($input->pageNum + 1), $ajax->insertafter, '');  ?>" aria-label="Next" class="load-link" <?php echo $ajax->data; ?>>
                	<span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
