<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 4/1/20
 * Time: 6:01 PM
 */

use Tests\TestCase;
class RowExecutorTest extends TestCase
{
    private $facadeMocks = [];

    public function setUp()
    {
        parent::setUp();

        $app = Mockery::mock('app')->shouldReceive('instance')->getMock();
        $this->facadeMocks['db'] = Mockery::mock('db');

        \Illuminate\Support\Facades\DB::setFacadeApplication($app);
        \Illuminate\Support\Facades\DB::swap($this->facadeMocks['db']);
    }

    public function testTa()
    {
        $row = Mockery::mock('Bigin\Shift\RowManager\RowExecutor');
        $row->shouldReceive('setUpdateExist')->andReturn(true);
        $row->shouldReceive('isAvailable')->andReturn(true);
        $row->shouldReceive('rowValues')->andReturnValues([1,2,3]);
        $row->shouldReceive('update')->andReturnTrue();
        $this->assertTrue($row->execute());
    }

}
