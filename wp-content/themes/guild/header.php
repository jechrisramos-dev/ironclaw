<?php
global $post, $have_bg;

//echo get_the_title($post->post_parent);

$body_height = null;
$background_post_types = ['industry', 'expert', 'resource',];

$background_pages = ['about-the-syndicate', 'team', 'services-offered', 'client-testimonials', 'submit-a-quest', 'terms-conditions', ];

if (in_array(get_post_type(), $background_post_types, true) || is_page($background_pages)):
    $the_bar = (!is_user_logged_in()) ? '' : '-bar';
    $body_height = 'bodyTop' . $the_bar;
    $have_bg = 'have-bg';
endif;

?>

<!DOCTYPE html>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri() . '/images/favicon.ico' ?>">
    <?php wp_head()?>

    <style>
        /* header */
        header .navbar.have-bg {
            border-bottom: 1px solid rgba(163, 163, 163, 0.3);
            background: #000116;
        }

        #header .site-title {
            font-size: 42px;
            font-weight: 500;
            line-height: 1;
            margin-bottom: 0;
            text-transform: uppercase;
        }

        #header .site-title a,
        #header .site-title a:hover {
            color: #fff;
            text-decoration: none;
        }

        #header .site-description {
            color: #fff;
            font-size: .8em;
            font-style: italic;
            margin-bottom: 0;
        }
        /* end of header */
        /* expert page */
        .team-img {
            border-radius: 50%;
            height: 200px;
            margin: 0 auto;
            overflow: hidden;
            width: 200px;
        }

        .team-img-single {
            background-color: gray;
            height: 100%;
            transition: all .3s ease-in-out;
            width: 100%;
            object-fit: cover;
        }

        ul.experts-socials li a {
            background-color: #198754;
            border-radius: 50%;
            box-sizing: content-box;
            color: #fff;
            display: inline-block;
            height: 25px;
            padding: .5em;
            text-align: center;
            width: 25px;
        }
        /* end of expert page */
        /* footer */
        footer { padding : 80px 10px; }

        footer img {
            display: block;
            height: 165px;
        }

        .copyright li:first-child a { padding-left: 0; }

        .copyright .nav-link {
            display: block;
            padding: 0 1rem;
        }

        .copyright .copy_text {
            display: inline-block;
            padding: 0 1rem;
            word-spacing: normal;
        }

        .wp-block-buttons.is-layout-flex.wp-block-buttons-is-layout-flex { margin-bottom: 1rem; }
        /* end of footer */

        @media screen and (max-width: 576px) {
            /* header */
            a.navbar-brand { margin-right: 0.18rem; }

            #header .site-title { font-size: 2rem; }
            /* end of header */

            /* expert page */
            img.single-expert-img { width: 100%; }

            .profile-title h1 { margin-top: 1rem; }
            /* end of expert page */

            /* footer */
            footer img { margin: 0 auto; }

            .cftw-widget { text-align: center; }

            footer { padding : 50px 10px; }

            .copyright .copy_text {
                padding: 0;
                margin-top: 0.5rem;
            }
            /* end of footer */
        }
    </style>
    
</head>

<body <?php body_class($body_height);?>>

<?php get_template_part('template-parts/navigation/navigation', 'top');?>

<div id="main">