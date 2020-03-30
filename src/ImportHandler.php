<?php

/**
 * Created by PhpStorm.
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
use Bigin\Shift\Operation\ImportOperation;

class ImportHandler
{

    public function __construct()
    {
        $config = new Configuration(base_path("packages/shift/test.xlsx"), new FileLogger());
        $columns = [
            new ColumnDirectMapping("STT", "id", new QuickValidation('numeric|required')),
            new ColumnRelativeMapping("Category", "category_id",['table'=> 'categories', 'column' => 'name'] ,new RelativeValidation(['table'=> 'categories', 'column' => 'name'])),
            new ColumnDirectMapping("STT", "id", new QuickValidation('numeric|required'))
        ];
        $operation = new ImportOperation($config, $columns);
        $operation->getRowExecutor()->setUpdateExist(true);
    }

}