<?php namespace App\Models;

use CodeIgniter\Model;


class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'code_id',
        'image',
        'name',
        'status',
        'condicion',
        'category',
        'color',
        'size',
        'occasion',
        'gender',
        'description'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules  = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}