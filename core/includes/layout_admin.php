<!DOCTYPE html>
<html>
    <head>
        <title>Administration Asgard-Servers</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="Description" content="Serveur privé francophone du jeu World of Wracraft: Cataclysm, en 4.1.0 avec un émulateur très performant. Propulsé par la team Old-Scool.">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <meta name="Url" content="http://www.rolkithan.fr/">
        <meta name="Version" content="1.1">
        <link href="template/css/adminStyle.css" rel="stylesheet">
        <link href="template/zoombox/zoombox.css" rel="stylesheet" type="text/css" media="screen" />
    </head>
    <body>
        <div id="content">
            <div id="contentMenu">
                <div id="menu">
                    <a href="index.php">Retourner sur le site</a>
                    <div id="Serveur" class="menuHeader"><span>Serveur</span></div>
                    <div id="Organisation" class="menuHeader"><span>Organisation</span></div>
                    <div id="Communication" class="menuHeader"><span>Communication</span></div>
                    <div id="Statistiques" class="menuHeader"><span>Statistiques</span></div>
                    <div id="Outils" class="menuHeader"><span>Outils</span></div>
                    <div id="Comptes" class="menuHeader"><span>Comptes</span></div>
					<div id="Parametres" class="menuHeader"><span>Paramètres</span></div>
                    <div class="clear"></div>
                </div>
                <div id="submenu">
                    <p id="Serveur" class="liens"><a href="#">Gestion du Top-vote</a> | <a href="#">Liste des Uptimes</a></p>
                    <p id="Organisation" class="liens">
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestProjets">Gestion des projets</a><?php endif; ?> 
						<a href="#">Liste de tâches a faire</a> | 
						<a href="#">Faire une demande</a>
					</p>
                    <p id="Communication" class="liens"> 
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestNews">Gestionnaire des news</a><?php endif; ?> 
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestNewsLetter">Créer news Letter</a><?php endif; ?> 
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestDebugDev">Gestionnaire des débugs</a><?php endif; ?>
                    </p>
                    <p id="Statistiques" class="liens"><a href="#">Statistiques des joueurs</a> | <a href="#">Statistiques des comptes</a>| <a href="#">Statistiques des Votes</a></p>
                    <p id="Outils" class="liens"><a href="index.php?page=gestRecups">Gestion des Récupérations</a> | <a href="#">Liste des Uptimes</a></p>
                    <p id="Comptes" class="liens"><a href="#">Gestion des comptes</a> | <a href="#">Liste de comptes</a></p>
					<p id="Parametres" class="liens">
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestFamilles">Famille de projets</a><?php endif; ?> 
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestCategories">Catégorie de tickets</a><?php endif; ?> 
						<?php if(isset($_SESSION['Administrateur'])): ?><a href="index.php?page=gestStatuts">Statuts des tickets</a><?php endif; ?> 
					</p>
                </div>
            </div>
        <div id="content">
        <?php echo $contenu; ?>
        </div>
            </div>
    </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="template/zoombox/zoombox.js"></script>
        <script type="text/javascript">jQuery(function($){    $('a.zoombox').zoombox();    });</script>
        <script>
           $(document).ready(function(){
               /*
                *$('#news_container').animate({opacity:0.1}).load(href + ' #content #block_middle #contenu #block_left #news_container   ', function() {
                    $('#news_container').fadeTo('slow','1');
                });
               */
               $("#submenu p").hide();
               $("#submenu p:first").fadeIn(100); //Affiche le menu en chargent la page
               
               $('.menuHeader').click(function(){
                   var id = $(this).attr('id');
                    $("#submenu .liens").fadeOut(5, function () {
                        $("#submenu #"+id).fadeIn(100);
                    });
               });
           });
       </script>
       <script type="text/javascript" src="template/zoombox/zoombox.js"></script>
       <script type="text/javascript" src="template/js/tinyMce/tiny_mce.js"></script>
        <script type="text/javascript">
            tinyMCE.init({
            // General options
            mode : "textareas",
            theme : "advanced",
            plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect,forecolor",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 : "",
            theme_advanced_buttons4 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,

            // Skin options
            skin : "o2k7",
            skin_variant : "silver",

            // Example content CSS (should be your site CSS)
            content_css : "css/example.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "js/template_list.js",
            external_link_list_url : "js/link_list.js",
            external_image_list_url : "js/image_list.js",
            media_external_list_url : "js/media_list.js",

            // Replace values for the template plugin
            template_replace_values : {
                    username : "Some User",
                    staffid : "991234"
            }
        });
    </script>
</html>