<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;

class Delete implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value) {}

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
            $prepare = $connection->prepare($query);
            //dd($activeRecordInterface->getAttributes());
            $prepare->execute($activeRecordInterface->getAttributes());
            if ($prepare->rowCount() > 0) {
                return $prepare->rowCount() . " - Registro excluido com sucesso ! ";
            } else {
                return $prepare->rowCount() . " - Registro já foi excluido";
            }

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

        $sql = "delete from {$activeRecordInterface->getTable()}";
        $sql.= " where {$this->field} =:{$this->field}";
 

        return $sql;
    }
}
