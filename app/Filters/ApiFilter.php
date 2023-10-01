<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request)
    {
        // создание пустого массива *
        // перебор сейф параметров и получение ключа и значения *
        // получение в переменной значения с помощью функции query, которая получает значение с строки запроса*
        // затем проверка на пустоту переменной *
        // в случае успеха в переменную через проверку получаем значение из колонок нужное *
        // название колонки по ключу, полученному ранее после перебора *

        $elQuery = [];

        foreach ($this->safeParms as $parms => $operators) {
            $req = $request->query($parms);

            if (!isset($req)) {
                continue;
            }

            $column = $this->columnMap[$parms] ?? $parms; //true ?? false

            // перебрать все возможные операторы и каждый из них проверить на валидность
            // здесь как бы идет разбиение запроса на кусочки и проверка нужных параметров
            // проверка на валидность, а точнее на пустоту
            // а затем происходит добавление в массив части запроса where [[column, operator, query]]
            // в случае тру добавление в заранее созданный массив данных в формате, который привед выше

            foreach ($operators as $operator) {
                if (isset($req[$operator])) {
                    $elQuery[] = [$column, $this->operatorMap[$operator], $req[$operator]];
                }
            }

            return $elQuery;
        }
    }
}
