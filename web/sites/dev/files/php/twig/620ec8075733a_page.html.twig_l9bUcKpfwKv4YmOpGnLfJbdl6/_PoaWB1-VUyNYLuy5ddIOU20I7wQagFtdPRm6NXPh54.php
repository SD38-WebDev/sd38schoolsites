<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/rsd_sites_barrio/templates/page.html.twig */
class __TwigTemplate_f113e84c0faf0d1b40ab0954e185ea3ac19d1f1411c043a8f8f94eca3c911af6 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@bootstrap_barrio/layout/page.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("@bootstrap_barrio/layout/page.html.twig", "themes/custom/rsd_sites_barrio/templates/page.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 72
    public function block_head($context, array $blocks = [])
    {
        // line 73
        echo "<div id=\"district-branding\">
\t\t<div class=\"container\">
\t\t\t<div class=\"row justify-content-between\">
\t\t\t\t<div class=\"col\"><a href=\"https://www.sd38.bc.ca\" target=\"_blank\" title=\"School District No. 38 (Richmond)\"><div class=\"district-logo\">District Logo</div></a></div><div class=\"d-none d-md-block col-12 col-sm-9 col-md-7 col-lg-5\"><div class=\"district-statement\">Slogan</div></div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
        ";
        // line 80
        if ((($this->getAttribute(($context["page"] ?? null), "secondary_menu", []) || $this->getAttribute(($context["page"] ?? null), "top_header", [])) || $this->getAttribute(($context["page"] ?? null), "top_header_form", []))) {
            // line 81
            echo "          <nav";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_top_attributes"] ?? null)), "html", null, true);
            echo ">
          ";
            // line 82
            if (($context["container_navbar"] ?? null)) {
                // line 83
                echo "          <div class=\"container\">
          ";
            }
            // line 85
            echo "              ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "secondary_menu", [])), "html", null, true);
            echo "
              ";
            // line 86
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "top_header", [])), "html", null, true);
            echo "
              ";
            // line 87
            if ($this->getAttribute(($context["page"] ?? null), "top_header_form", [])) {
                // line 88
                echo "                <div class=\"form-inline navbar-form float-right\">
                  ";
                // line 89
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "top_header_form", [])), "html", null, true);
                echo "
                </div>
              ";
            }
            // line 92
            echo "          ";
            if (($context["container_navbar"] ?? null)) {
                // line 93
                echo "          </div>
          ";
            }
            // line 95
            echo "          </nav>
        ";
        }
        // line 97
        echo "        <nav";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_attributes"] ?? null)), "html", null, true);
        echo ">
          ";
        // line 98
        if (($context["container_navbar"] ?? null)) {
            // line 99
            echo "          <div class=\"container\">
          ";
        }
        // line 101
        echo "            ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header", [])), "html", null, true);
        echo "
            ";
        // line 102
        if (($this->getAttribute(($context["page"] ?? null), "primary_menu", []) || $this->getAttribute(($context["page"] ?? null), "header_form", []))) {
            // line 103
            echo "              <button class=\"navbar-toggler navbar-toggler-right\" type=\"button\" data-toggle=\"collapse\" data-target=\"#CollapsingNavbar\" aria-controls=\"CollapsingNavbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"><span class=\"navbar-toggler-icon\"></span></button>
              <div class=\"collapse navbar-collapse\" id=\"CollapsingNavbar\">
                ";
            // line 105
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "primary_menu", [])), "html", null, true);
            echo "
                ";
            // line 106
            if ($this->getAttribute(($context["page"] ?? null), "header_form", [])) {
                // line 107
                echo "                  <div class=\"form-inline navbar-form float-right\">
                    ";
                // line 108
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header_form", [])), "html", null, true);
                echo "
                  </div>
                ";
            }
            // line 111
            echo "\t          </div>
            ";
        }
        // line 113
        echo "            ";
        if (($context["sidebar_collapse"] ?? null)) {
            // line 114
            echo "              <button class=\"navbar-toggler navbar-toggler-left collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#CollapsingLeft\" aria-controls=\"CollapsingLeft\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"></button>
            ";
        }
        // line 116
        echo "          ";
        if (($context["container_navbar"] ?? null)) {
            // line 117
            echo "          </div>
          ";
        }
        // line 119
        echo "        </nav>
