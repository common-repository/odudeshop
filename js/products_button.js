(function() {
    tinymce.create("tinymce.plugins.odudeshop_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button     
            ed.addButton("green", {
                title : "ODudeShop List Products",
                cmd : "green_command",
                 image : url+'/odude.png',
				 
            });

            //button functionality.
            ed.addCommand("green_command", function() {
				
				
				
				
                //var selected_text = ed.selection.getContent();
                //var return_text = "<span style='color: green'>" + selected_text + "</span>";
				 var perrow=prompt("Number of Product per Row", "2");
				 
				 if (perrow == null || perrow == '')
					 var perrow=2;
				 
				 var perpage=prompt("Total Product per Page", "20");
				  if (perpage == null || perpage == '')
					 var perpage=20;
				 
				 var ptype=prompt("Prodcut Categories slug name", "");
				 
				 var return_text="[odudes-all-products perrow="+perrow+" perpage="+perpage+" ptype="+ptype+"]";
				 
				 if (ptype == null || ptype == '')
					return_text="[odudes-all-products perrow="+perrow+" perpage="+perpage+"]";
				
                ed.execCommand("mceInsertContent", 0, return_text);
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "Narayan Prusty",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("odudeshop_button_plugin", tinymce.plugins.odudeshop_button_plugin);
})();


