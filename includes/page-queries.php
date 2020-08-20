<?php

/************************************/
/*
/* PAGE QUERIES
/* amalgamated functions
/*
/************************************/

// figure out the page title and derive correct content from it
function guru_page_content()
{
    if (is_page('all')) {
        guru_all();
    }

    if (is_page('test')) {
        guru_all();
    }
}

// custom queries

// all games
function guru_all()
{
    // grab all games with platform
    $query = new WP_Query(array(
        'post_type' => 'games',
        'nopaging' => true
    ));
    $results = $query->found_posts;
    echo "<p>Here's a list of all <strong>$results Games</strong> in my collection:</p><ul>";

    // list all games
    if ($query->have_posts()) {
        echo "";
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo "</ul>";
    } // end of games list
}
