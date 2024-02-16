<?php

namespace app\database\activerecord;

use app\database\connection\Connection;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Throwable;
use Exception;


class Insert implements ActiveRecordExecuteInterface
{
    public function execute(ActiveRecordInterface $activeRecordInterface) {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();
            
            /** Preparação da query */
            
            $prepare = $connection->prepare($query);

            $prepare->execute($activeRecordInterface->getAttributes());

            if ($prepare->rowCount() > 0) {
                return $prepare->rowCount() . " - Registro Gravado com sucesso ! ";
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

        $sql = "insert into {$activeRecordInterface->getTable()} (";
        $sql.= implode(',' , array_keys( $activeRecordInterface->getAttributes())).') values (';
        $sql.= ':'. implode(',:',array_keys( $activeRecordInterface->getAttributes())).')';

        return $sql;
    }
}