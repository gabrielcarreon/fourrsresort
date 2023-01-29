$(document).ready(function(){
    table = dataTable();
    getUsers();
    addUser();
    modalFunctions();
    editUser();
    deleteUser();
});

function dataTable(){
    return $("#users-table").DataTable({
        'scrollY': 400,
        "scrollCollapse": true,
        "paging": false
        // "columnDefs": [
            // { className: "d-flex", "targets": [ 0 ] },
            // { className: "justify-content-center", "targets": [ 0 ] },
            // { className: "align-items-center", "targets": [ 0 ] },
        //     { className: "text-start", "targets": [ 0 ] },
        //     { className: "py-3", "targets": [ 0 ] }
        //   ]
    }
    );
}

function getUsers(){
    table.clear();
    $("#users-tbody tr").off();
    $.get('../../php/handlers/getUsersHandler.php', function(data){
        jsondata = JSON.parse(data); 

        jsondata.forEach(value => {
            if(value.is_active ==1){
                isactive = 'Active';
                pillbg = 'text-bg-primary'
            }else{
                isactive = 'Inactive';
                pillbg = 'text-bg-secondary'
            }
            var row = table.row.add([`<div class="d-flex">
                                        <div class="col-4"></div>
                                        <div class="me-2">
                                            <img src="../../assets/image/userplaceholder.jpg" alt="" class="user-image">
                                        </div>
                                        <div class="d-flex flex-column align-items-start justify-content-center">
                                            <h6 class="mb-0">`+value.name+`&nbsp;<span class="badge rounded-pill `+pillbg+`">`+isactive+`</span></h6>
                                            <p class="mb-0 user-id"">`+value.user_id+`</p>
                                        </div>
                                    </div>`, 
                                    `<span class="badge rounded-pill `+value.user_type+`">`+value.user_type+`</span>`]).node();
            $(row).attr('data-attr', value.user_id);
            $(row).addClass('py-3');

        });
        table.draw();
        $("#users-tbody tr").click(function(){
            $("#userinfomodal").modal('show');
            console.log($(this).attr('data-attr'));
            $.post('../../php/handlers/userHandler.php', {'user-id':$(this).attr('data-attr')}, (data)=>{
                jsondata = JSON.parse(data);
                $("#userinfo-name").html(jsondata.name);
                $("#userinfo-userid").html(jsondata.user_id);
                $("#userinfo-email").html(jsondata.email);
                $("#userinfo-role").val(jsondata.user_type);
                $("#userinfo-password").val(jsondata.password);
                if(jsondata.is_active === '1'){
                    $("#is-active").prop('checked', true);
                }else{
                    $("#is-active").prop('checked', false);

                }
            });
        });
    });
}

function addUser(){
    $("#btn-add-user").click(function(){
        console.log($("#add-user-form").serializeArray());
        $(".invalid-feedback").hide();
        $.post('../../php/handlers/userHandler.php', $("#add-user-form").serialize(), (data)=>{
            if(data == 1){
                $("#add-user-modal").modal('hide');
                feedbackModal(data, "Added user successfully", "Add user failed", 0);
                getUsers();
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

function modalFunctions(){
    $("#add-user-is-active").change(()=>{
        if($("#add-user-is-active").prop('checked') == true){
            $("label[for='isActive']").html('&nbsp;Active');
        }else{
            $("label[for='isActive']").html('&nbsp;Inactive');
        }
    });
    $("#deleteUserConfirmationModal").on('show.bs.modal', ()=>{
        $("#deleteUserModalTitle").html("Delete item")
        $("#deleteUserModalMessage").html("Are you sure you want to delete "+$("#userinfo-name").html()+"?…")
    });
    $("button[data-dismiss='modal']").click(function(){
        $("#deleteUserConfirmationModal").modal('hide');
    });
    $("#suffix-checkbox").on('change', function(){
        if($(this).prop('checked') == false){
            $("#add-user-suffix").val('');
            $("#add-user-suffix").prop('readonly', true);
        }else{
            $("#add-user-suffix").prop('readonly', false);
        }
    });
    $("#mname-checkbox").on('change', function(){
        if($(this).prop('checked') == false){
            $("#add-user-mname").val('');
            $("#add-user-mname").prop('readonly', true);
        }else{
            $("#add-user-mname").prop('readonly', false);
        }
    });
}
function editUser(){
    $('#userinfo-edit').click(()=>{
        $.post('../../php/handlers/userHandler.php',
        {
            'edit-uid': $("#userinfo-userid").html(),
            'edit-password': $("#userinfo-password").val(),
            'edit-is_active': $("#is-active").prop('checked')
        },(data)=>{
        console.log(data);
           if(data != 1 && data != 0){
            $("#"+data+' ~.invalid-feedback').show();
           }else{
            $("#userinfomodal").modal('hide');
            feedbackModal(data, "Edited user successfully", "Edit user failed", 0);
            getUsers();
           }
        });
    });
}
function deleteUser(){
    $("#btn-delete-user").click(function(){
        $.post('../../php/handlers/userHandler.php', {'delete-user-id': $("#userinfo-userid").html()}, (data)=>{
            $("#deleteUserConfirmationModal").modal('hide');
            feedbackModal(data, "Deleted user successfully", "Delete user failed", 0)
            getUsers();
        });      
    });
}