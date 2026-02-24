<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* core/modules/language/templates/language-negotiation-configure-form.html.twig */
class __TwigTemplate_a0738d1a121e407145e8aa294f7edf3a extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["language_types"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language_type"]) {
            // line 25
            yield "  ";
            // line 26
            $context["language_classes"] = ["js-form-item", "form-item", "table-language-group", (("table-" . CoreExtension::getAttribute($this->env, $this->source,             // line 30
$context["language_type"], "type", [], "any", false, false, true, 30)) . "-wrapper")];
            // line 33
            yield "  <div";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["language_type"], "attributes", [], "any", false, false, true, 33), "addClass", [($context["language_classes"] ?? null)], "method", false, false, true, 33), "html", null, true);
            yield ">
    <h2>";
            // line 34
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language_type"], "title", [], "any", false, false, true, 34), "html", null, true);
            yield "</h2>
    <div class=\"description\">";
            // line 35
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language_type"], "description", [], "any", false, false, true, 35), "html", null, true);
            yield "</div>
    ";
            // line 36
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language_type"], "configurable", [], "any", false, false, true, 36), "html", null, true);
            yield "
    ";
            // line 37
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language_type"], "table", [], "any", false, false, true, 37), "html", null, true);
            yield "
    ";
            // line 38
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language_type"], "children", [], "any", false, false, true, 38), "html", null, true);
            yield "
  </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['language_type'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["children"] ?? null), "html", null, true);
        yield "
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["language_types", "children"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "core/modules/language/templates/language-negotiation-configure-form.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  83 => 41,  74 => 38,  70 => 37,  66 => 36,  62 => 35,  58 => 34,  53 => 33,  51 => 30,  50 => 26,  48 => 25,  44 => 24,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "core/modules/language/templates/language-negotiation-configure-form.html.twig", "/usr/local/var/www/drupal/web/core/modules/language/templates/language-negotiation-configure-form.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 24, "set" => 26];
        static $filters = ["escape" => 33];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set'],
                ['escape'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

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
