<?php

function formatExcetion(Throwable $e) {
    var_dump("<b> Erro no arquivo {$e->getFile()}</b> na linha {$e->getLine()} - <b>Mensagem {$e->getMessage()}</b>");
}