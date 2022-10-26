var LIGHTS = {
  texts: {
    saveErrorRequest:
      "Sorry, but there was some kind of error when your wonderful text tried to reach the saving mechanism. Try again when you want.",
    saveError:
      ":( We couldn't save your awesome text. Maybe you could try again soon?",
    saveSuccess: "Cool! Great text!",
    toogleModeShow: "View in editor mode",
    toogleModeHide: "View in visitor mode",
  },

  toggleElement: null,

  editorIds: _LIGHTS,
  editingState: null,

  notify: function (text) {
    alert(text);
  },

  urlServer: _LIGHTS.baseurl + "lights-admin/ajax/",

  pageData: {
    current_slug: _LIGHTS.slug,
  },

  request: function (type, url, data, success, fail, editor) {
    var request = new XMLHttpRequest();

    function onStateChange(ev) {
      if (ev.target.readyState == 4) {
        if (editor) {
          editor.busy(false);
        }
        if (ev.target.status == "200") {
          success(JSON.parse(ev.target.responseText));
        } else {
          fail();
        }
      }
    }

    request.addEventListener("readystatechange", onStateChange);
    request.open(type, url, true);
    request.send(data);
  },

  save: function (content, editor, redirect) {
    if (!redirect) {
      content.append("current_slug", this.pageData.current_slug);
    }

    this.request(
      "POST",
      this.urlServer + "save-content",
      content,
      function (data) {
        if (EDITOR === "contenttools") {
          new ContentTools.FlashUI("ok");
        }
        if (redirect) {
          window.location.href = _LIGHTS.baseurl + redirect;
          return;
        }
        if (data.redirect) {
          window.location.href = _LIGHTS.baseurl + data.redirect;
          return;
        }
      },
      function () {
        if (EDITOR === "contenttools") {
          new ContentTools.FlashUI("no");
        }
      },
      editor
    );
  },

  show: function () {
    var s1, s2, c1, c2;

    if (EDITOR === "contenttools") {
      // Embed scripts
      s1 = document.createElement("script");
      s1.type = "text/javascript";
      s1.src = _LIGHTS.baseurl + "public/contenttools/content-tools.min.js";

      s2 = document.createElement("script");
      s2.type = "text/javascript";
      s2.src = _LIGHTS.baseurl + "public/editor-contenttools.js";

      c1 = document.createElement("link");
      c1.rel = "stylesheet";
      c1.type = "text/css";
      c1.href = _LIGHTS.baseurl + "public/contenttools/content-tools.min.css";

      c2 = document.createElement("link");
      c2.rel = "stylesheet";
      c2.type = "text/css";
      c2.href = _LIGHTS.baseurl + "public/editor-contenttools.css";

      document.body.appendChild(s1);
      document.body.appendChild(s2);
      document.body.appendChild(c1);
      document.body.appendChild(c2);
    }

    if (EDITOR === "ckeditor") {
      // Embed scripts
      s1 = document.createElement("script");
      s1.type = "text/javascript";
      s1.onload = function () {
        CKEDITOR.disableAutoInline = true;
      };
      s1.src = _LIGHTS.baseurl + "public/ckeditor/ckeditor.js";

      c2 = document.createElement("link");
      c2.rel = "stylesheet";
      c2.type = "text/css";
      c2.href = _LIGHTS.baseurl + "public/editor-contenttools.css";

      document.body.appendChild(s1);
      document.body.appendChild(c2);
    }

    // New page
    var link = document.createElement("div");
    link.innerHTML = "New page";
    link.addEventListener("click", function () {
      var title = prompt("New page title");
      var slug = "";
      if (title) {
        slug = prompt("New page URL");
      }

      if (slug) {
        var editor = null;
        if (EDITOR === "contenttools") {
          editor = ContentTools.EditorApp.get();
        }

        var payload = new FormData();
        payload.append("page_title", "<p>" + title + "</p>");
        payload.append("slug", slug);
        LIGHTS.save(payload, editor, slug);
      }
    });

    link.className = "create-page-button";

    document.body.appendChild(link);

    // Logout
    var linkLogout = document.createElement("div");
    linkLogout.innerHTML = "Log out";
    linkLogout.addEventListener("click", function () {
      window.location.href = "/logout";
    });

    linkLogout.className = "logout-button";

    document.body.appendChild(linkLogout);

    // Cancel edit of current page
    var linkCancel = document.createElement("div");
    linkCancel.innerHTML = "Cancel";
    linkCancel.addEventListener("click", function () {
      if (EDITOR === "contenttools") {
        var editor = ContentTools.EditorApp.get();
        editor.stop(false);
      }

      if (EDITOR === "ckeditor") {
        LIGHTS.editorIds.forEach(function (id) {
          document.getElementById(id).setAttribute("contenteditable", "false");
          CKEDITOR.instances[id].destroy();
        });
      }

      linkEdit.innerHTML = "Edit";
      linkCancel.style = "display:none;";
      LIGHTS.editingState = null;
    });

    linkCancel.className = "cancel-page-button";
    linkCancel.style = "display:none;";

    document.body.appendChild(linkCancel);

    // Edit current page
    var linkEdit = document.createElement("div");
    linkEdit.innerHTML = "Edit";
    linkEdit.addEventListener("click", function () {
      if (EDITOR === "contenttools") {
        var editor = ContentTools.EditorApp.get();

        if (editor.getState() === "editing") {
          editor.stop(true);
        } else {
          editor.start();
        }
      }

      if (EDITOR === "ckeditor") {
        if (LIGHTS.editingState === "editing") {
          payload = new FormData();

          LIGHTS.editorIds.forEach(function (id) {
            payload.append(id, document.getElementById(id).innerHTML);
            CKEDITOR.instances[id].destroy();
            document
              .getElementById(id)
              .setAttribute("contenteditable", "false");
          });

          LIGHTS.save(payload, null);
        } else {
          LIGHTS.editorIds.forEach(function (id) {
            document.getElementById(id).setAttribute("contenteditable", "true");
            CKEDITOR.inline(id);
          });
        }
      }

      if (LIGHTS.editingState === "editing") {
        linkEdit.innerHTML = "Edit";
        linkCancel.style = "display:none;";
        LIGHTS.editingState = null;
      } else {
        linkEdit.innerHTML = "Save";
        linkCancel.style = "display:block;";
        LIGHTS.editingState = "editing";
      }
    });

    linkEdit.className = "edit-page-button";

    document.body.appendChild(linkEdit);
  },

  is_loggedin: false,

  check_loggedin: function () {
    this.request(
      "GET",
      this.urlServer + "check-loggedin",
      null,
      function (content) {
        LIGHTS.is_loggedin = !!content.ok;
        LIGHTS.update_loggedin_status();
      },
      function () {},
      null
    );
  },

  update_loggedin_status: function () {
    if (this.is_loggedin) {
      document.body.setAttribute("data-loggedin", "1");
    } else {
      document.body.setAttribute("data-loggedin", "0");
    }
  },
};

document.addEventListener("DOMContentLoaded", function () {
  LIGHTS.check_loggedin();
  LIGHTS.update_loggedin_status();
  LIGHTS.show();
});
