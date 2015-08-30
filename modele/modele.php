<?php

$postdata = file_get_contents("php://input", true);
$request = json_decode($postdata);

if (isset($request->type)) {
	include_once('connexion_bdd.php');

	// Récupération de la liste des types d'ingrédients
	if ($request->type == "getListTypeIngredients") {
		$list = getListTypeIngredients($bdd);
		echo json_encode($list);
	}

	// Ajout des types d'ingrédients
	elseif ($request->type == "addTypeIngredient") {
		addTypeIngredient($bdd, $request->nom);
	}

	// Modification des types d'ingrédients
	elseif ($request->type == "updateTypeIngredient") {
		updateTypeIngredient($bdd, $request->id, $request->nom);
	}

	// Suppression des types d'ingrédients
	elseif ($request->type == "deleteTypeIngredient") {
		deleteTypeIngredient($bdd, $request->id);
	}

	// Affichage des recettes
	elseif ($request->type == "getListRecipes") {
		$list = getListRecipes($bdd, $request->num_page, $request->type_recette);
		echo json_encode($list);
	}

	// Suppression des recettes
	elseif ($request->type == "deleteRecipe") {
		deleteRecipe($bdd, $request->id);
	}

	// Récupération de la liste des unités
	elseif ($request->type == "getListUnits") {
		$list = getListUnits($bdd);
		echo json_encode($list);
	}

	// Ajout des unités
	elseif ($request->type == "addUnit") {
		addUnit($bdd, $request->nom, $request->type_unite);
	}

	// Modification des unités
	elseif ($request->type == "updateUnit") {
		updateUnit($bdd, $request->id, $request->nom, $request->type_unite);
	}

	//  Suppression des unités
	elseif ($request->type == "deleteUnit") {
		deleteUnit($bdd, $request->id);
	}
}

/** 
 * Récupère la liste des unités
 *
 * @param bdd
 *		Base de données
 * @param type_unite
 *		Type d'unité :
 * 			- 1 -> Unité pour les portions 
 *			- 2 -> Unité de temps
 *			- 3 -> Unité de poids
 *
 * @return array
 *		Table des unités 
**/
/*  	function getListUnit($bdd, $type_unite) {
  		$i = 0;
  		$list = array();

		$req = $bdd->prepare("SELECT id_unite, nom_unite FROM unite WHERE type_unite = ?");
		$req->execute(array($type_unite));


		while ($data = $req->fetch()) {
			$list[$i]['id'] = $data['id_unite'];
			$list[$i]['nom'] = $data['nom_unite'];
			$i++;
		}

		$req->closeCursor();

		return $list;
  	}*/


/** 
 * Récupère la liste des types de recette
 *
 * @param bdd
 *		Base de données
 *
 * @return array
 *		Table des types de recette
**/
  	function getListTypeRecipe($bdd) {
  		$i = 0;
  		$list = array();

		$req = $bdd->query("SELECT id_type_recette, nom_type_recette FROM type_recette");


		while ($data = $req->fetch()) {
			$list[$i]['id'] = $data['id_type_recette'];
			$list[$i]['nom'] = $data['nom_type_recette'];
			$i++;
		}

		$req->closeCursor();

		return $list;
  	}


/** 
 * Récupère la liste des ingrédients
 *
 * @param bdd
 *		Base de données
 *
 * @return array
 *		Table des ingrédients
**/
  	function getListTypeIngredients($bdd) {
  		$i = 0;
  		$list = array();

		$req = $bdd->query("SELECT id_type_ingredient, nom_type_ingredient FROM type_ingredient");

		while ($data = $req->fetch()) {
			$list[$i]['id'] = $data['id_type_ingredient'];
			$list[$i]['nom'] = $data['nom_type_ingredient'];
			$i++;
		}

		$req->closeCursor();

		return $list;
  	}

/** 
 * Ajout d'un type d'ingrédient
 *
 * @param bdd
 *		Base de données
 * @param ing
 *		Nom du type d'ingrédient
**/
  	function addTypeIngredient($bdd, $ing) {
		$req = $bdd->prepare("INSERT INTO type_ingredient SET nom_type_ingredient = ?");
		$req->execute(array($ing));
		$req->closeCursor();
  	}

