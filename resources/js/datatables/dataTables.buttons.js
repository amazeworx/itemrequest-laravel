/*! Buttons for DataTables 2.3.3
 * ©2016-2022 SpryMedia Ltd - datatables.net/license
 */
!(function (e) {
  "function" == typeof define && define.amd
    ? define(["jquery", "datatables.net"], function (t) {
        return e(t, window, document)
      })
    : "object" == typeof exports
    ? (module.exports = function (t, n) {
        return (
          (t = t || window),
          (n =
            n ||
            ("undefined" != typeof window
              ? require("jquery")
              : require("jquery")(t))).fn.dataTable ||
            require("datatables.net")(t, n),
          e(n, t, t.document)
        )
      })
    : e(jQuery, window, document)
})(function (v, m, y, x) {
  "use strict"
  var e = v.fn.dataTable,
    o = 0,
    C = 0,
    w = e.ext.buttons
  function _(t, n, e) {
    v.fn.animate
      ? t.stop().fadeIn(n, e)
      : (t.css("display", "block"), e && e.call(t))
  }
  function A(t, n, e) {
    v.fn.animate
      ? t.stop().fadeOut(n, e)
      : (t.css("display", "none"), e && e.call(t))
  }
  function k(n, t) {
    if (!(this instanceof k))
      return function (t) {
        return new k(t, n).container()
      }
    !0 === (t = void 0 === t ? {} : t) && (t = {}),
      Array.isArray(t) && (t = { buttons: t }),
      (this.c = v.extend(!0, {}, k.defaults, t)),
      t.buttons && (this.c.buttons = t.buttons),
      (this.s = {
        dt: new e.Api(n),
        buttons: [],
        listenKeys: "",
        namespace: "dtb" + o++,
      }),
      (this.dom = {
        container: v("<" + this.c.dom.container.tag + "/>").addClass(
          this.c.dom.container.className
        ),
      }),
      this._constructor()
  }
  v.extend(k.prototype, {
    action: function (t, n) {
      t = this._nodeToButton(t)
      return n === x ? t.conf.action : ((t.conf.action = n), this)
    },
    active: function (t, n) {
      var t = this._nodeToButton(t),
        e = this.c.dom.button.active,
        t = v(t.node)
      return n === x ? t.hasClass(e) : (t.toggleClass(e, n === x || n), this)
    },
    add: function (t, n, e) {
      var o = this.s.buttons
      if ("string" == typeof n) {
        for (
          var i = n.split("-"), s = this.s, r = 0, a = i.length - 1;
          r < a;
          r++
        )
          s = s.buttons[+i[r]]
        ;(o = s.buttons), (n = +i[i.length - 1])
      }
      return (
        this._expandButton(
          o,
          t,
          t !== x ? t.split : x,
          (t === x || t.split === x || 0 === t.split.length) && s !== x,
          !1,
          n
        ),
        (e !== x && !0 !== e) || this._draw(),
        this
      )
    },
    collectionRebuild: function (t, n) {
      var e = this._nodeToButton(t)
      if (n !== x) {
        for (var o = e.buttons.length - 1; 0 <= o; o--)
          this.remove(e.buttons[o].node)
        for (o = 0; o < n.length; o++) {
          var i = n[o]
          this._expandButton(
            e.buttons,
            i,
            i !== x && i.config !== x && i.config.split !== x,
            !0,
            i.parentConf !== x && i.parentConf.split !== x,
            o,
            i.parentConf
          )
        }
      }
      this._draw(e.collection, e.buttons)
    },
    container: function () {
      return this.dom.container
    },
    disable: function (t) {
      t = this._nodeToButton(t)
      return (
        v(t.node).addClass(this.c.dom.button.disabled).prop("disabled", !0),
        this
      )
    },
    destroy: function () {
      v("body").off("keyup." + this.s.namespace)
      for (var t = this.s.buttons.slice(), n = 0, e = t.length; n < e; n++)
        this.remove(t[n].node)
      this.dom.container.remove()
      var o = this.s.dt.settings()[0]
      for (n = 0, e = o.length; n < e; n++)
        if (o.inst === this) {
          o.splice(n, 1)
          break
        }
      return this
    },
    enable: function (t, n) {
      return !1 === n
        ? this.disable(t)
        : ((n = this._nodeToButton(t)),
          v(n.node)
            .removeClass(this.c.dom.button.disabled)
            .prop("disabled", !1),
          this)
    },
    index: function (t, n, e) {
      n || ((n = ""), (e = this.s.buttons))
      for (var o = 0, i = e.length; o < i; o++) {
        var s = e[o].buttons
        if (e[o].node === t) return n + o
        if (s && s.length) {
          s = this.index(t, o + "-", s)
          if (null !== s) return s
        }
      }
      return null
    },
    name: function () {
      return this.c.name
    },
    node: function (t) {
      return t ? ((t = this._nodeToButton(t)), v(t.node)) : this.dom.container
    },
    processing: function (t, n) {
      var e = this.s.dt,
        o = this._nodeToButton(t)
      return n === x
        ? v(o.node).hasClass("processing")
        : (v(o.node).toggleClass("processing", n),
          v(e.table().node()).triggerHandler("buttons-processing.dt", [
            n,
            e.button(t),
            e,
            v(t),
            o.conf,
          ]),
          this)
    },
    remove: function (t) {
      var n = this._nodeToButton(t),
        e = this._nodeToHost(t),
        o = this.s.dt
      if (n.buttons.length)
        for (var i = n.buttons.length - 1; 0 <= i; i--)
          this.remove(n.buttons[i].node)
      ;(n.conf.destroying = !0),
        n.conf.destroy && n.conf.destroy.call(o.button(t), o, v(t), n.conf),
        this._removeKey(n.conf),
        v(n.node).remove()
      o = v.inArray(n, e)
      return e.splice(o, 1), this
    },
    text: function (t, n) {
      function e(t) {
        return "function" == typeof t ? t(i, s, o.conf) : t
      }
      var o = this._nodeToButton(t),
        t = this.c.dom.collection.buttonLiner,
        t = (o.inCollection && t && t.tag ? t : this.c.dom.buttonLiner).tag,
        i = this.s.dt,
        s = v(o.node)
      return n === x
        ? e(o.conf.text)
        : ((o.conf.text = n),
          (t ? s.children(t).eq(0).filter(":not(.dt-down-arrow)") : s).html(
            e(n)
          ),
          this)
    },
    _constructor: function () {
      var e = this,
        t = this.s.dt,
        o = t.settings()[0],
        n = this.c.buttons
      o._buttons || (o._buttons = []),
        o._buttons.push({ inst: this, name: this.c.name })
      for (var i = 0, s = n.length; i < s; i++) this.add(n[i])
      t.on("destroy", function (t, n) {
        n === o && e.destroy()
      }),
        v("body").on("keyup." + this.s.namespace, function (t) {
          var n
          ;(y.activeElement && y.activeElement !== y.body) ||
            ((n = String.fromCharCode(t.keyCode).toLowerCase()),
            -1 !== e.s.listenKeys.toLowerCase().indexOf(n) && e._keypress(n, t))
        })
    },
    _addKey: function (t) {
      t.key && (this.s.listenKeys += (v.isPlainObject(t.key) ? t.key : t).key)
    },
    _draw: function (t, n) {
      t || ((t = this.dom.container), (n = this.s.buttons)),
        t.children().detach()
      for (var e = 0, o = n.length; e < o; e++)
        t.append(n[e].inserter),
          t.append(" "),
          n[e].buttons &&
            n[e].buttons.length &&
            this._draw(n[e].collection, n[e].buttons)
    },
    _expandButton: function (t, n, e, o, i, s, r) {
      var a = this.s.dt,
        l = !1,
        u = Array.isArray(n) ? n : [n]
      n === x && (u = Array.isArray(e) ? e : [e]),
        n !== x && n.split !== x && (l = !0)
      for (var c = 0, d = u.length; c < d; c++) {
        var f = this._resolveExtends(u[c])
        if (f)
          if (((l = !(f.config === x || !f.config.split)), Array.isArray(f)))
            this._expandButton(
              t,
              f,
              p !== x && p.conf !== x ? p.conf.split : x,
              o,
              r !== x && r.split !== x,
              s,
              r
            )
          else {
            var p = this._buildButton(
              f,
              o,
              f.split !== x || (f.config !== x && f.config.split !== x),
              i
            )
            if (p) {
              if (
                (s !== x && null !== s ? (t.splice(s, 0, p), s++) : t.push(p),
                p.conf.buttons || p.conf.split)
              ) {
                if (
                  ((p.collection = v(
                    "<" +
                      (l ? this.c.dom.splitCollection : this.c.dom.collection)
                        .tag +
                      "/>"
                  )),
                  (p.conf._collection = p.collection),
                  p.conf.split)
                )
                  for (var h = 0; h < p.conf.split.length; h++)
                    "object" == typeof p.conf.split[h] &&
                      ((p.conf.split[h].parent = r),
                      p.conf.split[h].collectionLayout === x &&
                        (p.conf.split[h].collectionLayout =
                          p.conf.collectionLayout),
                      p.conf.split[h].dropup === x &&
                        (p.conf.split[h].dropup = p.conf.dropup),
                      p.conf.split[h].fade === x) &&
                      (p.conf.split[h].fade = p.conf.fade)
                else
                  v(p.node).append(
                    v(
                      '<span class="dt-down-arrow">' +
                        this.c.dom.splitDropdown.text +
                        "</span>"
                    )
                  )
                this._expandButton(
                  p.buttons,
                  p.conf.buttons,
                  p.conf.split,
                  !l,
                  l,
                  s,
                  p.conf
                )
              }
              ;(p.conf.parent = r),
                f.init && f.init.call(a.button(p.node), a, v(p.node), f),
                0
            }
          }
      }
    },
    _buildButton: function (n, t, e, o) {
      function i(t) {
        return "function" == typeof t ? t(h, l, n) : t
      }
      var s,
        r,
        a,
        l,
        u = this.c.dom.button,
        c = this.c.dom.buttonLiner,
        d = this.c.dom.collection,
        f = (this.c.dom.split, this.c.dom.splitCollection),
        p = this.c.dom.splitDropdownButton,
        h = this.s.dt
      if (n.spacer)
        return (
          (r = v("<span></span>")
            .addClass("dt-button-spacer " + n.style + " " + u.spacerClass)
            .html(i(n.text))),
          {
            conf: n,
            node: r,
            inserter: r,
            buttons: [],
            inCollection: t,
            isSplit: e,
            inSplit: o,
            collection: null,
          }
        )
      if (
        (!e && o && f ? (u = p) : !e && t && d.button && (u = d.button),
        !e && o && f.buttonLiner
          ? (c = f.buttonLiner)
          : !e && t && d.buttonLiner && (c = d.buttonLiner),
        n.available && !n.available(h, n) && !n.hasOwnProperty("html"))
      )
        return !1
      n.hasOwnProperty("html")
        ? (l = v(n.html))
        : ((s = function (t, n, e, o) {
            o.action.call(n.button(e), t, n, e, o),
              v(n.table().node()).triggerHandler("buttons-action.dt", [
                n.button(e),
                n,
                e,
                o,
              ])
          }),
          (r = n.tag || u.tag),
          (a = n.clickBlurs === x || n.clickBlurs),
          (l = v("<" + r + "/>")
            .addClass(u.className)
            .addClass(o ? this.c.dom.splitDropdownButton.className : "")
            .attr("tabindex", this.s.dt.settings()[0].iTabIndex)
            .attr("aria-controls", this.s.dt.table().node().id)
            .on("click.dtb", function (t) {
              t.preventDefault(),
                !l.hasClass(u.disabled) && n.action && s(t, h, l, n),
                a && l.trigger("blur")
            })
            .on("keypress.dtb", function (t) {
              13 === t.keyCode &&
                (t.preventDefault(), !l.hasClass(u.disabled)) &&
                n.action &&
                s(t, h, l, n)
            })),
          "a" === r.toLowerCase() && l.attr("href", "#"),
          "button" === r.toLowerCase() && l.attr("type", "button"),
          c.tag
            ? ((p = v("<" + c.tag + "/>")
                .html(i(n.text))
                .addClass(c.className)),
              "a" === c.tag.toLowerCase() && p.attr("href", "#"),
              l.append(p))
            : l.html(i(n.text)),
          !1 === n.enabled && l.addClass(u.disabled),
          n.className && l.addClass(n.className),
          n.titleAttr && l.attr("title", i(n.titleAttr)),
          n.attr && l.attr(n.attr),
          n.namespace || (n.namespace = ".dt-button-" + C++),
          n.config !== x && n.config.split && (n.split = n.config.split))
      var b,
        g,
        m,
        y,
        f = this.c.dom.buttonContainer,
        d =
          f && f.tag
            ? v("<" + f.tag + "/>")
                .addClass(f.className)
                .append(l)
            : l
      return (
        this._addKey(n),
        this.c.buttonCreated && (d = this.c.buttonCreated(n, d)),
        e &&
          ((b = v("<div/>").addClass(this.c.dom.splitWrapper.className)).append(
            l
          ),
          (g = v.extend(n, {
            text: this.c.dom.splitDropdown.text,
            className: this.c.dom.splitDropdown.className,
            closeButton: !1,
            attr: { "aria-haspopup": "dialog", "aria-expanded": !1 },
            align: this.c.dom.splitDropdown.align,
            splitAlignClass: this.c.dom.splitDropdown.splitAlignClass,
          })),
          this._addKey(g),
          (m = function (t, n, e, o) {
            w.split.action.call(n.button(b), t, n, e, o),
              v(n.table().node()).triggerHandler("buttons-action.dt", [
                n.button(e),
                n,
                e,
                o,
              ]),
              e.attr("aria-expanded", !0)
          }),
          (y = v(
            '<button class="' +
              this.c.dom.splitDropdown.className +
              ' dt-button"><span class="dt-btn-split-drop-arrow">' +
              this.c.dom.splitDropdown.text +
              "</span></button>"
          )
            .on("click.dtb", function (t) {
              t.preventDefault(),
                t.stopPropagation(),
                y.hasClass(u.disabled) || m(t, h, y, g),
                a && y.trigger("blur")
            })
            .on("keypress.dtb", function (t) {
              13 === t.keyCode &&
                (t.preventDefault(), y.hasClass(u.disabled) || m(t, h, y, g))
            })),
          0 === n.split.length && y.addClass("dtb-hide-drop"),
          b.append(y).attr(g.attr)),
        {
          conf: n,
          node: (e ? b : l).get(0),
          inserter: e ? b : d,
          buttons: [],
          inCollection: t,
          isSplit: e,
          inSplit: o,
          collection: null,
        }
      )
    },
    _nodeToButton: function (t, n) {
      for (var e = 0, o = (n = n || this.s.buttons).length; e < o; e++) {
        if (n[e].node === t) return n[e]
        if (n[e].buttons.length) {
          var i = this._nodeToButton(t, n[e].buttons)
          if (i) return i
        }
      }
    },
    _nodeToHost: function (t, n) {
      for (var e = 0, o = (n = n || this.s.buttons).length; e < o; e++) {
        if (n[e].node === t) return n
        if (n[e].buttons.length) {
          var i = this._nodeToHost(t, n[e].buttons)
          if (i) return i
        }
      }
    },
    _keypress: function (s, r) {
      var a
      r._buttonsHandled ||
        (a = function (t) {
          for (var n, e, o = 0, i = t.length; o < i; o++)
            (n = t[o].conf),
              (e = t[o].node),
              !n.key ||
                (n.key !== s &&
                  (!v.isPlainObject(n.key) ||
                    n.key.key !== s ||
                    (n.key.shiftKey && !r.shiftKey) ||
                    (n.key.altKey && !r.altKey) ||
                    (n.key.ctrlKey && !r.ctrlKey) ||
                    (n.key.metaKey && !r.metaKey))) ||
                ((r._buttonsHandled = !0), v(e).click()),
              t[o].buttons.length && a(t[o].buttons)
        })(this.s.buttons)
    },
    _removeKey: function (t) {
      var n
      t.key &&
        ((t = (v.isPlainObject(t.key) ? t.key : t).key),
        (n = this.s.listenKeys.split("")),
        (t = v.inArray(t, n)),
        n.splice(t, 1),
        (this.s.listenKeys = n.join("")))
    },
    _resolveExtends: function (e) {
      function t(t) {
        for (var n = 0; !v.isPlainObject(t) && !Array.isArray(t); ) {
          if (t === x) return
          if ("function" == typeof t) {
            if (!(t = t.call(i, s, e))) return !1
          } else if ("string" == typeof t) {
            if (!w[t]) return { html: t }
            t = w[t]
          }
          if (30 < ++n) throw "Buttons: Too many iterations"
        }
        return Array.isArray(t) ? t : v.extend({}, t)
      }
      var n,
        o,
        i = this,
        s = this.s.dt
      for (e = t(e); e && e.extend; ) {
        if (!w[e.extend]) throw "Cannot extend unknown button type: " + e.extend
        var r = t(w[e.extend])
        if (Array.isArray(r)) return r
        if (!r) return !1
        var a = r.className,
          l =
            (e.config !== x &&
              r.config !== x &&
              (e.config = v.extend({}, r.config, e.config)),
            (e = v.extend({}, r, e)),
            a && e.className !== a && (e.className = a + " " + e.className),
            e.postfixButtons)
        if (l) {
          for (e.buttons || (e.buttons = []), n = 0, o = l.length; n < o; n++)
            e.buttons.push(l[n])
          e.postfixButtons = null
        }
        var u = e.prefixButtons
        if (u) {
          for (e.buttons || (e.buttons = []), n = 0, o = u.length; n < o; n++)
            e.buttons.splice(n, 0, u[n])
          e.prefixButtons = null
        }
        e.extend = r.extend
      }
      return e
    },
    _popover: function (o, t, n, e) {
      function i() {
        ;(h = !0),
          A(v(".dt-button-collection"), b.fade, function () {
            v(this).detach()
          }),
          v(
            f.buttons('[aria-haspopup="dialog"][aria-expanded="true"]').nodes()
          ).attr("aria-expanded", "false"),
          v("div.dt-button-background").off("click.dtb-collection"),
          k.background(!1, b.backgroundClassName, b.fade, g),
          v(m).off("resize.resize.dtb-collection"),
          v("body").off(".dtb-collection"),
          f.off("buttons-action.b-internal"),
          f.off("destroy")
      }
      var s,
        r,
        a,
        l,
        u,
        c,
        d,
        f = t,
        p = this.c,
        h = !1,
        b = v.extend(
          {
            align: "button-left",
            autoClose: !1,
            background: !0,
            backgroundClassName: "dt-button-background",
            closeButton: !0,
            contentClassName: p.dom.collection.className,
            collectionLayout: "",
            collectionTitle: "",
            dropup: !1,
            fade: 400,
            popoverTitle: "",
            rightAlignClassName: "dt-button-right",
            tag: p.dom.collection.tag,
          },
          n
        ),
        g = t.node()
      !1 === o
        ? i()
        : ((p = v(
            f.buttons('[aria-haspopup="dialog"][aria-expanded="true"]').nodes()
          )).length &&
            (g.closest("div.dt-button-collection").length && (g = p.eq(0)),
            i()),
          (n = v(".dt-button", o).length),
          (p = ""),
          3 === n
            ? (p = "dtb-b3")
            : 2 === n
            ? (p = "dtb-b2")
            : 1 === n && (p = "dtb-b1"),
          (s = v("<div/>")
            .addClass("dt-button-collection")
            .addClass(b.collectionLayout)
            .addClass(b.splitAlignClass)
            .addClass(p)
            .css("display", "none")
            .attr({ "aria-modal": !0, role: "dialog" })),
          (o = v(o)
            .addClass(b.contentClassName)
            .attr("role", "menu")
            .appendTo(s)),
          g.attr("aria-expanded", "true"),
          g.parents("body")[0] !== y.body && (g = y.body.lastChild),
          b.popoverTitle
            ? s.prepend(
                '<div class="dt-button-collection-title">' +
                  b.popoverTitle +
                  "</div>"
              )
            : b.collectionTitle &&
              s.prepend(
                '<div class="dt-button-collection-title">' +
                  b.collectionTitle +
                  "</div>"
              ),
          b.closeButton &&
            s
              .prepend('<div class="dtb-popover-close">x</div>')
              .addClass("dtb-collection-closeable"),
          _(s.insertAfter(g), b.fade),
          (n = v(t.table().container())),
          (d = s.css("position")),
          ("container" !== b.span && "dt-container" !== b.align) ||
            ((g = g.parent()), s.css("width", n.width())),
          "absolute" === d
            ? ((p = v(g[0].offsetParent)),
              (t = g.position()),
              (n = g.offset()),
              (r = p.offset()),
              (a = p.position()),
              (l = m.getComputedStyle(p[0])),
              (r.height = p.outerHeight()),
              (r.width = p.width() + parseFloat(l.paddingLeft)),
              (r.right = r.left + r.width),
              (r.bottom = r.top + r.height),
              (p = t.top + g.outerHeight()),
              (u = t.left),
              s.css({ top: p, left: u }),
              (l = m.getComputedStyle(s[0])),
              ((c = s.offset()).height = s.outerHeight()),
              (c.width = s.outerWidth()),
              (c.right = c.left + c.width),
              (c.bottom = c.top + c.height),
              (c.marginTop = parseFloat(l.marginTop)),
              (c.marginBottom = parseFloat(l.marginBottom)),
              b.dropup && (p = t.top - c.height - c.marginTop - c.marginBottom),
              ("button-right" !== b.align &&
                !s.hasClass(b.rightAlignClassName)) ||
                (u = t.left - c.width + g.outerWidth()),
              ("dt-container" !== b.align && "container" !== b.align) ||
                ((u = u < t.left ? -t.left : u) + c.width > r.width &&
                  (u = r.width - c.width)),
              a.left + u + c.width > v(m).width() &&
                (u = v(m).width() - c.width - a.left),
              n.left + u < 0 && (u = -n.left),
              a.top + p + c.height > v(m).height() + v(m).scrollTop() &&
                (p = t.top - c.height - c.marginTop - c.marginBottom),
              a.top + p < v(m).scrollTop() && (p = t.top + g.outerHeight()),
              s.css({ top: p, left: u }))
            : ((d = function () {
                var t = v(m).height() / 2,
                  n = s.height() / 2
                s.css("marginTop", -1 * (n = t < n ? t : n))
              })(),
              v(m).on("resize.dtb-collection", function () {
                d()
              })),
          b.background &&
            k.background(
              !0,
              b.backgroundClassName,
              b.fade,
              b.backgroundHost || g
            ),
          v("div.dt-button-background").on(
            "click.dtb-collection",
            function () {}
          ),
          b.autoClose &&
            setTimeout(function () {
              f.on("buttons-action.b-internal", function (t, n, e, o) {
                o[0] !== g[0] && i()
              })
            }, 0),
          v(s).trigger("buttons-popover.dt"),
          f.on("destroy", i),
          setTimeout(function () {
            ;(h = !1),
              v("body")
                .on("click.dtb-collection", function (t) {
                  var n, e
                  !h &&
                    ((n = v.fn.addBack ? "addBack" : "andSelf"),
                    (e = v(t.target).parent()[0]),
                    (!v(t.target).parents()[n]().filter(o).length &&
                      !v(e).hasClass("dt-buttons")) ||
                      v(t.target).hasClass("dt-button-background")) &&
                    i()
                })
                .on("keyup.dtb-collection", function (t) {
                  27 === t.keyCode && i()
                })
                .on("keydown.dtb-collection", function (t) {
                  var n = v("a, button", o),
                    e = y.activeElement
                  9 === t.keyCode &&
                    (-1 === n.index(e)
                      ? (n.first().focus(), t.preventDefault())
                      : t.shiftKey
                      ? e === n[0] && (n.last().focus(), t.preventDefault())
                      : e === n.last()[0] &&
                        (n.first().focus(), t.preventDefault()))
                })
          }, 0))
    },
  }),
    (k.background = function (t, n, e, o) {
      e === x && (e = 400),
        (o = o || y.body),
        t
          ? _(v("<div/>").addClass(n).css("display", "none").insertAfter(o), e)
          : A(v("div." + n), e, function () {
              v(this).removeClass(n).remove()
            })
    }),
    (k.instanceSelector = function (t, i) {
      var s, r, a
      return t === x || null === t
        ? v.map(i, function (t) {
            return t.inst
          })
        : ((s = []),
          (r = v.map(i, function (t) {
            return t.name
          })),
          (a = function (t) {
            var n
            if (Array.isArray(t))
              for (var e = 0, o = t.length; e < o; e++) a(t[e])
            else
              "string" == typeof t
                ? -1 !== t.indexOf(",")
                  ? a(t.split(","))
                  : -1 !== (n = v.inArray(t.trim(), r)) && s.push(i[n].inst)
                : "number" == typeof t
                ? s.push(i[t].inst)
                : "object" == typeof t && s.push(t)
          })(t),
          s)
    }),
    (k.buttonSelector = function (t, n) {
      for (
        var u = [],
          c = function (t, n, e) {
            for (var o, i, s = 0, r = n.length; s < r; s++)
              (o = n[s]) &&
                (t.push({
                  node: o.node,
                  name: o.conf.name,
                  idx: (i = e !== x ? e + s : s + ""),
                }),
                o.buttons) &&
                c(t, o.buttons, i + "-")
          },
          d = function (t, n) {
            var e = [],
              o =
                (c(e, n.s.buttons),
                v.map(e, function (t) {
                  return t.node
                }))
            if (Array.isArray(t) || t instanceof v)
              for (s = 0, r = t.length; s < r; s++) d(t[s], n)
            else if (null === t || t === x || "*" === t)
              for (s = 0, r = e.length; s < r; s++)
                u.push({ inst: n, node: e[s].node })
            else if ("number" == typeof t)
              n.s.buttons[t] && u.push({ inst: n, node: n.s.buttons[t].node })
            else if ("string" == typeof t)
              if (-1 !== t.indexOf(","))
                for (var i = t.split(","), s = 0, r = i.length; s < r; s++)
                  d(i[s].trim(), n)
              else if (t.match(/^\d+(\-\d+)*$/)) {
                var a = v.map(e, function (t) {
                  return t.idx
                })
                u.push({ inst: n, node: e[v.inArray(t, a)].node })
              } else if (-1 !== t.indexOf(":name")) {
                var l = t.replace(":name", "")
                for (s = 0, r = e.length; s < r; s++)
                  e[s].name === l && u.push({ inst: n, node: e[s].node })
              } else
                v(o)
                  .filter(t)
                  .each(function () {
                    u.push({ inst: n, node: this })
                  })
            else
              "object" == typeof t &&
                t.nodeName &&
                -1 !== (a = v.inArray(t, o)) &&
                u.push({ inst: n, node: o[a] })
          },
          e = 0,
          o = t.length;
        e < o;
        e++
      ) {
        var i = t[e]
        d(n, i)
      }
      return u
    }),
    (k.stripData = function (t, n) {
      return (
        "string" == typeof t &&
          ((t = (t = t.replace(
            /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
            ""
          )).replace(/<!\-\-.*?\-\->/g, "")),
          (n && !n.stripHtml) || (t = t.replace(/<[^>]*>/g, "")),
          (n && !n.trim) || (t = t.replace(/^\s+|\s+$/g, "")),
          (n && !n.stripNewlines) || (t = t.replace(/\n/g, " ")),
          !n || n.decodeEntities) &&
          ((l.innerHTML = t), (t = l.value)),
        t
      )
    }),
    (k.defaults = {
      buttons: ["copy", "excel", "csv", "pdf", "print"],
      name: "main",
      tabIndex: 0,
      dom: {
        container: { tag: "div", className: "dt-buttons" },
        collection: { tag: "div", className: "" },
        button: {
          tag: "button",
          className: "dt-button",
          active: "active",
          disabled: "disabled",
          spacerClass: "",
        },
        buttonLiner: { tag: "span", className: "" },
        split: { tag: "div", className: "dt-button-split" },
        splitWrapper: { tag: "div", className: "dt-btn-split-wrapper" },
        splitDropdown: {
          tag: "button",
          text: "&#x25BC;",
          className: "dt-btn-split-drop",
          align: "split-right",
          splitAlignClass: "dt-button-split-left",
        },
        splitDropdownButton: {
          tag: "button",
          className: "dt-btn-split-drop-button dt-button",
        },
        splitCollection: {
          tag: "div",
          className: "dt-button-split-collection",
        },
      },
    }),
    v.extend(w, {
      collection: {
        text: function (t) {
          return t.i18n("buttons.collection", "Collection")
        },
        className: "buttons-collection",
        closeButton: !(k.version = "2.3.3"),
        init: function (t, n, e) {
          n.attr("aria-expanded", !1)
        },
        action: function (t, n, e, o) {
          o._collection.parents("body").length
            ? this.popover(!1, o)
            : this.popover(o._collection, o),
            "keypress" === t.type && v("a, button", o._collection).eq(0).focus()
        },
        attr: { "aria-haspopup": "dialog" },
      },
      split: {
        text: function (t) {
          return t.i18n("buttons.split", "Split")
        },
        className: "buttons-split",
        closeButton: !1,
        init: function (t, n, e) {
          return n.attr("aria-expanded", !1)
        },
        action: function (t, n, e, o) {
          this.popover(o._collection, o)
        },
        attr: { "aria-haspopup": "dialog" },
      },
      copy: function (t, n) {
        if (w.copyHtml5) return "copyHtml5"
      },
      csv: function (t, n) {
        if (w.csvHtml5 && w.csvHtml5.available(t, n)) return "csvHtml5"
      },
      excel: function (t, n) {
        if (w.excelHtml5 && w.excelHtml5.available(t, n)) return "excelHtml5"
      },
      pdf: function (t, n) {
        if (w.pdfHtml5 && w.pdfHtml5.available(t, n)) return "pdfHtml5"
      },
      pageLength: function (t) {
        var n = t.settings()[0].aLengthMenu,
          e = [],
          o = []
        if (Array.isArray(n[0])) (e = n[0]), (o = n[1])
        else
          for (var i = 0; i < n.length; i++) {
            var s = n[i]
            v.isPlainObject(s)
              ? (e.push(s.value), o.push(s.label))
              : (e.push(s), o.push(s))
          }
        return {
          extend: "collection",
          text: function (t) {
            return t.i18n(
              "buttons.pageLength",
              { "-1": "Show all rows", _: "Show %d rows" },
              t.page.len()
            )
          },
          className: "buttons-page-length",
          autoClose: !0,
          buttons: v.map(e, function (s, t) {
            return {
              text: o[t],
              className: "button-page-length",
              action: function (t, n) {
                n.page.len(s).draw()
              },
              init: function (t, n, e) {
                function o() {
                  i.active(t.page.len() === s)
                }
                var i = this
                t.on("length.dt" + e.namespace, o), o()
              },
              destroy: function (t, n, e) {
                t.off("length.dt" + e.namespace)
              },
            }
          }),
          init: function (t, n, e) {
            var o = this
            t.on("length.dt" + e.namespace, function () {
              o.text(e.text)
            })
          },
          destroy: function (t, n, e) {
            t.off("length.dt" + e.namespace)
          },
        }
      },
      spacer: {
        style: "empty",
        spacer: !0,
        text: function (t) {
          return t.i18n("buttons.spacer", "")
        },
      },
    }),
    e.Api.register("buttons()", function (n, e) {
      e === x && ((e = n), (n = x)), (this.selector.buttonGroup = n)
      var t = this.iterator(
        !0,
        "table",
        function (t) {
          if (t._buttons)
            return k.buttonSelector(k.instanceSelector(n, t._buttons), e)
        },
        !0
      )
      return (t._groupSelector = n), t
    }),
    e.Api.register("button()", function (t, n) {
      t = this.buttons(t, n)
      return 1 < t.length && t.splice(1, t.length), t
    }),
    e.Api.registerPlural(
      "buttons().active()",
      "button().active()",
      function (n) {
        return n === x
          ? this.map(function (t) {
              return t.inst.active(t.node)
            })
          : this.each(function (t) {
              t.inst.active(t.node, n)
            })
      }
    ),
    e.Api.registerPlural(
      "buttons().action()",
      "button().action()",
      function (n) {
        return n === x
          ? this.map(function (t) {
              return t.inst.action(t.node)
            })
          : this.each(function (t) {
              t.inst.action(t.node, n)
            })
      }
    ),
    e.Api.registerPlural(
      "buttons().collectionRebuild()",
      "button().collectionRebuild()",
      function (e) {
        return this.each(function (t) {
          for (var n = 0; n < e.length; n++)
            "object" == typeof e[n] && (e[n].parentConf = t)
          t.inst.collectionRebuild(t.node, e)
        })
      }
    ),
    e.Api.register(["buttons().enable()", "button().enable()"], function (n) {
      return this.each(function (t) {
        t.inst.enable(t.node, n)
      })
    }),
    e.Api.register(["buttons().disable()", "button().disable()"], function () {
      return this.each(function (t) {
        t.inst.disable(t.node)
      })
    }),
    e.Api.register("button().index()", function () {
      var n = null
      return (
        this.each(function (t) {
          t = t.inst.index(t.node)
          null !== t && (n = t)
        }),
        n
      )
    }),
    e.Api.registerPlural("buttons().nodes()", "button().node()", function () {
      var n = v()
      return (
        v(
          this.each(function (t) {
            n = n.add(t.inst.node(t.node))
          })
        ),
        n
      )
    }),
    e.Api.registerPlural(
      "buttons().processing()",
      "button().processing()",
      function (n) {
        return n === x
          ? this.map(function (t) {
              return t.inst.processing(t.node)
            })
          : this.each(function (t) {
              t.inst.processing(t.node, n)
            })
      }
    ),
    e.Api.registerPlural("buttons().text()", "button().text()", function (n) {
      return n === x
        ? this.map(function (t) {
            return t.inst.text(t.node)
          })
        : this.each(function (t) {
            t.inst.text(t.node, n)
          })
    }),
    e.Api.registerPlural(
      "buttons().trigger()",
      "button().trigger()",
      function () {
        return this.each(function (t) {
          t.inst.node(t.node).trigger("click")
        })
      }
    ),
    e.Api.register("button().popover()", function (n, e) {
      return this.map(function (t) {
        return t.inst._popover(n, this.button(this[0].node), e)
      })
    }),
    e.Api.register("buttons().containers()", function () {
      var i = v(),
        s = this._groupSelector
      return (
        this.iterator(!0, "table", function (t) {
          if (t._buttons)
            for (
              var n = k.instanceSelector(s, t._buttons), e = 0, o = n.length;
              e < o;
              e++
            )
              i = i.add(n[e].container())
        }),
        i
      )
    }),
    e.Api.register("buttons().container()", function () {
      return this.containers().eq(0)
    }),
    e.Api.register("button().add()", function (t, n, e) {
      var o = this.context
      return (
        o.length &&
          (o = k.instanceSelector(this._groupSelector, o[0]._buttons)).length &&
          o[0].add(n, t, e),
        this.button(this._groupSelector, t)
      )
    }),
    e.Api.register("buttons().destroy()", function () {
      return (
        this.pluck("inst")
          .unique()
          .each(function (t) {
            t.destroy()
          }),
        this
      )
    }),
    e.Api.registerPlural(
      "buttons().remove()",
      "buttons().remove()",
      function () {
        return (
          this.each(function (t) {
            t.inst.remove(t.node)
          }),
          this
        )
      }
    ),
    e.Api.register("buttons.info()", function (t, n, e) {
      var o = this
      return (
        !1 === t
          ? (this.off("destroy.btn-info"),
            A(v("#datatables_buttons_info"), 400, function () {
              v(this).remove()
            }),
            clearTimeout(i),
            (i = null))
          : (i && clearTimeout(i),
            v("#datatables_buttons_info").length &&
              v("#datatables_buttons_info").remove(),
            (t = t ? "<h2>" + t + "</h2>" : ""),
            _(
              v('<div id="datatables_buttons_info" class="dt-button-info"/>')
                .html(t)
                .append(
                  v("<div/>")["string" == typeof n ? "html" : "append"](n)
                )
                .css("display", "none")
                .appendTo("body")
            ),
            e !== x &&
              0 !== e &&
              (i = setTimeout(function () {
                o.buttons.info(!1)
              }, e)),
            this.on("destroy.btn-info", function () {
              o.buttons.info(!1)
            })),
        this
      )
    }),
    e.Api.register("buttons.exportData()", function (t) {
      if (this.context.length) return u(new e.Api(this.context[0]), t)
    }),
    e.Api.register("buttons.exportInfo()", function (t) {
      return {
        filename: n((t = t || {})),
        title: r(t),
        messageTop: a(this, t.message || t.messageTop, "top"),
        messageBottom: a(this, t.messageBottom, "bottom"),
      }
    })
  var i,
    n = function (t) {
      var n
      return (n =
        "function" ==
        typeof (n =
          "*" === t.filename &&
          "*" !== t.title &&
          t.title !== x &&
          null !== t.title &&
          "" !== t.title
            ? t.title
            : t.filename)
          ? n()
          : n) === x || null === n
        ? null
        : (n = (n =
            -1 !== n.indexOf("*")
              ? n.replace("*", v("head > title").text()).trim()
              : n).replace(/[^a-zA-Z0-9_\u00A1-\uFFFF\.,\-_ !\(\)]/g, "")) +
            (s(t.extension) || "")
    },
    s = function (t) {
      return null === t || t === x ? null : "function" == typeof t ? t() : t
    },
    r = function (t) {
      t = s(t.title)
      return null === t
        ? null
        : -1 !== t.indexOf("*")
        ? t.replace("*", v("head > title").text() || "Exported data")
        : t
    },
    a = function (t, n, e) {
      n = s(n)
      return null === n
        ? null
        : ((t = v("caption", t.table().container()).eq(0)),
          "*" === n
            ? t.css("caption-side") !== e
              ? null
              : t.length
              ? t.text()
              : ""
            : n)
    },
    l = v("<textarea/>")[0],
    u = function (e, t) {
      for (
        var o = v.extend(
            !0,
            {},
            {
              rows: null,
              columns: "",
              modifier: { search: "applied", order: "applied" },
              orthogonal: "display",
              stripHtml: !0,
              stripNewlines: !0,
              decodeEntities: !0,
              trim: !0,
              format: {
                header: function (t) {
                  return k.stripData(t, o)
                },
                footer: function (t) {
                  return k.stripData(t, o)
                },
                body: function (t) {
                  return k.stripData(t, o)
                },
              },
              customizeData: null,
            },
            t
          ),
          t = e
            .columns(o.columns)
            .indexes()
            .map(function (t) {
              var n = e.column(t).header()
              return o.format.header(n.innerHTML, t, n)
            })
            .toArray(),
          n = e.table().footer()
            ? e
                .columns(o.columns)
                .indexes()
                .map(function (t) {
                  var n = e.column(t).footer()
                  return o.format.footer(n ? n.innerHTML : "", t, n)
                })
                .toArray()
            : null,
          i = v.extend({}, o.modifier),
          i =
            (e.select &&
              "function" == typeof e.select.info &&
              i.selected === x &&
              e.rows(o.rows, v.extend({ selected: !0 }, i)).any() &&
              v.extend(i, { selected: !0 }),
            e.rows(o.rows, i).indexes().toArray()),
          i = e.cells(i, o.columns),
          s = i.render(o.orthogonal).toArray(),
          r = i.nodes().toArray(),
          a = t.length,
          l = [],
          u = 0,
          c = 0,
          d = 0 < a ? s.length / a : 0;
        c < d;
        c++
      ) {
        for (var f = [a], p = 0; p < a; p++)
          (f[p] = o.format.body(s[u], c, p, r[u])), u++
        l[c] = f
      }
      i = { header: t, footer: n, body: l }
      return o.customizeData && o.customizeData(i), i
    }
  function t(t, n) {
    ;(t = new e.Api(t)), (n = n || t.init().buttons || e.defaults.buttons)
    return new k(t, n).container()
  }
  return (
    (v.fn.dataTable.Buttons = k),
    (v.fn.DataTable.Buttons = k),
    v(y).on("init.dt plugin-init.dt", function (t, n) {
      "dt" === t.namespace &&
        (t = n.oInit.buttons || e.defaults.buttons) &&
        !n._buttons &&
        new k(n, t).container()
    }),
    e.ext.feature.push({ fnInit: t, cFeature: "B" }),
    e.ext.features && e.ext.features.register("buttons", t),
    e
  )
})
