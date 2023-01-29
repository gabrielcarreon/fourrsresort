$(document).ready(function(){
    table = dataTable();
    getInventory();
    saveInventory();
    modalFunctions();
    addItem();
    deleteItem();
});
isDeleting = false;
function dataTable(){
    return $("#inventory-table").DataTable({
        'scrollY': 400,
        "scrollCollapse": true,
        "paging": false
    });
}

function getInventory(){
    table.clear().draw();
    $.get('../../php/handlers/getInventoryHandler.php', function(data){
        jsondata = JSON.parse(data);

        jsondata.forEach(value => {
            table.row.add([value.id, value.item_desc,value.quantity,`<span class="badge rounded-pill `+value.is_available+`">`+value.is_available+`</span>`]);
        });
        table.draw();
        $("#inventory-tbody tr").on('click',function(){
            $.post('../../php/handlers/inventoryHandler.php', {"inventory-id": table.row(this).data()[0]}, function(data){
               
                $("#inventory-modal .modal-title").html("Edit item");
                invjsondata = JSON.parse(data);
                $("#inv-id").val(parseInt(invjsondata.id));
                $("#inv-name").val(invjsondata.item_desc);
                $("#inv-quantity").val(invjsondata.quantity);
                $("#inv-price").val(invjsondata.price)
                if(invjsondata.is_available == 1){
                    $("#inv-available").prop('checked', true);
                }else{
                    $("#inv-available").prop('checked', false)
                }
                $("#inventory-modal").modal('show');
            });
        });
    });
}
function saveInventory(){
    $("#inv-save-changes").click(function(){
        console.log($("#inventory-form").serialize());

        $.post('../../php/handlers/inventoryHandler.php',$("#inventory-form").serialize(), function(data){
            console.log(data);
            if(data === '1'){
                $("#inventory-modal").modal('hide');
                feedbackModal(data, "Inventory updated", "Inventory update failed", 0)
                getInventory();
                $("#inventory-tbody tr").off();
            }else{
                jsonresponse = JSON.parse(data);
                jsonresponse.forEach(value => {
                    $("#"+value.error+' ~.invalid-feedback').show();
                });
            }
        
        });
    });
}
function addItem(){
    $('#add-item').click(function(){
        form = $("#inventory-form").serializeArray();
        console.log(form);
        if($('#inv-available').prop('checked') == true){
            form.push({name: 'add-available', value: 1})
        }else{
            form.push({name: 'inv-available', value: 0})
        }

        $.post('../../php/handlers/inventoryHandler.php', 
           form
        , function(data){
            if(data == '1'){
                $("#inventory-modal").modal('hide');
                feedbackModal(data, "Added item successfully", "Add item failed", 0)
                getInventory();
            }else{
                jsonresponse = JSON.parse(data);
                jsonresponse.forEach(value => {
                    $("#"+value.error+' ~.invalid-feedback').show();
                });
            }
         
        });
    });
}

function feedbackModal(status, successMessage, failMessage, reload){
    if(status ==='1'){
        $("#success_tic").modal('show');
        $("#response-message").html(successMessage);
    }else{
        $("#fail_tic").modal('show');
        $("#fail-response-message").html(failMessage);
    }
    setTimeout(function(){
        $("#success_tic").modal('hide');
        $("#fail_tic").modal('hide');
    }, 1500);
    $("#fail_tic").modal('hide');
    if(reload === 1){
        setTimeout(function(){
            location.reload();
        }, 1500);
    }
 
}

function deleteItem(){
    $("#btn-delete-item").click(function(){
        console.log($("#inv-id").val());
        $.post('../../php/handlers/inventoryHandler.php', {'delete-id': $("#inv-id").val()}, (data)=>{
            console.log(data);
            isDeleting = false;
            $("#deleteConfirmationModal").modal('hide');
            feedbackModal(data, "Deleted item successfully", "Delete item failed", 0)
            getInventory();
        });      
    });
}
function modalFunctions(){
    $('button[data-bs-target="#deleteConfirmationModal"]').on('click', function(){
        isDeleting = true;
    });

    $(".btn-add-inventory").on('click', function(){
        $("#inventory-modal .modal-title").html("Add item");
        $("#inv-name").val(" ");
        $("#inv-quantity").val(1);
        $("#inv-available").prop('checked', false);
        $("#add-item").show();
        $("#inv-save-changes").hide();
        $("#inv-id").attr('name', "add-inv-id");
        $("button[data-bs-target='#deleteConfirmationModal']").hide();
    });
    $("#inventory-modal").on('hidden.bs.modal', function(){
        $("#add-item").hide();
        $("#inv-save-changes").show();
        $("#inv-id").attr('name', 'inv-id');
        if(!isDeleting){
            $('#inventory-form').get(0).reset();
        }
        $("button[data-bs-target='#deleteConfirmationModal']").show();

        $(".invalid-feedback").hide();
    });

    $("#deleteConfirmationModal").on('show.bs.modal', ()=>{
        $("#deleteModalTitle").html("Delete item")
        $("#deleteModalMessage").html("Are you sure you want to delete "+$("#inv-name").val()+"?…")
    });
    $("button[data-dismiss='modal']").click(function(){
        $("#deleteConfirmationModal").modal('hide');
    });
}