/** 
 * Modification d'un type d'ingrédient
 *
 * @param bdd
 *		Base de données
 * @param id
 *		Identifiant de l'ingrédient à modifier
 * @param ing
 *		Nom du type d'ingrédient
**/
  	function updateTypeIngredient($bdd, $id, $ing) {
		$req = $bdd->prepare("UPDATE type_ingredient SET nom_type_ingredient = ? WHERE id_type_ingredient = ?");
		$req->execute(array($ing, $id));
		$req->closeCursor();
  	}

/** 
 * Suppression d'un type d'ingrédient
 *
 * @param bdd
 *		Base de données
 * @param id
 *		Identifiant de l'ingrédient à supprimer
**/
  	function deleteTypeIngredient($bdd, $id) {
		$req = $bdd->prepare("DELETE FROM type_ingredient WHERE id_type_ingredient = ?");
		$req->execute(array($id));
		$req->closeCursor();
  	}  	


 /** 
 * Récupère la liste des unités
 * Type d'unité :
 * 	- 1 -> Unité pour les portions 
 *	- 2 -> Unité de temps
 *	- 3 -> Unité de poids
 *
 * @param bdd
 *		Base de données
 *
 * @return array
 *		Table des unités
**/
  	function getListUnits($bdd) {
  		$i = 0;
  		$list = array();

		$req = $bdd->query("SELECT id_unite, type_unite, nom_unite FROM unite");

		while ($data = $req->fetch()) {
			$list[$i]['id'] = $data['id_unite'];
			$list[$i]['type_unite'] = $data['type_unite'];
			$list[$i]['nom'] = $data['nom_unite'];
			$i++;
		}

		$req->closeCursor();

		return $list;
  	}

 /** 
 * Ajout d'une unité
 *
 * @param bdd
 *		Base de données
 * @param unit
 *		Nom de l'unité
 * @param type
 *		Type d'unité
**/
  	function addUnit($bdd, $unit, $type) {
		$req = $bdd->prepare("INSERT INTO unite SET type_unite = ?, nom_unite = ?");
		$req->execute(array($type, $unit));
		$req->closeCursor();
  	}

/** 
 * Modification d'une unité
 *
 * @param bdd
 *		Base de données
 * @param id
 *		Identifiant de l'unité à modifier
 * @param unit
 *		Nom de l'unité
 * @param type
 *		Type d'unité
**/
  	function updateUnit($bdd, $id, $unit, $type) {
		$req = $bdd->prepare("UPDATE unite SET type_unite = ?, nom_unite = ? WHERE id_unite = ?");
		$req->execute(array($type, $unit, $id));
		$req->closeCursor();
  	}

/** 
 * Suppression d'une unité
 *
 * @param bdd
 *		Base de données
 * @param id
 *		Identifiant de l'unité à supprimer
**/
  	function deleteUnit($bdd, $id) {
		$req = $bdd->prepare("DELETE FROM unite WHERE id_unite = ?");
		$req->execute(array($id));
		$req->closeCursor();
  	}  	


/** 
 * Récupère la liste des recettes
 *
 * @param bdd
 *		Base de données
 * @param num_page
 *		Numéro de page
 * @param type_recette
 *		Type de recette (0 : Tous les types, 1 : Entrée, 2 : Plat, 3 : Dessert)
 *
 * @return array
 *		Table des recettes
**/
  	function getListRecipes($bdd, $num_page, $type_recette) {
  		$i = 0;
  		$list = array();

  		if ($num_page == 0) {
			$req = $bdd->query("SELECT r.id_recette as id, r.nom_recette as nom_recette, r.id_type_recette as id_type_recette, r.description as description, r.url_photo as url_photo, r.date_ajout as date_ajout, t.nom_type_recette as type_recette FROM recette r JOIN type_recette t ON r.id_type_recette = t.id_type_recette");
		}
		else {
			if ($num_page == 1) {
				$nb_recette = 0;
			}
			else {
				$nb_recette = (($num_page - 1) * 10);
			}

			if ($type_recette == 0) {
				$req = $bdd->query("SELECT r.id_recette as id, r.nom_recette as nom_recette, r.id_type_recette as id_type_recette, r.description as description, r.url_photo as url_photo, r.date_ajout as date_ajout, t.nom_type_recette as type_recette FROM recette r JOIN type_recette t ON r.id_type_recette = t.id_type_recette LIMIT $nb_recette, 10");
			}
			else {
				$req = $bdd->query("SELECT r.id_recette as id, r.nom_recette as nom_recette, r.id_type_recette as id_type_recette, r.description as description, r.url_photo as url_photo, r.date_ajout as date_ajout, t.nom_type_recette as type_recette FROM recette r JOIN type_recette t ON r.id_type_recette = t.id_type_recette WHERE r.id_type_recette = $type_recette LIMIT $nb_recette, 10");
			}
		}


		while ($data = $req->fetch()) {
			$list[$i]['id'] = $data['id'];
			$list[$i]['nom_recette'] = $data['nom_recette'];
			$list[$i]['id_type_recette'] = $data['id_type_recette'];
			$list[$i]['description'] = $data['description'];
			$list[$i]['type_recette'] = $data['type_recette'];
			$list[$i]['date_ajout'] = date("d/m/Y", strtotime($data['date_ajout']));
			$list[$i]['url_photo'] = $data['url_photo'];
			$i++;
		}

		$req->closeCursor();

		return $list;
  	}

