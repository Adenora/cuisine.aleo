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


    if (isset($_GET['cat']) && isset($_GET['id']) && $_GET['cat'] == 'recette') {
        echo $twig->render('recipe.html.twig', array(
            'recipe' => getListInformationRecipe($bdd,$_GET['id']),
            'listIngredientsRecipe' => getListIngredientRecipe($bdd,$_GET['id']),
            'listInstructionsRecipe' => getListInstructionRecipe($bdd,$_GET['id']),
            'url' => $url,
        ));
    }
    else {
        echo $twig->render('index.html.twig', array(
            'listRecipes' => getListRecipes($bdd,$num_page),
            'url' => $url,
        ));
    }