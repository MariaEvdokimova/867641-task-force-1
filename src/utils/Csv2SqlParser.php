<?php
declare(strict_types = 1);

namespace TaskForce\utils;

use \Exception;
use SplFileObject;

class Csv2SqlParser
{
    public static function parse(string $csvFilePath, string $outputDir, string $delimiter = ';', array $extraColumns = [], $callback = null)
    {
        if (!file_exists($csvFilePath)) {
            throw new Exception("CSV file {$csvFilePath} not found");
        }

        $splFile = new SplFileObject($csvFilePath);
        if ($splFile->getExtension() !== 'csv') {
            throw new Exception('Invalid file extension');
        }

        if (!$splFile->getSize()) {
            throw new Exception('CSV file is empty');
        }

        $columns = [];
        $values = [];

        while (!$splFile->eof()) {
            if ($splFile->key() === 0) {
                $columns = $splFile->fgetcsv();
            }

            $valuesArray = $splFile->fgetcsv($delimiter);
            if ($callback && is_callable($callback)) {
                $valuesArray = array_merge($valuesArray, call_user_func($callback));
            }

            $values[] = sprintf("\t(%s)", implode(',', array_map(function ($value) {
                return "'{$value}'";
            }, $valuesArray)));
        }

        $tableName = str_replace('.csv', '', basename($splFile->getFilename()));
        $outputStr = sprintf(
            "INSERT INTO\r\n\t%s\r\n\t(%s)\r\nVALUES %s;",
            $tableName,
            implode(',', array_map(function (string $columnName) {
                return "`{$columnName}`";
            }, array_merge($columns, $extraColumns))),
            implode(',', $values)
        );

        $outputFilePath = rtrim($outputDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "{$tableName}.sql";
        if (!file_put_contents($outputFilePath, $outputStr)) {
            throw new Exception('File save error');
        }
    }
}
