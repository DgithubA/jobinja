<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyCollection;
use App\Http\Resources\ResoumRes;
use App\Http\Resources\UsersRes;
use App\Models\Admin;
use App\Models\CompanyInfo;
use App\Models\User;
use App\Models\UserResoum;
use App\Rules\Boolean;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use function App\Helpers\response_json;

class ResoumController extends Controller{

    public function __construct(){
        $this->middleware('auth:user-api', ['only' => ['store', 'update', 'destroy']]);
    }


    public static function Returnok(mixed $resource): JsonResponse{
        return response_json((new MyCollection(ResoumRes::collection($resource))));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $Collection = UserResoum::all();
        foreach (CompanyInfo::all() as $item) {
            $Collection->add($item);
        }
        return self::Returnok($Collection);
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
        /** @var User $user */
        $user = auth()->user();
        $get = $user->resoum()->get();
        if ($get->isEmpty()) {
            if ($user->type === 'personally') {
                $request->validate(self::GetValidateRules());
                $make_resoum = $user->resoum()->create($request->all());
            } else {
                $request->validate([
                    //'likes',
                    'category' => 'required|string',
                    'number_of_ex' => "nullable|integer",
                    'build_year' => "nullable|integer",
                    'description' => 'nullable|string'
                ]);
                $make_resoum = $user->resoum()->create($request->all());
            }
            return response_json([
                'ok' => true,
                'result' => 'resoum created',
                'message' => 'resoum created successfully',
                'with_id' => $make_resoum->id
            ], 201);
        } else {
            return response_json([
                'ok' => false,
                'result' => 'duplicate model',
                'message' => 'u make resoum before.',
                'with_id' => $get[0]->id
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        if (!empty($id)) {
            $Collection = UserResoum::FindOrfail($id);
        }else{
            if(Auth()->check()){
                /** @var User $user */
                if($user = Auth::user() instanceof User){
                    $Collection = $user->resoum()->get();
                }
            }
        }

        //dd($Collection->first());
        return self::Returnok(new Collection([$Collection]));
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
    public function update(Request $request, string $id){
        /** @var User $user */
        $user = auth()->user();
        $request->validate(self::GetValidateRules());
        if ($user->resoum()->exists()) {
            if ($user->resoum()->get()[0]->update($request->all())) {
                return response_json([
                    'ok' => true,
                    'result' => "updated",
                    'message' => 'user resoum updated.',
                    'with_id' => $user->resoum()->get()[0]->id
                ]);
            } else throw new \Exception("something happened on update resoum");
        } else throw new \Exception("not resoum exist. first make it");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        /** @var User $user */
        $user = auth()->user();
        if ($user->resoum()->delete() !== 0) {
            return response_json([
                'ok' => true,
                'result' => 'deleted',
                'message' => 'user resoum deleted'
            ]);
        } else throw new \Exception('something happened on delete resoum');
    }

    private static function GetValidateRules($nullable = true){
        $nullable = $nullable ? 'nullable' : 'required';
        return [
            //'Likes',
            'public' => [$nullable,new Boolean],
            'job_title' => [$nullable,'string','max:255'],
            'job_status' => [$nullable,'string','max:255'],
            'expertise_category' => [$nullable,'array'],
            'skills' => [$nullable,'array'],
            'years_of_birthday' => [$nullable,'integer','digits:4'],
            'languages' => [$nullable,'array'],
            'about' => [$nullable,'string']
        ];
    }
}
