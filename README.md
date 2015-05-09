# Poirot\Exec

Execute system commands.

__STDIN__

```php
// Execute Command Line:
$exec = new ExeProc();
$re = $exec->exec("md5sum");

// Open Http Socket Connection:
$tcpClient = new \Poirot\Stream\WrapperClient('http://www.raya-media.com:80', 'r');
$stream = new \Poirot\Stream\Streamable($tcpClient->getConnect());
# pipe all http data as input for command(md5sum)
$stream->pipeTo($re->pipes()->stdin());
# close write input data
$re->pipes()->stdin()->getResource()->close();

// Read Output result, as stream:
$md5 = $re->pipes()->stdout()->readLine();

if ($re->pipes()->to(iExecDescriptor::XCDSC_STDERR) !== '') {
    // get stderr messages
    // ...
}

// Close Process:
$re->close();

var_dump($md5); // md5 hash of website content: fa59c70d613d4d0085b4d869c46288c9
```
