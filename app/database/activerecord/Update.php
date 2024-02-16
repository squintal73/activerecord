<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;
use Exception;

class Update implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value) {}
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {

        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
           
            /** Preparação da query */
            $attributes = array_merge($activeRecordInterface->getAttributes(), [$this->field => $this->value]);

            $prepare = $connection->prepare($query);
            $prepare->execute($attributes);

            if ($prepare->rowCount() > 0) {
                return $prepare->rowCount() . " - Registro Atualizado com sucesso ! ";
            } else {
                return $prepare->rowCount() . " - Registro já foi Atualizado";
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

        if(array_key_exists('id', $activeRecordInterface->getAttributes())) {
            throw new Exception("ID não pode ser passado!");
        }

        $sql = "update {$activeRecordInterface->getTable()} set ";
        foreach ($activeRecordInterface->getAttributes() as $key => $value) {
            $sql .= "{$key}=:{$key}, ";
        }

        $sql = rtrim($sql, ", ");
        $sql .= " where {$this->field} =:{$this->field}";

        return $sql;
    }

}
