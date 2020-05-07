

# ![LARAVEL - SHIFT](https://github.com/biginvn/shift/blob/development/resources/images/logo.png) Shift Laravel

**Import Excel & Mapping Datasource. A simple but elegant Laravel import process.**

## Features

- No need to maunally write mapping code, library has been supported mapping column with various type like One - One, Reference, Index table...
- Simple validation. We reuse the validation in Laravel make your task simpler.
- Easy to customize. Don't want to use built-in mapping? No problem, you can define your mapping way, just a few line of code.

### Simple Usage
```php
use Bigin\Shift\Configuration\Configuration;
use Bigin\Shift\Instances\ColumnManager\ColumnDirectMapping;
use Bigin\Shift\Instances\ColumnManager\ColumnIndexMapping;
use Bigin\Shift\Instances\ColumnManager\ColumnRelativeMapping;
use Bigin\Shift\Instances\Validation\QuickValidation;
use Bigin\Shift\Operation\ImportFactory;

...

$colors = [
      'Red'   => 'Màu đỏ',
      'Yellow'    => 'Màu vàng',
      'Green'     => 'Xanh lá cây',
      'Blue'      => 'Xanh da trời',
      'Pink'      => 'Hồng'
  ];
  $columns = [
      new ColumnDirectMapping("STT", "id", new QuickValidation('numeric|required')),
      new ColumnDirectMapping("Name", "name", new QuickValidation('required')),
      new ColumnRelativeMapping("Category", "category_id",['table'=> 'categories', 'column' => 'name']),
      new ColumnIndexMapping("Color", "color", $colors),
  ];
  $config = new Configuration(base_path('packages/shift/test.xlsx'));
  $operation = new ImportFactory($config, $columns);
  $operation->getRowExecutor()->setUpdateExist(false);
  $operation->getRowExecutor()->setPrimaryInput('STT');
  $operation->getRowExecutor()->setTable('products');
  $operation->execute();
  ```
