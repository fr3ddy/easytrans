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
                    $key = '';
                    if($data['key_1'] != ''){
                        $key = $data['key_1'];
                        if($data['key_2'] != ''){
                            $key .= '.'.$data['key_2'];
                            if($data['key_3'] != ''){
                                $key .= '.'.$data['key_3'];
                                if($data['key_4']){
                                    $key .= '.'.$data['key_4'];
                                    if($data['key_5']){
                                        $key .= '.'.$data['key_5'];
                                    }
                                }
                            }
                        }
                    }
                    $this->sheet_data[$key] = $data['value'];
                });
                $language_array = var_export($this->sheet_data,true);
                $file_content = '<?php

return [
            '.substr($language_array,7,-1).'
];';
                file_put_contents($file,$file_content);
            });
        });
    }
}
