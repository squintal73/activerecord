<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;

class FindAll implements ActiveRecordExecuteInterface
{
    public function __construct(
        private array $where = [],
        private string|int $limit = '',  
        private string|int $offset = '', 
        private string $fields = '*'
    ) {
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
           // dd($query);
            $prepare = $connection->prepare($query);
            //dd($prepare);
            $prepare->execute(
                $this->where
            );

            return $prepare->fetchAll();
            
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

        $where = array_keys($this->where);
        $sql = "select {$this->fields} from {$activeRecordInterface->getTable()}";
        $sql.= (!$this->where) ? '' : " where {$where[0]} =:{$where[0]}";
        $sql.= (!$this->limit) ? '' : " limit {$this->limit}";
        $sql.= ($this->offset != '') ? " offset {$this->offset}" : "";
 
        return $sql;
    }
}
