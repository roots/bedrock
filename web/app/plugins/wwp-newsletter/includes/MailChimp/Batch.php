<?php

namespace WonderWp\Plugin\Newsletter\MailChimp;

/**
 * A MailChimp Batch operation.
 * http://developer.mailchimp.com/documentation/mailchimp/reference/batches/
 *
 * @author Drew McLellan <drew.mclellan@gmail.com>
 */
class Batch
{
    private $MailChimp;

    private $operations = array();
    private $batch_id;

    public function __construct(MailChimp $MailChimp, $batch_id = null)
    {
        $this->MailChimp = $MailChimp;
        $this->batch_id = $batch_id;
    }

    /**
     * Add an HTTP DELETE request operation to the batch - for deleting data
     * @param   string $id ID for the operation within the batch
     * @param   string $method URL of the API request method
     * @return  void
     */
    public function delete($id, $method)
    {
        $this->queueOperation('DELETE', $id, $method);
    }

    /**
     * Add an HTTP GET request operation to the batch - for retrieving data
     * @param   string $id ID for the operation within the batch
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @return  void
     */
    public function get($id, $method, $args = array())
    {
        $this->queueOperation('GET', $id, $method, $args);
    }

    /**
     * Add an HTTP PATCH request operation to the batch - for performing partial updates
     * @param   string $id ID for the operation within the batch
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @return  void
     */
    public function patch($id, $method, $args = array())
    {
        $this->queueOperation('PATCH', $id, $method, $args);
    }

    /**
     * Add an HTTP POST request operation to the batch - for creating and updating items
     * @param   string $id ID for the operation within the batch
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @return  void
     */
    public function post($id, $method, $args = array())
    {
        $this->queueOperation('POST', $id, $method, $args);
    }

    /**
     * Add an HTTP PUT request operation to the batch - for creating new items
     * @param   string $id ID for the operation within the batch
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @return  void
     */
    public function put($id, $method, $args = array())
    {
        $this->queueOperation('PUT', $id, $method, $args);
    }

    /**
     * Execute the batch request
     * @param int $timeout Request timeout in seconds (optional)
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function execute($timeout = 10)
    {
        $req = array('operations' => $this->operations);

        $result = $this->MailChimp->post('batches', $req, $timeout);

        if ($result && isset($result['id'])) {
            $this->batch_id = $result['id'];
        }

        return $result;
    }

    /**
     * Check the status of a batch request. If the current instance of the Batch object
     * was used to make the request, the batch_id is already known and is therefore optional.
     * @param string $batch_id ID of the batch about which to enquire
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function check_status($batch_id = null)
    {
        if ($batch_id === null && $this->batch_id) {
            $batch_id = $this->batch_id;
        }

        return $this->MailChimp->get('batches/' . $batch_id);
    }

    /**
     * Add an operation to the internal queue.
     * @param   string $http_verb GET, POST, PUT, PATCH or DELETE
     * @param   string $id ID for the operation within the batch
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @return  void
     */
    private function queueOperation($http_verb, $id, $method, $args = null)
    {
        $operation = array(
            'operation_id' => $id,
            'method' => $http_verb,
            'path' => $method,
        );

        if ($args) {
            $key = ($http_verb == 'GET' ? 'params' : 'body');
            $operation[$key] = json_encode($args);
        }

        $this->operations[] = $operation;
    }
}
