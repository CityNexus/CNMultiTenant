<?php
namespace CityNexus\CityNexus;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Toin0u\Geocoder\Facade\Geocoder;


class CreateRaw implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    private $ids;
    private $table;
    /**
     * Create a new job instance.
     *
     * @param string $data
     * @param Property $upload_id
     */
    public function __construct($table, $ids)
    {
        $this->ids = $ids;
        $this->table = $table;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        DB::reconnect();

        if(is_array($this->ids))
        {
            foreach($this->ids as $id)
            {
                $tabler = new TableBuilder();

                //Process each individual record
                $tabler->saveRawAddress($this->table, $id);
            }
        }

    }
}