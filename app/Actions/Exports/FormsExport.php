<?php

namespace App\Actions\Exports;

use App\Models\FormAttribute;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;


class FormsExport implements FromCollection, WithMapping,  WithHeadings, WithEvents, WithColumnWidths
{

    private $images = [];

    public function collection()
    {
        return FormAttribute::all();
    }

    public function map($attribute): array
    {
        $image = "";
            // $image = Storage::disk('public')->get(str_replace("/storage/","",$attribute->product_image));
        $this->images[] = $attribute->product_image;
        return [
            $attribute->product_sku,
            $attribute->product_name,
            $attribute->product_type,
            $attribute->brand,
            $attribute->ref_price,
            $attribute->place_of_origin,
            $attribute->product_details,
            "",
        ];
    }

    public function headings(): array
    {
        return [
            'Sku',
            'Name',
            'Type',
            'Brand',
            'Ref Price',
            'Place Of Origin',
            'Details',
            'Image',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 20,
            'D' => 15,
            'E' => 10,
            'F' => 15,
            'G' => 50,
            'H' => 60,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // $event->sheet->getColumnDimension('G')->setWidth(120); // 调整图像列的宽度
                // $event->sheet->getDelegate()->getStyle('G')->getAlignment()->setWrapText(true); // 自动换行
                $event->sheet->getDelegate()->getStyle('B')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('G')->getAlignment()->setWrapText(true);
                $event->sheet
                    ->getDelegate()
                    ->getStyle('A1:H'.count($this->images))
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $loop = 2;
                foreach ($this->images as $images) {
                    if($images){
                        $event->sheet->getDelegate()->getRowDimension("$loop")->setRowHeight(120);
                        $drawing = new Drawing();
                        $drawing->setName('image');
                        $drawing->setDescription('image');
                        $drawing->setPath(public_path( str_replace("/uploads","/thumbnails",$images) ));
                        $drawing->setHeight(160);
                        $drawing->setCoordinates('H' . $loop);
                        $drawing->setWorksheet($event->sheet->getDelegate());

                        $event->sheet->getCell('H' . $loop)
                            ->getHyperlink()
                            ->setUrl(url($images))
                            ->setTooltip('Click to view');
                    }
                    $loop++;
                }
            }
        ];
    }
}
