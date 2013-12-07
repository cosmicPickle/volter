(function(){
    
    var ajaxLoaderClass = $(".volter-ajax-loader");
    var ajaxLoaders = [];
    
    function VolterAjaxLoader(object) {
        
        if(!object.data('ref'))
            return false;
        
        this.ref_object = object;
        this.ref = object.data('ref');
        this.data = object.data('cont');
        this.type = 'POST';
    }
    
    VolterAjaxLoader.prototype.exec = function(){
        
         $.ajax({
            url: this.ref,
            type: this.type,
            data: this.data,
            context: this.ref_object,
            success: function(data){
                $(this).html(data);
            }
         });
    }

    ajaxLoaderClass.each(function() {
        
       var index = ajaxLoaders.length;
       ajaxLoaders[index] = new VolterAjaxLoader($(this));
       ajaxLoaders[index].exec();
       
    });
})();