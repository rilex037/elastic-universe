<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Todo;
use Elasticquent\ElasticquentConfigTrait;
use Elasticquent\ElasticquentTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateMappings extends Command
{

    use ElasticquentTrait;
    use ElasticquentConfigTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:create_mappings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle(): bool
    {
        try {
            echo 'Creating indexes and mappings...' . PHP_EOL;;
            $this->createIndex();
            Post::putMapping(1);
            Todo::putMapping(1);
            return true;
        } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
            echo 'Error while creating indexes and mappings, or they already exist!' . PHP_EOL;
            Log::error($e);
            return false;
        }
    }

    private function createIndex($shards = 1, $replicas = 1)
    {
        $client = $this->getElasticSearchClient();

        $index = array(
            'index' =>  $this->getIndexName(),
        );

        if (!is_null($shards)) {
            $index['body']['settings']['number_of_shards'] = $shards;
        }

        if (!is_null($replicas)) {
            $index['body']['settings']['number_of_replicas'] = $replicas;
        }

        return $client->indices()->create($index);
    }
}
