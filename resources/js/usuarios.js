$("body").on("click", ".edit-btn", function () {
    var userId = $(this).data("id");
    var row = $(this).closest("tr");
    var login = row.find(".login").text().trim();
    var nombre = row.find(".nombre").text().trim();
    var email = row.find(".email").text().trim();
    var activado = row.find(".activado i").hasClass("bx-check");
    var admin = row.find(".role").text().trim() === 'Admin';
    
    document.querySelector("#edit_username").value = login;
    document.querySelector("#edit_nombre").value = nombre;
    document.querySelector("#edit_email").value = email;
    document.querySelector("#edit_id").value = userId;
    document.querySelector("#edit_activado").checked = activado;
    document.querySelector("#edit_admin").checked = admin;
});
