<?php

namespace Fr3ddy\Easytrans;

use Illuminate\Console\Command;
use Excel;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easytrans:import {lang : Destination Language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Excel and overwrite existing data';

    private $current_sheet;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Excel::load(storage_path('easytrans').'/'.$this->argument('lang').'.xls' , function($reader){
            $reader->each(function($sheet){
                $file = base_path().'/resources/lang/'.$this->argument('lang').'/'.$sheet->getTitle().'.php';
                copy($file , base_path().'/resources/lang/'.$this->argument('lang').'/'.$sheet->getTitle().'-'.date("YmdHis").'.php');
                $this->current_sheet = $sheet;
                $this->sheet_data = array();
                $sheet->each(function($row){
                    $data = $row->toArray();
                    if($data['key_1'] != '' && $data['key_2'] != '' && $data['key_3'] != '' && $data['key_4'] != '' && $data['key_5'] != ''){
                        $this->sheet_data[$data['key_1']][$data['key_2']][$data['key_3']][$data['key_4']][$data['key_5']] = $data['value'];
                    }elseif($data['key_1'] != '' && $data['key_2'] != '' && $data['key_3'] != '' && $data['key_4'] != ''){
                        $this->sheet_data[$data['key_1']][$data['key_2']][$data['key_3']][$data['key_4']] = $data['value'];
                    }elseif($data['key_1'] != '' && $data['key_2'] != '' && $data['key_3'] != ''){
                        $this->sheet_data[$data['key_1']][$data['key_2']][$data['key_3']] = $data['value'];
                    }elseif($data['key_1'] != '' && $data['key_2'] != ''){
                        $this->sheet_data[$data['key_1']][$data['key_2']] = $data['value'];
                    }elseif($data['key_1']){
                        $this->sheet_data[$data['key_1']] = $data['value'];
                    }
                });
                $language_array = var_export($this->sheet_data,true);
                $file_content = '<?php

return '.$language_array.'
;';
                file_put_contents($file,$file_content);
            });
        });
    }
}
