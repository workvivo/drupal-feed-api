<?php

namespace Drupal\workvivo_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

use Psr\Log\LoggerInterface;

/**
 * Provides a Workvivo Resource
 *
 * @RestResource(
 *   id = "workvivo_resource",
 *   label = @Translation("Workvivo Resource"),
 *   uri_paths = {
 *     "canonical" = "/workvivo_api/workvivo_resource"
 *   }
 * )
 */
class WorkvivoResource extends ResourceBase {
    /**
     * Responds to entity GET requests.
     * @return \Drupal\rest\ResourceResponse
     */
    private $space;
    public function get() {
        $config = \Drupal::config('workvivo_api.settings');

        $url = $config->get('workvivo_api.api_url');
        $key = $config->get('workvivo_api.api_key');

        $this->space = $_GET['space'];

        if($url && $key) {
            $response = $this->workvivoClient->fetch($url, $key, $this->space);
        } else {
            $response = ['error' => 'Api config information not set'];
        }

        return (new ResourceResponse($response))->addCacheableDependency(null);
    }
    
	protected $workvivoClient;


    /**
     * Constructs a new object.
     *
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param array $serializer_formats
     * @param \Psr\Log\LoggerInterface $logger
     */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, array $serializer_formats, LoggerInterface $logger) 
	{
        parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
        $this->workvivoClient = \Drupal::service('workvivo_client');
    }
    

}