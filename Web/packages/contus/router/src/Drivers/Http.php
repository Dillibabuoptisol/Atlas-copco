<?php
/**
 * Route Manager
 *
 * @name       RouteManager
 * @package    Router
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router\Drivers;

use Closure;
use Exception;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as AsyncRequest;
use Contus\Router\LogContainer;
use Contus\Router\Parser\Parser;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\RequestException;
use Contus\Router\Contracts\DriverInterface;
use Contus\Router\Models\RouterLog;

class Http implements DriverInterface{
    /**
     * Class property to hold the instance of http client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client = null;
    /**
     * Class property to hold the instance of Parser
     *
     * @var \Contus\Router\Parser\Parser
     */
    protected $parser = null; 
    /**
     * Class property to hold the instance of LogContainer
     *
     * @var \Contus\Router\LogContainer
     */
    protected $logContainer = null;        
    /**
     * Class property to hold the success callback
     *
     * @var \Closure
     */
    protected $successCallback = null;
    /**
     * Class property to hold the failure callback
     *
     * @var \Closure
     */
    protected $failureCallback = null;          
    /**
     * Class intializer
     *
     * @param \Contus\Router\Parser\Parser $parser
     * @param \Contus\Router\LogContainer $logContainer
     * @return void
     */
    public function __construct(Parser $parser,LogContainer $logContainer){
        $this->client = new Client;
        $this->parser = $parser;
        $this->logContainer = $logContainer;
        $this->logContainer->setLoggerModel(RouterLog::class);
    }  
    /**
     * Set Response Callbacks
     *
     * @param \Closure $promiseSuccessCallback
     * @param \Closure $promiseFailureCallback
     * @return \Contus\Router\Contracts\DriverInterface
     */
    public function setCallbacks(Closure $successCallback,Closure $failureCallback){
        $this->successCallback = $successCallback;
        $this->failureCallback = $failureCallback;

        return $this;
    }  
    /**
     * call success callback
     *
     * @param \Psr\Http\Message\ResponseInterface $response     
     * @param mixed $data
     * @return void
     */
    private function callSuccessCallback(ResponseInterface $response,$data){
        if($this->successCallback instanceof Closure){
            call_user_func(
                $this->successCallback,
                $data,
                $response
            );
        }
    }
    /**
     * call failure callback
     *
     * @param string $message
     * @return void
     */
    private function callFailureCallback($message){
        if($this->failureCallback instanceof Closure){
            call_user_func($this->failureCallback, $message);
        }
    }       
    /**
     * Handle Promise Response 
     *
     * @param \GuzzleHttp\Promise\PromiseInterface $promise
     * @param string $loggerId
     * @return void
     */
    private function handlePromiseResponse(PromiseInterface $promise,$loggerId){
        $promise->then(
            function(ResponseInterface $response) use ($loggerId){
                $statusCode = $response->getStatusCode();
                $data = $this->parser->parse($response);
                $this->callSuccessCallback($response,$data);
            },function (RequestException $exception) use ($loggerId){
                $this->logContainer->update($loggerId,['error_message' => $message]);
                $this->callFailureCallback($exception->getMessage());
            }
        )->wait();
    } 
    /**
     * Handle Response 
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $loggerId
     * @return void
     */
    private function handleResponse(ResponseInterface $response,$loggerId){
        $data = $this->parser->parse($response);

        $this->logContainer->update($loggerId,[
            'status_code' => $response->getStatusCode(),
            'response_data' => $data
        ]);

        $this->callSuccessCallback($response,$data);

        return $data;
    } 
    /**
     * Handle Request Failure 
     *
     * @param string $message
     * @param string $loggerId
     * @return void
     */
    private function handleRequestFailure($message,$loggerId){
        $this->logContainer->update($loggerId,['error_message' => $message]);

        $this->callFailureCallback($message);

        return $message;
    }                  
    /**
     * Provide convenicnce for calling driver with variouse http method name
     *
     * @method Psr\Http\Message\ResponseInterface get($uri, array $options = [])
     * @method Psr\Http\Message\ResponseInterface head($uri, array $options = [])
     * @method Psr\Http\Message\ResponseInterface put($uri, array $options = [])
     * @method Psr\Http\Message\ResponseInterface post($uri, array $options = [])
     * @method Psr\Http\Message\ResponseInterface patch($uri, array $options = [])
     * @method Psr\Http\Message\ResponseInterface delete($uri, array $options = [])
     * @method GuzzleHttp\Promise\PromiseInterface getAsync($uri, array $options = [])
     * @method GuzzleHttp\Promise\PromiseInterface headAsync($uri, array $options = [])
     * @method GuzzleHttp\Promise\PromiseInterface putAsync($uri, array $options = [])
     * @method GuzzleHttp\Promise\PromiseInterface postAsync($uri, array $options = [])
     * @method GuzzleHttp\Promise\PromiseInterface patchAsync($uri, array $options = [])
     * @method GuzzleHttp\Promise\PromiseInterface deleteAsync($uri, array $options = [])
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, array $parameters){
        $response = null;
        list($url,$requestData) = $parameters;

        try {
            $loggerId = $this->logContainer->add([
                'url'          => $url,
                'method'       => $method,
                'request_data' => $requestData
            ]);

            $response = $this->client->$method(...$parameters);

            if($response instanceof PromiseInterface){
                $this->handlePromiseResponse($response,$loggerId);
            } else {
                $response = $this->handleResponse($response,$loggerId);
            }
        } catch(RequestException $exception){
            $this->handleRequestFailure(Psr7\str($exception->hasResponse() ? $exception->getResponse() : $exception->getRequest()),$loggerId);
        } catch(Exception $exception){
            $this->handleRequestFailure($exception->getMessage(),$loggerId);
        }

        return $response;
    }           
}