";
    }

    // line 122
    public function block_content($context, array $blocks = [])
    {
        // line 123
        echo "        <div id=\"main\" class=\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
        echo "\">
          ";
        // line 124
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "breadcrumb", [])), "html", null, true);
        echo "
          <div class=\"row row-offcanvas row-offcanvas-left clearfix\">
              <main class=\"main-content col order-1 order-lg-2\" id=\"content\" role=\"main\">
                <section class=\"section\">
                  <a id=\"main-content\" tabindex=\"-1\"></a>
                  ";
        // line 129
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
        echo "
                </section>
              </main>
            ";
        // line 132
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])) {
            // line 133
            echo "              <div class=\"sidebar_first sidebar col-lg-3 order-2 order-lg-1\" id=\"sidebar_first\">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 135
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])), "html", null, true);
            echo "
                </aside>
              </div>
            ";
        }
        // line 139
        echo "            ";
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])) {
            // line 140
            echo "              <div class=\"sidebar_second sidebar col-lg-3 order-3 order-sm-3\" id=\"sidebar_second\">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 142
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])), "html", null, true);
            echo "
                </aside>
              </div>
            ";
        }
        // line 146
        echo "          </div>
        </div>
";
    }

    // line 150
    public function block_footer($context, array $blocks = [])
    {
        // line 151
        echo "        <div class=\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
        echo "\">
          ";
        // line 152
        if (((($this->getAttribute(($context["page"] ?? null), "footer_first", []) || $this->getAttribute(($context["page"] ?? null), "footer_second", [])) || $this->getAttribute(($context["page"] ?? null), "footer_third", [])) || $this->getAttribute(($context["page"] ?? null), "footer_fourth", []))) {
            // line 153
            echo "            <div class=\"site-footer row\">
              <div class=\"col-lg\"><a href=\"https://www.sd38.bc.ca\" target=\"_blank\" title=\"School District No. 38 (Richmond)\"><div id=\"richmond-footer\"><img src=\"/themes/custom/rsd_sites_barrio/images/sd38-logo-white.png\"></a><br>Copyright &copy; ";
            // line 154
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
            echo " <br>School District No. 38 (Richmond)</div>";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_first", [])), "html", null, true);
            echo "</div>
              <div class=\"col-lg\">";
            // line 155
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_second", [])), "html", null, true);
            echo "</div>
              <div class=\"col-lg\">";
            // line 156
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_third", [])), "html", null, true);
            echo "</div>
              <div class=\"col-lg text-lg-right\">";
            // line 157
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_fourth", [])), "html", null, true);
            echo "</div>
            </div>
          ";
        }
        // line 160
        echo "          ";
        if ($this->getAttribute(($context["page"] ?? null), "footer_fifth", [])) {
            // line 161
            echo "            <div class=\"site-footer__bottom\">
              ";
            // line 162
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_fifth", [])), "html", null, true);
            echo "
            </div>
          ";
        }
        // line 165
        echo "        </div>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/rsd_sites_barrio/templates/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  259 => 165,  253 => 162,  250 => 161,  247 => 160,  241 => 157,  237 => 156,  233 => 155,  227 => 154,  224 => 153,  222 => 152,  217 => 151,  214 => 150,  208 => 146,  201 => 142,  197 => 140,  194 => 139,  187 => 135,  183 => 133,  181 => 132,  175 => 129,  167 => 124,  162 => 123,  159 => 122,  154 => 119,  150 => 117,  147 => 116,  143 => 114,  140 => 113,  136 => 111,  130 => 108,  127 => 107,  125 => 106,  121 => 105,  117 => 103,  115 => 102,  110 => 101,  106 => 99,  104 => 98,  99 => 97,  95 => 95,  91 => 93,  88 => 92,  82 => 89,  79 => 88,  77 => 87,  73 => 86,  68 => 85,  64 => 83,  62 => 82,  57 => 81,  55 => 80,  46 => 73,  43 => 72,  33 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/rsd_sites_barrio/templates/page.html.twig", "/var/www/html/web/themes/custom/rsd_sites_barrio/templates/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 80];
        static $filters = ["escape" => 81, "date" => 154];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'date'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
