<nav class="text-center">
    <ul class="pagination">
        <?php if ($input->pageNum() == 1) : ?>
            <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        <?php else : ?>
            <li><a href="<?php echo paginate($config->filename, ($input->pageNum() - 1), $insertafter, '');  ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i < ($input->pageNum() + 5); $i++) : ?>
            <?php if ($input->pageNum() == $i) : ?>
                <li class="active"><a href="<?php echo paginate($config->filename, $i, $insertafter, '');  ?>"><?php echo $i; ?></a></li>
            <?php elseif ($i > $total_pages) : ?>
            
            <?php else : ?>
                <li><a href="<?php echo paginate($config->filename, $i, $insertafter, '');  ?>"><?php echo $i; ?></a></li>
            <?php endif; ?>      
        <?php endfor; ?>
    
        <?php if ($input->pageNum()== $total_pages) : ?>
            <li class="disabled"> <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
        <?php else : ?>
            <li> <a href="<?php echo paginate($config->filename, ($input->pageNum() + 1), $insertafter, '');  ?>" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
        <?php endif; ?>
    </ul>
</nav>