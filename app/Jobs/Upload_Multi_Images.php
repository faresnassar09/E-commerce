<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FileServices;

class Upload_Multi_Images implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

public $Folder = '';
public $Table = '';
public $Foregin_Id = '';
public $Id = null;
public $Images = [];

    /**
     * Create a new job instance.
     */
    public function __construct($Table,$Foregin_Id,$Id,$Images,$Folder)
    {

$this->Table = $Table;
$this->Foregin_Id = $Foregin_Id; 
$this->Id = $Id; 
$this->Images = $Images;
$this->Folder = $Folder;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        FileServices::Upload_multi_Images(
            $this->Table,
            $this->Foregin_Id,
            $this->Id,
            $this->Images,
            $this->Folder,

        );

    }
}
