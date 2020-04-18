<?php
/************************************/
/*
/* STEAM WIDGET
/*
/************************************/ 

// if we have a Steam URL in our content, display a widget
// based on https://github.com/ruLait/wp-steam-shortcode
function guru_show_steam_widget ( $steamURL ) {
  
    // extract Steam ID
    $parts = explode('/', $steamURL);
    $steamID = $parts[4];
    $width = '100%';
    $class = 'steamWidget';
  
    // generate Steam Widget
    $steamWidget = '<iframe id="' . htmlspecialchars($steamID) . 
    '" class="' . htmlspecialchars($class) . 
    '" style="width: ' . htmlspecialchars($width) .
    '; height: 190px; border: 0;" src="//store.steampowered.com/widget/' . 
    htmlspecialchars($steamID) . $subitem . '?t=' . 
    rawurlencode($text). '" scrolling="no"></iframe>';
  
    // show widget
    echo $steamWidget;
  }
  