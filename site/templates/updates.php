<?php 
    $template = 'warehouse-function';
    $binrpage = $pages->get('/warehouse/binr/');
    $binrpage->of(false);
    $binrpage->dplusfunction = 'binr';
    
    $binr_pages = array(
        'binr' => array(
            'name' => 'binr',
            'title' => 'Bin Reassignment',
            'summary' => 'Move Bin Item',
            'function' => 'binr'
        ),
        'move-from' => array(
            'name' => 'move-from',
            'title' => 'Move From',
            'summary' => 'Move Single items from same from bin',
            'function' => 'binr'
        ),
        'move-to' => array(
            'name' => 'move-to',
            'title' => 'Move To',
            'summary' => 'Move Single Items to the same to bin',
            'function' => 'binr'
        ),
        'move-bin-contents' => array(
            'name' => 'move-bin-contents',
            'title' => 'Move Bin Contents',
            'summary' => 'Move all Bin Items',
            'function' => 'binr'
        )
    );
    
    foreach ($binr_pages as $pagename => $page) {
        if (!$binrpage->numChildren("name=$pagename")) {
            $p = new Page();
            $p->template = $template; // set template
            $p->parent = $binrpage;
            $p->name = $page['name']; // give it a name used in the url for the page
            $p->title = $page['title']; // set page title (not neccessary but recommended)
            $p->summary = $page['summary'];
            $p->dplusfunction = $page['function'];
            $p->save();
        } else {
            $p = $binrpage->child("name=$pagename");
            $p->of(false);
            $p->title = $page['title'];
            $p->summary = $page['summary'];
            $p->dplusfunction = $page['function'];
            $p->save();
        }
    }
    
    $inventorypage = $pages->get('/warehouse/inventory/');
    $inventorypage->of(false);
    $inventorypage->dplusfunction = 'wm';
    
    $inventory_pages = array(
        'physical-count' => array(
            'name' => 'physical-count',
            'title' => 'Physical Count',
            'summary' => 'Update Inventory with Item Tag Entry',
            'function' => 'ite'
        ),
        'find-item' => array(
            'name' => 'find-item',
            'title' => 'Find Item',
            'summary' => 'Find Location(s) for an Item',
            'function' => 'wm'
        ),
        'bin-inquiry' => array(
            'name' => 'bin-inquiry',
            'title' => 'Bin Inquiry',
            'summary' => 'Show Items that are in a bin',
            'function' => 'wm'
        )
    );
    
    foreach ($inventory_pages as $pagename => $page) {
        if ($inventorypage->numChildren("name=$pagename")) {
            $p = $inventorypage->child("name=$pagename");
            $p->of(false);
            $p->title = $page['title'];
            $p->summary = $page['summary'];
            $p->dplusfunction = $page['function'];
            $p->save();
        }
    }
    
    $pickingpage = $pages->get('/warehouse/picking/');
    $pickingpage->of(false);
    $pickingpage->dplusfunction = 'wm';
    
    $picking_pages = array(
        'pick-order' => array(
            'name' => 'pick-order',
            'title' => 'Sales Order Picking',
            'summary' => 'Pick Items for a Sales Order',
            'function' => 'wm'
        ),
        'pick-pack' => array(
            'name' => 'pick-pack',
            'title' => 'Sales Order Picking & Packing',
            'summary' => 'Pick & Pack Items for a Sales Order',
            'function' => 'wm'
        )
    );
    
    foreach ($picking_pages as $pagename => $page) {
        if ($pickingpage->numChildren("name=$pagename")) {
            $p = $pickingpage->child("name=$pagename");
            $p->of(false);
            $p->title = $page['title'];
            $p->summary = $page['summary'];
            $p->dplusfunction = $page['function'];
            $p->save();
        }
    }
    
    $warehousepage = $pages->get('/warehouse/');
    $warehousepage->of(false);
    $warehousepage->dplusfunction = 'wm';
?>
