<?php

namespace HttpUnit\Http;

class Response
{
  /** @var tring */
  protected $content;

  /** @var int */
  protected $errno;

  /** @var string */
  protected $errmsg;

  /** @var array */
  protected $info = [];

  /** @var array */
  protected $headers = [];

  /** @var string */
  protected $header = '';

  /** @var string */
  protected $body = '';

  /** @var HttpUnit\Http\Cookie */
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

  /**
   * Gets HTTP status code
   * 
   * @return int
   */
  public function getStatusCode()
  {
    if (isset($this->info['http_code']))
    {
      return (int)$this->info['http_code'];
    }
  }

  /**
   * Get Content Type
   * 
   * @return string
   */
  public function getContentType()
  {
    if (isset($this->info['content_type'])
     && preg_match('/^([^;]*);*/i', $this->info['content_type'], $match)
    ) {
        return $match[1];
    }
  }

  /**
   * Populate headers
   */
  private function parseHeaders()
  {
    $headers = explode("\n", $this->header);

    foreach ($headers as $header)
    {
      // cookie
      if (preg_match('/^set-cookie:\s*(?<key>[^=]*)=(?<value>[^;]*)/mi', $header, $match))
      {
        $this->getCookie()->set($match['key'], $match['value']);
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
   * @return HttpUnit\Http\Cookie
   */
  public function getCookie()
  {
    return $this->cookie;
  }

  /**
   * Gets body part of the response
   * 
   * @return string
   */
  public function getBody()
  {
    return $this->body;
  }
}
