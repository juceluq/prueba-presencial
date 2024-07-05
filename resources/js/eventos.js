$("body").on("click", ".edit-btn", function () {
    var userId = $(this).data("id");
    var row = $(this).closest("tr");
    var nombre = row.find(".nombre").text().trim();
    var fondo = row.find(".fondo").text().trim();
    var borde = row.find(".borde").text().trim();
    var texto = row.find(".texto").text().trim();
    
    document.querySelector("#edit_nombre").value = nombre;
    document.querySelector("#edit_fondo").value = fondo;
    document.querySelector("#edit_borde").value = borde;
    document.querySelector("#edit_id").value = userId;
    document.querySelector("#edit_texto").value = texto;

});
