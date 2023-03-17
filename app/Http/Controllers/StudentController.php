<?php

namespace App\Http\Controllers;

// use datatables;
use Storage;
use datatables;
use App\Models\Student;
use Illuminate\Http\Request;
use Livewire\Commands\StubParser;
use Illuminate\Support\Facades\URL;
use Psy\CodeCleaner\ReturnTypePass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Intervention\Image\Facades\Image;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Yajra\DataTables\Html\Editor\Fields\Field;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if(request()->ajax()){
            
            return datatables()->of(Student::all())
            ->addColumn('action', function($data){
                $input = '';
                $input .= '<a type="button" view_id="'.$data -> id.'" class="view_prof btn btn-sm mx-1 btn-primary" href="#"><i class="fa-solid fa-street-view"></i></a>';
                $input .= '<a type="button" edit_id="'.$data -> id.'" class="btn edit btn-sm mx-1 btn-warning" href="#"><i class="fa-solid fa-pen-to-square"></i></a>';
                $input .= '<a type="button" delete_id="'.$data -> id.'" class="delete btn btn-sm mx-1 btn-danger" href="#"><i class="fa-solid fa-trash-can"></i></a>';
                return $input;
            })->rawColumns(['action'])->make();
         }
        return view('backend.table');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
     // Photo uploade
     if($request -> hasFile('photo')){
        $img = $request ->file('photo');
        $file_name = md5(time().rand()).'.'.$img -> clientExtension();
        $file_inter = Image::make($img -> getRealPath());
        $file_inter -> save(storage_path('app/public/student/'.$file_name ));
    }
    
    // Student Data Store
        Student::create([
        'name'  => $request -> name,
        'username'  => $request -> username,
        'email'  => $request -> email,
        'cell'  => $request -> phone,
        'birth'  => $request -> birthday,
        'gender'  => $request -> gender,
        'edu'  => $request -> education,
        'location'  => $request -> location,
        'photo'  => $file_name,
    ]);

    return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function DataStore(Request $request)
    {
             
    }

    // Delete mathod?
    public function Delete_id($id)
    {
      $data = Student::findOrFail($id);
      $data -> delete();
      return $data -> name;
    }

    // Student Edit Method
    public function Edit_id($id)
    {
      $edit = Student::find($id);

      // Show old img input tag
         $input = '<input old_img="'.$edit -> id.'" type="hidden" name="old_photo" value="">';
        // Gender Html convart With jquery
        $gender_data = '<input name="gender" '.($edit -> gender == 'male' ? 'checked' : "").' type="radio" value="male" id="male"> <label for="male">Male</label>
        <input name="gender" '.($edit -> gender == 'female' ? 'checked' : "").' type="radio" value="female" id="female"> <label for="female">Female</label> ';

        // Education html convart with jquery
        $edu_id = '';
        $edu_type = ['PSC','JSC','SSC','HSC'];

        $edu_id .= '<select name="education" id="" class="form-control form-select">';
        $edu_id .= '<option value="">-select-</option>';
            foreach($edu_type as $edus){
                $edu_id .= '<option '.($edus == $edit -> edu ? "selected" : "").' value="'.$edus.'">'.$edus.'</option>';
            }  
        $edu_id .= '</select>';
        
        // load Image
            $data = '<img style="max-width:100%; height:300px; object-fit:cover" id="edit_preview" src="'.('storage/student/'.$edit-> photo).'" alt="">';
        // return all key
      return [
        'id'      => $edit -> id, 
        'name'      => $edit -> name, 
        'username'  => $edit -> username, 
        'email'     => $edit -> email, 
        'cell'      => $edit -> cell,
        'location'  => $edit -> location, 
        'birth'     => $edit -> birth, 
        'gender'    => $gender_data, 
        'edu'       => $edu_id, 
        'photo'     => $data,  
        'input'     => $input, 

      ];
    }

    /**
     *  Student Data update
     */
    public function update_data(Request $request)
    {
        $studnet_data = Student::findOrFail($request -> update_id);

        // Photo update
        if($request -> hasFile('new_photo')){
 
            // Photo Upload
            $img = $request -> file('new_photo');
            $update_file = md5(time().rand()).'.'.$img -> clientExtension();
            $inter_image = Image::make($img -> getRealPath());
            $inter_image -> save(storage_path('app/public/student/'.$update_file));

            // Old image Delete
            $img_path = 'storage/student/'.$studnet_data -> photo;
            if(File::exists($img_path)){
                 File::delete($img_path);
            }
        }else{
            $update_file = $studnet_data -> old_photo;
        }
        $studnet_data -> name       = $request -> name;
        $studnet_data -> username   = $request -> username;
        $studnet_data -> email      = $request -> email;
        $studnet_data -> cell       = $request -> phone;
        $studnet_data -> location   = $request -> location;
        $studnet_data -> birth      = $request -> birthday;
        $studnet_data -> gender     = $request -> gender;
        $studnet_data -> edu        = $request -> education;
        $studnet_data -> update([
            'photo'    => $update_file,
        ]);

       
    }

    /**
     *  view Signle Page
     */
    public function view_single_page($id)
    {
      $view = Student::find($id);
        
      $single = '';

      $single .= '<table class="table table-striped table-hover table-info">';
        $single .= '<img class="view_img" src="storage/student/'.$view -> photo.'">';
        $single .= '<hr>';
        $single .= '<tr> <th>Name:</th> <td>'.$view -> name.'</td></tr>';
        $single .= '<tr> <th>UserName:</th> <td>'.$view -> username.'</td></tr>';
        $single .= '<tr> <th>Email:</th> <td>'.$view -> email.'</td></tr>';
        $single .= '<tr> <th>Phone:</th> <td>'.$view -> cell.'</td></tr>';
        $single .= '<tr> <th>Birthday:</th> <td>'.$view -> birth.'</td></tr>';
        $single .= '<tr> <th>Gender:</th> <td>'.$view -> gender.'</td></tr>';
        $single .= '<tr> <th>location:</th> <td>'.$view -> location.'</td></tr>';
        $single .= '<tr> <th>Graduation:</th> <td>'.$view -> edu.'</td></tr>';
      $single .= '</table>';
       
  return $single;

    //   <tr>
    //       <th>Name:</th>
    //       <td>ovaydul</td>
    //   </tr>
    //   <tr>
    //       <th>Name:</th>
    //       <td>ovaydul</td>
    //   </tr>
    //   <tr>
    //       <th>Name:</th>
    //       <td>ovaydul</td>
    //   </tr>
    //   <tr>
    //       <th>Name:</th>
    //       <td>ovaydul</td>
    //   </tr>
      
    }

}