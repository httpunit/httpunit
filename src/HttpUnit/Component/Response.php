<?php

namespace HttpUnit\Component;

class Response
{
  protected $content;
  protected $errno;
  protected $errmsg;
  protected $info;

  protected $headers = array();
  protected $header = '';
  protected $body = '';
  protected $cookie;
  
  /**
   * @param string $content
   * 
   * @param int $errno
   * 
   * @param string $errmsg
   * 
   * @param array $info
   */
  public function __construct($content = '', $errno = 0, $errmsg = '', array $info = [])
  {
    $this->content = $content;
    $this->errno = $errno;
    $this->errmsg = $errmsg;
    $this->info = $info;
    $this->cookie = new Cookie;

    if (isset($info['header_size']))
    {
      $headerSize = $info['header_size']; 
      $this->header = substr($content, 0, $headerSize);
      $this->body = substr($content, $headerSize);

      $this->parseHeaders();
    }
  }

  public function getInfo($key = null)
  {
    return null !== $key && array_key_exists($key, $this->info)
      ? $this->info[$key] : $this->info;
  }

  public function getStatusCode()
  {
    if (isset($this->info['http_code']))
    {
      return (int)$this->info['http_code'];
    }

    return 0;
  }

  /**
   * Get Content Type
   * 
   * @return string
   */
  public function getContentType()
  {
    if (isset($this->info['content_type']))
    {
      if (preg_match('/^([^;]*);*/i', $this->info['content_type'], $match))
      {
        return $match[1];
      }
    }
  }

  public function parseHeaders()
  {
    $headers = explode("\n", $this->header);

    foreach ($headers as $header)
    {
      // cookie
      if (preg_match('/^set-cookie:\s*(?<key>[^=]*)=(?<value>[^;]*)/mi', $header, $match))
      {
        $this->cookie->set($match['key'], $match['value']);
      }
      elseif (preg_match('/^(?<key>[^:]*):\s*(?<value>[^;]*)/mi', $header, $match))
      {
        $this->headers[$match['key']] = $match['value'];
      }
    }
  }

  /**
   * Gets cookie values from HTTP Headers
   * 
   * @return HttpUnit\Component\Cookie
   */
  public function getCookie()
  {
    return $this->cookie;
  }
}
