<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;

class FindBy implements ActiveRecordExecuteInterface
{
    public function __construct(
        private string $field, 
        private string|int $value, 
        private string $fields = '*'
    ){}

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
           // dd($query);
            $prepare = $connection->prepare($query);
            //dd($prepare);
            $prepare->execute();

            return $prepare->fetch();
            
        } catch (Throwable $throw) {
            formatExcetion($throw);
        }
    }

    /**
     * Method CreateQuery
     *
     * @param ActiveRecordInterface $activeRecordInterface
     */
    public function createQuery(ActiveRecordInterface $activeRecordInterface)
    {

        $sql = "select {$this->fields} from {$activeRecordInterface->getTable()}";
        $sql.= " where {$this->field} = {$this->value}";
 
        return $sql;
    }
}
