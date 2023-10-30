<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


class UserapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Log::info('UserapiController.index');
         //return UserResource::collection(User::all());
         $orderColumn = request('order_column', 'created_at');
         if (!in_array($orderColumn, ['id', 'name', 'created_at'])) {
             $orderColumn = 'created_at';
         }
         $orderDirection = request('order_direction', 'desc');
         if (!in_array($orderDirection, ['asc', 'desc'])) {
             $orderDirection = 'desc';
         }
         $users = User::
         when(request('search_id'), function ($query) {
             $query->where('id', request('search_id'));
         })
             //->where('status', '!=', '0')
             ->when(request('search_title'), function ($query) {
                 $query->where('name', 'like', '%'.request('search_title').'%');
                 
             })
             ->when(request('search_global'), function ($query) {
                 $query->where(function($q) {
                     $q->where('name', 'like', '%'.request('search_global').'%')
                         ->orWhere('jobtitle', 'like', '%'.request('search_global').'%');
 
                 });
             })
             ->where('status', '!=', '0')
             ->orderBy($orderColumn, $orderDirection)
             ->paginate(10);
 
             return UserResource::collection($users);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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


    //functionality to get all users from GLPI
    public function usersupdate()
    {
        Log::info('UserapiController.usersupdate');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://glpi.dunice.com.br/apirest.php/initSession',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic bHVjY2FzLnJpY2llcmk6UCNzc3cwcmQz',
            'App-Token: Bo3b3dDobZ9cgZZFWSr7o870i86BE0eRWSO9Vl5L',
            'Content-Type: aplicativo/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        if($response['session_token']){
            $token = $response['session_token'];
        }else{
            //return response()->json(['status' => 405, 'success' => false]);  
            return response()->json([
                'status' => true,
                'title' => 'Token',
                'message' => 'Token não encontrado!'
            ], Response::HTTP_OK);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://glpi.dunice.com.br/apirest.php/searchTeste/user',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'App-Token: Bo3b3dDobZ9cgZZFWSr7o870i86BE0eRWSO9Vl5L',
            'Content-Type: aplicativo/json',
            'Session-Token:' . $token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        $users = $response;

        foreach ($users as $key => $user) {
            if($this->usercheck($user) == false){
                $this->useradd($user);
                Log::info('UserapiController.usersupdate - useradd' . $user['email']);
            }else{
                $this->userupdate($user);
            }
        }

        return response()->json([
            'status' => true,
            'title' => 'Update',
            'message' => 'Employees updating success!'
        ], Response::HTTP_OK);
        

        
    }
    //firts step: check if user exists in local database
    public function usercheck($user)
    {
        $employee = User::where('email', $user['email'])->first();
        if($employee){
            return true;
        }else{
            return false;
        }
    }
    //if user not exists in local database, add user with permissions and roles
    public function useradd($user)
    {
        $valuesstr = array(".", "-");
        $hashpassword = str_replace($valuesstr, "", $user['foxcpffield']);

        if($user['email'] == 'luccas.ricieri@dunice.adv.br'){
            $role = 'admin';
        }else{
            $role = 'standard';
        }
        if($user['foxdatadenascimentofield'] != null){
            $valstring = strlen($user['foxdatadenascimentofield']);
            if($valstring == 10){
                $birthday = explode('/', $user['foxdatadenascimentofield']);
                $birthdayusa = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];
                
            }else{
                $birthdayusa = '1990-01-01';
            }
        }else{
            $birthdayusa = '1990-01-01';
        }

            $useradd = new User();
            $useradd->email = $user['email'];
            $useradd->status = $user['is_active'];
            $useradd->extension = $user['phone'];
            $useradd->name = $user['firstname'] . ' ' . $user['realname'];
            $useradd->jobtitle = $user['name'];
            $useradd->sector = $user['completename'];
            $useradd->document = $user['foxcpffield'];
            $useradd->birthday = $birthdayusa;
            $useradd->password = Hash::make($hashpassword);
            $useradd->assignRole($role);
            $useradd->save();
    }
    //if user exists in local database, update user
    public function userupdate($user)
    {
        $userupdate = User::where('email', $user['email'])
                //->where('status', '=', '1')
                ->first();
        if($user['foxdatadenascimentofield'] != null){
            $valstring = strlen($user['foxdatadenascimentofield']);
            if($valstring == 10){
                $birthday = explode('/', $user['foxdatadenascimentofield']);
                $birthdayusa = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];
                
            }else{
                $birthdayusa = '1990-01-01';
            }
        }else{
            $birthdayusa = '1990-01-01';
        }

        if($userupdate){
            $userupdate->email = $user['email'];
            $userupdate->status = $user['is_active'];
            $userupdate->extension = $user['phone'];
            $userupdate->name = $user['firstname'] . ' ' . $user['realname'];
            $userupdate->jobtitle = $user['name'];
            $userupdate->sector = $user['completename'];
            $userupdate->document = $user['foxcpffield'];
            $userupdate->birthday = $birthdayusa;
            $userupdate->save();
        }
    }

    //list of inactive users
    public function inactiveusers()
    {
        
        $orderColumn = request('order_column', 'created_at');
        if (!in_array($orderColumn, ['id', 'name', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }
        $users = User::
        when(request('search_id'), function ($query) {
            $query->where('id', request('search_id'));
        })
            //->where('status', '!=', '0')
            ->when(request('search_title'), function ($query) {
                $query->where('name', 'like', '%'.request('search_title').'%');
            })
            ->when(request('search_global'), function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.request('search_global').'%')
                        ->orWhere('jobtitle', 'like', '%'.request('search_global').'%');

                });
            })
            ->where('status', '=', '0')
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(10);

            return UserResource::collection($users);
    }
}
