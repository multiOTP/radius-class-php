Pure PHP radius class
=====================
This current build (1.2.4) is obsolete. Take a look at the project https://github.com/dapphp/radius, which is based on this work and has been greatly enhanced by Drew Phillips (still maintained).

This Radius class is a radius client implementation in pure PHP
following the RFC 2865 rules (http://www.ietf.org/rfc/rfc2865.txt)

(c) 2008-2009 SysCo systemes de communication sa
http://developer.sysco.ch/php/

Current build: 1.2.4 (2018-11-03)

[![Donate via PayPal](https://img.shields.io/badge/donate-paypal-87ceeb.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&currency_code=USD&business=paypal@sysco.ch&item_name=Donation%20for%20PHP%20radius%20class%20project)
*Please consider supporting this project by making a donation via [PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&currency_code=USD&business=paypal@sysco.ch&item_name=Donation%20for%20PHP%20radius%20class%20project*

This class works with at least the following RADIUS servers:
 - Authenex Strong Authentication System (ASAS) with two-factor authentication
 - FreeRADIUS, a free Radius server implementation for Linux and *nix environments
 - Microsoft Radius server IAS
 - Mideye RADIUS server (http://www.mideye.com)
 - Radl, a free Radius server for Windows
 - RSA SecurID
 - VASCO Middleware 3.0 server
 - WinRadius, Windows Radius server (free for 5 users)
 - ZyXEL ZyWALL OTP (Authenex ASAS branded by ZyXEL, cheaper)
 


USAGE
=====
```
require_once('radius.class.php');
$radius = new Radius($ip_radius_server = 'radius_server_ip_address', $shared_secret = 'radius_shared_secret'[, $radius_suffix = 'optional_radius_suffix'[, $udp_timeout = udp_timeout_in_seconds[, $authentication_port = 1812]]]);
$result = $radius->Access_Request($username = 'username', $password = 'password'[, $udp_timeout = udp_timeout_in_seconds]);
```

EXAMPLES
========

Example 1
```
    require_once('radius.class.php');
    $radius = new Radius('127.0.0.1', 'secret');
    $radius->SetNasIpAddress('1.2.3.4'); // Needed for some devices (not always auto-detected)
    if ($radius->AccessRequest('user', 'pass')) {
        echo "Authentication accepted.";
    } else {
        echo "Authentication rejected.";
    }
```

Example 2
```
    require_once('radius.class.php');
    $radius = new Radius('127.0.0.1', 'secret');
    $radius->SetNasPort(0);
    $radius->SetNasIpAddress('1.2.3.4'); // Needed for some devices (not always auto-detected)
    if ($radius->AccessRequest('user', 'pass')) {
        echo "Authentication accepted.";
        echo "<br />";
    } else {
        echo "Authentication rejected.";
        echo "<br />";
    }
    echo $radius->GetReadableReceivedAttributes();
```
