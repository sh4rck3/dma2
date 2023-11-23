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

    public function userslanding()
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

    public function birthdaylanding()
    {
     
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
             ->whereMonth('birthday', '=', date('m'))
             ->when(request('search_title'), function ($query) {
                 $query->where('name', 'like', '%'.request('search_title').'%');
             })
             ->when(request('search_global'), function ($query) {
                 $query->where(function($q) {
                     $q->where('name', 'like', '%'.request('search_global').'%')
                     ->orWhere('jobtitle', 'like', '%'.request('search_global').'%');
 
                 });
             })
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
         
         $users = User::findOrFail($id);
 
            return new UserResource($users);
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
        
        $user = User::findOrFail($id);
        $user->delete();

        //return response()->noContent();
    }


    //functionality to get all users from GLPI
    public function usersupdate()
    {
       
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
        Log::debug('response - ' . print_r($response, true));
        curl_close($curl);
        $response = json_decode($response, true);

        if($response == null){
             
            return response()->json([
                'status' => true,
                'title' => 'API GLPI',
                'message' => 'Api não retornou token de sessão!',
                'icon' => 'warning'
            ], Response::HTTP_OK);
        }else{
            if($response['session_token']){
                $token = $response['session_token'];
            }else{
                $token = '';
            }
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
        $a = 0;
        $u = 0;
        foreach ($users as $key => $user) {
            if($this->usercheck($user) == false){
                $this->useradd($user);
                Log::info('UserapiController.usersadd - ' . $user['email']);
                $a++;
            }else{
                if($this->userupdate($user) == false){
                    Log::info('Não atualizado nao entra no criterio - ' . $user['email']);
                }else{

                    $u++;
                }
            }
           
        }
        Log::info('Add - ' . $a . ' - Update - ' . $u);
        if($a > 0){
            return response()->json([
                'status' => true,
                'title' => 'Adicionados',
                'message' => 'Quantidade de usuários adicionados!' . $a,
                'icon' => 'success'
            ], Response::HTTP_OK);
        }elseif($u > 0){
            return response()->json([
                'status' => true,
                'title' => 'Atualizados',
                'message' => 'Lista de usuários atualizados!' . $u,
                'icon' => 'success'
            ], Response::HTTP_OK);
        }elseif($a == 0 && $u == 0){
            return response()->json([
                'status' => true,
                'title' => 'SEM ALTERAÇÕES',
                'message' => 'Comparado os ados e não houve alterações!',
                'icon' => 'info'
            ], Response::HTTP_OK);
        }  
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
        }elseif($user['email'] == 'ederson.anjos@dunice.adv.br' || $user['email'] == 'alice.rodrigues@dunice.adv.br'){
            $role = 'financeiro';
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
        $dateTime = explode(' ', $user['updated_at']);
        $dateApi = $dateTime[0] ;
        $timeApi = $dateTime[1];
        Log::debug('dateTime - ' . print_r($dateTime, true));
        $userupdate = User::where('email', '=', $user['email'])
                    ->where(
                        function($query) use ($dateApi, $timeApi) {
                        $query->whereDate('updateGlpi', '<', $dateApi)
                        ->whereTime('updateGlpi', '<', $timeApi);
                      }
                      )//('updateGlpi', '<', $user['updated_at'])
                    ->first();

        if($userupdate){
            if(is_numeric($userupdate->id) && $userupdate->id != '4'){
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


            $userupdate->email = $user['email'];
            $userupdate->status = $user['is_active'];
            $userupdate->extension = $user['phone'];
            $userupdate->name = $user['firstname'] . ' ' . $user['realname'];
            $userupdate->jobtitle = $user['name'];
            $userupdate->sector = $user['completename'];
            $userupdate->document = $user['foxcpffield'];
            $userupdate->birthday = $birthdayusa;
            $userupdate->updateGlpi = $user['updated_at'];
            $userupdate->save();
            Log::info('atualizado - ' . print_r($user, true));
            return $userupdate->id;
            
            }else{
                return false;
            }
            
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
