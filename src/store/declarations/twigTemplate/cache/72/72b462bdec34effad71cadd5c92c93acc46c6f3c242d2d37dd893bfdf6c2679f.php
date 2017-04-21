<?php

/* index.twig */
class __TwigTemplate_0a62f9956faa8c518df9ae6e81e899eabde0fc106a1ed21a012cc03a12659136 extends Twig_Template
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
    <title>";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["app"]) ? $context["app"] : null), "html", null, true);
        echo " Project Api Documentation</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <link href=\"http://";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"http://";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/prettify.css\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"http://";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/style.css\" rel=\"stylesheet\" media=\"screen, print\">
    <link href=\"http://apidocjs.com/example/img/favicon.ico\" rel=\"icon\" type=\"image/x-icon\">
    <script src=\"http://";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/polyfill.js\"></script>
    <script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"main\" src=\"http://";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/main.js\"></script><style type=\"text/css\">/* This is not a zero-length file! */</style><style type=\"text/css\">/* This is not a zero-length file! */</style><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"jquery\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/jquery.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"lodash\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/lodash.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"locales\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/locale.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"api_project.js\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/api_project.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"api_data.js\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/api_data.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"utilsSampleRequest\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/send_sample_request.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"pathToRegexp\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/index.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"prettify\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/prettify.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"handlebars\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/handlebars.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"locales/de.js\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/de.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"bootstrap\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/bootstrap.min.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"handlebarsExtended\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/handlebars_helper.js\"></script><script type=\"text/javascript\" charset=\"utf-8\" async=\"\" data-requirecontext=\"_\" data-requiremodule=\"diffMatchPatch\" src=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/diff_match_patch.min.js\"></script><link rel=\"stylesheet\" type=\"text/css\" href=\"http://";
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/css\"></head>
<body>



<div class=\"container-fluid\">
    <div class=\"row-fluid\">
        <div id=\"sidenav\" class=\"span2\">
            <nav id=\"scrollingNav\">
                <ul class=\"sidenav nav nav-list\">
                    <li class=\"nav-fixed nav-header\" data-group=\"_\"><a href=\"http://";
        // line 22
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/service/";
        echo twig_escape_filter($this->env, (isset($context["app"]) ? $context["app"] : null), "html", null, true);
        echo "/doc/index?doc=true";
        echo twig_escape_filter($this->env, (isset($context["token"]) ? $context["token"] : null), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "general", array(), "array"), "html", null, true);
        echo " </a></li>
                    <li class=\"nav-header\" data-group=\"User\"><a href=\"\">";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "services", array(), "array"), "html", null, true);
        echo "</a></li>

                    ";
        // line 25
        if ((twig_length_filter($this->env, (isset($context["services"]) ? $context["services"] : null)) > 0)) {
            // line 26
            echo "                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["services"]) ? $context["services"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 27
                echo "                    <li data-group=\"Service\" data-name=\"GetService\" data-version=\"0.1.0\">
                        <a href=\"http://";
                // line 28
                echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
                echo "/service/";
                echo twig_escape_filter($this->env, (isset($context["app"]) ? $context["app"] : null), "html", null, true);
                echo "/doc/index?doc=true";
                echo twig_escape_filter($this->env, (isset($context["token"]) ? $context["token"] : null), "html", null, true);
                echo "&service=";
                echo twig_escape_filter($this->env, $context["item"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, (isset($context["appHeader"]) ? $context["appHeader"] : null), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, $context["item"]), "html", null, true);
                echo "</a>
                    </li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            echo "
                    ";
        } else {
            // line 33
            echo "                        <li data-group=\"Service\" data-name=\"GetService\" data-version=\"0.1.0\">
                            <a href=\"\">";
            // line 34
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "noService", array(), "array"), "html", null, true);
            echo "</a>
                        </li>
                    ";
        }
        // line 37
        echo "
                </ul>
            </nav>
        </div>
        <div id=\"content\">
            <div id=\"project\">
                <div class=\"pull-left\">
                    ";
        // line 44
        if (((isset($context["getService"]) ? $context["getService"] : null) == null)) {
            // line 45
            echo "
                        <h1>Mobi ";
            // line 46
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "homeintro", array(), "array"), "html", null, true);
            echo "</h1>

                    ";
        } else {
            // line 49
            echo "
                        <h1>";
            // line 50
            echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, (isset($context["app"]) ? $context["app"] : null)), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, (isset($context["getService"]) ? $context["getService"] : null)), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "contentintro", array(), "array"), "html", null, true);
            echo "</h1>

                    ";
        }
        // line 53
        echo "

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

                ";
        // line 75
        if (((isset($context["getService"]) ? $context["getService"] : null) == null)) {
            // line 76
            echo "
                    <div id=\"api-_\"><h2 id=\"welcome-to-apidoc\">";
            // line 77
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "homeintrosub", array(), "array"), "html", null, true);
            echo "</h2>
                        <p></p>
                    </div>

                ";
        } else {
            // line 82
            echo "
                    <div id=\"api-_\"><h2 id=\"welcome-to-apidoc\">";
            // line 83
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["lang"]) ? $context["lang"] : null), "contentintrosub", array(), "array"), "html", null, true);
            echo "</h2>
                        <p>---</p>
                    </div>

                ";
        }
        // line 88
        echo "

            </div>
            <div id=\"sections\">
                ";
        // line 92
        if (((isset($context["getService"]) ? $context["getService"] : null) == null)) {
            // line 93
            echo "
                    ";
            // line 94
            $this->loadTemplate("home.twig", "index.twig", 94)->display($context);
            // line 95
            echo "
                ";
        } else {
            // line 97
            echo "
                    ";
            // line 98
            $this->loadTemplate("content.twig", "index.twig", 98)->display($context);
            // line 99
            echo "
                ";
        }
        // line 101
        echo "
            </div>

            <br>
            <div id=\"footer\">
                <div id=\"api-_footer\"><h2 id=\"epilogue\">Apix Restfull System</h2>
                    <p>Suggestions, contact, support and error reporting on <a href=\"https://github.com/aligurbuz/apix\">GitHub</a></p>
                </div>
            </div>
            <div id=\"generator\">
                <div class=\"content\">
                    Generated with <a href=\"https://github.com/aligurbuz/apix\">Apix System</a>
                </div>
            </div>
        </div>
    </div>
</div>



<script data-main=\"main.js\" src=\"http://";
        // line 121
        echo twig_escape_filter($this->env, (isset($context["root"]) ? $context["root"] : null), "html", null, true);
        echo "/external/public/declarations/apidoc_files/require.min.js\"></script>


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
        return array (  274 => 121,  252 => 101,  248 => 99,  246 => 98,  243 => 97,  239 => 95,  237 => 94,  234 => 93,  232 => 92,  226 => 88,  218 => 83,  215 => 82,  207 => 77,  204 => 76,  202 => 75,  178 => 53,  168 => 50,  165 => 49,  159 => 46,  156 => 45,  154 => 44,  145 => 37,  139 => 34,  136 => 33,  132 => 31,  113 => 28,  110 => 27,  105 => 26,  103 => 25,  98 => 23,  88 => 22,  47 => 12,  43 => 11,  38 => 9,  34 => 8,  30 => 7,  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.twig", "/var/www/public/apix/src/store/declarations/twigTemplate/index.twig");
    }
}
