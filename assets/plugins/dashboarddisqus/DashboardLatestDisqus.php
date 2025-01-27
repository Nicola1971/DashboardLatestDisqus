<?php

/** credits: https://github.com/bachors/jQuery-disqus-widget/blob/master/index.html */
global $modx,$_lang;
$ThisRole = $ThisRole ?? '';
$ThisUser = $ThisUser ?? '';
$HeadBG = isset($HeadBG) ? trim($HeadBG) : '';
$HeadColor = isset($HeadColor) ? trim($HeadColor) : '';
$BodyBG = isset($BodyBG) ? trim($BodyBG) : '';
$BodyColor = isset($BodyColor) ? trim($BodyColor) : '';
$BodyHeight = isset($BodyHeight) ? trim($BodyHeight) : '200';
// get manager role
$internalKey = $modx->getLoginUserID();
$sid = $modx->sid;
$role = $_SESSION['mgrRole'];
$user = $_SESSION['mgrShortname'];
// show widget only to Admin role 1
if(($role!=1) AND ($wdgVisibility == 'AdminOnly')) {}
// show widget to all manager users excluded Admin role 1
else if(($role==1) AND ($wdgVisibility == 'AdminExcluded')) {}
// show widget only to "this" role id
else if(($role!=$ThisRole) AND ($wdgVisibility == 'ThisRoleOnly')) {}
// show widget only to "this" username
else if(($user!=$ThisUser) AND ($wdgVisibility == 'ThisUserOnly')) {}
else {
// get plugin id
$result = $modx->db->select('id', $this->getFullTableName("site_plugins"), "name='{$modx->event->activePlugin}' AND disabled=0");
$pluginid = $modx->db->getValue($result);
if($modx->hasPermission('edit_plugin')) {
$button_pl_config = '<a data-toggle="tooltip" href="javascript:;" title="' . $_lang["settings_config"] . '" class="text-muted pull-right float-right" onclick="parent.modx.popup({url:\''. MODX_MANAGER_URL.'?a=102&id='.$pluginid.'&tab=1\',title1:\'' . $_lang["settings_config"] . '\',icon:\'fa-cog\',iframe:\'iframe\',selector2:\'#tabConfig\',position:\'center center\',width:\'80%\',height:\'80%\',hide:0,hover:0,overlay:1,overlayclose:1})" ><i class="fa fa-cog fa-spin-hover" style="color:'.$HeadColor.';"></i> </a>';
}
$modx->setPlaceholder('button_pl_config', $button_pl_config);
//widget name
$WidgetID = isset($WidgetID) ? $WidgetID : 'latest_disqus';

//output
$WidgetOutput = isset($WidgetOutput) ? $WidgetOutput : '';
//events
$EvoEvent = isset($EvoEvent) ? $EvoEvent : 'OnManagerWelcomeHome';
$output = "";
$e = &$modx->Event;
switch($e->name){
case 'OnManagerWelcomePrerender':
$jsinclude = '
    <script>
/*---------- Setting ----------------*/
bcr_disqus(\''.$DisqusDomain.'\','.$num_items.',\''.$DisqusApiKey.'\');
/*-----------------------------------*/


function bcr_disqus(username,count,apikey) {
    $.ajax({
        url: \'https://disqus.com/api/3.0/forums/listPosts.json?forum=\' + username + "&limit=" + count + "&related=thread&api_key=" + apikey,
        crossDomain: true,
        dataType: \'json\'
    }).done(function (data) {
        var html = \'\';
        html += \'<ul id="komentar">\';
        $.each(data.response, function(i, item) {       
            html += \'<li>\';
            html += \'<div class="avatar-container">\';
            html += \'<a href="\' + data.response[i].author.profileUrl + \'" target="_blank">\';
            html += \'<img src="\' + data.response[i].author.avatar.small.permalink + \'" class="avatar" alt="avatar" />\';
            html += \'</a>\';
            html += \'</div>\';
            html += \'<div class="post-container">\';
            html += \'<a href="\' + data.response[i].author.profileUrl + \'" class="profile" target="_blank">\';
            html += \'<span class="profile">\' + data.response[i].author.name;
            html += \'</a>\';              
            html += \'<span class="buled" aria-hidden="true">•</span>\';
            html += \'<span class="date">\' + data.response[i].createdAt + \'</span>\';
            html += \'<p>\' + data.response[i].raw_message + \'</p>\';
            html += \'<span class="posted">posted on <a href="\' + data.response[i].thread.link + \'" target="_blank">\' + data.response[i].thread.title + \'</a></span>\';
            html += \'</div>\';
            html += \'</li>\';        
        });
        html += \'</ul>\';
        $(\'#mydisqus\').html(html);
    });
}
</script>';

$cssOutput = '
<style>
ul#komentar {
  list-style-type: none;
  color: #3f4549;
  padding: 0px
}
ul#komentar li {
	margin-bottom: 10px;
	padding-bottom: 10px;
	position: relative;
  border-bottom: 1px solid #eee
}
ul#komentar li a {
	text-decoration: none;
	color: #4183C4
}
.avatar-container {
	width: 64px;
	box-sizing: border-box
}
.avatar {
	width: 60px;
	height: 60px;
	border-radius: 5px;
	float: left;
	margin: 5px
}
.post-container {
	padding-top: 3px;
	margin-left: 70px; 
	box-sizing: border-box
}
.profile {
	font-weight: bold
}
.date, .posted, .buled {
  color: #a5b2b9
}
.buled {
  padding: 0 2px
}
</style>';
$e->output($jsinclude.$cssOutput);
break;
case 'OnManagerWelcomeHome':
			$widgets['DashboardLatestDisqus'] = array(
				'menuindex' =>''.$wdgposition.'',
				'id' => 'DashboardLatestDisqus'.$pluginid.'',
				'cols' => 'col-md-'.$wdgsizex.'',
                'headAttr' => 'style="background-color:'.$HeadBG.'; color:'.$HeadColor.';"',
				'bodyAttr' => 'style="background-color:'.$BodyBG.'; color:'.$BodyColor.';; max-height:'.$BodyHeight.'px;overflow-y: scroll; padding:0;"',
				'icon' => ''.$wdgicon.'',
				'title' => ''.$wdgTitle.' '.$button_pl_config.'',
				'body' => '<div class="widget-stage"><!--disqus -->
		  	<div id="mydisqus"></div>
		   	<!---/disqus ---></div>'
			);	
            $e->output(serialize($widgets));
    break;
}
return;
}
?>