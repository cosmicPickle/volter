(function(){
    
    var ajaxLoaderClass = $(".volter-ajax-loader");
    var ajaxLinkClass = ".volter-ajax-link";
    var ajaxLoaders = [];
    var ajaxLinks = [];
    
    //The ajax execution function
    var exec = function(){
        
         $.ajax({
            url: this.ref,
            type: this.type,
            data: this.data,
            context: this.ref_object,
            success: function(data){
                $(this).html(data);
            }
         });
    };
    
    //The ajax autoloader class
    function VolterAjaxLoader(object) {
        
        if(!object.data('ref'))
            return false;
        
        this.ref_object = object;
        this.ref = object.data('ref');
        this.data = object.data('cont');
        this.type = 'POST';
        this.addReferer();
    }
    
    VolterAjaxLoader.prototype.addReferer = function(){
        var rand = (Math.floor(Math.random()*10000000)+1);
        this.ref_object.attr('id', 'referer-' + rand);
        this.data.ref_id = rand;
    };
    
    VolterAjaxLoader.prototype.exec = exec;
            
    ajaxLoaderClass.each(function() {
        
       var index = ajaxLoaders.length;
       ajaxLoaders[index] = new VolterAjaxLoader($(this));
       ajaxLoaders[index].exec();
       
    });
    
    //The ajax link loader class
    function VolterAjaxLink(object)
    {
        if(!object.data('referer'))
            return false;
        
        this.ref_object = $('#referer-' + object.data('referer'));
        this.ref = object.attr('href');
        
        this.data = object.data('cont');
        this.data.ref_id = object.data('referer');
        
        this.type = 'POST';
    }
    
    VolterAjaxLink.prototype.exec = exec;
    
    $(document).on('click', ajaxLinkClass, function(e){
        
        e.preventDefault();
        var index = ajaxLinks.length;
        ajaxLinks[index] = new VolterAjaxLink($(this));
        ajaxLinks[index].exec();
    })
    
})();