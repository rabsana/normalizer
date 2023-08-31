<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 18:25
 */

namespace Rabsana\Normalizer\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Rabsana\Normalizer\Contracts\NormalizerRepository;
use Rabsana\Normalizer\Models\Normalizer;
use Rabsana\Normalizer\Traits\NormalizerTrait;

class NormalizerRepositoryEloquent implements NormalizerRepository
{
    public function all()
    {
        return $this->model()->all();
    }

    public function allByUser($userId)
    {
        return $this->model()->where('user_id', $userId)->get();
    }


    public function model()
    {
        return new Normalizer();
    }

    public function templates()
    {
        $templates = [];

        foreach(config('rabsana-normalizer.templates') as $template){
            if (isset($template['class'])) {
                $class = $template['class'];
                if(isset($template['name'])){
                    $name = $template['name'];
                }else{
                    $name = class_basename($class);
                }
                if (isset($class::$normalizations)) {
                    $normalizations = $class::$normalizations;
                } else {
                    $normalizations = [];
                }
                $model = app($class);
                if ($model instanceof Model) {
                    $records = $model->all();
                } else {
                    $records = [];
                }
                $templates[] = [
                    'name' => $name,
                    'class' => $class,
                    'normalizations' => $normalizations,
                    'records' => $records,
                ];
            }
        }

        return new Collection($templates);
    }

    public function find($id)
    {
        return $this->model()->findOrFail($id);
    }

    public function getMinimumAcceptableValue($id, $type)
    {
        $record = $this->model()->where('normalizable_id', $id)->where('normalizable_type', $type)->orderBy('to', 'desc')->first();

        if(empty($record)){
            return 0;
        }

        return $record->to + PHP_FLOAT_EPSILON;
    }

    public function fillable()
    {
        return $this->model()->getFillable();
    }

    public function store(array $data)
    {
        $newRecord = $this->model()->replicate();

        $newRecord->fill($data);

        $newRecord->save();

        return $newRecord;
    }

    public function update($data, $id)
    {
        $existingModel = $this->model()->replicate();

        $existingModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $existingModel = $this->model()->replicate();

        $existingModel->where('id', $id)->delete();
    }


}
