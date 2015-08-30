
(function() {
  'use strict';
  var routeApp = angular.module('routeApp', ['ui.router', 'formly', 'formlyBootstrap']);


  // Routage
  routeApp.config(function($stateProvider, $urlRouterProvider, $locationProvider) { 

    $locationProvider.html5Mode(true);

    // Route par défaut
    $urlRouterProvider.otherwise('/admin');

    $stateProvider.state('recette', {
      url: '/admin/recette',
      templateUrl: 'views/show_recipe.html',
      controller: "RecipeController"
    });

    $stateProvider.state('ingredient', {
      url: '/admin/ingredient',
      templateUrl: 'views/manage_ingredient.html',
      controller: 'IngController'
    });

    $stateProvider.state('unite', {
      url: '/admin/unite',
      templateUrl: 'views/manage_unit.html',
      controller: 'UnitController'
    });
  });

  // Formulaire honrizontal
  routeApp.config(function(formlyConfigProvider) {
    formlyConfigProvider.setWrapper({
      name: 'horizontalBootstrapLabel',
          template: [
            '<label for="{{::id}}" class="col-sm-2 control-label">',
              '{{to.label}} {{to.required ? "*" : ""}}',
            '</label>',
            '<div class="col-sm-8">',
              '<formly-transclude></formly-transclude>',
            '</div>'
          ].join(' ')
    });

    formlyConfigProvider.setType({
      name: 'horizontalInput',
      extends: 'input',
      wrapper: ['horizontalBootstrapLabel', 'bootstrapHasError']
    });

    formlyConfigProvider.setType({
      name: 'horizontalSelect',
      extends: 'select',
      wrapper: ['horizontalBootstrapLabel', 'bootstrapHasError']
    });

  });


  // Controlleur pour la gestion des unités
  routeApp.controller('RecipeController', function($scope, $http) {

    /* Rafraichissement de la liste des recettes :
    (Type de recette (0 : Tous les types, 1 : Entrée, 2 : Plat, 3 : Dessert))*/
    $scope.refresh = function() {
      $http.post('modele/modele.php', { 
        type: 'getListRecipes', num_page: 0, type_recette: 0
      }).success(function(data) {
        $scope.recipes = data;
      });
    }

    $scope.refresh();

    // Suppression de la recette
    $scope.onDelete = function(id) {
      $http.post('modele/modele.php', {
        type: 'deleteRecipe', id: id
      }).success(function(data) {
        $scope.refresh();
      });
    };
  });


  // Controlleur pour la gestion des types d'ingrédients
  routeApp.controller('IngController', function($scope, $http) {
    var ing = this;

    ing.model = {};
      
    // Les champs du formulaire
    ing.fields = [{
      key: 'nom',
      type: 'horizontalInput',
      templateOptions: {
        type: 'text',
        label: 'Ingrédient',
        placeholder: 'Ingrédient',
        required: true
      }
    }];

    // Rafraichissement de la liste des types d'ingrédient
    $scope.refresh = function() {
      $http.post('modele/modele.php', { 
        type: 'getListTypeIngredients'
      }).success(function(data) {
        $scope.ingredients = data;
      });
    }

    $scope.refresh();


    // Ajout de l'ingrédient
    $scope.onSubmit = function() {
      if (ing.form.$valid) {
        $http.post('modele/modele.php', {
          type: 'addTypeIngredient', nom: ing.model.nom
        }).success(function(data) {
          ing.options.resetModel();
          $scope.refresh();
        });
      }
    };

    // Modification de l'ingrédient
    $scope.onUpdate = function(id, nom) {
      $http.post('modele/modele.php', {
        type: 'updateTypeIngredient', id: id, nom: nom
      }).success(function(data) {});
    };

    // Suppression de l'ingrédient
    $scope.onDelete = function(id) {
      $http.post('modele/modele.php', {
        type: 'deleteTypeIngredient', id: id
      }).success(function(data) {
        $scope.refresh();
      });
    };
  });


  // Controlleur pour la gestion des unités
  routeApp.controller('UnitController', function($scope, $http) {
    var unit = this;

    unit.model = {};
      
    // Les champs du formulaire
    unit.fields = [{
      key: 'type_unite',
      type: 'horizontalSelect',
      templateOptions: {
        label: 'Type unité',
        options: [
          {name: 'Portion', value: '1'},
          {name: 'Temps', value: '2'},
          {name: 'Poids', value: '3'},
        ],
        required: true,
      }
    },
    {
      key: 'nom',
      type: 'horizontalInput',
      templateOptions: {
        type: 'text',
        label: 'Unité',
        placeholder: 'Unité',
        required: true
    }
    }];

    // Les types des unités
    $scope.types = [{
      id: 1,
      value: 'Portion',
    },
    {
      id: 2,
      value: 'Temps',
    },
    {
      id: 3,
      value: 'Poids',
    }];

    // Rafraichissement de la liste des unités
    $scope.refresh = function() {
      $http.post('modele/modele.php', { 
        type: 'getListUnits'
      }).success(function(data) {
        $scope.unites = data;
      });
    }

    $scope.refresh();


    // Ajout de l'unité
    $scope.onSubmit = function() {
      if (unit.form.$valid) {
        $http.post('modele/modele.php', {
          type: 'addUnit', nom: unit.model.nom, type_unite: unit.model.type_unite
        }).success(function(data) {
          unit.options.resetModel();
          $scope.refresh();
        });
      }
    };

    // Modification de l'unité
    $scope.onUpdate = function(id, type_unite, nom) {
      $http.post('modele/modele.php', {
        type: 'updateUnit', id: id, type_unite: type_unite, nom: nom
      }).success(function(data) {});
    };

    // Suppression de l'unité
    $scope.onDelete = function(id) {
      $http.post('modele/modele.php', {
        type: 'deleteUnit', id: id
      }).success(function(data) {
        $scope.refresh();
      });
    };
  });
})();



