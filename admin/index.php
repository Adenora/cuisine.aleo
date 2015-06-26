<?php
    $url = "http://localhost/recette_aleo/";
    $url_admin = "http://localhost/recette_aleo/admin/";

	include_once('../modele/connexion_bdd.php');
    include_once('../modele/modele.php');

    include_once('../lib/twig/lib/Twig/Autoloader.php');
    Twig_Autoloader::register();
    
    $loader = new Twig_Loader_Filesystem('../views'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
      'cache' => false
    ));

    if (isset($_POST['add_recipe'])) {
        saveRecipe($bdd,$_POST);
        
        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }
    elseif (isset($_GET['cat']) && $_GET['cat'] == 'addrecipe') {
        echo $twig->render('manage_recipe.html.twig', array(
            'listGlobalUnit' => getListUnit($bdd,1),
            'listTimeUnit' => getListUnit($bdd,2),
            'listQuantityUnit' => getListUnit($bdd,3),
            'listTypeRecipe' => getListTypeRecipe($bdd),
            'listTypeIngredients' => getListTypeIngredients($bdd),
            'nbData' => getNbData($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
            'action' => $_GET['cat'],
        ));
    }
    elseif (isset($_GET['cat']) && isset($_GET['id']) && $_GET['cat'] == 'deleterecipe') {
        deleteRecipe($bdd,$_GET['id']);

        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }
    elseif (isset($_GET['cat']) && isset($_GET['id']) && $_GET['cat'] == 'modifyrecipe') {
        echo $twig->render('manage_recipe.html.twig', array(
            'listGlobalUnit' => getListUnit($bdd,1),
            'listTimeUnit' => getListUnit($bdd,2),
            'listQuantityUnit' => getListUnit($bdd,3),
            'listTypeRecipe' => getListTypeRecipe($bdd),
            'listTypeIngredients' => getListTypeIngredients($bdd),
            'recipe' => getListInformationRecipe($bdd, $_GET['id']),
            'listIngredientsRecipe' => getListIngredientRecipe($bdd, $_GET['id']),
            'listInstructionsRecipe' => getListInstructionRecipe($bdd, $_GET['id']),
            'nbData' => getNbData($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
            'action' => $_GET['cat'],
        ));
    }
    else {
        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }
