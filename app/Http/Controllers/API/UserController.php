<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyCollection;
use App\Http\Resources\UsersRes;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use function App\Helpers\response_json;
use function Symfony\Component\Translation\t;

class UserController extends Controller{

    const key_att = ['id','name','email','phone','type','password','key', 'resoum_id', 'contactsinfo_id'];

    public function __construct(){
        $this->middleware('auth:custom-header');
        $this->middleware('auth:user-api',['only'=>['update','destroy']]);
    }

    public function test(){
        return response_json(['ok'=>true]);
    }

    public static function Returnok(mixed $resource) :JsonResponse{
        return response_json((new MyCollection(UsersRes::collection($resource))));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $Collections = User::all(self::key_att);
        return self::Returnok($Collections);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'unique:users,email', 'email:rfc'],
            'phone' => ['numeric', Rule::requiredIf(true), 'unique:users,phone', 'starts_with:989', 'digits:12'],
            'type' => ['required', 'string', Rule::in(['personally', 'company'])],
            'password' => ['required', 'string', 'min:8'],
            'key' => ['string', 'unique:users,key']
        ]);


        $make_user = User::create($request->all(self::key_att));
        //dd($make_user);
        return response_json([
            'ok' => true,
            'result' => 'ok',
            'message' => 'user created',
            'with_id' => $make_user->id
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResponse{
        $Collections = User::FindOrFail($id);
        return self::Returnok(new Collection([$Collections]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id){

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):JsonResponse{
        $request->validate([
            'name' => ['string', 'max:30'],
            //'Email'=>['unique:users,Email','email:rfc'],
            //'Phone'=>['numeric',Rule::requiredIf(true),'unique:users,Phone','starts_with:989','digits:12'],
            //'Type'=>['string',Rule::in(['personally','company'])],
            'password' => ['string', 'min:8'],
            'key' => ['string', 'unique:users,key']
        ]);
        /** @var User $Collections */
        $Collections = auth()->user();

        if ($Collections->update($request->only(['name', 'password', 'key']))) {
            return response_json([
                'ok' => true,
                'result' => 'ok',
                'message' => 'user updated',
                'id' => $Collections->id
            ]);
        } else throw new \Exception("something happened on update user model.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        /** @var User $user */
        $user = auth()->user();
        if ($user->delete()) {
            return response_json([
                'ok' => true,
                'result' => 'ok',
                'message' => 'user deleted'
            ]);
        } else throw new \Exception("something happened on delete user model.");
    }

    public function usersform(){
        $users = User::all();
        return view('users.users',compact('users'));

    }
}
