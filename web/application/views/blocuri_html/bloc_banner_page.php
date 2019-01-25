<?php
$banner = base_url(). 'public/assets/img/banner-noimage.jpg';
if(!empty($page->b) && isset($page->b["banner1"]))
{
	$banner = base_url(). "public/upload/img/page/banners/" .$page->b['banner1']->img;
}
?>
        <section class="shop-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="s-header-text" style="background: #cccccc url('<?=$banner?>') repeat scroll center center / cover;">
                            <h1><?=$page->p->{'title_' . $site_lang}?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>