/*$(function() {
  var nb_ing_recipe_group = $("#ingredient").attr("data-inggroup");
  var nb_ing_recipe = $("#ingredient").attr("data-ing");
  var nb_ins_group = $("#instruction").attr("data-insgroup");
  var nb_ins = $("#instruction").attr("data-ins");
  var nb_ing = $("#ingredient").attr("data-lastiding");
  var listQuantityUnit;
  var listIngredients;

  $.post(
    "http://localhost/cuisine_aleo/modele/modele.php",
    {
      type : "getListQuantityUnit"
    },
    function(data){
      listQuantityUnit = JSON.parse(data);
    }
  );

  $.post(
    "http://localhost/cuisine_aleo/modele/modele.php",
    {
      type : "getListTypeIngredients"
    },
    function(data){
      listIngredients = JSON.parse(data);
    }
  );

  $("table").tablesorter({
    headers: { 
      3: {sorter:"dd/mm/yyyy"}        
    }         
  });

  // Ajout d'un ingrédient dans la recette
  $('#add_ing_recipe').click(function ( event ) {
  	event.preventDefault();
    nb_ing_recipe++;

    var typeUnit = '';
    var typeIngredient = '';

    for (i = 0; i < listQuantityUnit.length; i++) {
      typeUnit += '<option value="'+listQuantityUnit[i]['id']+'">'+listQuantityUnit[i]['nom']+'</option>';
    }

    for (i = 0; i < listIngredients.length; i++) {
      typeIngredient += '<option value="'+listIngredients[i]['id']+'">'+listIngredients[i]['nom']+'</option>';
    }


  	$("#ingredient").append('<tr class="ing'+nb_ing_recipe+'"><td><label for="ing'+nb_ing_recipe+'" class="col-lg-2 control-label">Ingrédient</label></td><td><input type="text" id="quantite'+nb_ing_recipe+'" name="quantite'+nb_ing_recipe+'" class="form-control" placeholder="Quantité" /></td><td><select id="unite'+nb_ing_recipe+'" name="unite'+nb_ing_recipe+'" class="form-control">'+typeUnit+'</select></td><td><select id="ing'+nb_ing_recipe+'" name="ing'+nb_ing_recipe+'" class="form-control">'+typeIngredient+'</select></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign pointeur" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'un groupe d'ingrédients dans la recette
  $('#add_group_ing_recipe').click(function ( event ) {
    event.preventDefault();
    nb_ing_recipe_group++;

    $("#ingredient").append('<tr class="ing_group'+nb_ing_recipe_group+'"><td><label for="ing_group'+nb_ing_recipe_group+'" class="col-lg-2 control-label">Groupe</label></td><td colspan="3"><input type="text" id="ing_group'+nb_ing_recipe_group+'" name="ing_group'+nb_ing_recipe_group+'"" class="form-control" placeholder="Groupe" /></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign pointeur" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'une instruction dans la recette
  $('#add_instruction').click(function ( event ) {
    event.preventDefault();
    nb_ins++;

    $("#instruction").append('<tr class="ins'+nb_ins+'"><td><label for="ins'+nb_ins+'" class="col-lg-1 control-label">Instruction</label></td><td><textarea id="ins'+nb_ins+'" name="ins'+nb_ins+'" class="form-control" placeholder="Description de l\'étape"></textarea></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign pointeur" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'un groupe d'instructions dans la recette
  $('#add_group_instruction').click(function ( event ) {
    event.preventDefault();
    nb_ins_group++;

    $("#instruction").append('<tr class="ins_group'+nb_ins_group+'"><td><label for="ins_group'+nb_ins_group+'" class="col-lg-2 control-label">Groupe</label></td><td><input type="text" id="ins_group'+nb_ins_group+'" name="ins_group'+nb_ins_group+'" class="form-control" placeholder="Groupe" /></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign pointeur" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'un ingrédient
  $('.pointeur_add').click(function ( event ) {
    event.preventDefault();
    nb_ing++;

    $("#ingredient").append('<tr class="ing'+nb_ing+'"><td><input type="text" id="ing'+nb_ing+'" name="ing'+nb_ing+'" class="form-control" placeholder="Ingredient" /></td><td class="green"><span class="glyphicon glyphicon-plus-sign pointeur_add" aria-hidden="true"></td><td class="red"><span class="glyphicon glyphicon-minus-sign pointeur" aria-hidden="true"></span></td></tr>');
  });

  // Suppression des ingrédients ou instructions dans la recette
  $('body').on("click", ".pointeur", function ( event ) {
    event.preventDefault();
    $(this).parent().parent().remove();
  });
});
*/