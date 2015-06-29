<?php
	$url = "http://localhost/cuisine_aleo/";

	include_once('modele/connexion_bdd.php');
    include_once('modele/modele.php');

    if (isset($_GET['page'])) {
    	$num_page = $_GET['page'];
    }
    else {
    	$num_page = 1;
    }

    include_once('lib/twig/lib/Twig/Autoloader.php');
    Twig_Autoloader::register();
    
    $loader = new Twig_Loader_Filesystem('views'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
      'cache' => false
    ));


    // Affichage d'une recette
    if (isset($_GET['cat']) && isset($_GET['id']) && $_GET['cat'] == 'recette') {
        echo $twig->render('recipe.html.twig', array(
            'recipe' => getListInformationRecipe($bdd,$_GET['id']),
            'listIngredientsRecipe' => getListIngredientRecipe($bdd,$_GET['id']),
            'listInstructionsRecipe' => getListInstructionRecipe($bdd,$_GET['id']),
            'url' => $url,
        ));
    }

    // Affichage des entrées
    elseif (isset($_GET['cat']) && $_GET['cat'] == 'entree') {
        $url_type_recette = $url."entree/";

        echo $twig->render('index.html.twig', array(
            'listRecipes' => getListRecipes($bdd,$num_page,1),
            'active_entree' => "active",
            'num_page' => $num_page,
            'nb_recette' => getNbRecipes($bdd,1),
            'url' => $url,
            'url_type_recette' => $url_type_recette,
        ));
    }

    // Affichage des plats
    elseif (isset($_GET['cat']) && $_GET['cat'] == 'plat') {
        $url_type_recette = $url."plat/";

        echo $twig->render('index.html.twig', array(
            'listRecipes' => getListRecipes($bdd,$num_page,2),
            'active_plat' => "active",
            'num_page' => $num_page,
            'nb_recette' => getNbRecipes($bdd,2),
            'url' => $url,
            'url_type_recette' => $url_type_recette,
        ));
    }

    // Affichage des desserts
    elseif (isset($_GET['cat']) && $_GET['cat'] == 'dessert') {
        $url_type_recette = $url."dessert/";

        echo $twig->render('index.html.twig', array(
            'listRecipes' => getListRecipes($bdd,$num_page,3),
            'active_dessert' => "active",
            'num_page' => $num_page,
            'nb_recette' => getNbRecipes($bdd,3),
            'url' => $url,
            'url_type_recette' => $url_type_recette,
        ));
    }

    // Affichage de toutes les recettes
    else {
        echo $twig->render('index.html.twig', array(
            'listRecipes' => getListRecipes($bdd,$num_page,0),
            'active_accueil' => "active",
            'num_page' => $num_page,
            'nb_recette' => getNbRecipes($bdd,0),
            'url' => $url,
            'url_type_recette' => $url,
        ));
    }