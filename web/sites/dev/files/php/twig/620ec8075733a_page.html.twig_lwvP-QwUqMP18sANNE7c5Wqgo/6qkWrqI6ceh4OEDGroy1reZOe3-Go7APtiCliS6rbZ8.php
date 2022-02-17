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

/* @bootstrap_barrio/layout/page.html.twig */
class __TwigTemplate_b6402f21f416c190625d59dcb0f075cbf6402ab41075a949e2480d04df5f4757 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'featured' => [$this, 'block_featured'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 70
        echo "<div id=\"page-wrapper\">
  <div id=\"page\">
    <header id=\"header\" class=\"header\" role=\"banner\" aria-label=\"";
        // line 72
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Site header"));
        echo "\">
      ";
        // line 73
        $this->displayBlock('head', $context, $blocks);
        // line 115
        echo "    </header>
    ";
        // line 116
        if ($this->getAttribute(($context["page"] ?? null), "highlighted", [])) {
            // line 117
            echo "      <div class=\"highlighted\">
        <aside class=\"";
            // line 118
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
            echo " section clearfix\" role=\"complementary\">
          ";
            // line 119
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "highlighted", [])), "html", null, true);
            echo "
        </aside>
      </div>
    ";
        }
        // line 123
        echo "    ";
        if ($this->getAttribute(($context["page"] ?? null), "featured_top", [])) {
            // line 124
            echo "      ";
            $this->displayBlock('featured', $context, $blocks);
            // line 131
            echo "    ";
        }
        // line 132
        echo "    <div id=\"main-wrapper\" class=\"layout-main-wrapper clearfix\">
      ";
        // line 133
        $this->displayBlock('content', $context, $blocks);
        // line 160
        echo "    </div>
    ";
        // line 161
        if ((($this->getAttribute(($context["page"] ?? null), "featured_bottom_first", []) || $this->getAttribute(($context["page"] ?? null), "featured_bottom_second", [])) || $this->getAttribute(($context["page"] ?? null), "featured_bottom_third", []))) {
            // line 162
            echo "      <div class=\"featured-bottom\">
        <aside class=\"";
            // line 163
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
            echo " clearfix\" role=\"complementary\">
          ";
            // line 164
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "featured_bottom_first", [])), "html", null, true);
            echo "
          ";
            // line 165
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "featured_bottom_second", [])), "html", null, true);
            echo "
          ";
            // line 166
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "featured_bottom_third", [])), "html", null, true);
            echo "
        </aside>
      </div>
    ";
        }
        // line 170
        echo "    <footer class=\"site-footer\">
      ";
        // line 171
        $this->displayBlock('footer', $context, $blocks);
        // line 188
        echo "    </footer>
  </div>
