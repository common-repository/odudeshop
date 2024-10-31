(function() {
	tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
		editor.addButton( 'my_mce_button', {
			text: '',
			title : "ODudeShop",
			icon: true,
			image: url+'/odude.png',
			type: 'menubutton',
			
					menu: [
						{
							text: 'Manually List Products',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert List Product Shortcode',
									body: [
										{
											type: 'textbox',
											name: 'ptype',
											label: 'Prodcut Categories slug name',
											value: ''
										},
										
										{
											type: 'listbox',
											name: 'perrow',
											label: 'Display Per Row',
											'values': [
												{text: '1 Product', value: '1'},
												{text: '2 Products', value: '2'},
												{text: '3 Products', value: '3'},
												{text: '4 Products', value: '4'},
												{text: '5 Products', value: '5'}
											]
										},
										{
											type: 'textbox',
											name: 'perpage',
											label: 'Products Per Page',
											value: '30'
										},
										{
											type: 'listbox',
											name: 'orderby',
											label: 'Sort Prodcuts as',
											'values': [
												{text: 'Order by date', value: 'date'},
												{text: 'Order by title', value: 'title'},
												{text: 'Order by last modified date', value: 'modified'},
												{text: 'Ramdom Order', value: 'rand'},
												{text: 'Order by post id', value: 'ID'}
											]
										},
										{
											type: 'listbox',
											name: 'page',
											label: 'WP-Pagenavi Page Navigation',
											'values': [
												{text: 'Hide Navigation', value: 'off'},
												{text: 'Show Navigation', value: 'on'}
												
											]
										},
										{
											type: 'listbox',
											name: 'layout',
											label: 'Change Layout',
											'values': [
												{text: 'Classic', value: 'list'},
												{text: 'Hover', value: 'hover'}
												
											]
										}
									],
									onsubmit: function( e ) 
									{
										var return_text='[odudes-all-products perrow="' + e.data.perrow + '" perpage="' + e.data.perpage + '"  orderby="' + e.data.orderby + '" page="' + e.data.page + '" layout="' + e.data.layout + '" ptype="' + e.data.ptype + '"]';
										
										if (e.data.ptype == null || e.data.ptype == '')
										return_text='[odudes-all-products perrow="' + e.data.perrow + '" perpage="' + e.data.perpage + '" orderby="' + e.data.orderby + '" page="' + e.data.page + '" layout="' + e.data.layout + '" ]';
										
										editor.insertContent( return_text);
									}
								});
							}
						},
						{
							text: 'Dynamic List Products',
							onclick: function() {
								editor.windowManager.open( {
									title: 'For Page with slug-name as section',
									body: [
												
										{
											type: 'listbox',
											name: 'perrow',
											label: 'Display Per Row',
											'values': [
												{text: '1 Product', value: '1'},
												{text: '2 Products', value: '2'},
												{text: '3 Products', value: '3'},
												{text: '4 Products', value: '4'},
												{text: '5 Products', value: '5'}
											]
										},
										{
											type: 'textbox',
											name: 'perpage',
											label: 'Products Per Page',
											value: '30'
										},
										{
											type: 'listbox',
											name: 'orderby',
											label: 'Sort Prodcuts as',
											'values': [
												{text: 'Order by date', value: 'date'},
												{text: 'Order by title', value: 'title'},
												{text: 'Order by last modified date', value: 'modified'},
												{text: 'Ramdom Order', value: 'rand'},
												{text: 'Order by post id', value: 'ID'}
											]
										},
										{
											type: 'listbox',
											name: 'layout',
											label: 'Change Layout',
											'values': [
												{text: 'Classic', value: 'list'},
												{text: 'Hover', value: 'hover'}
												
											]
										}
										
									],
									onsubmit: function( e ) 
									{
										var return_text='[odudes-all-section perrow="' + e.data.perrow + '" perpage="' + e.data.perpage + '" orderby="' + e.data.orderby + '" layout="' + e.data.layout + '"]';
										
										
										editor.insertContent( return_text);
									}
								});
							}
						},
						{
							text: 'List Categories',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert List Categories Shortcode',
									body: [
										{
											type: 'textbox',
											name: 'ptype',
											label: 'Prodcut Categories slug name',
											value: ''
										},
										{
											type: 'listbox',
											name: 'show_count',
											label: 'Total no. of products.',
											'values': [
												{text: 'Hide Count', value: '0'},
												{text: 'Show Count', value: '1'}
												
											]
										},
										{
											type: 'listbox',
											name: 'show_empty',
											label: 'Show total products containted.',
											'values': [
												{text: 'Hide empty category', value: '0'},
												{text: 'Show empty category', value: '1'}
												
											]
										},
										{
											type: 'listbox',
											name: 'show_as',
											label: 'Display categories as.',
											'values': [
												{text: 'Drop Down List', value: 'drop'},
												{text: 'List as link', value: 'link'}
												
											]
										}
												
										
									],
									onsubmit: function( e ) 
									{
										var return_text='[odudes-all-catlist ptype="' + e.data.ptype + '" show_count="' + e.data.show_count + '" show_empty="' + e.data.show_empty + '" show_as="' + e.data.show_as + '"]';
										
										
										
										editor.insertContent( return_text);
									}
								});
							}
						}
					]
				
			
		});
	});
})();