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
   * @var string
   * 
   * Capture all informations about transaction
   * when verbose is set.
   */
  protected $transaction;

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
    $this->getCookie()->merge($this->getResponse()->getCookie());

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
    $options = [];

    // method
    if ($request->method == 'POST')
    {
      $options = [
        CURLOPT_POST        => 1,
        CURLOPT_POSTFIELDS  => $request->params
      ] + $options;
    }
    // Sets params for other methods
    elseif (count($request->params))
    {
      $request->setQuery(http_build_query($request->params));
    }

    // -vv
    if ($this->verbose == 'vv')
    {
      $this->transaction = fopen('php://temp', 'w');
      $options[CURLOPT_VERBOSE] = 1;
      $options[CURLOPT_STDERR] = $this->transaction;
    }

    // cookie
    if ($this->getCookie()->count())
    {
      $options[CURLOPT_COOKIE] = $this->getCookie()->getFormatted();
    }

    // URL
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

  /**
   * Gets current cookie
   * 
   * @return HttpUnit\Component\Cookie
   */
  public function getCookie()
  {
    return $this->cookie;
  }

  /**
   * Gets informations about HTTP transaction
   * 
   * @return string
   */
  public function getTransaction()
  {
    rewind($this->transaction);

    $contents = '';

    while (!feof($this->transaction))
    {
      $contents .= fread($this->transaction, 8192);
    }

    return $contents;
  }
}
