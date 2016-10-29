<?php

namespace HttpUnit\Http;

use Exception;

class Request
{
  /** @var string */
  protected $method = 'GET';

  /** @var string */
  protected $scheme = 'http';

  /** @var string */
  protected $host = 'localhost';

  /** @var string */
  protected $path = '/';

  /** @var array */
  protected $params = [];

  /** @var string */
  protected $query;

  /**
   * @param array $options Default options for request
   */
  public function __construct($options = [])
  {
    foreach ($options as $attr => $value)
    {
      if (property_exists($this, $attr))
      {
        $this->$attr = $value;
      }
    }
  }

  /**
   * Gets a fully qualified URL
   * 
   * @return string
   */
  public function getUrl()
  {
    return sprintf('%s://%s%s%s'
      , $this->scheme
      , $this->host
      , $this->path
      , $this->query ? "?{$this->query}" : ''
    );
  }

  /**
   * Sets host
   *  
   * @param string
   */
  public function setHost($host)
  {
    $this->host = sprintf('%s', $host);
  }

  /**
   * Sets query params
   * 
   * @param string
   */
  public function setQuery($query)
  {
    $this->query = $query;
  }

  /**
   * Gets property
   * 
   * @return mixed
   * 
   * @throws \Exception
   */
  public function __get($name)
  {
    if (property_exists($this, $name))
    {
      return $this->$name;
    }
    
    throw new Exception('Property is NOT defined');
  }
}
