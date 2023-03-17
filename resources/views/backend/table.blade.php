<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <!-- Css Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="DataTables/datatables.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="assets/fontawesome/css/brands.css">
    <link rel="stylesheet" href="assets/fontawesome/css/solid.css">
    <link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    
       
 
<div class="container">
    <div class="p-2 shadow border table-responsive table-responsive-sm w-100 m-auto my-5">
        <div class="add mb-2">
            <a id="student_add" class="btn btn-md btn-primary" href="#">Add Student</a>
         </div>
        <table id="student_table" class="table table-striped table-hover table-secondary">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Cell</th>
                <th scope="col">UserName</th>
                <th scope="col">Birthday</th>
                <th scope="col">Location</th>
                <th scope="col">Graduation</th>
                <th scope="col">Gender</th>
                <th scope="col">Photo</th>
                <th scope="col">Action</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>

    {{-- Student Account Create Modal --}}
    <div id="create_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Create A New Account</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="msg"></div>
                    <form id="create_student" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Name</label>
                                <input name="name" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">UserName</label>
                                <input name="username" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Email</label>
                                <input name="email" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone</label>
                                <input name="phone" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Location</label>
                                <input name="location" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Birthday</label>
                                <input type="date" name="birthday" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="male">Male</label> <input name="gender" type="radio" value="male" id="male">
                                <label for="female">Female</label> <input name="gender" type="radio" value="female" id="female">
                            </div>
                            <div class="col-md-6">
                                <select name="education" id="" class="form-control form-select">
                                    <option value="">-select-</option>
                                    <option value="PSC">PSC</option>
                                    <option value="JSC">JSC</option>
                                    <option value="SSC">SSC</option>
                                    <option value="HSC">HSC</option>
                                </select>
                            </div>
                        </div>
                        <div class="student-img mb-3">
                            <label>Upload Photo</label>
                            <br>
                            <img style="max-width:100%; height:300px; object-fit:cover" id="preview" src="" alt="">
                            <br>
                            <input style="display: none" type="file" name="photo" id="photo_id">
                            <label for="photo_id">
                                <img id="photo_id" style="width:80px; height:auto;" src="assets/image/slide1.png" alt="">
                            </label>
                           
                        </div>
                        <div class="mb-2">
                             <input id="remove" type="submit" class="btn btn-primary btn-md" value="Sing up">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Edit Profile Modal --}}
    <div id="edit_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Edit Profile ?</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="msg"></div>
                    <form id="update_student" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Name</label>
                                <input name="name" type="text" class="form-control">
                                <input name="update_id" type="hidden">
                            </div>
                            <div class="col-md-6">
                                <label for="">UserName</label>
                                <input name="username" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Email</label>
                                <input name="email" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone</label>
                                <input name="phone" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Location</label>
                                <input name="location" type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Birthday</label>
                                <input name="birthday" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 student_gender">

                            </div>
                            <div class="col-md-6 student-select">

                            </div>
                        </div>
                        <div class="student-img mb-3">
                            <label>Upload Photo</label>
                            <br>
                                <div class="preview_img">

                                </div>
                            <br>
                            <label class="input_id" for=""></label>
                            <input style="display: none;" type="file" name="new_photo" id="pre_photo_id">
                            <label for="pre_photo_id">
                                <img id="pre_photo_id" style="width:80px; height:auto;" src="assets/image/slide1.png" alt="">
                            </label>
                           
                        </div>
                        <div class="mb-2">
                             <input id="remove" type="submit" class="btn btn-primary btn-md" value="update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- View Single page --}}

<div id="view_single_page" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>My Profile ?</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="single_view" class="modal-body">
                
            </div>
        </div>
    </div>
</div>





<!-- Js Files -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="DataTables/datatables.min.js"></script>
<script src="assets/fontawesome/js/fontawesome.js"></script>
<script src="assets/fontawesome/js/solid.js"></script>
<script src="assets/fontawesome/js/brands.js"></script>
<script src="assets/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/app.js"></script>

</body>
</html>