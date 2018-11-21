<?php include('./_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
    <div class="container page">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id=reports-list>
                <thead>
                    <tr>
                        <td>Report / Menu</td>
                        <td>Desc</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($page->children as $report) : ?>
                        <tr>
                            <td><a href="<?= $report->url; ?>"><?= $report->title; ?></a></td>
                            <td><?= $report->description; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include('./_foot.php'); // include footer markup ?>