/** 
 * Récupère le nombre d'ingrédients, le nombre de groupes d'ingrédients, le nombre d'instructions et le nombre de groupes d'instructions d'une recette
 *
 * @param bdd
 *		Base de données
 * @param id_recette
 *		Identifiant de la recette
 *
 * @return array
 *		Table contenant le nombre d'ingrédients, le nombre de groupes d'ingrédients, le nombre d'instructions et le nombre de groupes d'instructions
**/
  	function getNbData($bdd, $id_recette) {
  		$list = array();

  		if ($id_recette == 0) {
  			$list['inggroup'] = 0;
  			$list['insgroup'] = 0;
  			$list['ing'] = 0;
  			$list['ins'] = 0;
  		}
  		else {
			$req = $bdd->prepare("SELECT count(distinct nom_groupe) FROM ingredient WHERE id_recette = ?");
			$req->execute(array($id_recette));

			$list['inggroup'] = $req->fetchColumn();
			$req->closeCursor();


			$req = $bdd->prepare("SELECT count(*) FROM ingredient WHERE id_recette = ?");
			$req->execute(array($id_recette));

			$list['ing'] = $req->fetchColumn();
			$req->closeCursor();


			$req = $bdd->prepare("SELECT count(distinct nom_groupe) FROM etape WHERE id_recette = ?");
			$req->execute(array($id_recette));

			$list['insgroup'] = $req->fetchColumn();
			$req->closeCursor();


			$req = $bdd->prepare("SELECT count(*) FROM etape WHERE id_recette = ?");
			$req->execute(array($id_recette));

			$list['ins'] = $req->fetchColumn();
			$req->closeCursor();
		}

		return $list;
  	}


 /** 
 * Récupère le nombre de recettes
 *
 * @param bdd
 *		Base de données
 * @param type_recette
 *		Type de recette (0 : Tous les types, 1 : Entrée, 2 : Plat, 3 : Dessert)
 *
 * @return int
 *		Entier contenant le nombre de recettes
**/
  	function getNbRecipes($bdd, $type_recette) {
  		if ($type_recette == 0) {
			$req = $bdd->query("SELECT count(*) FROM recette");

			$nb_recette = $req->fetchColumn();
			$req->closeCursor();
  		}
  		else {
			$req = $bdd->prepare("SELECT count(*) FROM recette WHERE id_type_recette = ?");
			$req->execute(array($type_recette));

			$nb_recette = $req->fetchColumn();
			$req->closeCursor();
		}

		return $nb_recette;
  	}


