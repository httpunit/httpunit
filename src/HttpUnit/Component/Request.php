<?php

namespace HttpUnit\Component;

class Request
{
  /** @var string $method */
  protected $method = 'GET';

  /** @var string $scheme */
  protected $scheme = 'http';

  /** @var string $host */
  protected $host = 'localhost';

  /** @var string $path */
  protected $path = '/';

  /** @var array $params */
  protected $params = [];

  /** @var string $query */
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
   * Gets params
   * 
   * @return array
   */
  public function __get($name)
  {
    if (property_exists($this, $name))
    {
      return $this->$name;
    }
  }
}
