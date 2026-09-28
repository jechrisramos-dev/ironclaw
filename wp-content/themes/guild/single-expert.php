<?php
    /**Template Post Type: expert**/

    get_header();

    while (have_posts()) :
        the_post();

        $id = get_the_ID();
        $position = get_field('position');
        $profile_image = get_field('profile_image');
        $email = get_field('email');
        $contact_no = get_field('contact_no');
        $linkedin_url = get_field('linkedin_url');
        $location = get_field('location');
        $expertise = get_field('expertise_of_the_profile');
        $team_page = get_page_by_path('team');
        $team_url = $team_page ? get_permalink($team_page->ID) : home_url('/team/');

        $location_ids = [];
        $location_name = '';
        if ($location instanceof WP_Post) {
            $location_ids[] = $location->ID;
            $location_name = $location->post_title;
        } elseif (is_numeric($location)) {
            $location_ids[] = absint($location);
            $location_name = get_the_title(absint($location));
        } elseif (is_array($location)) {
            foreach ($location as $location_item) {
                if ($location_item instanceof WP_Post) {
                    $location_ids[] = $location_item->ID;

                    if (!$location_name) {
                        $location_name = $location_item->post_title;
                    }
                } elseif (is_numeric($location_item)) {
                    $location_ids[] = absint($location_item);

                    if (!$location_name) {
                        $location_name = get_the_title(
                            absint($location_item)
                        );
                    }
                }
            }
        }
?>

    <main id="main-content">
        <section class="single-expert">
            <div class="container no-pad-gutters">
                <div class="back mb-4 mb-md-5">
                    <i class="fa fa-caret-left align-bottom" aria-hidden="true"></i>
                    <a href="<?= esc_url($team_url); ?>" class="btn-outline-success text-uppercase px-0 ml-2">Back to team</a>
                </div>

                <div class="row">
                    <div class="col-md-4 team-left">
                        <div class="team-bg-img">
                            <?php
                                if(!empty($profile_image['ID'])){
                                    echo wp_get_attachment_image(
                                        $profile_image['ID'],
                                        'full',
                                        false,
                                        [
                                            'class' => 'single-expert-img',
                                            'alt' => get_the_title(),
                                        ]
                                    );
                                } elseif (has_post_thumbnail()) {
                                    the_post_thumbnail(
                                        'full',
                                        [
                                            'class' => 'single-expert-img',
                                        ]
                                    );
                                }
                            ?>
                        </div>
                    </div>

                    <div class="col-md-8 team-right">
                        <div class="profile-title">
                            <h1><?php the_title(); ?></h1>
                        </div>

                        <?php if($position) : ?>
                            <div class="profile-designation">
                                <p><strong><?= esc_html($position); ?></strong></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($location_name)) : ?>
                            <p class="city-title">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <em><?= esc_html($location_name); ?></em>
                            </p>
                        <?php endif; ?>

                        <!-- Contact information -->
                        <?php if($email || $contact_no || $linkedin_url) : ?>
                            <div class="social-icon">
                                <ul class="experts-socials d-flex justify-content-start gap-3 px-0" style="list-style:none;">
                                    <!-- Email -->
                                    <?php if($email) : ?>
                                        <li>
                                            <a href="mailto:<?= esc_url($email);?>">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- Phone number -->
                                    <?php if ($contact_no) : ?>
                                        <li>
                                            <a href="tel:<?= esc_url($contact_no);?>">
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- LinkedIn -->
                                    <?php if ($linkedin_url) : ?>
                                        <li>
                                            <a href="<?= esc_url($linkedin_url);?>" target="_blank" rel="noopener noreferrer">
                                                <i class="fab fa-linkedin" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="team-profile-con">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if (!empty($expertise)) : ?>
            <section class="text-bg-dark p-5">
                <div class="container no-pad-gutters">
                    <h2 class="text-white text-center pb-5">
                        Industry Expertise
                    </h2>

                    <div class="row d-flex justify-content-center align-items-center">
                        <?php foreach($expertise as $industry_id) : ?>
                            <?php
                                $industry_id = absint($industry_id);
                                if(!$industry_id) { continue; }
                                
                                $industry_name = get_the_title($industry_id);
                                $industry_image = get_field('industry_expertise', $industry_id);
                            ?>
                            <div class="col industry-icon text-center">
                                <?php if (!empty($industry_image['ID'])) : ?>
                                    <?= wp_get_attachment_image(
                                            $industry_image['ID'],
                                            'full',
                                            false,
                                            [
                                                'class' => 'img-fluid',
                                                'loading' => 'lazy',
                                                'alt' => !empty($industry_image['alt']) ? $industry_image['alt'] : $industry_name,
                                                'title' => $industry_name,
                                            ]
                                        );
                                    ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

<?php endwhile; ?>
<?php get_footer(); ?>