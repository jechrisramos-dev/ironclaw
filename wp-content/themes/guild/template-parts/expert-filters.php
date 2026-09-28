<?php
/**
 * Expert filters.
 *
 * Available arguments:
 * - industries: Array of Industry posts.
 * - locations: Array of Location posts.
 *
 * @package Guild
 */

$industries = $args['industries'] ?? [];
$locations  = $args['locations'] ?? [];
?>
<h3 class="text-uppercase mb4">Filters</h3>
<form id="expert-filter-form" class="expert-filter-form">
    <div class="row d-flex justify-content-between">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <select id="industry-filter" class="form-control border border-light bg-transparent text-white rounded-0" name="sector">
                        <option value="" class="text-black"><span>Sector</span></option>
                        <?php foreach ($industries as $industry) : ?>
                            <option value="<?php echo esc_attr($industry->ID); ?>" class="text-black">
                                <?= esc_html($industry->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <select id="location-filter" class="form-control border border-light bg-transparent text-white rounded-0" name="location">
                        <option value="" class="text-black"><span>Locations</span></option>
                        <?php foreach ($locations as $location) : ?>
                            <option value="<?php echo esc_attr($location->ID); ?>" class="text-black">
                                <?= esc_html($location->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="d-flex col-md-12 mb-3">
                    <input
                        id="quicksearch"
                        class="form-control border border-light bg-transparent text-white rounded-0"
                        type="search"
                        name="custom_input"
                        placeholder="<?php esc_attr_e('Search by name', 'guild'); ?>"
                        autocomplete="off"
                    >
                    <button type="submit" class="btn btn-outline-light border border-light bg-transparent text-white rounded-0"> <i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>