<?php

namespace App\Twig\Extension ;

class TwigCoreExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            // 'render' => new \Twig_Function_Method($this, 'render', array('needs_environment' => true, 'is_safe' => array('html'))),
        );
    }

    public function render(\Twig_Environment $twig, $uri)
    {
        
    }

    public function getName()
    {
        return 'silica';
    }
}
