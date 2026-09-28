<?php
/* Template Name: Expert Page */
get_header();
$id = get_the_ID();
$page = get_post($id);

$experts_query = new WP_Query(
    [
        'post_type'      => 'expert',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]
);
?>

<section class="bg-dark-blue">
    <div class="container text-white no-pad-gutters">
        <h3 class="text-uppercase mb-4"><?= $page->intro_title ?></h3>
        <div class="row">
            <div class="col-md-8 mb-4">
                <?= $page->post_content ?>
            </div>
        </div>
        
        <!--May implement the search and filter here-->
        <?php
            get_template_part(
                'template-parts/expert-filters',
                null,
                [
                    'industries' => get_industries(),
                    'locations'  => get_locations(),
                ]
            );
        ?>
    </div>
</section>

<!--May implement the experts profile list here-->
<div class="page-center">
    <div class="container">
        <div id="expert-list" class="row py-5">
            <?php if ($experts_query->have_posts()) : ?>
                <?php while ($experts_query->have_posts()) :
                    $experts_query->the_post();
                    $expert_id = get_the_ID();

                    $position = get_field('position', $expert_id);
                    $profile_image = get_field('profile_image',$expert_id);
                    $email = get_field('email', $expert_id);
                    $contact_no = get_field('contact_no', $expert_id);
                    $linkedin_url = get_field('linkedin_url', $expert_id);
                    $location = get_field( 'location', $expert_id);
                    $industries = get_field('expertise_of_the_profile', $expert_id);

                    $profile_image_id = 0;
                    if (is_array($profile_image)) {
                        if (!empty($profile_image['ID'])) {
                            $profile_image_id = absint($profile_image['ID']);
                        } elseif (!empty($profile_image['id'])) {
                            $profile_image_id = absint($profile_image['id']);
                        }
                    } elseif (is_numeric($profile_image)) {
                        $profile_image_id = absint($profile_image);
                    }

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

                    $industry_ids = [];
                    if (is_array($industries)) {
                        foreach ($industries as $industry) {
                            if ($industry instanceof WP_Post) {
                                $industry_ids[] = $industry->ID;
                            } elseif (is_numeric($industry)) {
                                $industry_ids[] = absint($industry);
                            }
                        }
                    }
                    ?>

                    <div
                        class="col-md-6 col-lg-4 mb-5 expert-card-column text-center"
                        data-expert-name="<?= esc_attr(strtolower(get_the_title($expert_id)));?>"
                        data-industries="<?= esc_attr(implode(',', $industry_ids)); ?>"
                        data-locations="<?= esc_attr(implode(',', $location_ids)); ?>"
                    >
                        <article class="expert-card team-box-inner" >
                            <a href="<?= esc_url( get_permalink() ); ?>" class="text-black" style="text-decoration:none;">
                                <!-- Profile image -->
                                <div class="team-img">
                                    <?php
                                        if ($profile_image_id) {
                                            echo wp_get_attachment_image(
                                                $profile_image_id,
                                                'medium',
                                                false,
                                                ['class' => 'team-img-single expert-card__photo', 'alt' => get_the_title(), ]
                                            );
                                        } elseif (has_post_thumbnail()) {
                                            the_post_thumbnail( 'medium', ['class' => 'team-img-single expert-card__photo', 'alt' => get_the_title(), ]);
                                        } else { ?>
                                            <div class="expert-card__placeholder" aria-hidden="true"></div>
                                    <?php } ?>
                                </div>
                            </a>

                            <!-- Card content -->
                            <div class="expert-card__content py-3">
                                <a href="<?= esc_url( get_permalink() ); ?>" class="member-name text-black" style="text-decoration:none;">
                                    <strong><?php the_title(); ?></strong>
                                </a>

                                <?php if (!empty($position)) : ?>
                                    <p class=" member-designation my-1"> <?= esc_html($position); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($location_name)) : ?>
                                    <p class="member-address mb-0">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <em><?= esc_html($location_name); ?></em>
                                    </p>
                                <?php endif; ?>

                                <!-- Contact information -->
                                <?php if ( $email || $contact_no || $linkedin_url ) : ?>
                                    <ul class="experts-socials p-0 mt-3 d-flex justify-content-center gap-3" style="list-style:none;">
                                        <!-- Email -->
                                        <?php if ($email) : ?>
                                            <li>
                                                <a href="mailto:<?= esc_html($email);?>">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- Phone number -->
                                        <?php if ($contact_no) : ?>
                                            <li>
                                                <a href="tel:<?= esc_html($$contact_no);?>">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- LinkedIn -->
                                        <?php if ($linkedin_url) : ?>
                                            <li>
                                                <a href="<?= esc_html($linkedin_url);?>" target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
                <div id="no-expert-results" class="col-12 py-5" hidden> <p class="text-center mb-0"><?php esc_html_e('No Expert Found.', 'guild'); ?></p> </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('expert-filter-form');
        const industryFilter = document.getElementById('industry-filter');
        const locationFilter = document.getElementById('location-filter');
        const searchInput = document.getElementById('quicksearch');
        const expertCards = document.querySelectorAll('.expert-card-column');
        const noResults = document.getElementById('no-expert-results');

        if (!filterForm) { return; }

        function filterExperts() {
            const selectedIndustry = industryFilter ? industryFilter.value : '';
            const selectedLocation = locationFilter ? locationFilter.value : '';
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

            let visibleExperts = 0;

            expertCards.forEach(function (card) {
                const expertName = (card.dataset.expertName || '').toLowerCase();
                const locationIds = (card.dataset.locations || '').split(',').filter(Boolean);
                const industryIds = (card.dataset.industries || '').split(',').filter(Boolean);
                const matchesIndustry = !selectedIndustry || industryIds.includes(selectedIndustry);
                const matchesLocation = !selectedLocation || locationIds.includes(selectedLocation);
                const matchesSearch = !searchTerm || expertName.includes(searchTerm);
                const shouldShow = matchesIndustry && matchesLocation && matchesSearch;
                card.style.display = shouldShow ? '' : 'none';
                if (shouldShow) { visibleExperts++; }
            });

            if (noResults) { noResults.hidden = visibleExperts !== 0; }
        }

        filterForm.addEventListener('submit', event => {
            event.preventDefault();
            filterExperts();
        });

        if (industryFilter) { industryFilter.addEventListener('change', filterExperts); }
        if (locationFilter) { locationFilter.addEventListener('change', filterExperts); }
        if (searchInput) { searchInput.addEventListener('input', filterExperts); }
    });
</script>