<?php

/* index.twig */
class __TwigTemplate_08b2de0882679053602c02e03072c8c0f036f73b881558d44267e66f37e6a91c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!-- saved from url=(0028)http://apidocjs.com/example/ -->
<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <title>apiDoc: apidoc-example - 0.3.0</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <link href=\"http://";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"http://";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/prettify.css\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"http://";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/style.css\" rel=\"stylesheet\" media=\"screen, print\">
    <link href=\"http://apidocjs.com/example/img/favicon.ico\" rel=\"icon\" type=\"image/x-icon\">
    <script src=\"http://";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/polyfill.js\"></script>
    <script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"main\" src=\"http://";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/main.js\"></script><style type=\"text/css\">/* This is not a zero-length file! */</style><style type=\"text/css\">/* This is not a zero-length file! */</style><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"jquery\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/jquery.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"lodash\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/lodash.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"locales\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/locale.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"api_project.js\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/api_project.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"api_data.js\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/api_data.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"utilsSampleRequest\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/send_sample_request.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"pathToRegexp\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/index.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"prettify\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/prettify.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"handlebars\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/handlebars.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"locales/de.js\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/de.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"bootstrap\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/bootstrap.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"handlebarsExtended\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/handlebars_helper.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"diffMatchPatch\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/diff_match_patch.min.js\"></script><link rel=\"stylesheet\" type=\"text/css\" href=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/css\"></head>
<body>



