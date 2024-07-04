$("body").on("click", ".edit-btn", function () {
    var userId = $(this).data("id");
    var row = $(this).closest("tr");
    var login = row.find(".login").text().trim();
    var nombre = row.find(".nombre").text().trim();
    var email = row.find(".email").text().trim();

    document.querySelector("#edit_username").value = login;
    document.querySelector("#edit_nombre").value = nombre;
    document.querySelector("#edit_email").value = email;
    document.querySelector("#edit_id").action = `/usuario/${userId}`;

    $("#editEmployeeModal").modal("show");
});