<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
abstract class MLCServer{

    /**
     * The filename of the currently executing script, relative to the document root. For instance, $_SERVER['PHP_SELF'] in a script at the address http://example.com/test.php/foo.bar would be /test.php/foo.bar. The __FILE__ constant contains the full path and filename of the current (i.e. included) file. If PHP is running as a command-line processor this variable contains the script name since PHP 4.3.0. Previously it was not available.
     */
    const PHP_SELF = 'PHP_SELF';
    /**
     * What revision of the CGI specification the server is using; i.e. 'CGI/1.1'.
     */
    const GATEWAY_INTERFACE = 'GATEWAY_INTERFACE';
    /**
     * The IP address of the server under which the current script is executing.
     */
    const SERVER_ADDR = 'SERVER_ADDR';
    /**
     * The name of the server host under which the current script is executing. If the script is running on a virtual host, this will be the value defined for that virtual host.
     */
    const SERVER_NAME = 'SERVER_NAME';
    /**
     *  Server identification string, given in the headers when responding to requests.
     */
    const SERVER_SOFTWARE = 'SERVER_SOFTWARE';
       /**
        * Name and revision of the information protocol via which the page was requested; i.e. 'HTTP/1.0';
        */
    const SERVER_PROTOCOL = 'SERVER_PROTOCOL';
    /**
     * Which request method was used to access the page; i.e. 'GET', 'HEAD', 'POST', 'PUT'.
     *  Note: PHP script is terminated after sending headers (it means after producing any output without output buffering) if the request method was HEAD.
     */
    const REQUEST_METHOD = 'REQUEST_METHOD';
    /**
     * The timestamp of the start of the request. Available since PHP 5.1.0.
     */
    const REQUEST_TIME = 'REQUEST_TIME';
     /**
      *  The query string, if any, via which the page was accessed.
      */
    const QUERY_STRING = 'QUERY_STRING';
       /**
        *  The document root directory under which the current script is executing, as defined in the server's configuration file.
        */
    const DOCUMENT_ROOT = 'DOCUMENT_ROOT';
    /**
     *  Contents of the Accept: header from the current request, if there is one.
     */
    const HTTP_ACCEPT = 'HTTP_ACCEPT';
       /**
        *  Contents of the Accept-Charset: header from the current request, if there is one. Example: 'iso-8859-1,*,utf-8'.
        */
    const HTTP_ACCEPT_CHARSET = 'HTTP_ACCEPT_CHARSET';
       /**
        * Contents of the Accept-Encoding: header from the current request, if there is one. Example: 'gzip'.
        */
    const HTTP_ACCEPT_ENCODING = 'HTTP_ACCEPT_ENCODING';
      /**
       * Contents of the Accept-Language: header from the current request, if there is one. Example: 'en'.
       */
    const HTTP_ACCEPT_LANGUAGE = 'HTTP_ACCEPT_LANGUAGE';
        /**
         * Contents of the Connection: header from the current request, if there is one. Example: 'Keep-Alive'.
         */
    const HTTP_CONNECTION = 'HTTP_CONNECTION';
       /**
        * Contents of the Host: header from the current request, if there is one.
        */
    const HTTP_HOST = 'HTTP_HOST';
        /**
         * The address of the page (if any) which referred the user agent to the current page. This is set by the user agent. Not all user agents will set this, and some provide the ability to modify HTTP_REFERER as a feature. In short, it cannot really be trusted.
         */
    const HTTP_REFERER = 'HTTP_REFERER';
        /**
         * Contents of the User-Agent: header from the current request, if there is one. This is a string denoting the user agent being which is accessing the page. A typical example is: Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586). Among other things, you can use this value with get_browser() to tailor your page's output to the capabilities of the user agent.
         */
    const HTTP_USER_AGENT = 'HTTP_USER_AGENT';
        /**
         * Set to a non-empty value if the script was queried through the HTTPS protocol.

            Note: Note that when using ISAPI with IIS, the value will be off if the request was not made through the HTTPS protocol.
         */
    const HTTPS = 'HTTPS';
        /**
         *  The IP address from which the user is viewing the current page.
         */
    const REMOTE_ADDR = 'REMOTE_ADDR';
       /**
        * The Host name from which the user is viewing the current page. The reverse dns lookup is based off the REMOTE_ADDR of the user.

            Note: Your web server must be configured to create this variable. For example in Apache you'll need HostnameLookups On inside httpd.conf for it to exist. See also gethostbyaddr().

        */
    const REMOTE_HOST = 'REMOTE_HOST';
        /**
         * The port being used on the user's machine to communicate with the web server.
         */
    const REMOTE_PORT = 'REMOTE_PORT';
        /**
         *
        The absolute pathname of the currently executing script.

            Note: If a script is executed with the CLI, as a relative path, such as file.php or ../file.php, $_SERVER['SCRIPT_FILENAME'] will contain the relative path specified by the user.

         */
    const SCRIPT_FILENAME = 'SCRIPT_FILENAME';
    /**
     * The value given to the SERVER_ADMIN (for Apache) directive in the web server configuration file. If the script is running on a virtual host, this will be the value defined for that virtual host.
     */
    const SERVER_ADMIN = 'SERVER_ADMIN';
        /**
         * The port on the server machine being used by the web server for communication. For default setups, this will be '80'; using SSL, for instance, will change this to whatever your defined secure HTTP port is.
         */
    const SERVER_PORT = 'SERVER_PORT';
       /**
        * String containing the server version and virtual host name which are added to server-generated pages, if enabled.
        */
    const SERVER_SIGNATURE = 'SERVER_SIGNATURE';
        /**
         * Filesystem- (not document root-) based path to the current script, after the server has done any virtual-to-real mapping.

            Note: As of PHP 4.3.2, PATH_TRANSLATED is no longer set implicitly under the Apache 2 SAPI in contrast to the situation in Apache 1, where it's set to the same value as the SCRIPT_FILENAME server variable when it's not populated by Apache. This change was made to comply with the CGI specification that PATH_TRANSLATED should only exist if PATH_INFO is defined. Apache 2 users may use AcceptPathInfo = On inside httpd.conf to define PATH_INFO.

         */
    const PATH_TRANSLATED = 'PATH_TRANSLATED';
        /**
         * Contains the current script's path. This is useful for pages which need to point to themselves. The __FILE__ constant contains the full path and filename of the current (i.e. included) file.
         */
    const SCRIPT_NAME = 'SCRIPT_NAME';
        /**
         * The URI which was given in order to access this page; for instance, '/index.html'.
         */
    const REQUEST_URI = 'REQUEST_URI';
        /**
         *  When running under Apache as module doing Digest HTTP authentication this variable is set to the 'Authorization' header sent by the client (which you should then use to make the appropriate validation).
         */
    const PHP_AUTH_DIGEST = 'PHP_AUTH_DIGEST';
       /**
        * When running under Apache or IIS (ISAPI on PHP 5) as module doing HTTP authentication this variable is set to the username provided by the user.
        */
    const PHP_AUTH_USER = 'PHP_AUTH_USER';
        /**
         * When running under Apache or IIS (ISAPI on PHP 5) as module doing HTTP authentication this variable is set to the password provided by the user.
         */
    const PHP_AUTH_PW = 'PHP_AUTH_PW';
        /**
         *  When running under Apache as module doing HTTP authenticated this variable is set to the authentication type.
         */
    const AUTH_TYPE = 'AUTH_TYPE';
      /**
         * Contains any client-provided pathname information trailing the actual script filename but preceding the query string, if available. For instance, if the current script was accessed via the URL http://www.example.com/php/path_info.php/some/stuff?foo=bar, then $_SERVER['PATH_INFO'] would contain /some/stuff.
         */
    const PATH_INFO = 'PATH_INFO';
        /**
         * Original version of 'PATH_INFO' before processed by PHP.
         */
    const ORIG_PATH_INFO = 'ORIG_PATH_INFO';
        
}
?>