<div class=\"container-fluid\">
    <div class=\"row-fluid\">
        <div id=\"sidenav\" class=\"span2\">
            <nav id=\"scrollingNav\">
                <ul class=\"sidenav nav nav-list\">
                    <li class=\"nav-fixed nav-header\" data-group=\"_\"><a href=\"http://apidocjs.com/example/#api-_\">General</a></li>
                    <li class=\"nav-header\" data-group=\"User\"><a href=\"http://apidocjs.com/example/#api-User\">User</a></li>
                    <li data-group=\"User\" data-name=\"GetUser\" data-version=\"0.3.0\">
                        <a href=\"http://apidocjs.com/example/#api-User-GetUser\">Read data of a User</a>
                    </li>
                    <li class=\"hide\" data-group=\"User\" data-name=\"GetUser\" data-version=\"0.2.0\">
                        <a href=\"http://apidocjs.com/example/#api-User-GetUser\">Read data of a User</a>
                    </li>
                    <li class=\"hide\" data-group=\"User\" data-name=\"GetUser\" data-version=\"0.1.0\">
                        <a href=\"http://apidocjs.com/example/#api-User-GetUser\">Read data of a User</a>
                    </li>
                    <li data-group=\"User\" data-name=\"PostUser\" data-version=\"0.3.0\">
                        <a href=\"http://apidocjs.com/example/#api-User-PostUser\">Create a new User</a>
                    </li>
                    <li class=\"hide\" data-group=\"User\" data-name=\"PostUser\" data-version=\"0.2.0\">
                        <a href=\"http://apidocjs.com/example/#api-User-PostUser\">Create a User</a>
                    </li>
                    <li data-group=\"User\" data-name=\"PutUser\" data-version=\"0.3.0\" class=\"is-new\">
                        <a href=\"http://apidocjs.com/example/#api-User-PutUser\">Change a new User</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id=\"content\">
            <div id=\"project\">
                <div class=\"pull-left\">
                    <h1>apidoc-example</h1>
                    <h2>apiDoc example project</h2>
                </div>
                <div class=\"pull-right\">
                    <div class=\"btn-group\">
                        <button id=\"version\" class=\"btn btn-large dropdown-toggle\" data-toggle=\"dropdown\">
                            <strong>0.3.0</strong> <span class=\"caret\"></span>
                        </button>
                        <ul id=\"versions\" class=\"dropdown-menu open-left\">
                            <li><a id=\"compareAllWithPredecessor\" href=\"http://apidocjs.com/example/#\">Compare all with predecessor</a></li>
                            <li class=\"divider\"></li>
                            <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">show up to version:</a></li>
                            <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                            <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                            <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.1.0</a></li>
                        </ul>
                    </div>
                </div>
                <div class=\"clearfix\"></div>
            </div>
            <div id=\"header\">
                <div id=\"api-_\"><h2 id=\"welcome-to-apidoc\">Welcome to apiDoc</h2>
                    <p>Please visit <a href=\"http://apidocjs.com/\">apidocjs.com</a> with the full documentation.</p>
                </div>
            </div>
            <div id=\"sections\">
                <section id=\"api-User\">
                    <h1>User</h1>
                    <div id=\"api-User-GetUser\">

                        <article id=\"api-User-GetUser-0.3.0\" data-group=\"User\" data-name=\"GetUser\" data-version=\"0.3.0\">
                            <div class=\"pull-left\">
                                <h1>User - Read data of a User</h1>
                            </div>
                            <div class=\"pull-right\">
                                <div class=\"btn-group\">
                                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                                        <strong>0.3.0</strong> <span class=\"caret\"></span>
                                    </button>
                                    <ul class=\"versions dropdown-menu open-left\">
                                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.1.0</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=\"clearfix\"></div>

                            <p></p><p>Compare Verison 0.3.0 with 0.2.0 and you will see the green markers with new items in version 0.3.0 and red markers with removed items since 0.2.0.</p> <p></p>

                            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"get\"><code><span class=\"pln\">/user/:id</span></code></pre>

                            <p>
                                Permission:
                                admin
                                &nbsp;<a href=\"http://apidocjs.com/example/#\" data-toggle=\"popover\" data-placement=\"right\" data-html=\"true\" data-content=\"&lt;p&gt;Optionally you can write here further Informations about the permission.&lt;/p&gt; &lt;p&gt;An &amp;quot;apiDefine&amp;quot;-block can have an &amp;quot;apiVersion&amp;quot;, so you can attach the block to a specific version.&lt;/p&gt; \" title=\"\" data-original-title=\"Admin access rights needed.\"><span class=\"label label-info\"><i class=\"icon icon-info-sign icon-white\"></i></span></a>

                            </p>

                            <ul class=\"nav nav-tabs nav-tabs-examples\">
                                <li class=\"active\">
                                    <a href=\"http://apidocjs.com/example/#examples-User-GetUser-0_3_0-0\">Example usage:</a>
                                </li>
                            </ul>

                            <div class=\"tab-content\">
                                <div class=\"tab-pane active\" id=\"examples-User-GetUser-0_3_0-0\">
                                    <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">curl </span><span class=\"pun\">-</span><span class=\"pln\">i http</span><span class=\"pun\">://</span><span class=\"pln\">localhost</span><span class=\"pun\">/</span><span class=\"pln\">user</span><span class=\"pun\">/</span><span class=\"lit\">4711</span></code></pre>
                                </div>
                            </div>




                            <h2>Parameter</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Success 200</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">registered</td>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                        <p>Registration Date.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">name</td>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                        <p>Fullname of the User.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">nicknames</td>
                                    <td>
                                        String[]
                                    </td>
                                    <td>
                                        <p>List of Users nicknames (Array of Strings).</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">profile</td>
                                    <td>
                                        Object
                                    </td>
                                    <td>
                                        <p>Profile data (example for an Object)</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">&nbsp;&nbsp;age</td>
                                    <td>
                                        Number
                                    </td>
                                    <td>
                                        <p>Users age.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">&nbsp;&nbsp;image</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>Avatar-Image.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">options</td>
                                    <td>
                                        Object[]
                                    </td>
                                    <td>
                                        <p>List of Users options (Array of Objects).</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">&nbsp;&nbsp;name</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>Option Name.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">&nbsp;&nbsp;value</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>Option Value.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Error 4xx</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>

                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">NoAccessRight</td>
                                    <td>
                                        <p>Only authenticated Admins can access the data.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">UserNotFound</td>
                                    <td>
                                        <p>The <code>id</code> of the User was not found.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <ul class=\"nav nav-tabs nav-tabs-examples\">
                                <li class=\"active\">
                                    <a href=\"http://apidocjs.com/example/#error-examples-User-GetUser-0_3_0-0\">Response (example):</a>
                                </li>
                            </ul>

                            <div class=\"tab-content\">
                                <div class=\"tab-pane active\" id=\"error-examples-User-GetUser-0_3_0-0\">
        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">    HTTP</span><span class=\"pun\">/</span><span class=\"lit\">1.1</span><span class=\"pln\"> </span><span class=\"lit\">401</span><span class=\"pln\"> </span><span class=\"typ\">Not</span><span class=\"pln\"> </span><span class=\"typ\">Authenticated</span><span class=\"pln\">
    </span><span class=\"pun\">{</span><span class=\"pln\">
      </span><span class=\"str\">\"error\"</span><span class=\"pun\">:</span><span class=\"pln\"> </span><span class=\"str\">\"NoAccessRight\"</span><span class=\"pln\">
    </span><span class=\"pun\">}</span></code></pre>
                                </div>
                            </div>




                            <h2>Send a Sample Request</h2>
                            <form class=\"form-horizontal\">
                                <fieldset>
                                    <div class=\"control-group\">
                                        <div class=\"controls\">
                                            <div class=\"input-prepend\">&gt;
                                                <span class=\"add-on\">url</span>
                                                <input type=\"text\" class=\"input-xxlarge sample-request-url\" value=\"http://apidocjs.com/example/api_project.json\">
                                            </div>
                                        </div>
                                    </div>


                                    <h3>Parameters</h3>
                                    <h4><input type=\"radio\" data-sample-request-param-group-id=\"sample-request-param-0\" name=\"User-GetUser-0_3_0-sample-request-param\" value=\"0\" class=\"sample-request-param sample-request-switch\" checked=\"\"> Parameter</h4>
                                    <div class=\"User-GetUser-0_3_0-sample-request-param-fields\">
                                        <div class=\"control-group\">
                                            <label class=\"control-label\" for=\"sample-request-param-field-id\">id</label>
                                            <div class=\"controls\">
                                                <div class=\"input-append\">&gt;
                                                    <input type=\"text\" placeholder=\"id\" class=\"input-xxlarge sample-request-param\" data-sample-request-param-name=\"id\" data-sample-request-param-group=\"sample-request-param-0\">
                                                    <span class=\"add-on\">String</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"control-group\">
                                        <div class=\"controls\">
                                            <button class=\"btn btn-default sample-request-send\" data-sample-request-type=\"get\">Send</button>
                                        </div>
                                    </div>

                                    <div class=\"sample-request-response\" style=\"display: none;\">
                                        <h3>
                                            Response
                                            <button class=\"btn btn-small btn-default pull-right sample-request-clear\">X</button>
                                        </h3>
                                        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code class=\"sample-request-response-json\"></code></pre>
                                    </div>

                                </fieldset>
                            </form>


                        </article>

                    </div>
                    <div id=\"api-User-GetUser\">

                        <article id=\"api-User-GetUser-0.2.0\" class=\"hide\" data-group=\"User\" data-name=\"GetUser\" data-version=\"0.2.0\">
                            <div class=\"pull-left\">
                                <h1>User - Read data of a User</h1>
                            </div>
                            <div class=\"pull-right\">
                                <div class=\"btn-group\">
                                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                                        <strong>0.2.0</strong> <span class=\"caret\"></span>
                                    </button>
                                    <ul class=\"versions dropdown-menu open-left\">
                                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.1.0</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=\"clearfix\"></div>

                            <p></p><p>Here you can describe the function. Multilines are possible.</p> <p></p>

                            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"get\"><code><span class=\"pln\">/user/:id</span></code></pre>

                            <p>
                                Permission:
                                admin
                                &nbsp;<a href=\"http://apidocjs.com/example/#\" data-toggle=\"popover\" data-placement=\"right\" data-html=\"true\" data-content=\"\" title=\"\" data-original-title=\"This title is visible in version 0.1.0 and 0.2.0\"><span class=\"label label-info\"><i class=\"icon icon-info-sign icon-white\"></i></span></a>

                            </p>





                            <h2>Parameter</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Success 200</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">name</td>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                        <p>Fullname of the User.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Error 4xx</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>

                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">UserNotFound</td>
                                    <td>
                                        <p>The <code>id</code> of the User was not found.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>







                        </article>

                    </div>
                    <div id=\"api-User-GetUser\">

                        <article id=\"api-User-GetUser-0.1.0\" class=\"hide\" data-group=\"User\" data-name=\"GetUser\" data-version=\"0.1.0\">
                            <div class=\"pull-left\">
                                <h1>User - Read data of a User</h1>
                            </div>
                            <div class=\"pull-right\">
                                <div class=\"btn-group\">
                                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                                        <strong>0.1.0</strong> <span class=\"caret\"></span>
                                    </button>
                                    <ul class=\"versions dropdown-menu open-left\">
                                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.1.0</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=\"clearfix\"></div>

                            <p></p><p>Here you can describe the function. Multilines are possible.</p> <p></p>

                            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"get\"><code><span class=\"pln\">/user/:id</span></code></pre>

                            <p>
                                Permission:
                                admin
                                &nbsp;<a href=\"http://apidocjs.com/example/#\" data-toggle=\"popover\" data-placement=\"right\" data-html=\"true\" data-content=\"\" title=\"\" data-original-title=\"This title is visible in version 0.1.0 and 0.2.0\"><span class=\"label label-info\"><i class=\"icon icon-info-sign icon-white\"></i></span></a>

                            </p>





                            <h2>Parameter</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Success 200</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">name</td>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                        <p>Fullname of the User.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Error 4xx</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>

                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">UserNotFound</td>
                                    <td>
                                        <p>The error description text in version 0.1.0.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>







                        </article>

                    </div>
                    <div id=\"api-User-PostUser\">

                        <article id=\"api-User-PostUser-0.3.0\" data-group=\"User\" data-name=\"PostUser\" data-version=\"0.3.0\">
                            <div class=\"pull-left\">
                                <h1>User - Create a new User</h1>
                            </div>
                            <div class=\"pull-right\">
                                <div class=\"btn-group\">
                                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                                        <strong>0.3.0</strong> <span class=\"caret\"></span>
                                    </button>
                                    <ul class=\"versions dropdown-menu open-left\">
                                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=\"clearfix\"></div>

                            <p></p><p>In this case \"apiUse\" is defined and used. Define blocks with params that will be used in several functions, so you dont have to rewrite them.</p> <p></p>

                            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"post\"><code><span class=\"pln\">/user</span></code></pre>

                            <p>
                                Permission:
                                none
                            </p>





                            <h2>Parameter</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">name</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>Name of the User.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Success 200</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The new Users-ID.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Error 4xx</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>

                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">NoAccessRight</td>
                                    <td>
                                        <p>Only authenticated Admins can access the data.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">UserNameTooShort</td>
                                    <td>
                                        <p>Minimum of 5 characters required.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <ul class=\"nav nav-tabs nav-tabs-examples\">
                                <li class=\"active\">
                                    <a href=\"http://apidocjs.com/example/#error-examples-User-PostUser-0_3_0-0\">Response (example):</a>
                                </li>
                            </ul>

                            <div class=\"tab-content\">
                                <div class=\"tab-pane active\" id=\"error-examples-User-PostUser-0_3_0-0\">
        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">    HTTP</span><span class=\"pun\">/</span><span class=\"lit\">1.1</span><span class=\"pln\"> </span><span class=\"lit\">400</span><span class=\"pln\"> </span><span class=\"typ\">Bad</span><span class=\"pln\"> </span><span class=\"typ\">Request</span><span class=\"pln\">
    </span><span class=\"pun\">{</span><span class=\"pln\">
      </span><span class=\"str\">\"error\"</span><span class=\"pun\">:</span><span class=\"pln\"> </span><span class=\"str\">\"UserNameTooShort\"</span><span class=\"pln\">
    </span><span class=\"pun\">}</span></code></pre>
                                </div>
                            </div>






                        </article>

                    </div>
                    <div id=\"api-User-PostUser\">

                        <article id=\"api-User-PostUser-0.2.0\" class=\"hide\" data-group=\"User\" data-name=\"PostUser\" data-version=\"0.2.0\">
                            <div class=\"pull-left\">
                                <h1>User - Create a User</h1>
                            </div>
                            <div class=\"pull-right\">
                                <div class=\"btn-group\">
                                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                                        <strong>0.2.0</strong> <span class=\"caret\"></span>
                                    </button>
                                    <ul class=\"versions dropdown-menu open-left\">
                                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=\"clearfix\"></div>

                            <p></p><p>In this case \"apiUse\" is defined and used. Define blocks with params that will be used in several functions, so you dont have to rewrite them.</p> <p></p>

                            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"post\"><code><span class=\"pln\">/user</span></code></pre>

                            <p>
                                Permission:
                                none
                            </p>





                            <h2>Parameter</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">name</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>Name of the User.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Success 200</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">id</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>The Users-ID.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>




                            <h2>Error 4xx</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>

                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">NoAccessRight</td>
                                    <td>
                                        <p>Only authenticated Admins can access the data.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">UserNameTooShort</td>
                                    <td>
                                        <p>Minimum of 5 characters required.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <ul class=\"nav nav-tabs nav-tabs-examples\">
                                <li class=\"active\">
                                    <a href=\"http://apidocjs.com/example/#error-examples-User-PostUser-0_2_0-0\">Response (example):</a>
                                </li>
                            </ul>

                            <div class=\"tab-content\">
                                <div class=\"tab-pane active\" id=\"error-examples-User-PostUser-0_2_0-0\">
        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">    HTTP</span><span class=\"pun\">/</span><span class=\"lit\">1.1</span><span class=\"pln\"> </span><span class=\"lit\">400</span><span class=\"pln\"> </span><span class=\"typ\">Bad</span><span class=\"pln\"> </span><span class=\"typ\">Request</span><span class=\"pln\">
    </span><span class=\"pun\">{</span><span class=\"pln\">
      </span><span class=\"str\">\"error\"</span><span class=\"pun\">:</span><span class=\"pln\"> </span><span class=\"str\">\"UserNameTooShort\"</span><span class=\"pln\">
    </span><span class=\"pun\">}</span></code></pre>
                                </div>
                            </div>






                        </article>

                    </div>
                    <div id=\"api-User-PutUser\">

                        <article id=\"api-User-PutUser-0.3.0\" data-group=\"User\" data-name=\"PutUser\" data-version=\"0.3.0\">
                            <div class=\"pull-left\">
                                <h1>User - Change a new User</h1>
                            </div>
                            <div class=\"pull-right\">
                                <div class=\"btn-group\">
                                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                                        <strong>0.3.0</strong> <span class=\"caret\"></span>
                                    </button>
                                    <ul class=\"versions dropdown-menu open-left\">
                                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class=\"clearfix\"></div>

                            <p></p><p>This function has same errors like POST /user, but errors not defined again, they were included with \"apiUse\"</p> <p></p>

                            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"put\"><code><span class=\"pln\">/user/:id</span></code></pre>

                            <p>
                                Permission:
                                none
                            </p>





                            <h2>Parameter</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>
                                    <th style=\"width: 10%\">Type</th>
                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">name</td>
                                    <td>
                                        String
                                    </td>
                                    <td>
                                        <p>Name of the User.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>






                            <h2>Error 4xx</h2>
                            <table>
                                <thead>
                                <tr>
                                    <th style=\"width: 30%\">Field</th>

                                    <th style=\"width: 70%\">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class=\"code\">NoAccessRight</td>
                                    <td>
                                        <p>Only authenticated Admins can access the data.</p>


                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"code\">UserNameTooShort</td>
                                    <td>
                                        <p>Minimum of 5 characters required.</p>


                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <ul class=\"nav nav-tabs nav-tabs-examples\">
                                <li class=\"active\">
                                    <a href=\"http://apidocjs.com/example/#error-examples-User-PutUser-0_3_0-0\">Response (example):</a>
                                </li>
                            </ul>

                            <div class=\"tab-content\">
                                <div class=\"tab-pane active\" id=\"error-examples-User-PutUser-0_3_0-0\">
        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">    HTTP</span><span class=\"pun\">/</span><span class=\"lit\">1.1</span><span class=\"pln\"> </span><span class=\"lit\">400</span><span class=\"pln\"> </span><span class=\"typ\">Bad</span><span class=\"pln\"> </span><span class=\"typ\">Request</span><span class=\"pln\">
    </span><span class=\"pun\">{</span><span class=\"pln\">
      </span><span class=\"str\">\"error\"</span><span class=\"pun\">:</span><span class=\"pln\"> </span><span class=\"str\">\"UserNameTooShort\"</span><span class=\"pln\">
    </span><span class=\"pun\">}</span></code></pre>
                                </div>
                            </div>






                        </article>

                    </div>
                </section>
            </div>
            <div id=\"footer\">
                <div id=\"api-_footer\"><h2 id=\"epilogue\">Epilogue</h2>
                    <p>Suggestions, contact, support and error reporting on <a href=\"https://github.com/apidoc/apidoc/issues\">GitHub</a></p>
                </div>
            </div>
            <div id=\"generator\">
                <div class=\"content\">
                    Generated with <a href=\"http://apidocjs.com/\">apiDoc</a> 0.9.0 - 2014-11-28T14:51:50.677Z
                </div>
            </div>
        </div>
    </div>
</div>



<script data-main=\"main.js\" src=\"http://";
        // line 1042
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/public/declarations/apidoc_files/require.min.js\"></script>


</body></html>";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1105 => 1042,  44 => 12,  40 => 11,  35 => 9,  31 => 8,  27 => 7,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.twig", "/var/www/public/apix/src/declarations/twigTemplate/index.twig");
    }
}
