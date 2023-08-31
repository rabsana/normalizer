<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 05:14
 */

namespace Rabsana\Normalizer\Controllers;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Rabsana\Normalizer\Contracts\NormalizerRepository;
use Rabsana\Normalizer\Models\Normalizer;
use Illuminate\Support\Arr;

class NormalizerController extends Controller
{
    use ValidatesRequests;

    protected $repository;

    public function __construct(NormalizerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        $userId = request()->get('user', null);
        if(!is_null($userId)){
            $user = DB::table('users')->where('id', $userId)->first();
            if(!empty($user)){
                $data['user'] = $user;
            }
        }
        if(empty($user)){
            $normalizers = $this->repository->all();
        }else{
            $normalizers = $this->repository->allByUser($user->id);
        }
        $data['normalizers'] = $normalizers;

        return view('rabsana-normalizer::index', $data);
    }
    public function create(){
        $templates = $this->repository->templates();
        $data['templates'] = $templates;
        $userId = request()->get('user', null);
        if(!is_null($userId)){
            $user = DB::table('users')->where('id', $userId)->first();
            if(!empty($user)){
                $data['user'] = $user;
            }
        }
        return view('rabsana-normalizer::create', $data);
    }

    public function store(Request $request){

        try{
            $validData = $this->validate($request, $this->rules());

            $record = $this->repository->store($validData);

            return response([
                'record' => $record
            ], 201);

        }catch (ValidationException $e){
            return response([
                'errors' => $e->validator->errors()
            ], 422);
        }
    }
    public function edit($id){
        $normalizer = $this->repository->find($id);
        $templates = $this->repository->templates();
        return view('rabsana-normalizer::edit', compact('normalizer', 'templates'));
    }
    public function update(Request $request, $id){
        try{
            $request->request->add([
                'id' => $id
            ]);

            $partialRules = $this->rules(
                array_keys(
                    $request->only(
                        $this->repository->fillable()
                    )
                )
            );

            $validData = $this->validate($request, array_merge($partialRules, [
                'id' => 'required|exists:rabsana_normalizer_normalizers'
            ]));

            $this->repository->update($validData, $id);

            return response('', 204);

        }catch (ValidationException $e){
            return response([
                'errors' => $e->validator->errors()
            ], 422);
        }
    }
    public function destroy(Request $request, $id){
        try{
            $request->request->add([
                'id' => $id
            ]);
            $this->validate($request, [
                'id' => 'required|exists:rabsana_normalizer_normalizers'
            ]);

            $this->repository->delete($id);

            return response('', 204);

        }catch (ValidationException $e){
            return response([
                'errors' => $e->validator->errors()
            ], 422);
        }
    }

    protected function rules($filter = []){
        $defaultRules = [
            'from' => 'required|numeric',
            'to' => 'required|numeric|rabsana_normalizer_gt:from',
            'normalizable_type' => 'required',
            'normalizable_id' => 'bail|required|rabsana_normalizer_exists',
            'ratio' => 'required|numeric',
            'prop' => 'required',
            'active' => 'required|boolean',
            'user_id' => 'sometimes|exists:users,id'
        ];

        if(empty($filter)){
           return $defaultRules;
        }


        return Arr::only($defaultRules, $filter);
    }
}
