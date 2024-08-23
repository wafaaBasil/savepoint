<?php

namespace App\Exports;

use App\Models\ProductCategory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductCategoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductCategory::get();

    }
    public function map($category) : array {
       /* $drawing = new Drawing();
        $drawing->setName('image');
        $drawing->setDescription('This is category image');
        $drawing->setPath(public_path('/storage/images/product_categories'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');
*/
        return [
            $category->id,
            //$drawing,
            $category->name,
            $category->active,
            Carbon::parse($category->created_at)->isoFormat('a h:m - YYYY/M/D')
        ] ;
 
 
    }
  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["ID", "Name","Active", "created_at"];
    }
}