<?php
declare(strict_types=1);

namespace App\Backend\ImportCategory\Business\Model\Update;

use App\Generated\Dto\CsvCategoryDataTransferObject;

interface CategoryUpdateInterface
{
    public function performUpdateActions(CsvCategoryDataTransferObject $csvDTO): void;
}