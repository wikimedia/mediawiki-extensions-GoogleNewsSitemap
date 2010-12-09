<?php
/**
 * Internationalisation file for extension special page GNSM
 * New version of DynamicPageList extension for use by Wikinews projects
 *
 * @addtogroup Extensions
 **/

$messages= array();

/** English
 * @author Amgine
 **/

$messages['en'] = array(
    'gnsm'                  => 'Google News SiteMap',
    'gnsm-desc'             => 'Outputs an Atom/RSS feed as a Google News Sitemap.',
    'gnsm_categorymap'      => '', #default empty. list of categories to map to keywords. do not translate.
    'gnsm_toomanycats'      => 'Error: Too many categories!',
    'gnsm_toofewcats'       => 'Error: Too few categories!',
    'gnsm_noresults'        => 'Error: No results!',
    'gnsm_noincludecats'    => 'Error: You need to include at least one category, or specify a namespace!',
);

/** Français
 * @author Amgine
 **/

$messages['fr'] = array(
    'gnsm'                  => 'Google nouvelles SiteMap',
    'gnsm-desc'             => 'Cre un Atom ou RSS feed comme un plan Sitemap pour Google.',
    'gnsm_toomanycats'      => 'Erreur: Trop de nombreuses catégories!',
    'gnsm_toofewcats'       => 'Erreur: Trop peu de catégories!',
    'gnsm_noresults'        => 'Erreur: Pas de résultats!',
    'gnsm_noincludecats'    => 'Erreur: Vous devez inclure au moins une catégorie, ou spécifier un nom d\'espace !'
);
