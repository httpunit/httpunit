<?php

namespace HttpUnit\Component;

class Cookie
{
  /** @var array $array An array of key=>value pairs */
  protected $array = [];

  /** @var float $starttime */
  protected $starttime;
  
  /**
   * @param array $options
   */
  public function __construct(array $options = [])
  {
    $this->starttime = microtime(true);
    
    foreach ($options as $key => $value)
    {
      $this->set($key, $value);
    }
  }

  /**
   * Count cookie values
   * 
   * @return int
   */
  public function count()
  {
    return count($this->array);
  }

  /**
   * Gets values as array
   * 
   * @return array
   */
  public function toArray()
  {
    return $this->array;
  }

  /**
   * Set a new cookie value
   * 
   * @param string $key
   * 
   * @param string $value
   */
  public function set($key, $value)
  {
    $this->array[$key] = $value;
  }

  /**
   * Gets as header formatted
   * 
   * @return string
   */
  public function getFormatted()
  {
    $str = '';

    foreach ($this->array as $key => $value)
    {
      $str .= sprintf('%s=%s;', $key, $value);
    }

    return rtrim($str, ';');
  }

  /**
   * Merge with another cookie
   * 
   * @return HttpUnit\Component\Cookie
   */
  public function merge(Cookie $cookie)
  {
    $values = $cookie->toArray();

    foreach ($values as $key => $value)
    {
      $this->set($key, $value);
    }

    return $this;
  }
}
