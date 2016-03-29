var LIGHTS = {
  texts: {
    saveErrorRequest: 'Sorry, but there was some kind of error when your wonderful text tried to reach the saving mechanism. Try again when you want.',
    saveError: ':( We couldn\'t save your awesome text. Maybe you could try again soon?',
    saveSuccess: 'Cool! Great text!',
    toogleModeShow: 'View in editor mode',
    toogleModeHide: 'View in visitor mode'
  },

  toggleElement: null,

  notify: function(text) {
    alert(text);
  },

  urlServer: 'lights-server/',

  pageData: {
    slug: _LIGHTS.slug
  },

  request: function(type, url, data, success, fail, editor) {
    var request = new XMLHttpRequest();

    function onStateChange(ev) {
      if (ev.target.readyState == 4) {
        if (editor) {
          editor.busy(false);
        }
        if (ev.target.status == '200') {
          success(JSON.parse(ev.target.responseText));
        } else {
          fail();
        }
      }
    }

    request.addEventListener('readystatechange', onStateChange);
    request.open(type, url, true);
    request.send(data);
  },

  save: function(content, editor, redirect) {
    if (!redirect) {
      content.append('slug', this.pageData.slug);
    }

    this.request('POST', this.urlServer + 'save-content.php', content, function() {
      new ContentTools.FlashUI('ok');
      if (redirect) {
        window.location.href = redirect;
      }
    }, function() {
      new ContentTools.FlashUI('no');
    }, editor);
  },

  show: function() {
    var s1 = document.createElement("script");
    s1.type = "text/javascript";
    s1.src = "lights-public/contenttools/content-tools.min.js";
    var s2 = document.createElement("script");
    s2.type = "text/javascript";
    s2.src = "lights-public/editor-contenttools.js";
    var c1 = document.createElement("link");
    c1.rel = "stylesheet";
    c1.type = "text/css";
    c1.href = "lights-public/contenttools/content-tools.min.css";
    var c2 = document.createElement("link");
    c2.rel = "stylesheet";
    c2.type = "text/css";
    c2.href = "lights-public/editor-contenttools.css";

    document.body.appendChild(s1);
    document.body.appendChild(s2);
    document.body.appendChild(c1);
    document.body.appendChild(c2);

    var link = document.createElement('div');
    link.innerHTML = 'New page';
    link.addEventListener("click", function() {
      var title = prompt('New page title');
      var slug = '';
      if (title) {
        slug = prompt('New page URL');
      }

      if (slug) {
        var editor = ContentTools.EditorApp.get();
        var payload = new FormData();
        payload.append('page_title', '<p>' + title + '</p>');
        payload.append('slug', slug);
        LIGHTS.save(payload, editor, slug);

      }
    });

    link.className = 'create-page-button';

    this.toggleElement = link;

    document.body.appendChild(link);

    var linkLogout = document.createElement('div');
    linkLogout.innerHTML = 'Log out';
    linkLogout.addEventListener("click", function() {
      window.location.href = 'logout';
    });

    linkLogout.className = 'logout-button';

    this.toggleElement = linkLogout;

    document.body.appendChild(linkLogout);
  },

  is_loggedin: false,

  check_loggedin: function() {
    this.request('GET', this.urlServer + 'check-loggedin.php', null, function(content) {
      LIGHTS.is_loggedin = !!content.ok;
      LIGHTS.update_loggedin_status();
    }, function() {}, null);
  },

  update_loggedin_status: function() {
    if (this.is_loggedin) {
      document.body.setAttribute('data-loggedin', '1');
    } else {
      document.body.setAttribute('data-loggedin', '0');
    }
  }
};

document.addEventListener("DOMContentLoaded", function() {
  LIGHTS.check_loggedin();
  LIGHTS.update_loggedin_status();
  LIGHTS.show();
});
