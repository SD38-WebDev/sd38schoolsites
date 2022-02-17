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

/* themes/custom/rsd_sites_barrio/templates/block--system-branding-block.html.twig */
class __TwigTemplate_45e54ffa300f605a54eebebb077ce89c06d8933c36543d5d98a090beb1fc30b4 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 15
        $context["attributes"] = $this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => "site-branding"], "method");
        // line 16
        echo "  ";
        if (($context["site_name"] ?? null)) {
            // line 17
            echo "  <div class=\"row brand-row align-items-center\">
    ";
            // line 18
            if (($context["site_logo"] ?? null)) {
                // line 19
                echo "\t    <div class=\"col-sm-3 col-lg-2 logo d-none d-sm-block\"><a href=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("<front>"));
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
                echo "\" rel=\"home\"><img class=\"site-logo\" src=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_logo"] ?? null)), "html", null, true);
                echo "\"></a></div>
    ";
            }
            // line 21
            echo "    <div class=\"col\">
    \t<div class=\"welcome-txt\">Welcome to</div>
\t    <a href=\"";
            // line 23
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("<front>"));
            echo "\" title=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
            echo "\" rel=\"home\" class=\"site-name navbar-brand\">
\t      ";
            // line 24
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_name"] ?? null)), "html", null, true);
            echo "
\t    </a>
  ";
        }
        // line 27
        echo "  \t\t";
        if (($context["site_slogan"] ?? null)) {
            // line 28
            echo "\t    <div class=\"slogan\">
\t      ";
            // line 29
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_slogan"] ?? null)), "html", null, true);
            echo "
\t    </div>
\t\t";
        }
        // line 32
        echo "    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/rsd_sites_barrio/templates/block--system-branding-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 32,  74 => 29,  71 => 28,  68 => 27,  62 => 24,  56 => 23,  52 => 21,  42 => 19,  40 => 18,  37 => 17,  34 => 16,  32 => 15,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/rsd_sites_barrio/templates/block--system-branding-block.html.twig", "/var/www/html/web/themes/custom/rsd_sites_barrio/templates/block--system-branding-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 15, "if" => 16];
        static $filters = ["t" => 19, "escape" => 19];
        static $functions = ["path" => 19];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['t', 'escape'],
                ['path']
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
