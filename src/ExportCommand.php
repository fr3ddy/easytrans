<?php

namespace Fr3ddy\Easytrans;

use Illuminate\Console\Command;
use Excel;
use Lang;

class ExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easytrans:export {lang : Source Language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export translations to Excel';

    private $files;
    private $current_file;

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
        $base = base_path().'/resources/lang/'.$this->argument('lang');
        $paths = \File::files($base);

        foreach($paths as $path){
            $split1 = explode('/',$path);
            $split2 = explode('.' , $split1[sizeof($split1)-1]);
            $this->files[] = $split2[0];
        }

        Excel::create($this->argument('lang'), function($excel) {

            // Set the title
            $excel->setTitle('Easytrans Export File');

            // Chain the setters
            $excel->setCreator('Easytrans')
                ->setCompany('Fr3ddyF');

            // Call them separately
            $excel->setDescription('This is the Easytrans Export File.');

            foreach($this->files as $file){
                $this->current_file = $file;
                $excel->sheet($file, function($sheet) {
                    $this->info('Started File: '.$this->current_file);
                    $data = array();
                    $data[] = array('Key 1' , 'Key 2' , 'Key 3' , 'Key 4' , 'Key 5' , 'Value');
                    foreach(Lang::get($this->current_file) as $key1 => $value1){
                        $row[0] = $key1;
                        $row[1] = '';
                        $row[2] = '';
                        $row[3] = '';
                        $row[4] = '';
                        $row[5] = '';
                        $row[6] = '';
                        if(is_array($value1)){
                            foreach($value1 as $key2 => $value2){
                                $row[1] = $key2;
                                if(is_array($value2)){
                                    foreach($value2 as $key3 => $value3){
                                        $row[2] = $key3;
                                        if(is_array($value3)){
                                            foreach($value3 as $key4 => $value4){
                                                $row[3] = $key4;
                                                if(is_array($value4)){
                                                    foreach($value4 as $key5 => $value5){
                                                        $row[4] = $key5;
                                                        if(is_array($value5)){
                                                            $this->info('To deeeeeep');
                                                        }else{
                                                            $row[5]= $value5;
                                                            $data[] = $row;
                                                        }
                                                    }
                                                }else{
                                                    $row[5]= $value4;
                                                    $data[] = $row;
                                                }
                                            }
                                        }else{
                                            $row[5]= $value3;
                                            $data[] = $row;
                                        }
                                    }
                                }else{
                                    $row[5]= $value2;
                                    $data[] = $row;
                                }
                            }
                        }else{
                            $row[5] = $value1;
                            $data[] = $row;
                        }
                    }
                    $sheet->rows($data);
                    // Freeze first row
                    $sheet->freezeFirstRow();
                    // Set auto size for sheet
                    $sheet->setAutoSize(true);

                    //Format first row
                    $sheet->cells('A1:F1', function($cells) {

                        $cells->setFontSize(14);
                        $cells->setFontWeight('bold');

                    });

                });

                $this->info('Finished File: '.$this->current_file);
            }

        })->store('xls', storage_path('easytrans'));
        $this->info('Exported');
    }
}
