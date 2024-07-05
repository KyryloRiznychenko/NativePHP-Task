<?php

namespace App\Providers\Transactions;

use App\Entities\Transactions\TransactionEntity;
use App\Enums\Transactions\TransactionOperationTypeStringEnum;
use App\Enums\Transactions\TransactionUserTypeStringEnum;
use App\Exceptions\Files\InvalidInputFilePathException;

class CsvTransactionProvider implements TransactionProviderInterface
{
    private array $transactions = [];

    /**
     * @throws InvalidInputFilePathException
     */
    public function __construct(private readonly string $csvFilePath)
    {
        if (!file_exists($this->csvFilePath)) {
            throw new InvalidInputFilePathException($this->csvFilePath);
        }

        $this->pullTransactions();
    }

    private function pullTransactions(): void
    {
        $stream = fopen($this->csvFilePath, 'r');

        do {
            $csvRow = fgetcsv($stream);

            if (!empty($csvRow)) {
                $this->transactions[] = new TransactionEntity(
                    $csvRow[0],
                    $csvRow[1],
                    TransactionUserTypeStringEnum::from($csvRow[2]),
                    TransactionOperationTypeStringEnum::from($csvRow[3]),
                    (float)$csvRow[4],
                    $csvRow[5],
                );
            }
            //we can also add here our custom exception for invalid format or
            //an exception for the ValueError
            //for cases where the value is not valid for our entity properties
        } while ($csvRow);

        fclose($stream);
    }

    /**
     * @return TransactionEntity[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }
}