<?php
namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headers;
    protected $footer;

    public function __construct($data, $headers, $footer = null)
    {
        $this->data = $data;
        $this->headers = $headers;
        $this->footer = $footer;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }


    public function headings(): array
    {
        return $this->headers;
    }

    public function footer(): array
    {
        if ($this->footer !== null) {
            return $this->footer;
        }
        return [];
    }
}
