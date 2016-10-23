<?php

namespace HttpUnit\Component;

class Crawler
{
  /** @var array $options */
  protected $options = [
      CURLOPT_RETURNTRANSFER => true,         // return web page
      CURLOPT_HEADER         => true,         // return headers
      CURLOPT_FOLLOWLOCATION => true,         // follow redirects
      CURLOPT_ENCODING       => "",           // handle all encodings
      CURLOPT_USERAGENT      => "HttpUnit Test Spider",
      CURLOPT_AUTOREFERER    => true,         // set referer on redirect
      CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
      CURLOPT_TIMEOUT        => 120,          // timeout on response
      CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
      CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
      CURLOPT_SSL_VERIFYPEER => false,        //
      CURLOPT_VERBOSE        => 0
  ];

  /** @var HttpUnit\Component\Cookie $cookie */
  protected $cookie; 

  /** @var string $host */
  protected $host;

  /** @var HttpUnit\Component\Response $response */
  protected $response;

  /** @var string $verbose v for verbosity, vv for more verbosity */
  protected $verbose;

  /**
   * @param array $options Defaults for the crawler
   */
  public function __construct($options = [])
  {
    $this->cookie = new Cookie;

    foreach ($options as $attr => $value)
    {
      if (array_key_exists($attr, $this->options))
      {
        $this->options[$attr] = $value;
      }
      elseif ($attr == 'cookie')
      {
        $this->cookie = new Cookie ($value);
      }
      elseif (property_exists($this, $attr))
      {
        $this->$attr = $value;
      }
    }

    $this->response = new Response;
  }

  /**
   * @param HttpUnit\Component\Request $request
   * 
   * @return HttpUnit\Component\Response $this->response
   */
  public function run(Request $request)
  {
    // Override request's host
    if (null !== $this->host && $request->host == 'localhost')
    {
      $request->setHost($this->host);
    }

    // Make options
    $options = $this->makeOptions($request) + $this->options;

    $handler = curl_init();
    curl_setopt_array($handler, $options);

    $this->response = new Response(
      curl_exec($handler), curl_errno($handler), curl_error($handler), curl_getinfo($handler)
    );
    curl_close($handler);

    // Merge cookie
    $this->cookie->merge($this->response->getCookie());

    if ($this->verbose)
    {
      foreach ($this->response as $attr => $value)
      {
        echo PHP_EOL . "$attr:" . print_r($value, true);
      }
    }

    return $this->response;
  }

  /**
   * Makes local options
   * 
   * @param HttpUnit\Component\Request $request
   * 
   * @return array
   */
  private function makeOptions(Request $request)
  {
    // method
    if ($request->method == 'POST')
    {
      $options = array_merge($options, [
        CURLOPT_POST        => 1,
        CURLOPT_POSTFIELDS  => $request->params
      ]);
    }
    // Sets params for other methods
    elseif (count($request->params))
    {
      $request->setQuery(http_build_query($request->params));
    }

    // -vv
    if ($this->verbose == 'vv')
    {
      $options[CURLOPT_VERBOSE] = 1;
    }

    // cookie
    if (count($this->cookie))
    {
      $options[CURLOPT_COOKIE] = $this->cookie->getFormatted();
    }

    $options[CURLOPT_URL] = $request->getUrl();

    return $options;
  }

  /**
   * Gets last response
   * 
   * @return HttpUnit\Component\Response
   */
  public function getResponse()
  {
    return $this->response;
  }

  public function getCookie()
  {
    if (property_exists($this, 'cookie'))
    {
      return $this->cookie;
    }
  }

  public function getHeaders()
  {
    if (property_exists($this->response, 'headers'))
    {
      return $this->response->headers;
    }
  }

  public function getContent()
  {
    if (property_exists($this->response, 'content'))
    {
      return $this->response->content;
    }
  }

  public function getInfo()
  {
    if (property_exists($this->response, 'info'))
    {
      return $this->response->info;
    }
  }
}
