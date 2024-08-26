<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyCollection;
use App\Http\Resources\PostsRes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use function App\Helpers\response_json;
class PostController extends Controller
{

    const key_att = ['status', 'title', 'type', 'job_classification',
        'description', 'type_of_cooperation', 'benefit', 'states', 'work_experience', 'job_position', 'required_gender', 'acceptable_military_service_status', 'minimum_education_degree'];


    public function __construct(){
        $this->middleware('auth:user-api', ['only' => ['store', 'update', 'destroy']]);
        //$this->middleware('auth:custom-header');

    }

    public static function Returnok(mixed $resource): JsonResponse
    {
        return response_json((new MyCollection(PostsRes::collection($resource))));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        /** @var Collection $Collections */
        //return response_json(['message'=>'test error'],429);
        $builder = Post::query();
        if(!empty($request->filters)){
            $filters = $request->filters;
            $in_array = function (Builder $builder,string $column,array|string $values){
                if(is_string($values)) $values = [$values];
                foreach ($values as $value) {
                    $builder->orWhere($column, 'like', "%{$value}%");
                }
            };

            foreach (['q','states','job_classification','type_of_cooperation','acceptable_military_service_status'] as $column) {
                if(!empty($filters[$column])){//indexed in
                    $states = $filters[$column];
                    $builder->where($in_array($builder,$column,$states));
                }//dd(http_build_query(['filters'=>['states'=>['تهران']]]));
            }
            /*
            if(!empty($filters['states'])){//indexed in
                $states = $filters['states'];
                $builder->where($in_array($builder,'states',$states));
            }//dd(http_build_query(['filters'=>['states'=>['تهران']]]));

            if(!empty($filters['job_classification'])){//indexed within

            }
            if(!empty($filters['type_of_cooperation'])){//indexed within

            }
            if (!empty($filters['acceptable_military_service_status'])){//indexed within

            }
            */

            if(!empty($filters['benefit'])){//more than give value
                $minimum_value = $filters['benefit'];
                $builder->whereRaw('CAST(`benefit` AS SIGNED) >= ?' ,[$minimum_value]);
            }

            if(!empty($filters['work_experience'])){//lower than give value
                $max_work_experience = $filters['work_experience'];
                //$builder->where('work_experience','=>',);
                $builder->whereRaw('CAST(`work_experience` AS SIGNED) <= ?' ,[$max_work_experience]);
            }

            if(!empty($filters['required_gender'])){//equal
                $builder->where('required_gender','=',$filters['required_gender']);
            }

            if(!empty($filters['minimum_education_degree'])){//equal
                $builder->where('minimum_education_degree','=',$filters['minimum_education_degree']);
            }
        }

        if ($request->sort === "newest"){//newest
            /** @var Builder $latest */
            $builder->latest();
        }elseif ($request->sort === "oldest") {//oldest
            $builder->oldest();
        }elseif (!empty($request->where)){
            $builder->where($request->where['column'],$request->where['operator'],$request->where['value']);
        }
        $peerPage = $request->has('limit') ? (int)$request->limit : 20;
        $paginate = $builder->paginate($peerPage);
        $Collections = new Collection($paginate->items());
        //dd($builder->toSql(),$builder->get());

        if(!isset($Collections)) $Collections = $builder->get();

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
            'status' => ["nullable", Rule::in(config('constants.post_status'))],
            'title' => "required|string|max:255",
            'type' => [Rule::in(config('constants.post_type')), 'required'],
            'job_classification' => ['array', Rule::in(config('constants.job_classification'))],
            'description' => ['nullable', 'string'],
            //nullable
            'type_of_cooperation' => ['array', Rule::in(config('constants.types_of_acceptable_contracts'))],
            'benefit' => ['integer'],
            'states' => ['array', 'nullable', Rule::in(config('constants.states'))],
            'work_experience' => ['regex:/^([\d]+)\<Y$/sui', "nullable"],
            'job_position' => ['string', 'nullable'],
            'required_gender' => ['string','nullable', Rule::in(config('constants.gender'))],
            'acceptable_military_service_status' => ['array',Rule::in(config('constants.military_service_status')), 'required_unless:required_gender,male'],
            'minimum_education_degree' => ['string',Rule::in(config('constants.grades'))]
        ]);
        /** @var User $user */
        $user = Auth::user();
        /** @var Post $make_post */
        $make_post = $user->posts()->create($request->all(self::key_att));

        return response_json([
            'ok' => true,
            'result' => 'ok',
            'message' => 'post created',
            'with_id' => $make_post->id
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse{
        $Collections = Post::FindOrFail($id);
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
    public function update(Request $request, string $id){
        $request->validate([
            'status' => ["nullable", Rule::in(config('constants.post_status'))],
            'title' => ["nullable","string","max:255"],
            'type' => ['nullable', Rule::in(config('constants.post_type'))],
            'job_classification' => ['array', Rule::in(config('constants.job_classification'))],
            'description' => ['nullable', 'string'],
            //nullable
            'type_of_cooperation' => ['nullable', 'array', Rule::in(config('constants.types_of_acceptable_contracts'))],
            'benefit' => ['nullable', 'integer'],
            'states' => ['nullable', 'array', 'nullable', Rule::in(config('constants.states'))],
            'work_experience' => ['nullable', 'regex:/^([\d]+)\<Y$/sui'],
            'job_position' => ['nullable', 'string'],
            'required_gender' => ['nullable' , 'string', Rule::in(config('constants.gender'))],
            'acceptable_military_service_status' => ['array','nullable', Rule::in(config('constants.military_service_status')), 'required_unless:required_gender,male'],
            'minimum_education_degree' => ['string','nullable', Rule::in(config('constants.grades'))]
        ]);
        /** @var HasMany $user_posts */
        $user_posts = auth()->user()->posts();
        /** @var Post $Collection */
        $Collection = $user_posts->findOrFail($id);
        if ($Collection->update($request->all(self::key_att))) {
            return response_json(
                ['ok' => true,
                    'result' => 'ok',
                    'message' => "update successfully"
                ], 200);
        } else throw new \Exception('something happened on update model.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $this->middleware('auth:user-api');
        /** @var HasMany $user_posts */
        $user_posts = auth()->user()->posts();
        /** @var Post $Collection */
        $Collection = $user_posts->find($id);
        if ($Collection->delete()) {
            return response_json(
                ['ok' => true,
                    'result' => 'ok',
                    'message' => "delete successfully"
                ], 200);
        } else throw new \Exception("something happened on delete model.");
    }
}
