<?php 
    $formtype = $page->parent->name;
    $formconfig = new FormFieldsConfig($formtype);
    $datetypes = array('m/d/y' => 'MM/DD/YY', 'm/d/Y' => 'MM/DD/YYYY', 'm/d' => 'MM/DD', 'm/Y' => 'MM/YYYY')
?>

<div class="page container">
    <ol class="breadcrumb">
        <li><a href="<?= $page->parent->url; ?>"><?= $page->parent->title; ?></a></li>
        <li class="active"><?= $page->title; ?></li>
    </ol>

    <div class="formatter-response">
        <div class="message"></div>
    </div>

    <form action="<?= $page->fullURL; ?>" method="POST" class="" id="">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="formtype" value="<?= $formtype; ?>">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><?php echo $page->title; ?></h3> </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="formatter-container">
                        <table class="table table-striped table-bordered table-condensed table-sm">
                        	<thead>
                        		<tr> 
                                    <th>Field</th> 
                                    <th>Field Definition</th> 
                                    <th>Label</th>
                                    <th>Required?</th> 
                                </tr>
                        	</thead>
                        	<?php foreach ($formconfig->fields['fields'] as $key => $field) : ?>
                        		<tr>
                        			<td class="field"><?= $key; ?></td>
                        			<td>
                                        <?php if ($field['datatype'] == 'D') : ?>
                                            <select class="form-control input-sm" name="<?= $name."-date-format";?>">
                        						<?php foreach ($datetypes as $datetype => $value) : ?>
                        							<?php if ($datetype == $field['date-format']) : ?>
                        								<option value="<?= $datetype; ?>" selected><?= $value . ' - '. date($datetype); ?></option>
                        							<?php else : ?>
                        								<option value="<?= $datetype; ?>"><?= $value . ' - '. date($datetype); ?></option>
                        							<?php endif; ?>
                        						<?php endforeach; ?>
                        					</select>
                        				<?php elseif ($field['datatype'] == 'I') : ?>
                        					Integer
                        				<?php elseif ($field['datatype'] == 'C') : ?>
                        					Text
                        				<?php elseif ($field['datatype'] == 'N') : ?>
                        					<div>
                        						Before Decimal &nbsp;
                        						<input type="text" class="form-control inline input-sm qty-sm before-decimal" name="<?php echo $key.'-before-decimal'; ?>" value="<?= $field['before-decimal']; ?>"> &nbsp; &nbsp;
                        						After Decimal &nbsp;  
                        						<input type="text" class="form-control inline input-sm qty-sm after-decimal" name="<?php echo $key.'-after-decimal'; ?>" value="<?= $field['after-decimal']; ?>">
                        					</div>
                        				<?php endif; ?>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm col-label" type="text" name="<?php echo $key.'-label'; ?>" value="<?= $field['label']; ?>">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="<?php echo $key.'-required'; ?>" class="check-toggle" data-size="small" data-width="73px" value="Y" <?php echo $formconfig->generate_showrequired($key); ?>>
                                    </td>
                        		</tr>
                        	<?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save Configuration</button>
    </form>
</div>      
