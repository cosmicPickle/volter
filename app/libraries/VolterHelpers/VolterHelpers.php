<?php namespace Volter\VolterHelpers;

class VolterHelpers {
    
    protected $ajaxLinksClass = 'volter-ajax-link';
    protected $ajaxLoaderClass = 'volter-ajax-loader';
    
    public function generateAjaxLink($route, $label, $fbUid = NULL, $referer = NULL, $data = array())
    {
        $html = "<a class='%s' href='%s' data-cont='%s' data-referer='%s'>%s</a>";
        
        $route = url($route);
        !$fbUid || $data['fb_uid'] = $fbUid;
        
        return sprintf($html, $this->ajaxLinksClass, $route, json_encode($data), $referer, $label);
    }
    
    public function generateAjaxLoader($route, $fbUid = NULL, $data = array())
    {
        $html = "<div class='%s' data-ref='%s' data-cont='%s'></div>";
        
        $route = url($route);
        !$fbUid || $data['fb_uid'] = $fbUid;
        
        return sprintf($html, $this->ajaxLoaderClass, $route, json_encode($data));
    }
}