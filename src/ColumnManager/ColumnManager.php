<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 6:24 PM
 */

namespace Bigin\Shift\ColumnManager;


class ColumnManager {
    /**
     * @var Column[]
     */
    private $columns;

    /**
     * ColumnManager constructor.
     * @param Column[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param Column[] $columns
     * @return ColumnManager
     */
    public function setColumns(array $columns) : ColumnManager
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param Column $column
     * @return ColumnManager
     */
    public function attach(Column $column) : ColumnManager {
        $this->columns[] = $column;
        return $this;
    }

    /**
     * @param int $index
     * @return ColumnManager
     */
    public function detach(int $index) : ColumnManager {
        unset($this->columns[$index]);
        array_values($this->columns);
        return $this;
    }
}