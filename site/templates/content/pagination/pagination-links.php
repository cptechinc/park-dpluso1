<nav class="text-center">
    <ul class="pagination">
        <?php if ($input->pageNum() == 1) : ?>
            <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        <?php else : ?>
            <li><a href="<?php echo $pagination_link.($input->pageNum() - 1); ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i < $total_pages + 1; $i++) : ?>
            <?php if ($input->pageNum() == $i) : ?>
                <li class="disabled"><a href="<?php echo $pagination_link.$i; ?>"><?php echo $i; ?></a></li>
            <?php else : ?>
                <li><a href="<?php echo $pagination_link.$i; ?>"><?php echo $i; ?></a></li>
            <?php endif; ?>      
        <?php endfor; ?>
    
        <?php if ($input->pageNum() == $total_pages) : ?>
            <li class="disabled"> <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
        <?php else : ?>
            <li> <a href="<?php echo $pagination_link.($input->pageNum() + 1); ?>" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
        <?php endif; ?>
    </ul>
</nav>