<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 18:24
 */
namespace Rabsana\Normalizer\Contracts;

interface NormalizerRepository
{
    public function all();

    public function allByUser($userId);

    public function model();

    public function templates();

    public function find($id);

    public function getMinimumAcceptableValue($id, $type);

    public function fillable();

    public function store(array $data);

    public function update($data, $id);

    public function delete($id);
}
