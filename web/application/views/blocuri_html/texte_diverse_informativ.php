		<?php if(!is_null($texte_diverse_informativ)) { ?>
		<!--Service Area Start-->
        <section class="service-area">
            <div class="container">
                <div class="row">
					<?php foreach($texte_diverse_informativ as $td_i) { ?>
                    <div class="single-service">
                        <div class="service-icon">
                            <div class="service-tablecell">
                                <img src="<?=base_url()?>public/assets/img/<?=$td_i->i_pictograma?>" alt="piese industriale">
                            </div>
                        </div>
                        <h4><?=$td_i->{'atom_name' . '_' . $site_lang}?></h4>
                    </div>
					<?php } ?>
                </div>
            </div>
        </section>
        <!--End of Service Area-->
		<?php } ?>