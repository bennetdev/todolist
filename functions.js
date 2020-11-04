function closeListener(){
	$("body").on("click", ".remove", function(){
		var li = $(this).closest("li");

		var a = li.find("a");
		var id = a.attr("id");
		if(Number.isInteger(+id) && +id > 0){
			$(".debug").load("php/delete.php",
			{
				id: id
			}, function(){
				li.remove();	
			});
		}
	});	
}

function listener(){
	$(document).on("submit",".item-add", function(){
		event.preventDefault();
		var ul = $(this).closest(".todo-list").find("ul");
		var code = ul.html();
		var kategorie_id = $(this).closest(".todo-list").attr("id").split("-")[1];
		var nameField = $(this).find(".name")
		var name = nameField.val();
		var submit = $(this).find(".submit").val();
		$(ul).load("php/add.php",
			{
				kategorie_id: kategorie_id,
				name: name,
				submit: submit
			}, function(){
				ul.prepend(code);
				nameField.val("");

			});
	});
	
}

$(document).ready(function(){
	closeListener();
	listener();
	$(document).on("submit", ".kategorie-add", function(){
		event.preventDefault();
		var div = $("#todo-content");
		var code = div.html();
		var nameField = $(this).find(".name")
		var name = nameField.val();
		var submit = $(this).find(".submit").val();
		$(div).load("php/addKategorie.php",
			{
				name: name,
				submit: submit
			}, function(){
				div.prepend(code);
				nameField.val("");

			});
	});	
	$(document).on("click", ".edit-todo", function(){
		$("#editModalTodo").modal('show');
		var id = $(this).attr("id");
		
		$(".debugModal").load("php/setupEdit.php", {
			id: id
		});
	});

	$(document).on("click", ".edit-kategorie", function(){
		$("#editModalKategorie").modal('show');
		var id = $(this).closest(".todo-list").attr("id").split("-")[1];
		
		$(".debugModal").load("php/setupEditKategorie.php", {
			id: id
		});
	});

	$(document).on("click","#submit-edit",function(){
		event.preventDefault();
		var id = $(".modal-footer-todo").attr("id").split("-")[1];
		var name = $("#todo-name").val();
		var description = $("#todo-description").val();
		var done = $("#todo-done").prop("checked");
		var due_to = $("#enable-due-to").prop("checked") ? $("#due-to-input").val() : "";
		var submit = $("#submit-edit").val();
		console.log(due_to);
		$(".debug").load("php/edit.php", {
			id: id,
			name: name,
			description: description,
			done: done,
			due_to: due_to,
			submit: submit
		},function(){
			$("#"+id).text(name);
			if(done == true){
				$("#"+id).attr("class", "done edit-todo");
			}
			else{
				$("#"+id).attr("class", "edit-todo");
			}
			if(done == false && due_to != ""){
				if(new Date(due_to).toDateString() === new Date().toDateString()){
					$("#"+id).parent().attr("class", "due-today todo");
				}
				else if( new Date(due_to) < new Date()){
					$("#"+id).parent().attr("class", "overdue todo");
				}
				else{
					$("#"+id).parent().attr("class", "todo");
				}
			}
			else{
				$("#"+id).parent().attr("class", "todo");
			}
		});
	});
	$(document).on("click","#submit-edit-kategorie",function(){
		event.preventDefault();
		var id = $(".modal-footer-kategorie").attr("id").split("-")[1];
		var name = $("#kategorie-name").val();
		var submit = $("#submit-edit-kategorie").val();
		
		$(".debug").load("php/editKategorie.php", {
			id: id,
			name: name,
			submit: submit
		},function(){
			$("#kategorie-"+id).find(".edit-kategorie").text(name);
		});
	});


	$(document).on("click", ".remove-kategorie", function(){
		$("#submitRemoveModal").modal('show');
		var id = $(this).closest(".todo-list").attr("id").split("-")[1];
		$("#submit-remove-kategorie").closest(".modal-footer-remove").attr("id","kategorie-remove-"+id);
		
	});
	$("#enable-due-to").on("change", function(){
		if ($("#enable-due-to").is(":checked")) {
			let now = new Date().toISOString().slice(0,10);
			$("#due-to-input").val(now);
			$("#due-to-input").attr("readonly", false);
		}
		else {
			$("#due-to-input").val("YYYY-MM-DD");
			$("#due-to-input").attr("readonly", true);
		}

	});
	$(document).on("click","#submit-remove-kategorie",function(){
		var div = $(this).closest(".modal-footer-remove");
		var id = div.attr("id").split("-")[2];
		
		$(".debug").load("php/deleteKategorie.php", {
			id: id
		},function(){
			$("#kategorie-"+id).remove();
		});
	});
	$(document).on("click", "#about", function(){
		$("#aboutModal").modal('show');
	});
	
});