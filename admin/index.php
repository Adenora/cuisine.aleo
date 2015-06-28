﻿<?php
    $url = "http://localhost/cuisine_aleo/";
    $url_admin = "http://localhost/cuisine_aleo/admin/";

	include_once('../modele/connexion_bdd.php');
    include_once('../modele/modele.php');

    include_once('../lib/twig/lib/Twig/Autoloader.php');
    Twig_Autoloader::register();
    
    $loader = new Twig_Loader_Filesystem('../views'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
      'cache' => false
    ));

    // Ajout d'une recette dans la bdd
    if (isset($_POST['add_recipe'])) {
        saveRecipe($bdd,$_POST);
        
        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }

    // Modification d'une recette dans la bdd
    elseif (isset($_POST['modify_recipe'])) {
        updateRecipe($bdd,$_GET['id'],$_POST);
        
        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }

    // Création du formulaire pour ajouter une recette
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

    // Suppression d'une recette dans la bdd
    elseif (isset($_GET['cat']) && isset($_GET['id']) && $_GET['cat'] == 'deleterecipe') {
        deleteRecipe($bdd,$_GET['id']);

        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }

    // Création du formulaire pour modifier une recette
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
            'nbData' => getNbData($bdd,$_GET['id']),
            'url' => $url,
            'url_admin' => $url_admin,
            'action' => $_GET['cat'],
        ));
    }

    // Affichage de toutes les recettes
    else {
        echo $twig->render('index_admin.html.twig', array(
            'listRecipes' => getListRecipes($bdd,0),
            'url' => $url,
            'url_admin' => $url_admin,
        ));
    }
