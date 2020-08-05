<?php 
//Security configuration.
$_SEC_CONFIG['INT32'] = FALSE;
//If you change site config then the salt will change too. This shold not change allot in production
$siteName = Tsama\Server::GetWebsiteConfig("NAME")["NAME"];
$siteLogo = Tsama\Server::GetWebsiteConfig("LOGO")["LOGO"];
$_SEC_CONFIG['FOOTPRINT_SALT'] = base64_encode($siteName.$siteLogo);
//Content-Security-Policy - See https://content-security-policy.com
//Default policies
$_SEC_CONFIG["CSP"]["default-src"] = "'none'";
$_SEC_CONFIG["CSP"]["script-src"] = "'self' 'unsafe-inline'";
$_SEC_CONFIG["CSP"]["style-src"] = "'self' 'unsafe-inline'";
$_SEC_CONFIG["CSP"]["img-src"] = "'self'";
$_SEC_CONFIG["CSP"]["connect-src"] = "'self'";
$_SEC_CONFIG["CSP"]["font-src"] = "";
$_SEC_CONFIG["CSP"]["object-src"] = "";
$_SEC_CONFIG["CSP"]["media-src"] = "";
$_SEC_CONFIG["CSP"]["frame-src"] = "'self'";
$_SEC_CONFIG["CSP"]["sandbox"] = "";
$_SEC_CONFIG["CSP"]["child-src"] = "";
$_SEC_CONFIG["CSP"]["form-action"] = "'self'";
$_SEC_CONFIG["CSP"]["base-uri"] = "'self'";
$_SEC_CONFIG["CSP"]["report-to"] = "";
//Add other settings as follows: e.g. $_SEC_CONFIG["CSP"]["manifest-src"] = 'none' or  $_SEC_CONFIG["CSP"]["navigate-to"] = "example.com"
?>