</div>
";
    }

    // line 73
    public function block_head($context, array $blocks = [])
    {
        // line 74
        echo "        ";
        if ((($this->getAttribute(($context["page"] ?? null), "secondary_menu", []) || $this->getAttribute(($context["page"] ?? null), "top_header", [])) || $this->getAttribute(($context["page"] ?? null), "top_header_form", []))) {
            // line 75
            echo "          <nav";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_top_attributes"] ?? null)), "html", null, true);
            echo ">
          ";
            // line 76
            if (($context["container_navbar"] ?? null)) {
                // line 77
                echo "          <div class=\"container\">
          ";
            }
            // line 79
            echo "              ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "secondary_menu", [])), "html", null, true);
            echo "
              ";
            // line 80
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "top_header", [])), "html", null, true);
            echo "
              ";
            // line 81
            if ($this->getAttribute(($context["page"] ?? null), "top_header_form", [])) {
                // line 82
                echo "                <div class=\"form-inline navbar-form ml-auto\">
                  ";
                // line 83
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "top_header_form", [])), "html", null, true);
                echo "
                </div>
              ";
            }
            // line 86
            echo "          ";
            if (($context["container_navbar"] ?? null)) {
                // line 87
                echo "          </div>
          ";
            }
            // line 89
            echo "          </nav>
        ";
        }
        // line 91
        echo "        <nav";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_attributes"] ?? null)), "html", null, true);
        echo ">
          ";
        // line 92
        if (($context["container_navbar"] ?? null)) {
            // line 93
            echo "          <div class=\"container\">
          ";
        }
        // line 95
        echo "            ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header", [])), "html", null, true);
        echo "
            ";
        // line 96
        if (($this->getAttribute(($context["page"] ?? null), "primary_menu", []) || $this->getAttribute(($context["page"] ?? null), "header_form", []))) {
            // line 97
            echo "              <button class=\"navbar-toggler navbar-toggler-right collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#CollapsingNavbar\" aria-controls=\"CollapsingNavbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"><span class=\"navbar-toggler-icon\"></span></button>
              <div class=\"collapse navbar-collapse justify-content-end\" id=\"CollapsingNavbar\">
                ";
            // line 99
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "primary_menu", [])), "html", null, true);
            echo "
                ";
            // line 100
            if ($this->getAttribute(($context["page"] ?? null), "header_form", [])) {
                // line 101
                echo "                  <div class=\"form-inline navbar-form justify-content-end\">
                    ";
                // line 102
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header_form", [])), "html", null, true);
                echo "
                  </div>
                ";
            }
            // line 105
            echo "\t          </div>
            ";
        }
        // line 107
        echo "            ";
        if (($context["sidebar_collapse"] ?? null)) {
            // line 108
            echo "              <button class=\"navbar-toggler navbar-toggler-left collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#CollapsingLeft\" aria-controls=\"CollapsingLeft\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"></button>
            ";
        }
        // line 110
        echo "          ";
        if (($context["container_navbar"] ?? null)) {
            // line 111
            echo "          </div>
          ";
        }
        // line 113
        echo "        </nav>
      ";
    }

    // line 124
    public function block_featured($context, array $blocks = [])
    {
        // line 125
        echo "        <div class=\"featured-top\">
          <aside class=\"featured-top__inner section ";
        // line 126
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
        echo " clearfix\" role=\"complementary\">
            ";
        // line 127
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "featured_top", [])), "html", null, true);
        echo "
          </aside>
        </div>
      ";
    }

    // line 133
    public function block_content($context, array $blocks = [])
    {
        // line 134
        echo "        <div id=\"main\" class=\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
        echo "\">
          ";
        // line 135
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "breadcrumb", [])), "html", null, true);
        echo "
          <div class=\"row row-offcanvas row-offcanvas-left clearfix\">
              <main";
        // line 137
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content_attributes"] ?? null)), "html", null, true);
        echo ">
                <section class=\"section\">
                  <a id=\"main-content\" tabindex=\"-1\"></a>
                  ";
        // line 140
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
        echo "
                </section>
              </main>
            ";
        // line 143
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])) {
            // line 144
            echo "              <div";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_first_attributes"] ?? null)), "html", null, true);
            echo ">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 146
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])), "html", null, true);
            echo "
                </aside>
              </div>
            ";
        }
        // line 150
        echo "            ";
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])) {
            // line 151
            echo "              <div";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_second_attributes"] ?? null)), "html", null, true);
            echo ">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 153
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])), "html", null, true);
            echo "
                </aside>
              </div>
            ";
        }
        // line 157
        echo "          </div>
        </div>
      ";
    }

    // line 171
    public function block_footer($context, array $blocks = [])
    {
        // line 172
        echo "        <div class=\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null)), "html", null, true);
        echo "\">
          ";
        // line 173
        if (((($this->getAttribute(($context["page"] ?? null), "footer_first", []) || $this->getAttribute(($context["page"] ?? null), "footer_second", [])) || $this->getAttribute(($context["page"] ?? null), "footer_third", [])) || $this->getAttribute(($context["page"] ?? null), "footer_fourth", []))) {
            // line 174
            echo "            <div class=\"site-footer__top clearfix\">
              ";
            // line 175
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_first", [])), "html", null, true);
            echo "
              ";
            // line 176
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_second", [])), "html", null, true);
            echo "
              ";
            // line 177
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_third", [])), "html", null, true);
            echo "
              ";
            // line 178
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_fourth", [])), "html", null, true);
            echo "
            </div>
          ";
        }
        // line 181
        echo "          ";
        if ($this->getAttribute(($context["page"] ?? null), "footer_fifth", [])) {
            // line 182
            echo "            <div class=\"site-footer__bottom\">
              ";
            // line 183
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_fifth", [])), "html", null, true);
            echo "
            </div>
          ";
        }
        // line 186
        echo "        </div>
      ";
    }

    public function getTemplateName()
    {
        return "@bootstrap_barrio/layout/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  349 => 186,  343 => 183,  340 => 182,  337 => 181,  331 => 178,  327 => 177,  323 => 176,  319 => 175,  316 => 174,  314 => 173,  309 => 172,  306 => 171,  300 => 157,  293 => 153,  287 => 151,  284 => 150,  277 => 146,  271 => 144,  269 => 143,  263 => 140,  257 => 137,  252 => 135,  247 => 134,  244 => 133,  236 => 127,  232 => 126,  229 => 125,  226 => 124,  221 => 113,  217 => 111,  214 => 110,  210 => 108,  207 => 107,  203 => 105,  197 => 102,  194 => 101,  192 => 100,  188 => 99,  184 => 97,  182 => 96,  177 => 95,  173 => 93,  171 => 92,  166 => 91,  162 => 89,  158 => 87,  155 => 86,  149 => 83,  146 => 82,  144 => 81,  140 => 80,  135 => 79,  131 => 77,  129 => 76,  124 => 75,  121 => 74,  118 => 73,  111 => 188,  109 => 171,  106 => 170,  99 => 166,  95 => 165,  91 => 164,  87 => 163,  84 => 162,  82 => 161,  79 => 160,  77 => 133,  74 => 132,  71 => 131,  68 => 124,  65 => 123,  58 => 119,  54 => 118,  51 => 117,  49 => 116,  46 => 115,  44 => 73,  40 => 72,  36 => 70,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@bootstrap_barrio/layout/page.html.twig", "/var/www/html/web/themes/contrib/bootstrap_barrio/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["block" => 73, "if" => 116];
        static $filters = ["t" => 72, "escape" => 118];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['block', 'if'],
                ['t', 'escape'],
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
