<?php

namespace Core;

/**
 * View 
 */
class View {

  /**
   * Render a view file
   * 
   * @param string $view The view file
   * 
   * @return void
   */
  public static function render($view, $args = []) {

      extract($args, EXTR_SKIP);

      $file="../App/Views/$view"; 

      if (is_readable($file)) {
          require $file;
      } else {
          echo "$file not found";
      }
  }

  /**
   * Render using TWIG
   */
  public static function renderTemplate($template, $args = []){
      static $twig = null;

      if ($twig === null) {
          $loader = new \Twig_Loader_Filesystem('../App/Views');
          $twig = new \Twig_Environment($loader);
      }

      echo $twig->render($template, $args);
  }
}