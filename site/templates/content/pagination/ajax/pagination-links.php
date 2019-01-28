<?php use Dplus\Content\Paginator; ?>

<nav class="text-center">
    <ul class="pagination">
        <?php if ($input->pageNum == 1) : ?>
            <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        <?php else : ?>
            <li>
                <a href="<? Paginator::paginate_url($ajax->link, ($input->pageNum - 1), $ajax->insertafterPaginator::paginate_url();  ?>" aria-label="Previous" class="load-link" <? $ajax->data; ?>>
                	<span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = ($input->pageNum - 3); $i < ($input->pageNum + 4); $i++) : ?>
            <?php if ($i > 0) : ?> 
				<?php if ($input->pageNum == $i) : ?>
					<li class="active">
						<a href="<? Paginator::paginate_url($ajax->link, $i, $ajax->insertafterPaginator::paginate_url();  ?>" class="load-link" <? $ajax->data; ?>><? $i; ?></a>
					</li>
				<?php elseif ($i > $totalpages) : ?>

				<?php else : ?>
					<li><a href="<? Paginator::paginate_url($ajax->link, $i, $ajax->insertafterPaginator::paginate_url();  ?>" class="load-link" <? $ajax->data; ?>><? $i; ?></a></li>
				<?php endif; ?>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($input->pageNum == $totalpages) : ?>
            <li class="disabled"> <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
        <?php else : ?>
            <li>
            	<a href="<? Paginator::paginate_url($ajax->link, ($input->pageNum + 1), $ajax->insertafterPaginator::paginate_url();  ?>" aria-label="Next" class="load-link" <? $ajax->data; ?>>
                	<span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
