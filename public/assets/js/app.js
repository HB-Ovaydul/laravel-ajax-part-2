(function($){
 $(document).ready(function(){
    // alert function
    function alertkey(mgs, type = 'danger'){
        return `<p class="alert alert-${type} alert-dismissible">${mgs}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></p>`;
    }
    alertkey();

    // Regular Expration Email Validate 
    function checkemial(check){
        let filter =  /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/
        if(filter.test(check)){
            return false;
        }else{
            return true;
        }
    }
    checkemial();

    // Regular Expration Phone Number Validate
    function phonecheck(phone){
        let filter = /^(01|8801|\+8801|07)[0-9]{9}$/
        if(filter.test(phone)){
            return false;
        }else{
            return true;
        }
    }
    phonecheck();

  // Form Background-color change
    $('#theme').click(function(e){
        e.preventDefault();
        $('#card_table').css('background-color', '#232323').css('color', 'white');
    });

    $('#student_table').DataTable({
        processing: true,
        serverSide: true,
        ajax : {
            url : '/student',
        },
        columns : [
            {
                data : 'id',
                name : 'id',
            },
            {
                data : 'name',
                name : 'name',
            },
            {
                data : 'email',
                name : 'email',
            },
            {
                data : 'cell',
                name : 'cell',
            },
            {
                data : 'username',
                name : 'username',
            },
            {
                data : 'birth',
                name : 'birth',
            },
            {
                data : 'location',
                name : 'location',
            },
            {
                data : 'edu',
                name : 'edu',
            },
            {
                data : 'gender',
                name : 'gender',
            },
            {
                data : 'photo',
                name : 'photo',
                render: function(data){
                    return `<img class="table-img" src="storage/student/${data}">`;
                }
            },
            {
                data : 'action',
                name : 'action'
            },
         
        ]
        
    });

    // Photo Preview when Create Profile
         $('#photo_id').change(function(e){
            e.preventDefault();
            let url = URL.createObjectURL(e.target.files[0]);
             $('#preview').attr('src', url);
        });

    // Photo Preview when Edit Profile
         $('#pre_photo_id').change(function(e){
            e.preventDefault();
            let url = URL.createObjectURL(e.target.files[0]);
             $('#edit_preview').attr('src', url);
        });
    // Show Account Create Modal
    $('#student_add').click(function(e){
        e.preventDefault();
        $('#create_modal').modal('show');
    });
    //Create Student Account
        $('#create_student').submit(function(e){
        e.preventDefault();
        let name = $('#create_student input[name="name"]').val();
        let email = $('#create_student input[name="email"]').val();
        let cell = $('#create_student input[name="phone"]').val();

        if (name == '' || email == '' || cell == '') {
             $('.msg').html(alertkey('All filed Are Required!','danger'));
        }else if(checkemial(email)){
            $('.msg').html(alertkey('Your email Number Is Invalid'));
        }else if(phonecheck(cell)){
            $('.msg').html(alertkey('Your Phone Number Is Invalid'));
        }else{
            $.ajax({
                url : '/student',
                method : 'POST',
                data : new FormData(this),
                contentType: false,
                processData: false,
                success : function(data){
                    $('#create_student')[0].reset();
                    $('#student_table').DataTable().ajax.reload();
                    $('#create_modal').modal('hide');
                }
            });
        }
        
    });

    // Delete User Profile
    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        let id = $(this).attr('delete_id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : '/delete/'+id,
                    success : function(data){
                        Swal.fire(
                            'Hi '+ data,
                            'Your Data Deleted SuccessFul!',
                            'success'
                            )
                        $('#student_table').DataTable().ajax.reload()

                    }
                });
            }
          })
    });
// Show Modal & Edit Profile
$(document).on('click', '.edit', function(e){
    e.preventDefault();
    let edit_id = $(this).attr('edit_id');
    $.ajax({
        url : '/edit/'+edit_id,
        success : function(data){
            $('#update_student input[name="name"]').val(data.name);
            $('#update_student input[name="username"]').val(data.username);
            $('#update_student input[name="email"]').val(data.email);
            $('#update_student input[name="phone"]').val(data.cell);
            $('#update_student input[name="location"]').val(data.location);
            $('#update_student input[name="birthday"]').val(data.birth);
            $('#update_student input[name="update_id"]').val(data.id);
            $('.student_gender').html(data.gender);
            $('.student-select').html(data.edu);
            $('.preview_img').html(data.photo);
            $('.input_id').html(data.input);
            $('#edit_modal').modal('show');
            
        }
    });
});

 // Update Profile
 $('#update_student').submit(function(e){
    e.preventDefault();
    // update
    $.ajax({
        url : '/update-data',
        method : 'POST',
        data : new FormData(this),
        contentType : false,
        processData : false,
        success : function(data){

            $('#student_table').DataTable().ajax.reload();
            $('#edit_modal').modal('hide'); 
            Swal.fire(
                'Your',
                'Data Updated',
                'success',
            )
           
        }
    });
}); 

/**
 *  View Single Profile
 */

$(document).on('click', 'a.view_prof',function(e){
    e.preventDefault();
    $('#view_single_page').modal('show');
    let view_id = $(this).attr('view_id');
    $.ajax({
        url : '/view-single-page/'+view_id,
        // method : 'GET',
        success : function(data){
            $('#single_view').html(data);
        }

    });
    
});




 });
})(jQuery);


