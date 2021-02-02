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

    if (is_page('apple-arcade')) {
        guru_apple_arcade();
    }

    if (is_page('console')) {
        guru_console();
    }

    if (is_page('epic-games')) {
        guru_epic();
    }

    if (is_page('gog')) {
        guru_gog();
    }

    if (is_page('pc')) {
        guru_pc();
    }

    if (is_page('ps3')) {
        guru_ps3();
    }

    if (is_page('ps4')) {
        guru_ps4();
    }

    if (is_page('steam')) {
        guru_steam();
    }
}

// prints formatted TOC list
// requires $query
function guru_print_games ( $query ) {

    // list articles
    if ($query->have_posts()) {
        $output = $output . '<ul>';

        $count = 0;
        while ($query->have_posts()) {

            $count++;
            $query->the_post();
            $output = $output .  '<li style="list-style: disclosure-closed"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';

            if ($count >= 10) {
                $output = $output . "<hr class='slimline'>";
                $count = 0;
            }
        }
        $output = $output .  "</ul>";

        echo $output;
    } // end list articles
}

// custom queries

// All Games
function guru_all() {

    // grab all games with platform
    $query = new WP_Query(array(
        'post_type' => 'games',
        'nopaging' => true
    ));
    $results = $query->found_posts;
    echo "<p>Here's a list of all <strong>$results Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

// Apple Arcade
function guru_apple_arcade() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'apple', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results Apple Arcade Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

// Apple Arcade
function guru_console() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'console', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results Console Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

function guru_epic() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'epic', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results EPIC Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

function guru_gog() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'gog', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results GOG Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

function guru_pc() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'pc', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results PC Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

function guru_ps3() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'ps3', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results Playstation 3 Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

function guru_ps4() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'ps4', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results Playstation 4 Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}

function guru_steam() {

    // grab all games with platform
    $query = new WP_Query( array( 
        'platform' => 'steam', 
        'nopaging' => true )
    );
    $results = $query->found_posts;
    echo "<p>There are <strong>$results Steam Games</strong> in my collection:</p><ul>";

    guru_print_games($query);
}