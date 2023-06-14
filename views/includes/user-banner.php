<section class="site_width section_banner_profile">
    <div class="banner_profile" >
        <div class="box_img_banner">
            <img class="img_banner" src="<?=empty($banner) ? theme('/assets/images/banner.jpg') : image($banner)?>" alt="">
        </div>
        <div class="box_banner_profile">
            <div class="box_img_photo_banner">
                <img src="<?= empty($photo) ? theme('/assets/images/perfil.jpg') : image($photo) ?>" alt="">
            </div>
            <div class="box_info_banner">
                <h5><?= text($name)?></h5>
            </div>
        </div>
    </div>
</section>