$(document).ready(function(){
    $(document).on("submit", ".subkategorie-add", function(){
        event.preventDefault();
        var div = $("#todo-content");
        var code = div.html();
        var nameField = $(this).find(".name")
        var name = nameField.val();
        var submit = $(this).find(".submit").val();
        var kategorie = new URL(window.location.href).searchParams.get("id")
        console.log(kategorie)
            $(div).load("php/addSubkategorie.php",
                {
                    name: name,
                    submit: submit,
                    kategorie_id: kategorie
                }, function(){
                    div.prepend(code);
                    nameField.val("");

                });
    });
});

