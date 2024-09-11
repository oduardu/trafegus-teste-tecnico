<?php

use Zend\View\Model\ViewModel;

if (!function_exists('viewModel')) {
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

if (!function_exists('debug')) {
    function debug($data)
    {
        echo "<small> " . debug_backtrace(0)[0]['file'] . ":" . debug_backtrace(0)[0]['line'] . "</small>";
        echo '<pre>';
        if (is_object($data)) {
            $data = (array)$data;
        }

        if (is_array($data)) {
            print_r($data);
        } else {
            var_dump($data);
        }

        echo '</pre>';
        exit;
    }
}