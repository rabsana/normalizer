<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-28 23:30
 */

namespace Rabsana\Normalizer\Traits;

use Rabsana\Normalizer\Models\Normalizer as NormalizerModel;
trait NormalizerTrait
{
    public function normalizers(){
        return $this->morphMany(NormalizerModel::class, 'normalizable');
    }

    public function normalize($property, $value, $userId=null){
        if($this->propertyRegisteredAsNormalization($property)){
            return $this->calculate($property, $value, $userId);
        }

        return $value;
    }

    public function propertyRegisteredAsNormalization($property){
        return array_key_exists($property, $this->getNormalizations());
    }

    public function getNormalizations()
    {
        //TODO throw error when normalizations is not array
        //TODO convert simple array to key=>value
        if(isset(self::$normalizations) && is_array(self::$normalizations)){
            return self::$normalizations;
        }
        return [];
    }

    protected function calculate($property, $value, $userId=null)
    {
        $record = $this->filterRecords($property, $value, $userId);

        if (empty($record)) {
            return [
                'unit_amount_before_normalizer' => $this->{$property},
                'unit_amount_after_normalizer' => $this->{$property},
                'ratio' => 1
            ];
        }

        return [
            'unit_amount_before_normalizer' => $this->{$property},
            'unit_amount_after_normalizer' => $this->{$property} * $record->ratio,
            'ratio' => $record->ratio
        ];

    }

    protected function filterRecords($property, $value, $userId=null){
        if(!is_null($userId)){
            //Normalizer for specific user
            $normalizer = $this->normalizers()
                ->prop($property)
                ->range($value)
                ->userId($userId)
                ->active()
                ->first();

            if(!empty($normalizer)){
                return $normalizer;
            }
        }
        //Default normalizer
        return $this->normalizers()
            ->prop($property)
            ->range($value)
            ->userId(null)
            ->active()
            ->first();
    }

}
