<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "/libraries/PHPExcel.php";

class Excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();

    }

    public function excel_to($str_filename = 'justme_excel')
    {
        $this->setActiveSheetIndex(0);
        $this->getActiveSheet()->setTitle('test worksheet');
        $this->getActiveSheet()->setCellValue('A1', 'This is just some text value');
        $this->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $this->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->getActiveSheet()->mergeCells('A1:D1');
        $this->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');
        $objWriter->save('php://output');
    }

    public function export_to_excel($fields =  array(), $table_name, $str_filename ='mifile', $sql_select = null, $sql_where = null)
    {
        if($sql_select){
            $this->CI->db->select($sql_select);
        }

        if($sql_where && is_array($sql_where)){
            $this->CI->db->where($sql_where);
        }

        $query = $this->CI->db->get($table_name);


        if (!$query)
            return false;


        //tittle
        $this->getActiveSheet()->setTitle(date('dMy').'_'.$table_name );

        // Field names in the first row
        $fields = empty($fields) ? $query->list_fields() : $fields;

        $col = 0;
        foreach ($fields as $field) {

            $this->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field['label']);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query->result() as $data) {
            $col = 0;
            foreach ($fields as $field) {

                $value = $data->{$field['field']};

                if($field['field'] ===  'created'){
                    $value = date('d/m/Y', strtotime($value));
                }

                $this->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $row++;
        }

        $this->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$str_filename . date('dMy_h:m:s') . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

    }

}
