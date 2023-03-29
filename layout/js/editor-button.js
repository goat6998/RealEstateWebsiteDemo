(function() {
  tinymce.create( 'tinymce.plugins.example_shortcode_button', {
    init: function( ed, url ) {
      ed.addButton( 'titlebar', {
        title: 'titlebar shortcode',
        icon: 'code',
        cmd: 'titlebar_cmd'
      });

      ed.addCommand( 'titlebar_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '[titlebar]' + selected_text + '[/titlebar]';
        ed.execCommand( 'mceInsertContent', 0, return_text );
      });
    },
    createControl : function( n, cm ) {
      return null;
    },
  });
  tinymce.PluginManager.add( 'example_shortcode_button_plugin', tinymce.plugins.example_shortcode_button );
})();