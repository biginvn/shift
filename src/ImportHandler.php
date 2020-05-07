<?php

/**
 * Created by PhpStorm.
 * Just a simple interface to interact with Import Functional
 * User: minhtruong
 * Date: 3/21/20
 * Time: 10:27 AM
 */
namespace Bigin\Shift;


use Bigin\Shift\Configuration\Configuration;
use Bigin\Shift\Instances\ColumnManager\ColumnDirectMapping;
use Bigin\Shift\Instances\ColumnManager\ColumnRelativeMapping;
use Bigin\Shift\Instances\Logging\FileLogger;
use Bigin\Shift\Instances\Validation\QuickValidation;
use Bigin\Shift\Instances\Validation\RelativeValidation;
use Bigin\Shift\Operation\ImportFactory;

class ImportHandler
{
    public function __construct(Configuration $config, array $columns)
    {

        $columns = [
            new ColumnDirectMapping("STT", "id", new QuickValidation('numeric|required')),
            new ColumnRelativeMapping("Category", "category_id",['table'=> 'categories', 'column' => 'name'] ),
            new ColumnDirectMapping("STT", "id", new QuickValidation('numeric|required')),
        ];
        $operation = new ImportFactory($config, $columns);
        $operation->getRowExecutor()->setUpdateExist(true);
        $operation->getRowExecutor()->setTable('products');
    }

}