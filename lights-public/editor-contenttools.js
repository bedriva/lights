window.addEventListener('load', function() {
  var editor;

  ContentTools.StylePalette.add([
      new ContentTools.Style('Author', 'author', ['p'])
  ]);

  editor = ContentTools.EditorApp.get();
  editor.init('*[data-editable]', 'data-name');

  editor.addEventListener('saved', function (ev) {
      var name, payload, xhr;

      // Check that something changed
      var regions = ev.detail().regions;
      if (Object.keys(regions).length === 0) {
          return;
      }

      // Set the editor as busy while we save our changes
      this.busy(true);

      // Collect the contents of each region into a FormData instance
      payload = new FormData();
      for (name in regions) {
          if (regions.hasOwnProperty(name)) {
              payload.append(name, regions[name]);
          }
      }

      LIGHTS.save(payload, editor);
  });

  editor.addEventListener('start', function () {
    console.log(':)');
    //editor.highlightRegions(true);
  });

  editor.addEventListener('stop', function () {
    console.log(':)');
    //editor.highlightRegions(true);
  });

});
