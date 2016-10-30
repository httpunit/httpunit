<?php

namespace HttpUnit\Http;

class Headers
{
  /** @var array */
  protected $data = [];

  /**
   * Set a new header value
   * 
   * @param string $key
   * 
   * @param string $value
   */
  public function set($key, $value)
  {
    $this->data[$key] = $value;
  }

  /**
   * Get an array of headers
   * 
   * @return array
   */
  public function toArray()
  {
    $header = [];

    foreach ($this->data as $key => $value)
    {
      $header[] = sprintf('%s: %s', $key, $value);
    }

    return $header;
  }

  /**
   * Sets headers data from an array
   * 
   * @param array
   */
  public function fromArray(array $data)
  {
    foreach ($data as $key => $value)
    {
      $this->set($key, $value);
    }
  }

  /**
   * Counts headers values
   * 
   * @return int
   */
  public function count()
  {
    return count($this->data);
  }
}
