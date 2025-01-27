//<?php
/**
 * DashboardLatestDisqus
 * Latest Disqus Comments widget for Evolution cms Dashboard
 *
 * @author      Nicola Lambathakis http://www.tattoocms.it/
 * @category    plugin
 * @version    3.2.3
 * @license	   http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnManagerWelcomeHome,OnManagerWelcomePrerender
 * @internal    @installset base
 * @internal    @modx_category Dashboard
 * @documentation Requirements: This plugin requires Evolution 1.4 or later
 * @reportissues https://github.com/Nicola1971/DashboardLatestDisqus/issues
 * @link        
 * @lastupdate  27/01/2025
 * @internal    @properties &wdgVisibility=Show widget for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Show only to this role id:;string;;;enter the role id &ThisUser=Show only to this username:;string;;;enter the username &wdgTitle= Widget Title:;string;Latest Disqus Comments &wdgicon=widget icon:;string;fa-commenting-o &wdgposition=widget position:;list;1,2,3,4,5,6,7,8,9,10;1 &wdgsizex=widget width:;list;12,6,4,3;6 &DisqusDomain=Disqus domain name (ie: tattoocms):;string;tattoocms &DisqusApiKey=Disqus Public Key:;string;S95vswe6x8aXZRojcr5ZY9x0e4FNW48a1ZSfKMvUbEgc45kbzIxAN0llIb1mHwBq &num_items=Number of comments to show in the widget:;string;5 &BodyHeight= Widget Body max-height:;string;300
*/
// Run the main code
include($modx->config['base_path'].'assets/plugins/dashboarddisqus/DashboardLatestDisqus.php');