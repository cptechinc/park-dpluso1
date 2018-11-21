<?php include('./_head.php'); // include header markup ?>
	<div class="jumbotron pagetitle">
		<div class="container">
			<?php if ($page == $page->rootParent) : ?>
				 <h1><?= $page->get('pagetitle|headline|title') ; ?></h1>
			<?php else : ?>
				 <h1><?= 'Docs: ' . $page->get('pagetitle|headline|title') ; ?></h1>
			<?php endif; ?>
		</div>
	</div>
	<div class="container page">
		<div class="col-sm-3">
			<?php generate_documentationmenu($page); ?>
		</div>
		<div class="col-sm-9">
			<ol class="breadcrumb">
				<?php $parents = $page->parents("template!=home"); ?>
				<?php foreach ($parents as $parent) : ?>
					<li><a href="<?php echo $parent->url; ?>"><?php echo $parent->title; ?></a></li>
				<?php endforeach; ?>
				<li class="active"><?php echo $page->title; ?></li>
			</ol>
		</div>
	</div>
<?php include('./_foot.php'); // include footer markup ?>
