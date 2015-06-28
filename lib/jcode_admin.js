$.tablesorter.addParser({
    id: "dd/mm/yyyy",
    is: function(s) {
        return false;
    },
    format: function(s) {
        s = "" + s;
        var hit = s.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
        if (hit && hit.length == 4) {
            return hit[3] + hit[2] + hit[1];
        } else {
            return s;
        }
    },
    type: "text"
}); 


$(function() {
  var nb_ing_group = $("#ingredient").attr("data-inggroup");
  var nb_ing = $("#ingredient").attr("data-ing");
  var nb_ins_group = $("#instruction").attr("data-insgroup");
  var nb_ins = $("#instruction").attr("data-ins");
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
      type : "getListIngredients"
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

  // Ajout d'un ingrédient
  $('#add_ingredient').click(function ( event ) {
  	event.preventDefault();
    nb_ing++;

    var typeUnit = '';
    var typeIngredient = '';

    for (i = 0; i < listQuantityUnit.length; i++) {
      typeUnit += '<option value="'+listQuantityUnit[i]['id']+'">'+listQuantityUnit[i]['nom']+'</option>';
    }

    for (i = 0; i < listIngredients.length; i++) {
      typeIngredient += '<option value="'+listIngredients[i]['id']+'">'+listIngredients[i]['nom']+'</option>';
    }


  	$("#ingredient").append('<tr class="ing'+nb_ing+'"><td><label for="ing'+nb_ing+'" class="col-lg-2 control-label">Ingrédient</label></td><td><input type="text" id="quantite'+nb_ing+'" name="quantite'+nb_ing+'" class="form-control" placeholder="Quantité" /></td><td><select id="unite'+nb_ing+'" name="unite'+nb_ing+'" class="form-control">'+typeUnit+'</select></td><td><select id="ing'+nb_ing+'" name="ing'+nb_ing+'" class="form-control">'+typeIngredient+'</select></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign del" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'un groupe d'ingrédients
  $('#add_group_ingredient').click(function ( event ) {
    event.preventDefault();
    nb_ing_group++;
    $("#ingredient").append('<tr class="ing_group'+nb_ing_group+'"><td><label for="ing_group'+nb_ing_group+'" class="col-lg-2 control-label">Groupe</label></td><td colspan="3"><input type="text" id="ing_group'+nb_ing_group+'" name="ing_group'+nb_ing_group+'"" class="form-control" placeholder="Groupe" /></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign del" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'une instruction
  $('#add_instruction').click(function ( event ) {
    event.preventDefault();
    nb_ins++;

    $("#instruction").append('<tr class="ins'+nb_ins+'"><td><label for="ins'+nb_ins+'" class="col-lg-1 control-label">Instruction</label></td><td><textarea id="ins'+nb_ins+'" name="ins'+nb_ins+'" class="form-control" placeholder="Description de l\'étape"></textarea></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign del" aria-hidden="true"></span></td></tr>');
  });

  // Ajout d'un groupe d'instructions
  $('#add_group_instruction').click(function ( event ) {
    event.preventDefault();
    nb_ins_group++;
    $("#instruction").append('<tr class="ins_group'+nb_ins_group+'"><td><label for="ins_group'+nb_ins_group+'" class="col-lg-2 control-label">Groupe</label></td><td><input type="text" id="ins_group'+nb_ins_group+'" name="ins_group'+nb_ins_group+'" class="form-control" placeholder="Groupe" /></td><td class="red" align="center"><span class="glyphicon glyphicon-minus-sign del" aria-hidden="true"></span></td></tr>');
  });

  // Suppression
  $('body').on("click", ".del", function ( event ) {
    event.preventDefault();
    $(this).parent().parent().remove();
  });

/*  $('#add_recipe').click(function ( event ) {
    event.preventDefault();

    $.post(
      "../modele/modele.php",
      {
        type : "getListQuantityUnit",
        dataform : ""
      },
      function(data){
        listQuantityUnit = JSON.parse(data);
      }
    );
  });*/
});
