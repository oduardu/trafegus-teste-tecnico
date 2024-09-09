<?php

use Zend\View\Model\ViewModel;

if (!function_exists('viewModel')) {
    /**
     * Return instance of ViewModel
     *
     * @param string|null $template
     * @param array|null $variables
     *
     * @return ViewModel
     *
     */
    function viewModel($template = null, $variables = null)
    {
        $viewModel = new ViewModel();

        if (!is_null($template)) {
            $viewModel->setTemplate($template);
        }

        if (!is_null($variables)) {
            $viewModel->setVariables($variables);
        }

        return $viewModel;
    }
}