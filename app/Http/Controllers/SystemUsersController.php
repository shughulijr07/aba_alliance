<?php

namespace App\Http\Controllers;

use App\AutogeneratedPassword;
use App\Helper;
use App\Http\Controllers\Controller;
use App\SystemUser;
use App\SystemRole;
use App\User;
use App\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Gate;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class SystemUsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        if (Gate::denies('access',['system_users','view'])){
            abort(403, 'Access Denied');
        }

        $system_roles = SystemRole::all();

        //record user activity
        $activity = [
            'action'=> 'View',
            'item'=> 'system_users',
            'item_id'=> '',
            'description'=> 'Viewed SystemUser List Page',
            'user_id'=> auth()->user()->id,
        ];

        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);

        $model_name = 'system_user';
        $controller_name = 'system_users';
        $view_type = 'index';

        return view('system_users.index', compact('system_roles','model_name', 'controller_name', 'view_type'));

    }


    public function create()
    {
        if (Gate::denies('access',['system_users','store'])){
            abort(403, 'Access Denied');
        }

        $system_user = new SystemUser();
        $system_roles = SystemRole::all();


        //record user activity
        $activity = [
            'action'=> 'View',
            'item'=> 'system_users',
            'item_id'=> '',
            'description'=> 'Viewed New SystemUser Page',
            'user_id'=> auth()->user()->id,
        ];

        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);

        $model_name = 'system_user';
        $controller_name = 'system_users';
        $view_type = 'create';


        return view('system_users.create',
            compact( 'system_user', 'system_roles',
                'model_name', 'controller_name', 'view_type'));
    }



    public function store(Request $request)
    {
        if (Gate::denies('access',['system_users','store'])){
            abort(403, 'Access Denied');
        }

        $userData = $this->validateRequest();

        //Because we are adding new user then re-validate email and phone no to make sure they are unique
        request()->validate([
            //'phone_no' =>  'required|regex:/(0)[0-9]{9}/|unique:users',
            'email' =>  'e-mail|required|unique:users',
        ]);


        //create user
        $user = $this->addSystemUserToGeneralUsersTable($userData);

        //create System User
        if(!isset($user->id)){
            Session::flash('message', 'Unable to create user please contact Development Team for this issue');
            return redirect()->back()->withInput();
        }

        $userData['user_id'] = $user->id;
        $userData['name'] = $userData['first_name'].' '.$userData['middle_name'].' '.$userData['last_name'];
        $userData['name'] = str_replace('  ','',$userData['name']);

        $systemUser = SystemUser::create($userData);

        //store Image if there is any
        $this->storeImage($systemUser);


        //record user activity
        $activity = [
            'action'=> 'Created',
            'item'=> 'system_users',
            'item_id'=> $systemUser->id,
            'description'=> 'Created New SystemUser With ID - '.$systemUser->id,
            'user_id'=> auth()->user()->id,
        ];

        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);

        //return redirect('system_user');
        return redirect('system_users/'.$systemUser->id);
    }



    public function show(SystemUser $system_user)
    {
        if (Gate::denies('access',['system_users','view'])){
            abort(403, 'Access Denied');
        }

        $system_roles = SystemRole::all();
        $autogenerated_password = null;
        if(isset($system_user->user)){
            $autogeneratedPassword = AutogeneratedPassword::where('user_id','=',$system_user->user->id)
                ->orderBy('id','DESC')->first();

            if(isset($autogeneratedPassword->id)){
                $autogenerated_password = $autogeneratedPassword->password;
            }
        }

        //record user activity
        $activity = [
            'action'=> 'View',
            'item'=> "system_user",
            'item_id'=> $system_user->id,
            'description'=> 'Viewed Information Page Of SystemUser with ID - '.$system_user->id,
            'user_id'=> auth()->user()->id,
        ];

        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);

        $model_name = 'system_user';
        $controller_name = 'system_users';
        $view_type = 'show';


        return view('system_users.show',
            compact( 'system_user', 'system_roles', 'autogenerated_password',
                'model_name', 'controller_name', 'view_type'));
    }



    public function edit(SystemUser $system_user)
    {
        if (Gate::denies('access',['system_users','edit'])){
            abort(403, 'Access Denied');
        }


        $system_roles = SystemRole::all();


        //record user activity
        $activity = [
            'action'=> 'Editing',
            'item'=> "system_user",
            'item_id'=> $system_user->id,
            'description'=> 'Viewed Information Page Of SystemUser with ID - '.$system_user->id.' In Editing Mode',
            'user_id'=> auth()->user()->id,
        ];

        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);


        $model_name = 'system_user';
        $controller_name = 'system_users';
        $view_type = 'create';

        return view('system_users.edit',
            compact( 'system_user', 'system_roles',
                'model_name', 'controller_name', 'view_type'));

    }


    public function update(Request $request, SystemUser $system_user)
    {
        if (Gate::denies('access',['system_users','edit'])){
            abort(403, 'Access Denied');
        }

        $userData = $this->validateRequest();

        $userData['name'] = $userData['first_name'].' '.$userData['middle_name'].' '.$userData['last_name'];
        $userData['name'] = str_replace('  ','',$userData['name']);

        //if email have been updated the revalidate it to make sure new email provided is unique
        if($system_user->email != $userData['email'] ){
            request()->validate([
                'email' =>  'e-mail|required|unique:users',
            ]);
        }
        //if phone number have been updated the revalidate it to make sure new phone number provided is unique
        if($system_user->phone_no != $userData['phone_no'] ){
            request()->validate([
                'phone_no' =>  'required|regex:/(0)[0-9]{9}/|unique:users',
            ]);
        }

        //if phone number have changed then revalidate it

        //update information
        $system_user->update($userData);

        //store Image if there is any
        $this->storeImage($system_user);

        //update user information in users table
        $this->updateSystemUserInformationInlUsersTable($system_user->user_id,$userData);


        //record user activity
        $activity = [
            'action'=> 'Updating',
            'item'=> "system_user",
            'item_id'=> $system_user->id,
            'description'=> 'Updated Information Of SystemUser with ID - '.$system_user->id,
            'user_id'=> auth()->user()->id,
        ];

        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);

        return redirect('system_users/'.$system_user->id);


    }


    public function destroy(SystemUser $system_user)
    {
        if (Gate::denies('access',['system_users','delete'])){
            abort(403, 'Access Denied');
        }

        $system_user->delete();

        $message  = auth()->user()->name.' has Deleted  SystemUser: '.$system_user->name;
        $message .= ' at '.date("d-m-Y H:i:s");

        //record user activity
        $activity = [
            'action'=> 'Deleting',
            'item'=> "system_user",
            'item_id'=> $system_user->id,
            'description'=> $message,
            'user_id'=> auth()->user()->id,
        ];
        $activity_category = 'major';
        UserActivity::record_user_activity($activity, $activity_category);


        return redirect('system_user');
    }


    private function storeImage($systemUser){

        if ( request()->has('image') ){
            //Save image
            $imagePath = request()->image->store('system_users/images','public');
            $imageName = str_replace('system_users/images/','',$imagePath);


            $originalImage= request()->image;
            //Save passport size
            $passportImage = Image::make($originalImage);
            $passportPath = storage_path()."/app/public/system_users/passports/".$imageName;
            $passportImage->save($passportPath);
            $passportImage->resize(450,null,function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $passportImage->save($passportPath);

            //Save thumbnail
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = storage_path()."/app/public/system_users/thumbnails/".$imageName;
            $thumbnailImage->save($thumbnailPath);
            $thumbnailImage->resize(64,null,function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnailImage->save($thumbnailPath);

            //Update participant details

            $systemUser->update([
                'image' => $imagePath,
                'passport' => 'system_users/passports/'.$imageName,
                'thumbnail' => 'system_users/thumbnails/'.$imageName,
            ]);

        }

    }


    public function addSystemUserToGeneralUsersTable($userData){ //we update access to the system by modifying users table


        $autogeneratedPassword =  Helper::generate_complex_random_password();

        $user = User::create([
            'name' => $userData['first_name'].' '.$userData['last_name'],
            'email' => $userData['email'],
            //'phone_no' => $userData['phone_no'],
            'category' => 'system_user',
            'role_id' => $userData['system_role_id'],
            'password' => Hash::make($autogeneratedPassword),
            'status' => 'active',
        ]);

        if(isset($user->id)){
            //Save autogenerated password
            $autogen_password = new AutogeneratedPassword();
            $autogen_password->user_id = $user->id;
            $autogen_password->password = $autogeneratedPassword;
            $autogen_password->save();
        }

        return $user;


    }


    public function updateSystemUserInformationInlUsersTable($userId,$userData){
        User::where('id',$userId)->update([
            'name' => $userData['first_name'].' '.$userData['last_name'],
            'email' => $userData['email'],
            //'phone_no' => $userData['phone_no'],
            'category' => 'system_user',
            'role_id' => $userData['system_role_id'],
            'status' => 'active',
        ]);
    }


    private function validateRequest(){

        return  request()->validate([
            'first_name' =>  'required',
            'middle_name' =>  'required',
            'last_name' =>  'required',
            'gender' =>  'required',
            'phone_no' =>  'required|regex:/(0)[0-9]{9}/',
            'email' =>  'e-mail|required',
            'company' =>  'nullable',
            'description' =>  'nullable',
            'image' =>  'sometimes|file|image|max:3000',
            'status' =>  'required',
            'system_role_id' =>  'required',
        ]);



    }





    public function ajaxGetSystemUsers(Request $request){

        if(!request()->ajax()) exit;

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];//Column index
        $columnName = $columnName_arr[$columnIndex]['data'];//Column name
        $columnSortOrder = $order_arr[0]['dir'];//asc or desc
        $searchValue = $search_arr['value'];//Search value

        //Convert Column Names
        if($columnName == "#"){$columnName = "id";}
        if($columnName == "Id"){$columnName = "id";}
        if($columnName == "Name"){$columnName = "name";}
        if($columnName == "Gender"){$columnName = "gender";}
        if($columnName == "Phone"){$columnName = "phone_no";}
        if($columnName == "Email"){$columnName = "email";}
        if($columnName == "Company"){$columnName = "company";}
        if($columnName == "Role"){$columnName = "system_role_id";}
        if($columnName == "Status"){$columnName = "status";}
        if($columnName == "Actions"){$columnName = "id";}

        $exactMatchColumns = [
            'id','status','system_role_id'
        ];

        $records = [];
        $totalRecords = SystemUser::select('count(*) as allcount');
        $totalRecordsWithFilter = 0;



        if(empty($request->filters))
        {
            // Total records
            $totalRecordsWithFilter = SystemUser::select('count(*) as allcount');

            //Exclude columns which are not in database
            if(!in_array($columnName, ["#","Actions"])){
                $totalRecordsWithFilter = $totalRecordsWithFilter->where($columnName, 'like', '%' .$searchValue . '%');
                $records = SystemUser::orderBy($columnName,$columnSortOrder)->where($columnName, 'like', '%' .$searchValue . '%');
            }else{
                $records = SystemUser::orderBy('id',$columnSortOrder);
            }

            $data_arr = array();

        }else{

            // Total records
            $totalRecordsWithFilter = SystemUser::select('count(*) as allcount');
            foreach ($request->filters as $filter_name => $filter_value ){
                $searchValue = $filter_value;
                $columnName = $filter_name;
                if(!in_array($searchValue, ['',null])){

                    if(in_array($columnName, $exactMatchColumns)){
                        $totalRecordsWithFilter = $totalRecordsWithFilter->where($columnName, '=', $searchValue);
                    }else{
                        $totalRecordsWithFilter = $totalRecordsWithFilter->where($columnName, 'like', '%' .$searchValue . '%');
                    }
                }
            }

            // Fetch records
            $records = SystemUser::orderBy($columnName,$columnSortOrder);
            foreach ($request->filters as $filter_name => $filter_value ){
                $searchValue = $filter_value;
                $columnName = $filter_name;
                if(!in_array($searchValue, ['',null])){
                    if(in_array($columnName, $exactMatchColumns)){
                        $records = $records->where($columnName, '=', $searchValue);
                    }else{
                        $records = $records->where($columnName, 'like', '%' .$searchValue . '%');
                    }
                }
            }


            $data_arr = array();
        }


        $totalRecordsWithFilter = $totalRecordsWithFilter->count();
        $records = $records->select('*')->skip($start)->take($rowperpage)->get();
        $totalRecords = $totalRecords->count();



        $no = 1;
        foreach($records as $record){


            $actions = '<div class="btn-group dropdown">
                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                <i class="pe-7s-menu btn-icon-wrapper"></i>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-212px, 36px, 0px);">
                                <h6 tabindex="-1" class="dropdown-header">'.$record->name.'</h6>';

            $actions .='<a href="'.url('/system_users/'.$record->id).'" target="_blank" type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-eye"> </i><span>View User Details</span></a>';

            if (!Gate::denies('access',['system_users','edit'])){
                $actions .='<a href="'.url('/system_users/'.$record->id.'/edit').'" target="_blank"  type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-pencil"> </i><span>Edit User Details</span></a>';
            }

            if (!Gate::denies('access',['system_users','delete'])){
                $actions .='        <a type="button" tabindex="0" class="dropdown-item" data-id="'.$record->id.'"><i class="dropdown-icon lnr-trash"> </i><span>Delete User</span></a>';
            }

            $actions .='        <div tabindex="-1" class="dropdown-divider"></div>
                                <div class="p-3 text-right">
                                    <button class="mr-2 btn-shadow btn-sm btn btn-primary">Close</button>
                                </div>
                            </div>
                        </div>';


            $data_arr[] = array(
                //"#" => $no,
                "Id" => $record->id,
                "Name" => $record->name,
                "Gender" => $record->gender,
                "Phone" => $record->phone,
                "Email" => $record->email,
                "Company" => $record->company,
                "Role" => $record->user ? $record->user->system_role->name : "",
                "Status" => $record->status  == 'Active' ? "<div class='mb-2 mr-2 badge badge-success'>Active</div>" : "<div class='mb-2 mr-2 badge badge-danger'>Inactive</div>",
                "Actions" => $actions,
            );

            $no++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;

    }


}
