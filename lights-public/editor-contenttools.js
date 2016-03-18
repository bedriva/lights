window.addEventListener('load', function() {
    var editor;

    ContentTools.StylePalette.add([
        new ContentTools.Style('Author', 'author', ['p'])
    ]);

    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');

    editor.bind('save', function (regions) {
        var name, payload, xhr;

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

    editor.bind('start', function () {
      console.log(':)');
      this.hightlightRegions(true);
    });

    editor.bind('stop', function () {
      console.log(':)');
      this.hightlightRegions(true);
    });

});
