<?php
/* Template Name: Gallery Template From Plugin */
get_header();
$categories = get_categories(array(
    'taxonomy' => 'dh_category',
    'orderby' => 'name',
    'order'   => 'ASC'
));

// Pagination setup
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$images_per_page = 6;

if (isset($_GET["filter"])) {
    if (!empty(sanitize_text_field($_GET["filter"]))) {
        if (sanitize_text_field($_GET["filter"]) == 'all') {
            $args = array(
                'post_type'      => 'dh_gallery',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            );
            $AllImages = get_posts($args);
        } else {
            $args = array(
                'post_type'      => 'dh_gallery',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'dh_category',
                        'field'    => 'slug',
                        'terms'    => sanitize_text_field($_GET["filter"])
                    )
                ),
                'orderby'        => 'date',
                'order'          => 'DESC',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            );
            $AllImages = get_posts($args);
        }
    } else {
        $args = array(
            'post_type'      => 'dh_gallery',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => -1,
            'post_status'    => 'publish'
        );
        $AllImages = get_posts($args);
    }
} else {
    $args = array(
        'post_type'      => 'dh_gallery',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => -1,
        'post_status'    => 'publish'
    );
    $AllImages = get_posts($args);
}

$total_images = count($AllImages);
$total_pages = ceil($total_images / $images_per_page);

$offset = ($paged - 1) * $images_per_page;
$AllImages = array_slice($AllImages, $offset, $images_per_page);

$active = 'active';
?>
<!-- ============MAIN START HERE============== -->
<div class="row outer_dh_gallery_plugin">
    <div class="col-md-3 sticky-md-top  all-items dh_all_cat_list  py-5">
        <ul class="pt-2 ms-0 nav flex-column nav-pills pills-dark mb-2 tab-outer flex-nowrap d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item w-100 mr-0 text-center mb-3">
                <a class="nav-link dh_sidebar_tab <?php if (isset($_GET["filter"])) {
                                                    if (!empty(sanitize_text_field($_GET["filter"]))) {
                                                        if (sanitize_text_field($_GET["filter"]) == 'all') {
                                                            echo esc_attr($active);
                                                        }
                                                    } else {
                                                        echo esc_attr($active);
                                                    }
                                                } else {
                                                    echo esc_attr($active);
                                                } ?>" id="pills-all-tab" href="?filter=all" role="" aria-controls="pills-home" aria-selected="true">All</a>
            </li>
            <?php foreach ($categories as $category) { ?>
                <li class="nav-item w-100 mr-0 text-center mb-3">
                    <a class="nav-link dh_sidebar_tab <?php if (isset($_GET["filter"])) {
                                                        if (sanitize_text_field($_GET["filter"]) == $category->slug) {
                                                            echo esc_attr($active);
                                                        }
                                                    } ?>" id="pills-activity-tab" href="?filter=<?php echo esc_attr($category->slug); ?>" role="tab" aria-controls="pills-activity" aria-selected="false"><?php echo esc_attr($category->name); ?> </a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="col-md-9 sticky-top dh_cat_imgs">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade px-2 active show" id="pills-all" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="dh_gallery-imgs">
                    <?php
                    if (count($AllImages) > 0) {
                    ?>
                        <div class="dh_inner_images">
                            <?php foreach ($AllImages as $oneAllImages) { ?>
                                <img src="<?php echo esc_attr(get_the_post_thumbnail_url($oneAllImages->ID, 'full')); ?>" class="rounded-sm w-100 gallery-imgs_items" alt="<?php echo esc_attr($oneAllImages->post_title); ?>">
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12">
                            <div class="error-template">
                                <h1>Oops!</h1>
                                <h2>Pictures Not Found</h2>
                                <div class="error-details">
                                    Sorry, No pictures found of <?php
                                                                    if (isset($_GET["filter"])) {
                                                                        if (!empty(sanitize_text_field($_GET["filter"]))) {
                                                                            echo ucfirst(esc_attr($_GET["filter"]));
                                                                        }
                                                                    } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php
        echo '<li class="page-item">';
        echo paginate_links(array(
            'total'   => $total_pages,
            'current' => $paged,
            'prev_text' => '<span aria-hidden="true">&laquo;</span>',
            'next_text' => '<span aria-hidden="true">&raquo;</span>',
        ));
        echo '</li>';
        ?>
    </ul>
</nav>
<?php get_footer(); ?>
