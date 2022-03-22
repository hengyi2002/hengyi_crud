$(".product-form").submit(function (e) {
  $("#cart-partial").html("loading!");
  e.preventDefault(); // avoid to execute the actual submit of the form.
  var form = $(this);
  var url = form.attr("action");
  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      $("#cart-partial").html(data);
    },
  });
});

$.get("cart_partial.php", function (data) {
  $("#cart-partial").html(data);
});