/** 
 * Récupère la liste des informations d'une recette
 *
 * @param bdd
 *		Base de données
 * @param id_recette
 *		Identifiant de la recette
 *
 * @return array
 *		Table des informations de la recette
**/
  	function getListInformationRecipe($bdd, $id_recette) {
  		$list = array();

		$req = $bdd->prepare("SELECT r.id_recette as id, r.nom_recette as nom_recette, r.id_type_recette as id_type_recette, r.description as description, r.id_unite_prep as id_unite_prep, r.duree_prep as duree_prep, r.id_unite_cuisson as id_unite_cuisson, r.duree_cuisson as duree_cuisson, r.id_unite_attente as id_unite_attente, r.duree_attente as duree_attente, r.id_unite as id_unite, r.quantite_recette as quantite_recette, r.url_photo as url_photo, r.date_ajout as date_ajout, t.nom_type_recette as nom_type_recette FROM recette as r JOIN type_recette as t ON r.id_type_recette = t.id_type_recette WHERE id_recette = ?");

		$req->execute(array($id_recette));


		while ($data = $req->fetch()) {
			$data['date_ajout'] = date("d/m/Y", strtotime($data['date_ajout']));
			$list = $data;
		}

		// Portion
		$req = $bdd->prepare("SELECT nom_unite as portion FROM unite WHERE id_unite = ?");

		$req->execute(array($list['id_unite']));


		while ($data = $req->fetch()) {
			$list['portion'] = $data['portion'];
		}

		// Temps de préparation
		$req = $bdd->prepare("SELECT nom_unite as unite_prep FROM unite WHERE id_unite = ?");

		$req->execute(array($list['id_unite_prep']));


		while ($data = $req->fetch()) {
			$list['unite_prep'] = $data['unite_prep'];
		}	

		// Temps de cuisson
		$req = $bdd->prepare("SELECT nom_unite as unite_cuisson FROM unite WHERE id_unite = ?");

		$req->execute(array($list['id_unite_cuisson']));


		while ($data = $req->fetch()) {
			$list['unite_cuisson'] = $data['unite_cuisson'];
		}	

		// Temps d'attente
		$req = $bdd->prepare("SELECT nom_unite as unite_attente FROM unite WHERE id_unite = ?");

		$req->execute(array($list['id_unite_attente']));


		while ($data = $req->fetch()) {
			$list['unite_attente'] = $data['unite_attente'];
		}	

		$req->closeCursor();

		return $list;
  	}


/** 
 * Récupère la liste des ingrédients d'une recette
 *
 * @param bdd
 *		Base de données
 * @param id_recette
 *		Identifiant de la recette
 *
 * @return array
 *		Table des ingrédients pour la recette
**/
  	function getListIngredientRecipe($bdd, $id_recette) {
  		$list = array();

		$req = $bdd->prepare("SELECT i.id_ingredient as id, i.id_type_ingredient as id_type_ingredient, i.id_unite as id_unite, i.nom_groupe as nom_groupe, i.quantite_ing as quantite_ing, u.nom_unite as nom_unite, t.nom_type_ingredient as nom_ing FROM ingredient as i JOIN unite as u ON i.id_unite = u.id_unite JOIN type_ingredient as t ON i.id_type_ingredient = t.id_type_ingredient WHERE i.id_recette = ?");
		$req->execute(array($id_recette));


		while ($data = $req->fetch()) {
			$list[$data['id']]['nom_grp'] = $data['nom_groupe'];
			$list[$data['id']]['id_type_ing'] = $data['id_type_ingredient'];
			$list[$data['id']]['nom_ing'] = $data['nom_ing'];
			$list[$data['id']]['id_unite'] = $data['id_unite'];
			$list[$data['id']]['nom_unite'] = $data['nom_unite'];
			$list[$data['id']]['quantite'] = $data['quantite_ing'];
		}

		$req->closeCursor();

		ksort($list);

		return $list;
  	}


/** 
 * Récupère la liste des instructions d'une recette
 *
 * @param bdd
 *		Base de données
 * @param id_recette
 *		Identifiant de la recette
 *
 * @return array
 *		Table des instructions pour la recette
**/
  	function getListInstructionRecipe($bdd, $id_recette) {
  		$list = array();

		$req = $bdd->prepare("SELECT id_etape, nom_groupe, description FROM etape WHERE id_recette = ?");
		$req->execute(array($id_recette));


		while ($data = $req->fetch()) {
			$list[$data['id_etape']]['nom_grp'] = $data['nom_groupe'];
			$list[$data['id_etape']]['description'] = $data['description'];
		}

		$req->closeCursor();

		ksort($list);

		return $list;
  	}


