var typeahead_options = {
    minLength: 1,
    order: "asc",
    mustSelectItem: true,
    searchOnFocus: true,
    dynamic: true,
    maxItem: 0,
    callback: {
      onClickAfter: function (node, a, item, event) {
        console.log(node)
        console.log(a)
        console.log(item)
        console.log(event)
        $("#generator").submit();
      },
    },
  };
  
  $.typeahead({
    ...typeahead_options,
    input: "#hairStyle",
    matcher: function (item, displayKey) {
      if (
        item.display.includes("hair") ||
        item.display.includes("bald") ||
        item.display.includes("debrained")
      ) {
        return true;
      } else {
        return undefined;
      }
      return true;
    },
    source: {
      hair: "/icons/mob/species/human/human_face/human_face.json",
    },
  });

  $.typeahead({
    ...typeahead_options,
    input: "#facial",
    matcher: function (item, displayKey) {
      if (item.display.includes("facial")) {
        item.display = item.display.replace(/facial_/, "");
        return true;
      } else {
        return undefined;
      }
      return true;
    },
    source: {
        facial: "/icons/mob/species/human/human_face/human_face.json",
    },
  });

  $.typeahead({
    ...typeahead_options,
    input: "#eyeWear",
    source: {
      eyeWear: "/icons/mob/clothing/eyes/eyes.json",
    },
  });

  $.typeahead({
    ...typeahead_options,
    input: "#mask",
    source: {
      uniform: "/icons/mob/clothing/mask/mask.json",
    },
  });

$.typeahead({
    ...typeahead_options,
    input: "#uniform",
    source: {
      uniform: "/icons/mob/clothing/under/under.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#suit",
    source: {
      suit: "/icons/mob/clothing/suits/suits.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#head",
    source: {
      head: "/icons/mob/clothing/head/head.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#belt",
    source: {
      belt: "/icons/mob/clothing/belt/belt.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#gloves",
    source: {
      head: "/icons/mob/clothing/hands/hands.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#shoes",
    source: {
      head: "/icons/mob/clothing/feet/feet.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#back",
    source: {
      head: "/icons/mob/clothing/back/back.json",
    },
  });
  
  $.typeahead({
    ...typeahead_options,
    input: "#neck",
    source: {
      head: "/icons/mob/clothing/neck/neck.json",
    },
  });

$.ajax("img2.php", {
  dataType: "json",
}).done(function (i) {
  console.log(i);
  $("#mugshot").attr("src", `data:image/png;base64,${i.mugshot}`);
  $("#corp").attr("src", `data:image/png;base64,${i.corp}`);
  $("#idcard").attr("src", `data:image/png;base64,${i.card}`);
});
$("body").on("click", ".skinTone", function (e) {
  var form = $(this).parents("form");
  form.submit();
});
$(".form-control").on("change", function(e){
  var form = $(this).parents("form");
  form.submit();    
})
$("form").on("submit", function (e) {
  e.preventDefault();
  console.log($(this).serializeArray());
  $.ajax("img2.php", {
    dataType: "json",
    data: $(this).serializeArray(),
    method: "POST",
  }).done(function (i) {
    $("#mugshot").attr("src", `data:image/png;base64,${i.mugshot}`);
    $("#corp").attr("src", `data:image/png;base64,${i.corp}`);
    $("#idcard").attr("src", `data:image/png;base64,${i.card}`);
  });
});
var humanSkintones = {
  caucasian1: "#ffe0d1",
  caucasian2: "#fcccb3",
  caucasian3: "#e8b59b",
  latino: "#d9ae96",
  mediterranean: "#c79b8b",
  asian1: "#ffdeb3",
  asian2: "#e3ba84",
  arab: "#c4915e",
  indian: "#b87840",
  african1: "#754523",
  african2: "#471c18",
  albino: "#fff4e6",
  orange: "#ffc905",
};

$.each(humanSkintones, function (i, v) {
  var option =
    "<input type='radio' name='skinTone' value='" +
    i +
    "' class='field c form-control skinTone' id='skintone-" +
    i +
    "'><label for='skintone-" +
    i +
    "' style='background: " +
    v +
    "'></label>";
  $("#skintone").append(option);
});
