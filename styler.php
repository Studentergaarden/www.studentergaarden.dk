<?php
header('Content-Type: text/html; charset=utf-8');

function createSite($content, $curPage, $curLanguage, $altLanguage, $altLanLabel){

	$menuDanish = array(
	    0 => "Forside",
	    1 => "Om Studentergården",
	    2 => "Livet på gården",
	    3 => "Optagelse",
	    4 => "Gårdboersamfundet",
	    5 => "Kontakt"
	    );

	$menuEnglish = array(
	    0 => "Home",
	    1 => "About Studentergården",
	    2 => "Life at Studentergården",
	    3 => "Admission",
	    4 => "Alumni",
	    5 => "Contact"
	    );

	//Lidt spøjs omskrivning for at have dansk some default
	$menuLanNeutral = ($curLanguage != "en") ? $menuDanish : $menuEnglish;

	$menuContent = "";

	foreach ($menuLanNeutral as $key => $value){
	    $active = ($key == $curPage) ? "class='active'" : "";

	    $menuContent .= "<a $active href='index.php?page=$key&lan=$curLanguage'>$value</a>";
	}
	$menuContent .="<a href='?page=$curPage&lan=$altLanguage' class='none'><img src='img/$altLanLabel.png' height='16px'></a>";

	echo "
	<!doctype html>
	<html>
	<head>
	    <link rel='stylesheet' type='text/css' href='css/style.css' />";

	if(isset($_SESSION['v2Admin']) && $_SESSION['v2Admin'] == 1){
	echo "    <link type='text/css' rel='stylesheet' href='css/raptor-front-end.css' />
	    <script type='text/javascript' src='js/raptor.js'></script>
	    <script type='text/javascript'>
	        jQuery(function($) {
	            $('.editable').raptor({
	                \"plugins\": {
	                    \"dock\": {
	                        \"docked\": true
	                    },
	                    \"classMenu\": {
	                        \"classes\": {
	                            \"Blue background\": \"cms-blue-bg\",
	                            \"Round corners\": \"cms-round-corners\",
	                            \"Indent and center\": \"cms-indent-center\"
	                        }
	                    },
	                    save:{   
	                        plugin: 'saveJson'
	                    },
	                    saveJson: {
	                        // The URL to which Raptor data will be POSTed
	                        url: 'save.php',
	                        // The parameter name for the posted data
	                        postName: 'raptor-content',
	                        // A string or function that returns the identifier for the Raptor instance being saved
	                        id: '$curPage',
	                        lan: '$curLanguage',
	                        token: '$_SESSION[token]'
	                    }
	                }
	            });
	        });";
	}
	echo "
	    </script>
	        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	        <!--meta name='description' content='A website for my games' />
	        <meta property='og:title' content='blaavogn.dk' />
	        <meta property='og:type' content='website'/>
	        <meta property='og:image' content='http://blaavogn.dk/img/34_thumb.png' />
	        <meta property='og:url' content='http://www.blaavogn.dk' />
	        <meta property='og:description' content='A website for my games' />

	        <link rel='shortcut icon' href='img/site.ico' /-->
	    </head>
	    <body>
	        <div id='content'>
	            <div id='heading'>
	                <img src='img/top.png' />
	            </div>
	            <div id='box'>
	                <div id='banner'>
	                    <img src='img/banners/0.png' />
	                </div>
	                <div id='menu'>
	                    <div id='menuContent'>
	                    	$menuContent
	                	</div>
	                </div>
	                <div style='clear: both'></div>
	                <div id='entries'>
	                    <div class='editable' data-id='body-1'>$content</div>
	                </div>
	                <div id='footer'></div>
	            </div>
	        </div>
	    </body>
	</html>";
}


?>
