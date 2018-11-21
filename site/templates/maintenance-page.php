<?php 
    $returnpage = $input->get->returnpage ? $input->get->text('returnpage') : $config->pages->index;
    if (!$page->hasChildren('completed=0')) { // IF PAGE DOES NOT HAVE ANY CHILDREN THAT ARE UNCOMPLETE
        //$session->redirect("$returnpage");
    }
    include('./_head-blank.php');
?> 

<div class="jumbotron pagetitle">
    <div class="container">
        <h1><?= $page->get('pagetitle|headline|title') ; ?></h1>
    </div>
</div>
<div class="container page">
    <div class="well">
        <div class="row">
            <div class="col-sm-6">
                <div class="text-center">
                    <i class="fa fa-cogs fa-15x" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-6">
                <h2>We're Sorry</h2>
                <h4>Our site is temporarily down for maintenance. See below for tasks currently taking place.</h4>
            </div>
        </div>
    </div>
    
    <h3>Current Maintenance Schedule</h3>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <th>Event</th> <th>Description</th> <th>Start Time</th> <th>End Time</th>
        </thead>
        <?php $children = $page->children; ?>
        <?php foreach ($children as $child) : ?>
            <?php if ($child->completed == '0') : ?>
                <tr>
                    <td><?= $child->title; ?></td>
                    <td><?= $child->event_description; ?></td>
                    <td><?= $child->start; ?></td>
                    <td><?= $child->end; ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>        

<?php include('./_foot-blank.php') ?>
