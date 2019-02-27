<?php 
    use Dplus\Warehouse\Binr;
    
    $binr = new Binr();
    $whsesession = WhseSession::load(session_id());
    $whsesession->init();
    $whseconfig = WhseConfig::load($whsesession->whseid);
    $config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/_shared-functions.js'));
    $config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/move-bin-contents.js'));
    
    $page->body = __DIR__."/move-form.php";
    $toolbar = false;
    include $config->paths->content."common/include-toolbar-page.php";