/** 
 * Sauvegarde les données de la nouvelle recette
 *
 * @param bdd
 *		Base de données
 * @param data_form
 *		Les données à sauvegarder
**/
  	function saveRecipe($bdd, $data_form) {
  		$ing_group = "";
  		$ins_group = "";
  		$ing = 0;
  		$ins = 0;

 		// Infos principales de la recette
		$req = $bdd->prepare("INSERT INTO recette SET nom_recette = ?, id_type_recette = ?, description = ?, id_unite_prep = ?, duree_prep = ?, id_unite_cuisson = ?, duree_cuisson = ?, id_unite_attente = ?, duree_attente = ?, id_unite = ?, quantite_recette = ?, url_photo = ?, date_ajout = ?");

		$req->execute(array($data_form['titre'], $data_form['type'], $data_form['description'], $data_form['unite_prep'], $data_form['duree_prep'], $data_form['unite_cuisson'], $data_form['duree_cuisson'], $data_form['unite_attente'], $data_form['duree_attente'], $data_form['unite_portion'], $data_form['portion'], $data_form['photo'], date('Y-m-d')));

		$req->closeCursor();

		$req = $bdd->query("SELECT id_recette FROM recette ORDER BY id_recette DESC LIMIT 1");

		if ($data = $req->fetch()) {
			$id_recette = $data['id_recette'];
		}

		$req->closeCursor();

		foreach($data_form as $key => $value) {
			// Groupes des ingrédients de la recette
			if (strstr($key, 'ing_group')) {
				$ing_group = $value;
			}

			// Groupes des instructions de la recette
			elseif (strstr($key, 'ins_group')) {
				$ins_group = $value;
			}

			// Ingrédients de la recette
			elseif (strstr($key, 'ing')) {
				$ing++;

				$num_ing = substr($key, 3);
				$unite = "unite".$num_ing;
				$quantite = "quantite".$num_ing;

				$req = $bdd->prepare("INSERT INTO ingredient SET id_recette = ?, id_ingredient = ?, id_type_ingredient = ?, id_unite = ?, nom_groupe = ?, quantite_ing = ?");

				$req->execute(array($id_recette, $ing, $data_form[$key], $data_form[$unite], $ing_group, $data_form[$quantite]));

				$req->closeCursor();
			}

			// Instructions de la recette
			elseif (strstr($key, 'ins')) {
				$ins++;

				$num_ins = substr($key, 3);

				$req = $bdd->prepare("INSERT INTO etape SET id_recette = ?, id_etape = ?,  nom_groupe = ?, description = ?");

				$req->execute(array($id_recette, $ins, $ins_group, $data_form[$key]));

				$req->closeCursor();
			}
		}
  	}

 /** 
 * Modifie les données d'une recette
 *
 * @param bdd
 *		Base de données
 * @param id
 *		Identifiant de la recette
 * @param data_form
 *		Les données à sauvegarder
**/
  	function updateRecipe($bdd, $id, $data_form) {
  		$ing_group = "";
  		$ins_group = "";
  		$ing = 0;
  		$ins = 0;

 		// Infos principales de la recette
		$req = $bdd->prepare("UPDATE recette SET nom_recette = ?, id_type_recette = ?, description = ?, id_unite_prep = ?, duree_prep = ?, id_unite_cuisson = ?, duree_cuisson = ?, id_unite_attente = ?, duree_attente = ?, id_unite = ?, quantite_recette = ?, url_photo = ?, date_ajout = ? WHERE id_recette = ?");

		$req->execute(array($data_form['titre'], $data_form['type'], $data_form['description'], $data_form['unite_prep'], $data_form['duree_prep'], $data_form['unite_cuisson'], $data_form['duree_cuisson'], $data_form['unite_attente'], $data_form['duree_attente'], $data_form['unite_portion'], $data_form['portion'], $data_form['photo'], date('Y-m-d'), $id));

		$req->closeCursor();

		foreach($data_form as $key => $value) {
			// Groupes des ingrédients de la recette
			if (strstr($key, 'ing_group')) {
				$ing_group = $value;
			}

			// Groupes des instructions de la recette
			elseif (strstr($key, 'ins_group')) {
				$ins_group = $value;
			}

			// Ingrédients de la recette
			elseif (strstr($key, 'ing')) {
				$ing++;

				$num_ing = substr($key, 3);
				$unite = "unite".$num_ing;
				$quantite = "quantite".$num_ing;

				// Vérification de l'existence de l'ingrédient dans la bdd
				$req = $bdd->prepare("SELECT count(*) FROM ingredient WHERE id_recette = ? AND id_ingredient = ?");

				$req->execute(array($id, $ing));

				if ($req->fetchColumn() == 0) {
					// Insertion
					$req->closeCursor();

					$req = $bdd->prepare("INSERT INTO ingredient SET id_recette = ?, id_ingredient = ?, id_type_ingredient = ?, id_unite = ?, nom_groupe = ?, quantite_ing = ?");

					$req->execute(array($id, $ing, $data_form[$key], $data_form[$unite], $ing_group, $data_form[$quantite]));

					$req->closeCursor();
				}
				else {
					// Mise à jour
					$req->closeCursor();

					$req = $bdd->prepare("UPDATE ingredient SET id_type_ingredient = ?, id_unite = ?, nom_groupe = ?, quantite_ing = ? WHERE id_recette = ? AND id_ingredient = ?");

					$req->execute(array($data_form[$key], $data_form[$unite], $ing_group, $data_form[$quantite], $id, $ing));

					$req->closeCursor();
				}
			}

			// Instructions de la recette
			elseif (strstr($key, 'ins')) {
				$ins++;

				$num_ins = substr($key, 3);

				// Vérification de l'existence de l'instruction dans la bdd
				$req = $bdd->prepare("SELECT count(*) FROM etape WHERE id_recette = ? AND id_etape = ?");

				$req->execute(array($id, $ins));

				if ($req->fetchColumn() == 0) {
					// Insertion
					$req->closeCursor();

					$req = $bdd->prepare("INSERT INTO etape SET id_recette = ?, id_etape = ?,  nom_groupe = ?, description = ?");

					$req->execute(array($id, $ins, $ins_group, $data_form[$key]));

					$req->closeCursor();
				}
				else {
					// Mise à jour
					$req->closeCursor();
					
					$req = $bdd->prepare("UPDATE etape SET nom_groupe = ?, description = ? WHERE id_recette = ? AND id_etape = ?");

					$req->execute(array($ins_group, $data_form[$key], $id, $ins));

					$req->closeCursor();
				}
			}
		}

		$trouve = true;

		while ($trouve) {
			$ing++;

			// Suppression des ingrédients
			$req = $bdd->prepare("SELECT count(*) FROM ingredient WHERE id_recette = ? AND id_ingredient = ?");

			$req->execute(array($id, $ing));

			if ($req->fetchColumn() == 0) {
				$trouve = false;
				$req->closeCursor();
			}
			else {
				$req->closeCursor();
				$req = $bdd->prepare("DELETE FROM ingredient WHERE id_recette = ? AND id_ingredient = ?");
				$req->execute(array($id, $ing));
				$req->closeCursor();
			}
		}

		$trouve = true;

		while ($trouve) {
			$ins++;

			// Suppression des instructions
			$req = $bdd->prepare("SELECT count(*) FROM etape WHERE id_recette = ? AND id_etape = ?");

			$req->execute(array($id, $ins));

			if ($req->fetchColumn() == 0) {
				$trouve = false;
				$req->closeCursor();
			}
			else {
				$req->closeCursor();
				$req = $bdd->prepare("DELETE FROM etape WHERE id_recette = ? AND id_etape = ?");
				$req->execute(array($id, $ins));
				$req->closeCursor();
			}
		}
  	}


/** 
 * Supprime une recette
 *
 * @param bdd
 *		Base de données
 * @param id_recipe
 *		Identifiant de la recette à supprimer
**/
  	function deleteRecipe($bdd, $id_recipe) {
  		$req = $bdd->prepare("DELETE FROM ingredient WHERE id_recette = ?");
		$req->execute(array($id_recipe));
		$req->closeCursor();

		$req = $bdd->prepare("DELETE FROM etape WHERE id_recette = ?");
		$req->execute(array($id_recipe));
		$req->closeCursor();

		$req = $bdd->prepare("DELETE FROM recette WHERE id_recette = ?");
		$req->execute(array($id_recipe));
		$req->closeCursor();
  	}	

?>
