<?php
namespace Junk\Routing;

/**
 * This class represents one route that stores URI regex and action.
 * 
 */
class Route {
    /**
     * URI defined int the format `"/route/{param}"`.
     * 
     * @var string
     */
    protected string $uri;
    /**
     * Action associated to this URI
     * 
     * @var \Closure
     */
    protected \Closure $action;
    /**
     * Regular expresion used to match incoming requests URIs.
     * 
     * @var string
     */
    protected string $regex;
    /**
     * Route parameters names.
     * @var array<string>
     */
    protected array $parameters = [];

    /**
     * Create a new route with the given URI and action
     * 
     * @param string $uri
     * @param \Closure $action
     */
    public function __construct(string $uri, \Closure $action) {
        $this->uri = $uri;
        $this->action = $action;
        $this->regex = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9]+)', $uri);
        preg_match_all('/\{([a-zA-Z0-9]+)\}/', $uri, $parameters);
        $this->parameters = $parameters[1];
    }
    /**
     * Get a URI definition for this route
     * 
     * @return string
     */
    public function uri(): string {
        return $this->uri;
    }
    /**
     * Get the action that handles requests to the this URI.
     * 
     * @return \Closure
     */
    public function action(): \Closure {
        return $this->action;
    }
    /**
     * Check if the given `$uri` matches the regex of this route.
     * 
     * @param string $uri
     * @return bool
     */
    public function matches(string $uri): bool {
        return preg_match("#^$this->regex/?$#", $uri);
    }
    /**
     * Check if this route has variable parameters in its definition
     * 
     * @return bool
     */
    public function hasParameters(): bool {
        return count($this->parameters) > 0;
    }
    /**
     * Get the key-value pairs from the `$uri` as defined by this route
     * 
     */
    public function parseParameters(string $uri): array {
        preg_match("#^$this->regex$#", $uri, $arguments);
        
        return array_combine($this->parameters, array_slice($arguments, 1));
    }
}